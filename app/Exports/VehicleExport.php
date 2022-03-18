<?php

namespace App\Exports;

use App\Models\Vehicle;
use Illuminate\Support\Facades\Schema;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class VehicleExport implements FromCollection, WithHeadings
{
	/**
	 * @return \Illuminate\Support\Collection
	 */

	public function collection()
	{
		return Vehicle::all();
	}

	public function headings(): array
	{
		return Schema::getColumnListing('vehicles');
	}
}