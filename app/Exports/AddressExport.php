<?php

namespace App\Exports;

use App\Models\Address;
use Illuminate\Support\Facades\Schema;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class AddressExport implements FromCollection, WithHeadings, ShouldAutoSize
{
	private $ids;

	public function __construct(array $ids)
	{
		$this->ids = $ids;
	}

	public function collection()
	{
		if (count($this->ids) === 0) return Address::all();
		return Address::whereIn('id', $this->ids)->get();
	}


	public function headings(): array
	{
		return Schema::getColumnListing('addresses');
	}
}