<?php

namespace App\Http\Controllers\Driver;


use App\Models\Activity;
use App\Models\ActivityStatus;
use App\Models\AddressProject;
use App\Models\Vehicle;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\Driver\StoreActivityRequest;
use App\Http\Requests\Driver\UpdateActivityRequest;
use App\Models\ActivityPayment;
use App\Models\Driver;
use App\Transaction\Constants\NotifactionTypeConstant;
use Exception;
use Illuminate\Support\Facades\Session;

// TO-DO Make Gate
class ActivityController extends Controller
{
  public function __construct()
  {
    $this->authorizeResource(Activity::class, 'activity');
  }

  public function index()
  {
    $activities = DB::table('activities')
      ->leftJoin('activity_statuses', 'activities.activity_status_id', '=', 'activity_statuses.id')
      ->leftJoin('activity_payments', 'activity_statuses.id', '=', 'activity_payments.activity_status_id')
      ->leftJoin(DB::raw('addresses dep'), 'activities.departure_location_id', '=', 'dep.id')
      ->leftJoin(DB::raw('addresses arr'), 'activities.arrival_location_id', '=', 'arr.id')
      ->leftJoin('vehicles', 'activities.vehicle_id', '=', 'vehicles.id')
      ->where('user_id', '=', auth()->user()->id)
      ->orderByDesc('activities.created_at')
      ->selectRaw(
        'bbm_amount + toll_amount + parking_amount + retribution_amount AS total_cost, arrival_odo - departure_odo AS distance,
        activity_statuses.status, do_number, departure_date, arrival_date, dep.name AS departure_name, arr.name AS arrival_name, license_plate,
        (CASE
          WHEN activity_statuses.status = "draft" THEN "bg-warning"
          WHEN activity_statuses.status = "pending" THEN "bg-warning"
          WHEN activity_statuses.status = "approved" THEN "bg-info"
          WHEN activity_statuses.status = "paid" THEN "bg-success"
          WHEN activity_statuses.status = "rejected" THEN "bg-primary"
          END) AS activityStatusColor'
      )
      ->paginate(3);

    return view('driver.activities.index', [
      'title' => __('Activity History'),
      'activities' => $activities,
    ]);
  }

  public function create()
  {
    $projectId = auth()->user()->person->project_id;

    $vehicles = Vehicle::where('project_id', $projectId)->orderBy('license_plate')->get();

    return view('driver.activities.create', [
      'title' => 'Create Activity',
      'vehicles' => $vehicles,
      'projectId' => $projectId
    ]);
  }

  public function store(StoreActivityRequest $request)
  {
    $timestamp = now()->timestamp;
    $images = collect($request->allFiles());
    $vehicle = Vehicle::find($request->vehicle_id);

    ['lat' => $lat, 'lon' => $lon, 'loc' => $loc] = get_location_ngt(str_replace(' ', '', $vehicle->license_plate));

    $listOfPath = uploadImages($images, $request->do_number, $timestamp);
    $data = array_merge(
      $request->safe()->except(['do_image', 'departure_odo_image']),
      [
        'do_date' => now(),
        'user_id' => auth()->user()->id,
        'project_id' => $vehicle->project_id,
        'start_lat' => $lat,
        'start_lon' => $lon,
        'start_loc' => $loc,
      ],
      $listOfPath
    );

    try {
      DB::transaction(function () use ($data, $request) {
        $activity = Activity::create($data);
        $activity->vehicle->update([
          'last_do_number' => $request->do_number,
          'last_do_date' => now(),
        ]);
        ActivityStatus::create(['status' => 'draft', 'activity_id' => $activity->id]);
        $request->session()->put('activity_id', $activity->id);
      });
    } catch (Exception $e) {
      return to_route('driver.activity.create')->withInput();
    }

    return to_route('index')
      ->with(genereateNotifaction(NotifactionTypeConstant::SUCCESS, 'activity', 'created'));
  }

  public function show(Activity $activity)
  {
    //
  }

  public function edit(Activity $activity)
  {
    return view('driver.activities.edit', [
      'title' => 'Update Activity',
      'activity' => $activity,
      'arrival_addresses' => AddressProject::where('address_id', '!=', $activity->departure_location_id)
        ->where('project_id', $activity->project_id)
        ->with('address')
        ->get()
        ->sortBy('address.name')
    ]);
  }

  public function update(UpdateActivityRequest $request, Activity $activity)
  {
    $vehicle = Vehicle::where('id', $activity->vehicle_id)->first();
    $totalCustTrip = auth()->user()->total_cust_trip;

    $a_name =  strtoupper($activity->arrivalLocation->addressType->name);
    $d_name = strtoupper($activity->departureLocation->addressType->name);

    $activityType = null;

    DB::beginTransaction();
    try {
      switch ($a_name) {
        case "TUJUAN PENGIRIMAN":
          $totalCustTrip += 1;

          Driver::where('user_id', auth()->user()->id)->update([
            'total_cust_trip' => $totalCustTrip + 1,
            'last_activity_id' => $activity->id
          ]);

          $activityType = "mdp-" . $totalCustTrip;
          break;

        case "KANTOR UTAMA":
        case "POOL":
          $activityType = "pool";
          break;

        case "STATION":
          if ($d_name == "Station") {
            $activityType = 'manuver';
          } else {

            $activityType = 'return';

            if ($totalCustTrip == 0) {
              break;
            }

            $type = $totalCustTrip > 1 ? 'mdp-e' : 'sdp';

            $driver = Driver::where('user_id', auth()->user()->id);

            $driver->lastActivity->update([
              'type' => $type
            ]);

            $driver->update([
              'total_cust_trip' => 0,
              'last_activity_id' => NULL
            ]);
          }
          break;

        case "WORKSHOP":
          $activityType = "maintenance";
          break;

        case "PKB/SAMSAT":
          $activityType = "kir";
          break;
      }

      ['lat' => $lat, 'lon' => $lon, 'loc' => $loc] = get_location_ngt(str_replace(' ', '', $vehicle->license_plate));
      $data = $request->safe()->merge(
        [
          'end_lat' => $lat,
          'end_lon' => $lon,
          'end_loc' => $loc,
          'type' => $activityType,
          'arrival_date' => now()
        ]
      )->except(
        ['bbm_image', 'toll_image', 'parking_image', 'arrival_odo_image', 'bbm_amount', 'toll_amount', 'parking_amount']
      );
      $images = collect($request->allFiles());
      $timestamp = now()->timestamp;

      $listOfPath = uploadImages($images, $activity->do_number, $timestamp);
      $data = array_merge($data, $listOfPath);

      DB::transaction(function () use ($activity, $data, $request) {
        $activity->update($data);

        $activityStatus = ActivityStatus::create([
          'status' => 'pending',
          'activity_id' => $activity->id
        ]);

        $activity->vehicle->update([
          'odo' => $request->arrival_odo,
          'address_id' => $request->arrival_id,
          // 'last_do_number' => NULL,
          // 'last_do_date' => NULL,
        ]);

        ActivityPayment::create([
          'activity_status_id' => $activityStatus->id,
          'bbm_amount' => $request->bbm_amount,
          'toll_amount' => $request->toll_amount,
          'parking_amount' => $request->parking_amount,
        ]);
      });
    } catch (Exception $e) {
      DB::rollBack();
      return to_route('driver.activity.edit')->withInput();
    }
    DB::commit();

    $request->session()->forget('activity_id');

    return to_route('index')
      ->with(genereateNotifaction(NotifactionTypeConstant::SUCCESS, 'activity', 'finished'));;
  }

  public function destroy(Activity $activity)
  {
    //
  }
}