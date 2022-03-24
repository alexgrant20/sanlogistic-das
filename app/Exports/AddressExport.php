<?php

namespace App\Exports;

use App\Models\Address;
use Maatwebsite\Excel\Concerns\FromCollection;

class AddressExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Address::all();
    }
}
