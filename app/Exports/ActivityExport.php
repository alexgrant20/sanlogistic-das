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
      ->when($idsExists, function ($query, $idsExists) {
        if ($idsExists) {
          return $query->whereIn('activities.id', $this->ids);
        }
      })
      ->orderByDesc('activities.created_at')
      ->get(
        [
          'activities.id AS activities_id',
          'activities.type AS activities_type',
          'activities.departure_date AS activities_departure_date',
          'people.name AS person_name',
          'vehicles.license_plate AS license_plate',
          'activities.do_number AS do_number',
          'dep.name AS departure_name',
          'arr.name AS arrival_name',
          'activity_statuses.status AS status',
          'do_date AS do_full_date',
          DB::raw('MONTHNAME(do_date) AS do_month'),
          DB::raw('YEAR(do_date) AS do_year'),
          DB::raw('DAY(do_date) AS do_date'),
        ]
      );

    return $activities;
  }

  public function headings(): array
  {
    return [
      'AKTIVITAS ID',
      'ACTIVITIES TYPE',
      'DEPARTURE DATE',
      'PERSON NAME',
      'LICENSE PLATE',
      'DO NUMBER',
      'DEPARTURE NAME',
      'ARRIVAL NAME',
      'STATUS',
      'DO FULL DATE',
      'DO MONTH',
      'DO YEAR',
      'DO DATE',
    ];
  }
}