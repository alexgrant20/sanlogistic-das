<?php

namespace App\Exports;

use App\Models\Activity;
use Illuminate\Support\Facades\Schema;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ActivityRecapExport implements FromCollection, WithHeadings, ShouldAutoSize
{
  private $params;

  public function __construct(array $params)
  {
    $this->params = $params;
  }

  public function collection()
  {
    $mainQuery = Activity::join('projects', 'activities.project_id', 'projects.id')
      ->join('users', 'activities.user_id', 'users.id')
      ->join('people', 'users.person_id', 'people.id')
      ->join('activity_statuses', 'activities.activity_status_id', 'activity_statuses.id')
      ->join('activity_payments', 'activity_statuses.id', 'activity_payments.activity_status_id')
      ->selectRaw("projects.name as project_name, people.name as person_name")
      ->selectRaw("SUM(activity_payments.bbm_amount) total_bbm")
      ->selectRaw("SUM(activity_payments.toll_amount) total_toll")
      ->selectRaw("SUM(activity_payments.parking_amount) total_park")
      ->selectRaw("SUM(activity_payments.load_amount) + SUM(activity_payments.unload_amount) total_load")
      ->selectRaw("SUM(activity_payments.maintenance_amount) total_maintenance")
      ->selectRaw("SUM(activity_payments.courier_amount) total_courier")
      ->selectRaw("SUM(activity_payments.bbm_amount) + SUM(activity_payments.toll_amount) + SUM(activity_payments.parking_amount) + SUM(activity_payments.load_amount) + SUM(activity_payments.unload_amount) + SUM(activity_payments.maintenance_amount)  as total")
      ->where('activities.project_id', $this->params['project_id'])
      ->where('activity_statuses.status', 'approved');

    $payloads = $mainQuery->groupBy('user_id')->get();
    $totalTrip = $mainQuery->where('activities.type', 'return')->count();

    foreach ($payloads as $payload) {
      $payload->total_trip = $totalTrip;
      $payload->average = $payload->total / $totalTrip;
    }

    return $payloads;
  }

  public function headings(): array
  {
    return [
      'PROJECT NAME',
      'PERSON NAME',
      'TOTAL BBM',
      'TOTAL TOLL',
      'TOTAL PARK',
      'TOTAL UN/LOAD',
      'TOTAL MAINTENANCE',
      'TOTAL COURIER',
      'TOTAL',
      'TOTAL_TRIP',
      'AVERAGE'
    ];
  }
}
