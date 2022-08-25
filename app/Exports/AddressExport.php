<?php

namespace App\Exports;

use App\Models\Address;
use Illuminate\Support\Facades\DB;
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
    $idsExists = count($this->ids) !== 0;

    $addresses = DB::table('addresses')
      ->leftJoin('address_types', 'addresses.address_type_id', '=', 'address_types.id')
      ->leftJoin('subdistricts', 'addresses.subdistrict_id', '=', 'subdistricts.id')
      ->leftJoin('districts', 'subdistricts.district_id', '=', 'districts.id')
      ->leftJoin('cities', 'districts.city_id', '=', 'cities.id')
      ->leftJoin('provinces', 'cities.province_id', '=', 'provinces.id')
      ->when($idsExists, function ($query, $idsExists) {
        if ($idsExists) {
          return $query->whereIn('addresses.id', $this->ids);
        }
      })
      ->orderByDesc('addresses.created_at')
      ->get(
        [
          'addresses.id AS address_id',
          'addresses.name AS address_name',
          'addresses.full_address AS full_address',
          'subdistricts.name AS subdistrict_name',
          'districts.name AS district_name',
          'address_types.name AS address_types_name',
          'cities.name AS cities_name',
          'provinces.name AS provinces_name'
        ]
      );

    return $addresses;
  }


  public function headings(): array
  {
    return [
      'ID',
      'ACTIVITIES NAME',
      'FULL ADDRESS',
      'SUBDISTRICT NAME',
      'DISTRICT NAME',
      'ADDRESS TYPE',
      'CITY NAME',
      'PROVINCE NAME',
    ];
  }
}