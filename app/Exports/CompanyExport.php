<?php

namespace App\Exports;

use App\Models\Company;
use Illuminate\Support\Facades\Schema;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CompanyExport implements FromCollection, WithHeadings, ShouldAutoSize
{
  /**
   * @return \Illuminate\Support\Collection
   */
  public function collection()
  {
    return Company::all();
  }

  public function headings(): array
  {
    return Schema::getColumnListing('companies');
  }
}