<?php

namespace App\Exports;

use App\Models\Project;
use Illuminate\Support\Facades\Schema;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ProjectExport implements FromCollection, WithHeadings, ShouldAutoSize
{
	private $ids;

	public function __construct(array $ids)
	{
		$this->ids = $ids;
	}

	public function collection()
	{
		if (count($this->ids) === 0) return Project::all();
		return Project::whereIn('id', $this->ids)->get();
	}

	public function headings(): array
	{
		return Schema::getColumnListing('projects');
	}
}