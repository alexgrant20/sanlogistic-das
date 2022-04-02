<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateActivityCostRequest;
use App\Models\Activity;
use App\Models\ActivityPayment;
use App\Models\ActivityStatus;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FinanceController extends Controller
{
  public function acceptance()
  {
    return view('finance.acceptance.index', [
      'activities' => Activity::status('pending')->get(),
      'importPath' => '/finance/acceptance/import/excel',
      'title' => 'Acceptance'
    ]);
  }

  public function approve(Request $request)
  {
    try {
      $ids = json_decode($request->getContent());

      DB::beginTransaction();

      foreach ($ids as $id) {

        $activityStatus = ActivityStatus::create([
          'activity_id' => $id,
          'status' => 'approved',
        ]);

        $data = Activity::where('id', $id)->first();

        ActivityPayment::create([
          'activity_status_id' => $activityStatus->id,
          'bbm_amount' => $data['bbm_amount'],
          'parking_amount' => $data['parking'],
          'toll_amount' => $data['toll_amount'],
          'retribution_amount' => $data['retribution_amount'],
        ]);
      }

      DB::commit();

      session()->flash('success', 'Activity approved!');
    } catch (Exception $e) {
      DB::rollBack();
      session()->flash('error', 'Failed to approved!');
    }
  }

  public function edit(Activity $activity)
  {
    return view('finance.acceptance.edit', [
      'activities' => Activity::status('pending')->get(),
      'importPath' => '/finance/acceptance/import/excel',
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

      return redirect('/finances/acceptance')->with('success', 'Activity has been audited!');
    } catch (Exception $e) {
      DB::rollBack();
      return redirect("/finances/acceptance/$activity->id/edit")->withInput()->with('error', 'Failed to audit activity!');
    }
  }

  public function payment()
  {
    return view('finance.payment.index', [
      'activities' => Activity::join('projects', 'activities.project_id', '=', 'projects.id')
        ->join('users', 'activities.user_id', '=', 'users.id')
        ->join('people', 'users.person_id', '=', 'people.id')
        ->join('activity_statuses', 'activities.activity_status_id', '=', 'activity_statuses.id')
        ->join('activity_payments', 'activity_statuses.id', '=', 'activity_payments.activity_status_id')
        ->selectRaw("SUM(activity_payments.bbm_amount) as total_bbm")
        ->selectRaw("SUM(activity_payments.toll_amount) as total_toll")
        ->selectRaw("SUM(activity_payments.parking_amount) as total_park")
        ->selectRaw("SUM(activity_payments.retribution_amount) as total_retribution")
        ->selectRaw("projects.name as project_name, people.name as person_name")
        ->groupBy('activities.project_id')
        ->groupBy('user_id')
        ->orderByDesc('activity_payments.id')
        ->get(),
      'importPath' => '/finance/acceptance/import/excel',
      'title' => 'Acceptance'
    ]);
  }
}