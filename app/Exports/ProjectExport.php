<?php

namespace App\Exports;

use App\Models\Project;
use Illuminate\Support\Facades\Schema;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ProjectExport implements FromCollection, WithHeadings, ShouldAutoSize
{
  /**
   * @return \Illuminate\Support\Collection
   */
  public function collection()
  {
    return Project::all();
  }

  public function headings(): array
  {
    return Schema::getColumnListing('projects');
  }
}