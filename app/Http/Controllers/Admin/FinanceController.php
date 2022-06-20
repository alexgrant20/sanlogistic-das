<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Exports\ActivityRecapExport;
use App\Http\Requests\UpdateActivityCostRequest;
use App\Models\Activity;
use App\Models\ActivityPayment;
use App\Models\ActivityStatus;
use App\Models\Project;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class FinanceController extends Controller
{
  public function acceptance()
  {

    return view('admin.finance.acceptance.index', [
      'activities' => Activity::with('driver', 'driver.person')->status('pending')->orWhereRelation('activityStatus', 'status', 'rejected')->get(),
      'title' => 'Acceptance'
    ]);
  }

  public function approve(Request $request)
  {
    try {
      $ids = json_decode($request->getContent());

      DB::beginTransaction();
      foreach ($ids as $id) {

        $data = Activity::find($id)->activityStatus->activityPayment;

        $activityStatus = ActivityStatus::create([
          'activity_id' => $id,
          'status' => 'approved',
        ]);


        ActivityPayment::create([
          'activity_status_id' => $activityStatus->id,
          'bbm_amount' => $data->bbm_amount,
          'parking_amount' => $data->parking_amount,
          'toll_amount' => $data->toll_amount,
          'retribution_amount' => $data->retribution_amount,
        ]);
      }
      DB::commit();
    } catch (Exception $e) {
      DB::rollBack();
      dd($e->getMessage());
    }
  }

  public function pay(Request $request)
  {
    try {
      $ids = json_decode($request->getContent());

      $activities = Activity::whereIn('user_id', $ids)->status('approved')->get();

      DB::beginTransaction();

      foreach ($activities as $activity) {
        $activityStatus = ActivityStatus::create([
          'activity_id' => $activity['id'],
          'status' => 'paid',
        ]);

        ActivityPayment::create([
          'activity_status_id' => $activityStatus->id,
          'bbm_amount' => $activity->activityStatus->activityPayment->bbm_amount,
          'parking_amount' => $activity->activityStatus->activityPayment->parking_amount,
          'toll_amount' => $activity->activityStatus->activityPayment->toll_amount,
          'retribution_amount' => $activity->activityStatus->activityPayment->retribution_amount,
        ]);
      }
      DB::commit();
    } catch (Exception $e) {
      DB::rollBack();
    }
  }

  public function reject(Request $request)
  {
    $data = $request->validate([
      'project_id' => 'required',
      'user_id' => 'required',
    ]);

    $activities = Activity::where('project_id', $data['project_id'])->where('user_id', $data['user_id'])->status('approved')->get();

    try {

      DB::beginTransaction();

      foreach ($activities as $activity) {
        $activityStatus = ActivityStatus::create([
          'activity_id' => $activity['id'],
          'status' => 'rejected',
        ]);

        ActivityPayment::create([
          'activity_status_id' => $activityStatus->id,
          'bbm_amount' => $activity->activityStatus->activityPayment->bbm_amount,
          'parking_amount' => $activity->activityStatus->activityPayment->parking_amount,
          'toll_amount' => $activity->activityStatus->activityPayment->toll_amount,
          'retribution_amount' => $activity->activityStatus->activityPayment->retribution_amount,
        ]);
      }

      DB::commit();

      $notification = array(
        'message' => 'Activity successfully rejected!',
        'alert-type' => 'success',
      );

      return to_route('admin.finance.payment')->with($notification);
    } catch (Exception $e) {
      DB::rollBack();

      $notification = array(
        'message' => 'Activity failed to reject!',
        'alert-type' => 'error',
      );

      return to_route('admin.finance.payment')->with($notification);
    }
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
    try {
      $data = $request->safe()->all();


      foreach ($data as $key => $x) $data[$key] = preg_replace("/[^0-9]/", "", $x);

      DB::beginTransaction();

      $activityStatus = ActivityStatus::create([
        'activity_id' => $activity->id,
        'status' => 'approved'
      ]);

      ActivityPayment::create([
        'activity_status_id' => $activityStatus->id,
        'bbm_amount' => $data['bbm_amount'],
        'parking_amount' => $data['parking'],
        'toll_amount' => $data['toll_amount'],
        'retribution_amount' => $data['retribution_amount'],
      ]);

      DB::commit();

      $notification = array(
        'message' => 'Activity successfully audited!',
        'alert-type' => 'success',
      );

      return to_route('admin.finance.acceptance')->with($notification);
    } catch (Exception $e) {
      DB::rollBack();

      $notification = array(
        'message' => 'Activity failed to audit!',
        'alert-type' => 'error',
      );

      return redirect("/finances/acceptance/$activity->id/edit")->withInput()->with($notification);
    }
  }

  public function payment()
  {
    return view('admin.finance.payment.index', [
      'activities' => Activity::join('projects', 'activities.project_id', '=', 'projects.id')
        ->join('users', 'activities.user_id', '=', 'users.id')
        ->join('people', 'users.person_id', '=', 'people.id')
        ->join('activity_statuses', 'activities.activity_status_id', '=', 'activity_statuses.id')
        ->join('activity_payments', 'activity_statuses.id', '=', 'activity_payments.activity_status_id')
        ->selectRaw("SUM(activity_payments.bbm_amount) as total_bbm")
        ->selectRaw("SUM(activity_payments.toll_amount) as total_toll")
        ->selectRaw("SUM(activity_payments.parking_amount) as total_park")
        ->selectRaw("SUM(activity_payments.retribution_amount) as total_retribution")
        ->selectRaw("projects.name as project_name, people.name as person_name, activities.user_id as user_id, activities.project_id as project_id")
        ->groupBy('activities.project_id')
        ->groupBy('user_id')
        ->orderByDesc('activity_payments.id')
        ->status('approved')
        ->get(),
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
