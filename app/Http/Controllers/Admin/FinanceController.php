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
use Barryvdh\DomPDF\Facade\Pdf;

class FinanceController extends Controller
{
  public function __construct()
  {
    $this->middleware('can:finance-acceptance', ['only' => ['acceptance', 'approve']]);
    $this->middleware('can:finance-payment', ['only' => ['payment', 'pay', 'edit', 'audit', 'reject']]);
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
        'load_amount',
        'unload_amount',
        'maintenance_amount',
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
            'load_amount' => $activity->load_amount,
            'unload_amount' => $activity->unload_amount,
            'maintenance_amount' => $activity->maintenance_amount,
          ]);
        });
      } catch (Exception $e) {
        return to_route('admin.activities.approval')
          ->with(genereateNotifaction(NotifactionTypeConstant::ERROR, 'activity', 'approve'));
      }
    }
    return to_route('admin.activities.approval')
      ->with(genereateNotifaction(NotifactionTypeConstant::SUCCESS, 'activity', 'approved'));
  }

  public function pay(Request $request)
  {
    $userIds = json_decode($request->getContent());

    $activities = DB::table('activities AS ac')
      ->join('activity_statuses AS acs', 'acs.id', 'ac.activity_status_id')
      ->join('activity_payments AS ap', 'ap.activity_status_id', 'acs.id')
      ->where('acs.status', 'approved')
      ->whereIn('ac.user_id', $userIds)
      ->get([
        'ac.id',
        'bbm_amount',
        'parking_amount',
        'toll_amount',
        'load_amount',
        'unload_amount',
        'maintenance_amount',
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
            'load_amount' => $activity->load_amount,
            'unload_amount' => $activity->unload_amount,
            'maintenance_amount' => $activity->maintenance_amount,
          ]);
        });
      } catch (Exception $e) {
        return response()->json([
          'error' => 500,
          'message' => $e->getMessage()
        ]);
      }
    }
    return response()->json([
      'success' => 200
    ]);
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
        'load_amount',
        'unload_amount',
        'maintenance_amount'
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
            'load_amount' => $activity->load_amount,
            'unload_amount' => $activity->unload_amount,
            'maintenance_amount' => $activity->maintenance_amount,
          ]);
        });
      }
    } catch (Exception $e) {
      return to_route('admin.finances.payment')
        ->with(genereateNotifaction(NotifactionTypeConstant::ERROR, 'activity', 'reject'));
    }
    return to_route('admin.finances.payment')
      ->with(genereateNotifaction(NotifactionTypeConstant::SUCCESS, 'activity', 'rejected'));
  }

  public function edit(Activity $activity)
  {
    $activityStatus = $activity->activityStatus->status;

    if (!in_array($activityStatus, ['rejected', 'pending'])) abort(404);

    return view('admin.finance.acceptance.edit', [
      'importPath' =>  route('admin.finances.export.excel'),
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
        'load_amount' => $request->load_amount,
        'unload_amount' => $request->unload_amount,
        'maintenance_amount' => $request->maintenance_amount,
        'courier_amount' => $request->courier_amount,
        'description' => $request->description,
      ]);
    } catch (Exception $e) {
      DB::rollBack();

      return back()
        ->with(genereateNotifaction(NotifactionTypeConstant::ERROR, 'activity', 'audit'));
    }
    DB::commit();

    return to_route('admin.activities.approval')
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
      ->selectRaw("SUM(activity_payments.load_amount) total_load")
      ->selectRaw("SUM(activity_payments.unload_amount) total_unload")
      ->selectRaw("SUM(activity_payments.maintenance_amount) total_maintenance")
      ->selectRaw("SUM(activity_payments.courier_amount) total_courier")
      ->selectRaw("projects.name as project_name, projects.id as project_id, people.name as person_name, activities.user_id as user_id,
      activities.project_id as project_id, activity_statuses.status as status")
      ->groupBy('activities.project_id')
      ->groupBy('user_id')
      ->orderByDesc('activity_payments.id')
      ->where('activity_statuses.status', '=', 'approved')
      ->get();

    $projects = $activities->unique('project_id')->pluck('project_name', 'project_id');

    return view('admin.finance.payment.index', [
      'activities' => $activities,
      'title' => 'Pay',
      'projects' => $projects,
    ]);
  }

  public function exportExcel(Request $request)
  {
    $timestamp = now()->timestamp;

    $params = $request->validate([
      'project_id' => 'required',
    ]);

    return Excel::download(new ActivityRecapExport($params), "activities_export_{$timestamp}.xlsx");
  }

  public function exportPDF(Request $request)
  {
    $params = $request->validate([
      'project_id' => 'required',
    ]);

    $params = $request->input('ids');

    $ids = preg_split("/[,]/", $params);
    $data = DB::table('activities')
      ->leftJoin('projects', 'activities.project_id', '=', 'projects.id')
      ->leftJoin('users', 'activities.user_id', '=', 'users.id')
      ->leftJoin('people', 'users.person_id', '=', 'people.id')
      ->leftJoin('activity_statuses', 'activities.activity_status_id', '=', 'activity_statuses.id')
      ->leftJoin('activity_payments', 'activity_statuses.id', '=', 'activity_payments.activity_status_id')
      ->selectRaw("SUM(activity_payments.bbm_amount) total_bbm")
      ->selectRaw("SUM(activity_payments.toll_amount) total_toll")
      ->selectRaw("SUM(activity_payments.parking_amount) total_park")
      ->selectRaw("SUM(activity_payments.load_amount) total_load")
      ->selectRaw("SUM(activity_payments.unload_amount) total_unload")
      ->selectRaw("SUM(activity_payments.maintenance_amount) total_maintenance")
      ->selectRaw("SUM(activity_payments.maintenance_amount) total_courier")
      ->selectRaw("projects.name as project_name, people.name as person_name, activities.user_id as user_id,
    activities.project_id as project_id, activity_statuses.status as status")
      ->groupBy('user_id')
      ->orderBy('people.name')
      ->where('activity_statuses.status', '=', 'approved')
      ->where('activities.project_id', '=', $request->project_id)
      ->get();

    if ($data->isEmpty()) return back()->with(genereateNotifaction(NotifactionTypeConstant::ERROR, 'No Data Found!'));

    $pdf = Pdf::loadView('pdf.finance', compact('data'));

    return  $pdf->download('Finance-' .  now()->timestamp . '.pdf');
  }
}
