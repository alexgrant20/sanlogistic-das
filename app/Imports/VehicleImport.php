<?php

namespace App\Imports;

use App\Models\Vehicle;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;


class VehicleImport implements
	ToModel,
	WithHeadingRow,
	SkipsOnError,
	WithValidation,
	SkipsOnFailure,
	WithBatchInserts,
	WithChunkReading
{

	use Importable, SkipsErrors, SkipsFailures;

	public function model(array $row)
	{
		return new Vehicle([
			'project_id' => $row['project_id'],
			'area_id' => $row['area_id'],
			'vehicle_variety_id' => $row['vehicle_variety_id'],
			'address_id' => $row['address_id'],
			'owner_id' => $row['owner_id'],
			'vehicle_towing_id' => $row['vehicle_towing_id'],
			'vehicle_license_plate_color_id' => $row['vehicle_license_plate_color_id'],
			'last_do_number' => $row['last_do_number'],
			'last_do_date' => $row['last_do_date'],
			'license_plate' => $row['license_plate'],
			'frame_number' => $row['frame_number'],
			'registration_number' => $row['registration_number'],
			'engine_number' => $row['engine_number'],
			'modification' => $row['modification'],
			'internal_code' => $row['internal_code'],
			'status' => $row['status'],
			'capacity' => $row['capacity'],
			'wheel' => $row['wheel'],
			'odo' => $row['odo'],
			'registration_year' => $row['registration_year'],
			'is_maintenance' => $row['is_maintenance'],
			'note' => $row['note'],
			'created_at' => $row['created_at'],
			'updated_at' => $row['updated_at'],
		]);
	}

	public function rules(): array
	{
		return [
			'*.license_plate' => ['unique:vehicles']
		];
	}

	public function batchSize(): int
	{
		return 1000;
	}

	public function chunkSize(): int
	{
		return 1000;
	}
}