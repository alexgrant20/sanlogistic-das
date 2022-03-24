<?php

namespace App\Exports;

use App\Models\Activity;
use Illuminate\Support\Facades\Schema;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ActivityExport implements FromCollection, WithHeadings, ShouldAutoSize
{
  /**
   * @return \Illuminate\Support\Collection
   */
  public function collection()
  {
    return Activity::all();
  }


  public function headings(): array
  {
    return Schema::getColumnListing('activities');
  }
}