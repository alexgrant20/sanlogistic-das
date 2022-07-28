<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class IndexController extends Controller
{
  public function index()
  {
    $isUserDriver = Session::get('user_role') === 'driver';

    $params = [
      'title' => 'Home'
    ];

    if ($isUserDriver) {
      $activity = Activity::where('user_id', auth()->user()->id)
        ->with(['departureLocation', 'arrivalLocation'])
        ->latest()
        ->first();

      $params['activity'] = $activity;

      return view('driver.index', $params);
    } else {
      return view('admin.index', $params);
    }
  }
}