<?php

namespace App\Http\Controllers;

use App\Exports\ActivityExport;
use App\Models\Activity;
use App\Http\Requests\StoreActivityRequest;
use App\Http\Requests\UpdateActivityRequest;
use App\Models\Address;
use App\Models\Person;
use App\Models\Project;
use App\Models\User;
use App\Models\Vehicle;
use Exception;
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
      'activities' => Activity::latest()->with('driver', 'vehicle', 'departureLocation', 'arrivalLocation')->get()
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

      Activity::create($data);

      DB::commit();

      return redirect('/activities')->with('success', 'New company has been added!');
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
    //
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

      DB::commit();

      return redirect('/activities')->with('success', 'Company has been updated!');
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

  public function exportExcel()
  {
    $timestamp = now()->timestamp;
    return Excel::download(new ActivityExport, "activities_export_{$timestamp}.xlsx");
  }
}