<?php

namespace App\Exports;

use App\Models\Vehicle;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class VehicleExport implements FromCollection, WithHeadings, ShouldAutoSize
{
  private $ids;

  public function __construct(array $ids)
  {
    $this->ids = $ids;
  }

  public function collection()
  {
    $idsExists = count($this->ids) !== 0;

    $vehicles = DB::table('vehicles')
      ->leftJoin('companies', 'vehicles.owner_id', '=', 'companies.id')
      ->leftJoin('projects', 'vehicles.project_id', '=', 'projects.id')
      ->leftJoin('areas', 'vehicles.area_id', '=', 'areas.id')
      ->leftJoin('vehicle_varieties', 'vehicles.vehicle_variety_id', '=', 'vehicle_varieties.id')
      ->leftJoin('vehicle_types', 'vehicle_varieties.vehicle_type_id', '=', 'vehicle_types.id')
      ->leftJoin('vehicle_brands', 'vehicle_types.vehicle_brand_id', '=', 'vehicle_brands.id')
      ->leftJoin('addresses', 'vehicles.address_id', '=', 'addresses.id')
      ->leftJoin('vehicle_towings', 'vehicles.vehicle_towing_id', '=', 'vehicle_towings.id')
      ->leftJoin('vehicle_documents AS kir', function ($join) {
        $join->on('kir.vehicle_id', '=', 'vehicles.id');
        $join->where('kir.type', '=', 'kir');
      })
      ->leftJoin('vehicle_documents AS stnk', function ($join) {
        $join->on('stnk.vehicle_id', '=', 'vehicles.id');
        $join->where('stnk.type', '=', 'stnk');
      })
      ->when($idsExists, function ($query, $idsExists) {
        if ($idsExists) {
          return $query->whereIn('vehicles.id', $this->ids);
        }
      })
      ->orderByDesc('vehicles.created_at')
      ->get([
        'vehicles.id',
        'license_plate',
        'vehicle_license_plate_color_id',
        'companies.name AS company_name',
        'projects.name AS project_name',
        'vehicles.status AS status',
        'vehicle_brands.name AS vehicle_brand',
        'vehicle_types.name AS vehicle_type',
        'odo',
        'kir.expire AS kir_expire',
        'stnk.expire AS stnk_expire',
      ]);

    return $vehicles;
  }

  public function headings(): array
  {
    return [
      'ID',
      'LICENSE PLATE',
      'LICENSE PLATE COLOR',
      'COMPANY NAME',
      'PROJECT NAME',
      'STATUS',
      'VEHICLE BRAND',
      'VEHICLE TYPE',
      'ODO',
      'KIR EXPIRE',
      'STNK EXPIRE'
    ];
  }
}