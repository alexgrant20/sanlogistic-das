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

    return Activity::join('projects', 'activities.project_id', '=', 'projects.id')
      ->join('users', 'activities.user_id', '=', 'users.id')
      ->join('people', 'users.person_id', '=', 'people.id')
      ->join('activity_statuses', 'activities.activity_status_id', '=', 'activity_statuses.id')
      ->join('activity_payments', 'activity_statuses.id', '=', 'activity_payments.activity_status_id')
      ->selectRaw("projects.name as project_name, people.name as person_name")
      ->selectRaw("SUM(activity_payments.bbm_amount) as total_bbm")
      ->selectRaw("SUM(activity_payments.toll_amount) as total_toll")
      ->selectRaw("SUM(activity_payments.parking_amount) as total_park")
      ->selectRaw("SUM(activity_payments.retribution_amount) as total_retribution")
      ->selectRaw("SUM(activity_payments.bbm_amount) + SUM(activity_payments.toll_amount) + SUM(activity_payments.parking_amount) + SUM(activity_payments.retribution_amount) as total")
      ->where('activities.project_id', $this->params['project_id'])
      ->whereRelation('activityStatus', 'status', 'approved')
      ->whereRelation('activityStatus', function ($q) {
        $q->whereMonth('created_at', '=', $this->params['month']);
      })
      ->get()
      ->groupBy('user_id');
  }

  public function headings(): array
  {
    return [
      'PROJECT NAME',
      'PERSON NAME',
      'TOTAL BBM',
      'TOTAL TOLL',
      'TOTAL PARK',
      'TOTAL RETRIBUTION',
      'TOTAL'
    ];
  }
}