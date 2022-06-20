<?php

namespace App\Http\Controllers\Driver;


use App\Models\Vehicle;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class VehicleController extends Controller
{
  public function get(Request $request)
  {
    $projectId = $request->get('projectId');
    $vehicleId = $request->get('vehicleId');

    if ($vehicleId) {
      return Vehicle::where('id', $vehicleId)->with('address')->first();
    }

    if ($projectId) {
      return Vehicle::where('project_id', $projectId)->with('address')->get();
    }

    return Vehicle::with('address')->get();
  }
}