<?php

namespace App\Exports;

use App\Models\Company;
use Illuminate\Support\Facades\Schema;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CompanyExport implements FromCollection, WithHeadings, ShouldAutoSize
{
	private $ids;

	public function __construct(array $ids)
	{
		$this->ids = $ids;
	}

	public function collection()
	{
		if (count($this->ids) === 0) return Company::all();
		return Company::whereIn('id', $this->ids)->get();
	}

	public function headings(): array
	{
		return Schema::getColumnListing('companies');
	}
}