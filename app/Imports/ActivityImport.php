<?php

namespace App\Imports;

use App\Models\Activity;
use Maatwebsite\Excel\Concerns\ToModel;

class ActivityImport implements ToModel
{
	/**
	 * @param array $row
	 *
	 * @return \Illuminate\Database\Eloquent\Model|null
	 */
	public function model(array $row)
	{
		return new Activity([
			'user_id' => $row['user_id'],
			'vehicle_id' => $row['vehicle_id'],
			'project_id' => $row['project_id'],
			'departure_location_id' => $row['departure_location_id'],
			'arrival_location_id' => $row['arrival_location_id'],
			'do_date' => $row['do_date'],
			'do_number' => $row['do_number'],
			'do_image' => $row['do_image'],
			'departure_date' => $row['departure_date'],
			'departure_odo' => $row['departure_odo'],
			'departure_odo_image' => $row['departure_odo_image'],
			'arrival_date' => $row['arrival_date'],
			'arrival_odo' => $row['arrival_odo'],
			'arrival_odo_image' => $row['arrival_odo_image'],
			'bbm_amount' => $row['bbm_amount'],
			'bbm_image' => $row['bbm_image'],
			'toll_amount' => $row['toll_amount'],
			'toll_image' => $row['toll_image'],
			'retribution_amount' => $row['retribution_amount'],
			'retribution_image' => $row['retribution_image'],
			'parking' => $row['parking'],
			'parking_image' => $row['parking_image'],
			'bbm_amount_approved' => $row['bbm_amount_approved'],
			'toll_amount_approved' => $row['toll_amount_approved'],
			'parking_amount_approved' => $row['parking_amount_approved'],
			'retribution_amount_approved' => $row['retribution_amount_approved'],
			'status' => $row['status'],
			'type' => $row['type'],
			'start_lat' => $row['start_lat'],
			'start_lon' => $row['start_lon'],
			'start_loc' => $row['start_loc'],
			'end_lat' => $row['end_lat'],
			'end_lon' => $row['end_lon'],
			'end_loc' => $row['end_loc'],
			'created_by' => $row['created_by'],
			'updated_by' => $row['updated_by'],
			'created_at' => $row['created_at'],
			'updated_at' => $row['updated_at'],
		]);
	}
}