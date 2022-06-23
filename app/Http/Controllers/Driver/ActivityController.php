<?php

namespace App\Http\Controllers\Driver;


use App\Models\Activity;
use App\Models\ActivityStatus;
use App\Models\AddressProject;
use App\Models\User;
use App\Models\Vehicle;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\Driver\StoreActivityRequest;
use App\Http\Requests\Driver\UpdateActivityRequest;
use App\Models\ActivityPayment;
use App\Models\Address;
use Illuminate\Support\Arr;

class ActivityController extends Controller
{
  public function index()
  {
    //
  }

  public function create()
  {
    return view('driver.activities.create', [
      'title' => 'Create Activity'
    ]);
  }

  public function store(StoreActivityRequest $request)
  {
    $timestamp = now()->timestamp;
    $images = collect($request->allFiles());
    $vehicle = Vehicle::where('id', $request->vehicle_id)->first();
    ['lat' => $lat, 'lon' => $lon, 'loc' => $loc] = get_location_ngt(str_replace(' ', '', $vehicle->license_plate));

    $data = $request->safe()->merge(
      [
        'do_date' => now(),
        'user_id' => auth()->user()->id,
        'project_id' => $vehicle->project_id,
        'start_lat' => $lat,
        'start_lon' => $lon,
        'start_loc' => $loc,
      ]
    )->except(['do_image', 'departure_odo_image']);

    $listOfPath = uploadImages($images, $request->do_number, $timestamp);
    $data = array_merge($data, $listOfPath);

    return DB::transaction(function () use ($data, $request) {
      $activity = Activity::create($data);
      $activity->vehicle->update([
        'last_do_number' => $request->do_number,
        'last_do_date' => now(),
      ]);
      ActivityStatus::create(['status' => 'draft', 'activity_id' => $activity->id]);
      $request->session()->put('activity_id', $activity->id);
      return to_route('index');
    });
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
      'arrival_addresses' => AddressProject::where('address_id', '!=', $activity->departure_location_id)->where('project_id', $activity->project_id)->with('address')->get()
    ]);
  }

  public function update(UpdateActivityRequest $request, Activity $activity)
  {
    $vehicle = Vehicle::where('id', $activity->vehicle_id)->first();
    $user = User::find(auth()->user()->id);
    $totalCustTrip = auth()->user()->total_cust_trip;

    $a_name = $activity->arrivalLocation->addressType->name;
    $d_name = $activity->departureLocation->addressType->name;

    $activityType = null;

    switch ($a_name) {
      case "Tujuan Pengiriman":
        $totalCustTrip += 1;

        DB::transaction(function () use ($user, $totalCustTrip, $activity) {
          $user->update([
            'total_cust_trip' => $totalCustTrip + 1,
            'last_activity_id' => $activity->id
          ]);
        });

        $activityType = "mdp-" . $totalCustTrip;
        break;

      case "Kantor Utama":
      case "Pool":
        $activityType = "pool";
        break;

      case "Station":
        if ($d_name == "Station") {
          $activityType = 'manuver';
        } else {
          $type = $totalCustTrip > 1 ? 'mdp-e' : 'sdp';

          DB::transaction(function () use ($type, $user) {
            $user->lastActivity->update([
              'type' => $type
            ]);
            $user->update([
              'total_cust_trip' => 0,
              'last_activity_id' => NULL
            ]);
          });

          $activityType = 'return';
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

    $request->session()->forget('activity_id');
    return to_route('index');
  }

  public function destroy(Activity $activity)
  {
    //
  }
}