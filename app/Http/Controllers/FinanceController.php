<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateActivityCostRequest;
use App\Models\Activity;
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
        ActivityStatus::create([
          'activity_id' => $id,
          'status' => 'approved',
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
      $activity->update($data);
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
      'activities' => Activity::status('approved')->get(),
      'importPath' => '/finance/acceptance/import/excel',
      'title' => 'Acceptance'
    ]);
  }
}