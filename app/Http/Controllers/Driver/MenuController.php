<?php

namespace App\Http\Controllers\Driver;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Models\Address;
use App\Models\PersonDocument;
use App\Models\VehicleLastStatus;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class MenuController extends Controller
{
  public function profile()
  {
    $sim = PersonDocument::where('person_id', auth()->user()->person_id)
      ->where('type', '=', 'sim')
      ->get(['number', 'expire', 'image'])
      ->first();

    $personImage = auth()->user()->person->image;

    return view('driver.menu.profile', [
      'title' => 'Profile',
      'sim' => $sim,
      'personImage' => $personImage
    ]);
  }

  public function location(int $id = null)
  {
    $addresses = Address::orderBy('name')->get();

    return view('driver.menu.location', [
      'addresses' => $addresses,
      'title' => 'Location',
      'addressData' => $id ? $addresses->find($id) :
        Activity::find(Session::get('activity_id'))->arrivalLocation ?? null,
    ]);
  }

  public function finance()
  {
    $activities = DB::table('activities')
      ->leftJoin('activity_statuses', 'activities.activity_status_id', '=', 'activity_statuses.id')
      ->leftJoin('activity_payments', 'activity_statuses.id', '=', 'activity_payments.activity_status_id')
      ->where('user_id', '=', auth()->user()->id)
      ->where('activity_statuses.status', 'paid')
      ->orderByDesc('activities.updated_at')
      ->groupBy('activities.updated_at')
      ->selectRaw(
        'SUM(bbm_amount) + SUM(toll_amount) + SUM(parking_amount) + SUM(load_amount) + SUM(unload_amount) + SUM(maintenance_amount) AS total_cost,
        activities.updated_at'
      )
      ->paginate(4);

    return view('driver.menu.finance', [
      'title' => 'Finance',
      'activities' => $activities
    ]);
  }

  public function getChecklistLastStatus(int $vehicleId)
  {
    $data = VehicleLastStatus::where(['vehicle_id' => $vehicleId])->first();
    return response()->json($data);
  }
}
