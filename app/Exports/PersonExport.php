<?php

namespace App\Exports;

use App\Models\Person;
use Illuminate\Support\Facades\Schema;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PersonExport implements FromCollection, WithHeadings, ShouldAutoSize
{
	private $ids;

	public function __construct(array $ids)
	{
		$this->ids = $ids;
	}

	public function collection()
	{
		if (count($this->ids) === 0) return Person::all();
		return Person::whereIn('id', $this->ids)->get();
	}

	public function headings(): array
	{
		return Schema::getColumnListing('people');
	}
}