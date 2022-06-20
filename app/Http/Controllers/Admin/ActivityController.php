<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Exports\ActivityExport;
use App\Models\Activity;
use App\Http\Requests\StoreActivityRequest;
use App\Http\Requests\UpdateActivityRequest;
use App\Imports\ActivityImport;
use App\Models\ActivityPayment;
use App\Models\ActivityStatus;
use App\Models\Address;
use App\Models\Project;
use App\Models\User;
use App\Models\Vehicle;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class ActivityController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    return view('admin.activities.index', [
      'title' => 'Activities',
      'activities' => Activity::with('activityStatus', 'departureLocation', 'arrivalLocation', 'driver.person')
        ->latest()
        ->with('driver', 'vehicle', 'departureLocation', 'arrivalLocation')
        ->get(),
      'importPath' => '/admin/activities/import/excel',
    ]);
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    return view('admin.activities.create', [
      'title' => 'Create Activity',
      'addresses' => Address::orderBy('name', 'ASC')->get(),
      'vehicles' => Vehicle::orderBy('license_plate', 'ASC')->get(),
      'projects' => Project::orderBy('name', 'ASC')->get(),
      'users' => User::with('person')->get(),
    ]);
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \App\Http\Requests\StoreActivityRequest  $request
   * @return \Illuminate\Http\Response
   */
  public function store(StoreActivityRequest $request)
  {
    try {
      $moneyTable = ['bbm_amount', 'parking', 'retribution_amount', 'parking', 'toll_amount'];
      $imageTable = ['do', 'departure_odo', 'arrival_odo', 'bbm', 'toll', 'retribution', 'parking'];

      $data = $request->safe()->all();
      $person_name = User::with('person')->where('id', '=', $data['user_id'])->get()[0]->person->name;
      $timestamp = now()->timestamp;

      foreach ($moneyTable as $x) $data[$x] = preg_replace("/[^0-9]/", "", $data[$x]);

      foreach ($imageTable as $x) {
        $imagePath = "";
        if ($request->file("{$x}_image")) {
          $fileName = "{$x}-{$person_name}-{$timestamp}.{$request->file("{$x}_image")->extension()}";
          $imagePath = $request->file("{$x}_image")->storeAs("{$x}-images", $fileName, 'public');
        }
        $data["{$x}_image"] = $imagePath;
      }

      DB::beginTransaction();

      $activity = Activity::create($data);

      $activityStatus = ActivityStatus::create([
        'activity_id' =>  $activity->id,
        'status' => $request->status
      ]);

      ActivityPayment::create([
        'activity_status_id' => $activityStatus->id,
        'bbm_amount' => $data['bbm_amount'],
        'toll_amount' => $data['toll_amount'],
        'parking_amount' => $data['parking'],
        'retribution_amount' => $data['retribution_amount'],
      ]);

      DB::commit();

      $notification = array(
        'message' => 'Activity successfully created!',
        'alert-type' => 'success',
      );

      return to_route('admin.activity.index')->with($notification);
    } catch (Exception $e) {
      DB::rollback();

      $notification = array(
        'message' => 'Activity failed to create!',
        'alert-type' => 'error',
      );

      return to_route('admin.activity.create')->withInput()->with($notification);
    }
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Models\Activity  $activity
   * @return \Illuminate\Http\Response
   */
  public function show(Activity $activity)
  {

    $data = ActivityStatus::with('created_user')->where('activity_id', $activity->id)->get();

    return to_route('admin.activity.index')->with('log_data', $data);
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Models\Activity  $activity
   * @return \Illuminate\Http\Response
   */
  public function edit(Activity $activity)
  {
    return view('admin.activities.edit', [
      'title' => 'Update Activity',
      'activity' => $activity,
      'addresses' => Address::orderBy('name', 'ASC')->get(),
      'vehicles' => Vehicle::orderBy('license_plate', 'ASC')->get(),
      'projects' => Project::orderBy('name', 'ASC')->get(),
      'users' => User::with('person')->get(),
    ]);
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \App\Http\Requests\UpdateActivityRequest  $request
   * @param  \App\Models\Activity  $activity
   * @return \Illuminate\Http\Response
   */
  public function update(UpdateActivityRequest $request, Activity $activity)
  {
    try {
      $moneyTable = ['bbm_amount', 'parking', 'retribution_amount', 'toll_amount'];
      $imageTable = ['do', 'departure_odo', 'arrival_odo', 'bbm', 'toll', 'retribution', 'parking'];

      $data = $request->safe()->all();
      $person_name = User::with('person')->where('id', '=', $data['user_id'])->get()[0]->person->name;
      $timestamp = now()->timestamp;

      foreach ($moneyTable as $x) $data[$x] = preg_replace("/[^0-9]/", "", $data[$x]);

      foreach ($imageTable as $x) {
        $imagePath = $activity["{$x}_image"];
        if ($request->file("{$x}_image")) {
          $fileName = "{$x}-{$person_name}-{$timestamp}.{$request->file("{$x}_image")->extension()}";
          $imagePath = $request->file("{$x}_image")->storeAs("{$x}-images", $fileName, 'public');
        }
        $data["{$x}_image"] = $imagePath;
      }

      DB::beginTransaction();

      $activity->update($data);

      if ($activity->activityStatus()->first()->status !== $request->status) {
        $activityStatus = ActivityStatus::create([
          'activity_id' => $activity->id,
          'status' => $request->status
        ]);

        ActivityPayment::create([
          'activity_status_id' => $activityStatus->id,
          'bbm_amount' => $data['bbm_amount'],
          'toll_amount' => $data['toll_amount'],
          'parking_amount' => $data['parking'],
          'retribution_amount' => $data['retribution_amount'],
        ]);
      } else {
        ActivityPayment::where('id', $activity->activityStatus->activityPayment->id)->update([
          'bbm_amount' => $data['bbm_amount'],
          'toll_amount' => $data['toll_amount'],
          'parking_amount' => $data['parking'],
          'retribution_amount' => $data['retribution_amount'],
        ]);
      }

      DB::commit();

      $notification = array(
        'message' => 'Activity successfully updated!',
        'alert-type' => 'success',
      );

      return to_route('admin.activity.index')->with($notification);
    } catch (Exception $e) {
      DB::rollback();

      $notification = array(
        'message' => 'Activity failed to update!',
        'alert-type' => 'error',
      );

      return redirect("/admin/activities/{$activity->id}/edit")->withInput()->with($notification);
    }
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\Activity  $activity
   * @return \Illuminate\Http\Response
   */
  public function destroy(Activity $activity)
  {
    //

  }

  public function importExcel(Request $request)
  {
    try {
      $request->validate([
        'file' => 'required|mimes:csv,xls,xlsx'
      ]);

      $file = $request->file('file')->store('file-import/activity/');

      $import = new ActivityImport;
      $import->import($file);

      if ($import->failures()->isNotEmpty()) {
        return back()->with('importErrorList', $import->failures());
      }

      $notification = array(
        'message' => 'Activity successfully imported!',
        'alert-type' => 'success',
      );

      return to_route('admin.activity.index')->with($notification);
    } catch (Exception $e) {

      $notification = array(
        'message' => 'Activity failed to import!',
        'alert-type' => 'error',
      );

      return to_route('admin.activity.index')->with($notification);
    }
  }

  public function exportExcel(Request $request)
  {
    $timestamp = now()->timestamp;
    $params = $request->input('ids');
    $ids = preg_split("/[,]/", $params);
    return Excel::download(new ActivityExport($ids), "activities_export_{$timestamp}.xlsx");
  }
}