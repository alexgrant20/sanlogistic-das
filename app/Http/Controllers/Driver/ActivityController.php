<?php

namespace App\Http\Controllers\Driver;


use App\Models\Activity;
use App\Models\ActivityStatus;
use App\Models\AddressProject;
use App\Models\User;
use App\Models\Vehicle;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

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

  public function store(Request $request)
  {
    $validated = $request->validate([
      'do_number' => 'required|string',
      'arrival_location_id' => 'required|string',
      'vehicle_id' => 'required|string',
      'do_image' => 'image',
      'departure_odo_image' => 'image',
    ]);


    $imageFiles = ['do_image' => 'do_image', 'departure_odo_image' => 'departure_odo_image'];
    $timestamp = now()->timestamp;
    $data = $request->post();
    unset($data['_token']);

    foreach ($imageFiles as $key => $imageFile) {
      $extension = $validated[$imageFile]->extension();
      // Path for temp file
      $filepath = $validated[$imageFile]->getPathName();
      // Path for item withour storage
      $outputFilePath = "{$imageFile}/{$validated['do_number']}-{$timestamp}.{$extension}";
      // Full path for tinify
      // $outputFileFullPath = "storage/{$outputFilePath}";
      $data[$key] = $outputFilePath;

      try {
        // \Tinify\setKey(env("TINIFY_API_KEY"));
        // $source = \Tinify\fromFile($filepath);
        // $source->toFile($outputFileFullPath);
      } catch (Exception $e) {
        dd($e->getMessage());
      }
    }

    $data['do_date'] = now();
    $data['user_id'] = auth()->user()->id;
    $data['project_id'] = Vehicle::where('id', $data['vehicle_id'])->first()->project_id;

    try {
      DB::beginTransaction();

      $activity = Activity::create($data);

      User::where('id', auth()->user()->id)->update(['last_activity_id' => $activity->id]);
      ActivityStatus::create(['status' => 'draft', 'activity_id' => $activity->id]);

      $request->session()->put('activity_id', $activity->id);

      DB::commit();
    } catch (Exception $e) {
      DB::rollBack();
      abort(500, $e->getMessage());
    }
    return redirect('/');
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

  public function update(Request $request, Activity $activity)
  {
    $data = $request->validate([
      'arrival_id' => 'required',
      'arrival_odo' => 'required',
      'arrival_odo_img' => 'required',
      'bbm_amount' => 'required',
      'toll_amount' => 'required',
      'parking_amount' => 'required',
      'bbm_img' => 'image',
      'toll_img' => 'image',
      'parking_img' => 'image',
    ]);

    $moneyTables = ['bbm', 'parking', 'toll'];

    foreach ($moneyTables as $moneyTable) {
      $amount = preg_replace("/[^0-9]/", "", $data[$moneyTable . "_amount"]);

      if (
        ($amount > 0 && !array_key_exists($moneyTable . "_img", $data)) ||
        ($amount == 0 && array_key_exists($moneyTable . "_img", $data))
      ) {
        return redirect("/activities/{$activity->id}/edit")->withInput()->with('error', "Data invalid!");
      }
    }
  }

  public function destroy(Activity $activity)
  {
    //
  }
}