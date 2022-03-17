<?php

namespace App\Http\Controllers;

use App\Models\VehicleType;
use App\Models\VehicleVariety;
use Illuminate\Http\Request;

class OptionController extends Controller
{
	public function vehicleType($id)
	{
		$data = VehicleType::where('vehicle_brand_id', $id)->get();
		return response()->json($data);
	}

	public function vehicleVariety($id)
	{
		$data = VehicleVariety::where('vehicle_type_id', $id)->get();
		return response()->json($data);
	}
}