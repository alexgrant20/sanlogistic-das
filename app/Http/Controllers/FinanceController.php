<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use Illuminate\Http\Request;

class FinanceController extends Controller
{
  public function acceptance()
  {
    return view('finance.acceptance', [
      'activities' => Activity::whereRelation('activityStatus', 'status', '=', 'pending')->get(),
      'importPath' => '/finance/acceptance/import/excel',
      'title' => 'Acceptance'
    ]);
  }

  public function payment()
  {
    return view('finance.payment', [
      'activities' => Activity::whereRelation('activityStatus', 'status', '=', 'approved')->get(),
      'importPath' => '/finance/acceptance/import/excel',
      'title' => 'Acceptance'
    ]);
  }
}