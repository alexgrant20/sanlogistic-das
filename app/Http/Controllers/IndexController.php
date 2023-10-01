<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\VehicleImage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class IndexController extends Controller
{
  public function index()
  {
    $params = [
      'title' => 'Home'
    ];

    $user = auth()->user();

    if ($user->hasRole('super-admin') || $user->hasPermissionTo('access-admin-panel')) {
      return view('admin.index', $params);
    }

    if ($user->hasRole('driver')) {
      $activity = Activity::where('user_id', $user->id)
        ->with(['departureLocation', 'arrivalLocation'])
        ->latest()
        ->first();

      $vehicleImage = VehicleImage::where([
        ['vehicle_id', $activity->vehicle_id],
        ['type', 'mypertamina']
      ])->first();

      $params['activity'] = $activity;
      $params['mypertamina'] =  @$vehicleImage['image'];
    }

    return view('driver.index', $params);
  }
}
