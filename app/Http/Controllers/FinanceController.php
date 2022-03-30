<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\ActivityStatus;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FinanceController extends Controller
{
  public function acceptance()
  {
    return view('finance.acceptance', [
      'activities' => Activity::status('pending')->get(),
      'importPath' => '/finance/acceptance/import/excel',
      'title' => 'Acceptance'
    ]);
  }

  public function payment()
  {
    return view('finance.payment', [
      'activities' => Activity::status('approved')->get(),
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
}