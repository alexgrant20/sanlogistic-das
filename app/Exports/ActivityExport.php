<?php

namespace App\Exports;

use App\Models\Activity;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ActivityExport implements FromCollection, WithHeadings, ShouldAutoSize
{
  private $ids;

  public function __construct(array $ids)
  {
    $this->ids = $ids;
  }

  public function collection()
  {
    $idsExists = count($this->ids) === 0;

    $activities = DB::table('activities')
      ->leftJoin('activity_statuses', 'activities.activity_status_id', '=', 'activity_statuses.id')
      ->leftJoin('users', 'activities.user_id', '=', 'users.id')
      ->leftJoin('people', 'users.person_id', '=', 'people.id')
      ->leftJoin('vehicles', 'activities.vehicle_id', '=', 'vehicles.id')
      ->leftJoin(DB::raw('addresses dep'), 'activities.departure_location_id', '=', 'dep.id')
      ->leftJoin(DB::raw('addresses arr'), 'activities.arrival_location_id', '=', 'arr.id')
      ->leftJoin('projects', 'activities.project_id', '=', 'projects.id')
      ->leftJoin('companies', 'projects.company_id', '=', 'companies.id')
      // nambah BBM Toll Sollar yang sudah di approve per activity blm tahu cara nya
      ->leftJoin('activity_payments', 'activity_payments.activity_status_id', '=', 'activity_statuses.id')
      ->when($idsExists, function ($query, $idsExists) {
        if ($idsExists) {
          return $query->whereIn('activities.id', $this->ids);
        }
      })
      ->orderByDesc('activities.created_at')
      ->get(
        [
          'activities.do_number AS do_number',
          DB::raw('DAY(do_date) AS do_date'),
          DB::raw('MONTHNAME(do_date) AS do_month'),
          'dep.name AS departure_address',
          DB::raw('DAY(departure_date) AS dep_date'),
          DB::raw('MONTHNAME(departure_date) AS dep_month'),
          DB::raw('CAST(departure_date AS time) AS dep_time'), // lupa pakai apa tadi untuk hh:mm
          'activities.departure_odo As dep_odo',
          'arr.name AS arrival_address',
          DB::raw('DAY(arrival_date) AS arr_date'),
          DB::raw('MONTHNAME(arrival_date) AS arr_month'),
          DB::raw('CAST(arrival_date AS time) AS arr_time'), // lupa pakai apa tadi untuk hh:mm
          'activities.arrival_odo AS arr_odo',
          'vehicles.license_plate AS license_plate',
          'people.name AS person_name',
          'companies.name AS comp_name', //ambil nama companies untuk kolom Customer
          //Null for 'FREIGHT',
          DB::raw('"" AS FREIGHT'),
          //'PRODUCT NAME',
          DB::raw('"" AS PRODUCT'),
          //'QUANTITY',
          DB::raw('"" AS QUANTITY'),
          //'FREIGHT RETURNED',
          DB::raw('"" AS FREIGHT_RETURNED'),
          //'FREIGHT LOST',
          DB::raw('"" AS FREIGHT_LOST'),
          //'VOLUMEPENGISIAN',
          DB::raw('"" AS VOLUMEPENGISIAN'),
          'activities.type AS act_type', //Delivery Category
          // null for :
          //'DELIVERY REMARKS I',
          DB::raw('"" AS DELIVERY_REMARKS_I'),
          //'DELIVERY REMARKS II',
          DB::raw('"" AS DELIVERY_REMARKS_II'),
          //'Fuel Note',
          DB::raw('"" AS Fuel_Note'),
          'activity_payments.bbm_amount AS bbm',
          'activity_payments.toll_amount AS toll',
          'activity_payments.parking_amount AS parking',
          //'MAINTENANCE',
          DB::raw('"" AS MAINTENANCE'),
          //'LOADING EXPENSES',
          DB::raw('"" AS LOADING_EXPENSES'),
          //'UNLOADING EXPENSES',
          DB::raw('"" AS UNLOADING_EXPENSES'),
          //'Transport',
          DB::raw('"" AS Transport'),
          'activity_payments.retribution_amount AS retribution',
          //'IFRETRIBUTION EXPENSES',
          DB::raw('"" AS IFRETRIBUTION_EXPENSES'),
          //'ZONE',
          DB::raw('"" AS ZONE'),
          //'DCODE',
          DB::raw('"" AS DCODE'),
          //'DISTANCE', // odo akhir - odo awal gimana caranya tuh
          DB::raw('arrival_odo - departure_odo AS DISTANCE'),
          //'TOTAL COST',
          DB::raw('activity_payments.bbm_amount + activity_payments.toll_amount
          + activity_payments.parking_amount + activity_payments.retribution_amount AS total_cost')
        ]
      );

    return $activities;
  }

  public function headings(): array
  {
    return [
      'NO DO',
      'DODATE',
      'DOMONTH',
      'ORIGIN',
      'DDATE',
      'DMONTH',
      'DTIME',
      'DODOMETER',
      'DESTINATION',
      'ADATE',
      'AMONTH',
      'ATIME',
      'AODOMETER',
      'VEHICLE REG',
      'DRIVER',
      'CUSTOMER',
      'FREIGHT',
      'PRODUCT NAME',
      'QUANTITY',
      'FREIGHT RETURNED',
      'FREIGHT LOST',
      'VOLUMEPENGISIAN',
      'DELIVERY CATEGORY',
      'DELIVERY REMARKS I',
      'DELIVERY REMARKS II',
      'Fuel Note',
      'FUEL EXPENSES',
      'TOLL ROAD EXPENSES',
      'PARKING EXPENSES',
      'MAINTENANCE',
      'LOADING EXPENSES',
      'UNLOADING EXPENSES',
      'Transport',
      'FRETRIBUTION EXPENSES',
      'IFRETRIBUTION EXPENSES',
      'ZONE',
      'DCODE',
      'DISTANCE',
      'TOTAL COST',

    ];
  }
}