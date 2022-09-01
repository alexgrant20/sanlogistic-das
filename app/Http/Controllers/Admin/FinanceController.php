<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Exports\ActivityRecapExport;
use App\Http\Requests\Admin\UpdateActivityCostRequest;
use App\Models\Activity;
use App\Models\ActivityPayment;
use App\Models\ActivityStatus;
use App\Models\Project;
use App\Transaction\Constants\NotifactionTypeConstant;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class FinanceController extends Controller
{
  public function acceptance(Request $request)
  {
    $q_status = $request->status;

    $activities = DB::table('activities')
      ->leftJoin('users', 'activities.user_id', '=', 'users.id')
      ->leftJoin('people', 'users.person_id', '=', 'people.id')
      ->leftJoin('activity_statuses', 'activities.activity_status_id', '=', 'activity_statuses.id')
      ->leftJoin('activity_payments', 'activity_statuses.id', '=', 'activity_payments.activity_status_id')
      ->whereIn('activity_statuses.status', ['pending', 'rejected'])
      ->get(
        [
          'activities.id',
          'activities.departure_date',
          'do_number', 'people.name',
          'activity_payments.bbm_amount',
          'activity_payments.toll_amount',
          'activity_payments.parking_amount',
          'activity_payments.retribution_amount',
          'activity_statuses.status as status',
        ]
      );

    $activities_filtered = empty($q_status) ?  $activities : $activities->filter(fn ($item) => $item->status === $q_status);

    return view('admin.finance.acceptance.index', [
      'activities' => $activities,
      'activities_filtered' => $activities_filtered,
      'title' => 'Acceptance'
    ]);
  }

  public function approve(Request $request)
  {
    $activityIds = json_decode($request->getContent());

    $activities = DB::table('activities')
      ->leftJoin('activity_statuses', 'activities.activity_status_id', '=', 'activity_statuses.id')
      ->leftJoin('activity_payments', 'activity_statuses.id', '=', 'activity_payments.activity_status_id')
      ->whereIn('activities.id', $activityIds)
      ->get([
        'activities.id',
        'bbm_amount',
        'parking_amount',
        'toll_amount',
        'retribution_amount',
      ]);

    foreach ($activities as $activity) {
      try {
        DB::transaction(function () use ($activity) {
          $activityStatus = ActivityStatus::create([
            'activity_id' => $activity->id,
            'status' => 'approved',
          ]);

          ActivityPayment::create([
            'activity_status_id' => $activityStatus->id,
            'bbm_amount' => $activity->bbm_amount,
            'parking_amount' => $activity->parking_amount,
            'toll_amount' => $activity->toll_amount,
            'retribution_amount' => $activity->retribution_amount,
          ]);
        });
      } catch (Exception $e) {
        return to_route('admin.finance.acceptance')
          ->with(genereateNotifaction(NotifactionTypeConstant::ERROR, 'activity', 'approve'));
      }
    }
    return to_route('admin.finance.acceptance')
      ->with(genereateNotifaction(NotifactionTypeConstant::SUCCESS, 'activity', 'approved'));
  }

  public function pay(Request $request)
  {
    $userIds = json_decode($request->getContent());

    $activities = DB::table('activities')
      ->leftJoin('activity_statuses', 'activities.activity_status_id', '=', 'activity_statuses.id')
      ->leftJoin('activity_payments', 'activity_statuses.id', '=', 'activity_payments.activity_status_id')
      ->whereIn('user_id', $userIds)
      ->get([
        'activities.id',
        'bbm_amount',
        'parking_amount',
        'toll_amount',
        'retribution_amount',
      ]);

    foreach ($activities as $activity) {
      try {
        DB::transaction(function () use ($activity) {
          $activityStatus = ActivityStatus::create([
            'activity_id' => $activity->id,
            'status' => 'paid',
          ]);

          ActivityPayment::create([
            'activity_status_id' => $activityStatus->id,
            'bbm_amount' => $activity->bbm_amount,
            'parking_amount' => $activity->parking_amount,
            'toll_amount' => $activity->toll_amount,
            'retribution_amount' => $activity->retribution_amount,
          ]);
        });
      } catch (Exception $e) {
        return to_route('admin.finance.payment')
          ->with(genereateNotifaction(NotifactionTypeConstant::ERROR, 'activity', 'pay'));
      }
    }
    return to_route('admin.finance.payment')
      ->with(genereateNotifaction(NotifactionTypeConstant::SUCCESS, 'activity', 'paid'));
  }

  public function reject(Request $request)
  {
    $request->validate([
      'project_id' => 'required',
      'user_id' => 'required',
    ]);

    $activities = DB::table('activities')
      ->leftJoin('activity_statuses', 'activities.activity_status_id', '=', 'activity_statuses.id')
      ->leftJoin('activity_payments', 'activity_statuses.id', '=', 'activity_payments.activity_status_id')
      ->where('project_id', '=', $request->project_id)
      ->where('user_id', '=', $request->user_id)
      ->where('status', '=', 'approved')
      ->get([
        'activities.id',
        'bbm_amount',
        'parking_amount',
        'toll_amount',
        'retribution_amount',
      ]);

    try {
      foreach ($activities as $activity) {
        DB::transaction(function () use ($activity) {
          $activityStatus = ActivityStatus::create([
            'activity_id' => $activity->id,
            'status' => 'rejected',
          ]);

          ActivityPayment::create([
            'activity_status_id' => $activityStatus->id,
            'bbm_amount' => $activity->bbm_amount,
            'parking_amount' => $activity->parking_amount,
            'toll_amount' => $activity->toll_amount,
            'retribution_amount' => $activity->retribution_amount,
          ]);
        });
      }
    } catch (Exception $e) {
      return to_route('admin.finance.payment')
        ->with(genereateNotifaction(NotifactionTypeConstant::ERROR, 'activity', 'reject'));
    }
    return to_route('admin.finance.payment')
      ->with(genereateNotifaction(NotifactionTypeConstant::SUCCESS, 'activity', 'rejected'));
  }

  public function edit(Activity $activity)
  {
    return view('admin.finance.acceptance.edit', [
      'activities' => Activity::status('pending')->get(),
      'importPath' => '/admin/finance/acceptance/import/excel',
      'title' => 'Acceptance',
      'activity' => $activity,
    ]);
  }

  public function audit(UpdateActivityCostRequest $request, Activity $activity)
  {
    DB::beginTransaction();
    try {
      $activityStatus = ActivityStatus::create([
        'activity_id' => $activity->id,
        'status' => 'approved'
      ]);

      ActivityPayment::create([
        'activity_status_id' => $activityStatus->id,
        'bbm_amount' => $request->bbm_amount,
        'parking_amount' => $request->parking_amount,
        'toll_amount' => $request->toll_amount,
        'retribution_amount' => $request->retribution_amount,
      ]);
    } catch (Exception $e) {
      DB::rollBack();

      return redirect("/admin/finances/acceptance/$activity->id/edit")->withInput()
        ->with(genereateNotifaction(NotifactionTypeConstant::ERROR, 'activity', 'audit'));
    }
    DB::commit();

    return to_route('admin.finance.acceptance')
      ->with(genereateNotifaction(NotifactionTypeConstant::SUCCESS, 'activity', 'audited'));
  }

  public function payment()
  {
    $activities = DB::table('activities')
      ->leftJoin('projects', 'activities.project_id', '=', 'projects.id')
      ->leftJoin('users', 'activities.user_id', '=', 'users.id')
      ->leftJoin('people', 'users.person_id', '=', 'people.id')
      ->leftJoin('activity_statuses', 'activities.activity_status_id', '=', 'activity_statuses.id')
      ->leftJoin('activity_payments', 'activity_statuses.id', '=', 'activity_payments.activity_status_id')
      ->selectRaw("SUM(activity_payments.bbm_amount) total_bbm")
      ->selectRaw("SUM(activity_payments.toll_amount) total_toll")
      ->selectRaw("SUM(activity_payments.parking_amount) total_park")
      ->selectRaw("SUM(activity_payments.retribution_amount) total_retribution")
      ->selectRaw("projects.name as project_name, people.name as person_name, activities.user_id as user_id,
      activities.project_id as project_id, activity_statuses.status as status")
      ->groupBy('activities.project_id')
      ->groupBy('user_id')
      ->orderByDesc('activity_payments.id')
      ->where('activity_statuses.status', '=', 'approved')
      ->get();

    return view('admin.finance.payment.index', [
      'activities' => $activities,
      'title' => 'Pay',
      'projects' => Project::all(),
    ]);
  }

  public function exportExcel(Request $request)
  {
    $timestamp = now()->timestamp;
    $params = $request->validate([
      'month' => 'required',
      'project_id' => 'required',
    ]);

    return Excel::download(new ActivityRecapExport($params), "activities_export_{$timestamp}.xlsx");
  }
}