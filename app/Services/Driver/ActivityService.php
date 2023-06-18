<?php

namespace App\Services\Driver;

use App\Interface\CompanyInterface;
use App\Models\Activity;
use App\Models\ActivityIncentive;
use App\Models\ActivityPayment;
use App\Models\ActivityStatus;
use App\Models\Address;
use App\Models\ErrorLog;
use App\Models\IncentiveRate;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class ActivityService implements CompanyInterface
{
	private $needToCaclculateIncentive = false;
	private $isHalfTrip = false;

	private function setActivityConfigAndGetType($activity, $arrivalType, $departureType, &$totalCustTrip)
	{
		$activityType = null;
		$driver = auth()->user()->driver;

		switch ($arrivalType) {
			case "TUJUAN PENGIRIMAN":
				$totalCustTrip += 1;

				$driver->update([
					'last_activity_id' => $activity->id,
					'total_cust_trip' => $totalCustTrip,
				]);

				$activityType = "mdp-" . $totalCustTrip;
				break;

			case "KANTOR UTAMA":
			case "POOL":
				$activityType = "pool";
				break;

			case "STATION":
				$this->needToCaclculateIncentive = true;

				if ($departureType == "STATION") return 'manuver';

				if ($totalCustTrip != 0) {
					$driver->lastActivity->update([
						'type' => $totalCustTrip > 1 ? 'mdp-e' : 'sdp'
					]);

					$driver->update([
						'last_activity_id' => NULL,
						'total_cust_trip' => 0,
					]);
				}

				$activityType = 'return';
				break;
			case "WORKSHOP":
				$activityType = "maintenance";
				break;

			case "PKB/SAMSAT":
				$activityType = "kir";
				break;
		}

		return $activityType;
	}

	private function getActivityFixedPayload($licensePlate, $activityPayload, $activityFiles, $additionalPayload)
	{
		['lat' => $lat, 'lon' => $lon, 'loc' => $loc] = get_location_ngt(str_replace(' ', '', $licensePlate));

		$additionalPayload = array_merge($additionalPayload, [
			'end_lat' => $lat,
			'end_lon' => $lon,
			'end_loc' => $loc,
		]);

		$payload = $activityPayload->merge($additionalPayload)->toArray();

		$images = collect($activityFiles);
		$timestamp = now()->timestamp;

		$listOfPath = uploadImages($images, auth()->user()->person->name, $timestamp);
		$payload = array_merge($payload, $listOfPath);

		return $payload;
	}

	public function store($request)
	{
		$vehicle = Vehicle::find($request->vehicle_id);

		$storeAdditionalPayload = [
			'do_date' => now(),
			'user_id' => auth()->user()->id,
			'project_id' => $vehicle->project_id,
		];

		$fixedPayload = $this->getActivityFixedPayload(
			$vehicle->license_plate,
			$request->safe(),
			$request->allFiles(),
			$storeAdditionalPayload
		);

		DB::beginTransaction();

		try {
			$activity = Activity::create($fixedPayload);

			$vehicle->update([
				'last_do_number' => $request->do_number,
				'last_do_date' => now(),
			]);

			ActivityStatus::create(['status' => 'draft', 'activity_id' => $activity->id]);
		} catch (\Exception $e) {
			DB::rollBack();
			ErrorLog::createLog($e);
			return false;
		}

		DB::commit();
		return $activity;
	}

	private function getActivityParentId(Activity $currentActivity)
	{
		$relatedActivity = Activity::where([
			['user_id', Auth::id()],
			['type', '!=', 'tbd'],
		])
			->latest()
			->first();

		if (
			!in_array($relatedActivity->type, ['return', 'manuver']) &&
			$relatedActivity->parent_activity_id
		) return $relatedActivity->parent_activity_id;

		return $currentActivity->id;
	}

	public function update($request, Activity $activity)
	{
		$vehicle = $activity->vehicle;
		$totalCustTrip = auth()->user()->driver->total_cust_trip;
		$arrivalType =  strtoupper(Address::find($request->arrival_location_id)->addressType->name);
		$departureType = strtoupper($activity->departureLocation->addressType->name);

		DB::beginTransaction();

		try {
			$activityType = $this->setActivityConfigAndGetType($activity, $arrivalType, $departureType, $totalCustTrip);

			$finalizedAdditionalPayload = [
				'type' => $activityType,
				'arrival_date' => now()
			];

			$fixedPayload = $this->getActivityFixedPayload(
				$vehicle->license_plate,
				$request->safe(),
				$request->allFiles(),
				$finalizedAdditionalPayload,
			);

			$this->finalizedActivityStep($request, $activity, $fixedPayload, $totalCustTrip);
		} catch (\Exception $e) {
			DB::rollBack();
			ErrorLog::createLog($e);
			return false;
		}

		DB::commit();
		return true;
	}

	private function getTotalDistance($parentActivityId)
	{
		$activities = Activity::where('id', $parentActivityId)
			->orWhere('parent_activity_id', $parentActivityId)
			->get();

		$totalDistance = 0;

		$halfTripCriteria = [0, $activities->count() - 1];

		$loop = 0;

		$activities->each(function ($activity) use (&$totalDistance, &$loop, $halfTripCriteria) {

			if ($activity->do_number == "PT" && in_array($loop, [0, $halfTripCriteria])) {
				$this->isHalfTrip = true;
			}

			if (!in_array(@$activity->vehicle->owner_id, [self::BESTINDO, self::SURYA_ANUGERAH])) {
				return;
			}

			$totalDistance += $activity->arrival_odo - $activity->departure_odo;

			$loop++;
		});

		return $totalDistance;
	}

	private function getIncentiveType($totalDistance)
	{
		if ($this->isHalfTrip) $totalDistance *= 2;

		return IncentiveRate::where('range', '<=', $totalDistance)
			->orderByDesc('id')
			->first();
	}

	private function createActivityIncentiveRate($parentActivityId)
	{
		$totalDistance = $this->getTotalDistance($parentActivityId);
		$incentiveType = $this->getIncentiveType($totalDistance);

		$divider = $this->isHalfTrip ? 2 : 1;

		ActivityIncentive::create([
			'activity_id' => $parentActivityId,
			'total_distance' => $totalDistance,
			'incentive' => $incentiveType->incentive / $divider,
			'incentive_with_deposit' => $incentiveType->incentive_with_deposit / $divider,
			'is_half_trip' => $this->isHalfTrip
		]);
	}

	private function finalizedActivityStep($request, $activity, $updatedActivityPayload, $totalCustTrip)
	{
		$parentActivityId = $this->getActivityParentId($activity, $totalCustTrip);

		$updatedActivityPayload['parent_activity_id'] = $parentActivityId;

		$activity->update($updatedActivityPayload);

		$activityStatus = ActivityStatus::create([
			'status' => 'pending',
			'activity_id' => $activity->id
		]);

		if ($this->needToCaclculateIncentive) {
			$this->createActivityIncentiveRate($parentActivityId);
		}

		if ($activity->vehicle_id) {
			$activity->vehicle->update([
				'odo' => $request->arrival_odo,
				'address_id' => $request->arrival_location_id,
			]);
		}

		ActivityPayment::create([
			'activity_status_id' => $activityStatus->id,
			'bbm_amount' => $request->bbm_amount ?? 0,
			'toll_amount' => $request->toll_amount ?? 0,
			'parking_amount' => $request->parking_amount ?? 0,
		]);

		auth()->user()->driver->update([
			'last_location_id' => $request->arrival_location_id
		]);
	}

	public function storePublicTransport(Request $request)
	{
		$user = auth()->user();
		$driver = $user->driver;

		DB::beginTransaction();

		try {
			$departureLocationId = Crypt::decryptString($request->departure_location_id);

			$addressessType = Address::whereIn('id', [$departureLocationId, $request->arrival_location_id])
				->get()
				->mapWithKeys(function ($address) use ($departureLocationId) {
					$key = $address->id == $departureLocationId ? 'departure_location' : 'arrival_location';
					return [$key => strtoupper($address->addressType->name)];
				});

			$totalCustTrip = $driver->total_cust_trip;

			$activity = Activity::create([
				'user_id' => $user->id,
				'departure_location_id' => $departureLocationId,
				'arrival_location_id' => $request->arrival_location_id,
				'project_id' => $user->person->project->id,
				'do_number' => 'PT',
				'do_date' => now(),
			]);

			$activityType = $this->setActivityConfigAndGetType(
				$activity,
				$addressessType['arrival_location'],
				$addressessType['departure_location'],
				$totalCustTrip
			);

			$this->finalizedActivityStep($request, $activity, ['type' => $activityType], $totalCustTrip);
		} catch (\Exception $e) {
			DB::rollBack();
			ErrorLog::createLog($e);
			return false;
		}

		DB::commit();
		return true;
	}
}
