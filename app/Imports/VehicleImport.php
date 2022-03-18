<?php

namespace App\Imports;

use App\Models\Vehicle;
use Maatwebsite\Excel\Concerns\ToModel;

class VehicleImport implements ToModel
{
	/**
	 * @param array $row
	 *
	 * @return \Illuminate\Database\Eloquent\Model|null
	 */
	public function model(array $row)
	{
		return new Vehicle([
			'project_id' => $row['1'],
			'area_id' => $row['2'],
			'vehicle_variety_id' => $row['3'],
			'address_id' => $row['4'],
			'owner_id' => $row['5'],
			'vehicle_towing_id' => $row['6'],
			'vehicle_license_plate_color_id' => $row['7'],
			'last_do_number' => $row['8'],
			'last_do_date' => $row['9'],
			'license_plate' => $row['10'],
			'frame_number' => $row['11'],
			'registration_number' => $row['12'],
			'engine_number' => $row['13'],
			'modification' => $row['14'],
			'internal_code' => $row['15'],
			'status' => $row['16'],
			'capacity' => $row['17'],
			'wheel' => $row['18'],
			'odo' => $row['19'],
			'registration_year' => $row['20'],
			'is_maintenance' => $row['21'],
			'note' => $row['22'],
			'created_at' => $row['23'],
			'updated_at' => $row['24'],
		]);
	}
}