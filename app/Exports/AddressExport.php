<?php

namespace App\Exports;

use App\Models\Address;
use Illuminate\Support\Facades\Schema;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class AddressExport implements FromCollection, WithHeadings, ShouldAutoSize
{
  /**
   * @return \Illuminate\Support\Collection
   */
  public function collection()
  {
    return Address::all();
  }


  public function headings(): array
  {
    return Schema::getColumnListing('addresses');
  }
}