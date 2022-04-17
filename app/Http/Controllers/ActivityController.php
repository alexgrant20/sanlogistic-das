<?php

namespace App\Http\Controllers;

use App\Exports\ActivityExport;
use App\Models\Activity;
use App\Http\Requests\StoreActivityRequest;
use App\Http\Requests\UpdateActivityRequest;
use App\Imports\ActivityImport;
use App\Models\ActivityStatus;
use App\Models\Address;
use App\Models\Person;
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
    return view('activities.index', [
      'title' => 'Activities',
      'activities' => Activity::with('activityStatus', 'departureLocation', 'arrivalLocation', 'driver.person')
        ->latest()
        ->with('driver', 'vehicle', 'departureLocation', 'arrivalLocation')
        ->get(),
      'importPath' => '/activities/import/excel',
    ]);
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    return view('activities.create', [
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

      ActivityStatus::create([
        'activity_id' =>  $activity->id,
        'status' => $request->status
      ]);

      DB::commit();

      return redirect('/activities')->with('success', 'New activity has been added!');
    } catch (Exception $e) {
      DB::rollback();
      return redirect('/activities/create')->withInput()->with('error', $e->getMessage());
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

    return redirect('/activities')->with('log_data', $data);
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Models\Activity  $activity
   * @return \Illuminate\Http\Response
   */
  public function edit(Activity $activity)
  {
    return view('activities.edit', [
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
      $moneyTable = ['bbm_amount', 'parking', 'retribution_amount', 'parking', 'toll_amount'];
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
        ActivityStatus::create([
          'activity_id' => $activity->id,
          'status' => $request->status
        ]);
      }

      DB::commit();

      return redirect('/activities')->with('success', 'Activity has been updated!');
    } catch (Exception $e) {
      DB::rollback();
      return redirect("/activities/{$activity->id}/edit")->withInput()->with('error', $e->getMessage());
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

      return redirect('/activities')->with('success', 'Import completed!');
    } catch (Exception $e) {
      return redirect('/activities')->with('error', 'Import Failed! ' . $e->getMessage());
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