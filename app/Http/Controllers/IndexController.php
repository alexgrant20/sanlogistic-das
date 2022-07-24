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
      $activities = Activity::with(['departureLocation', 'arrivalLocation'])->limit(3)->paginate(1);

      $params['activities'] = $activities;

      return view('driver.index', $params);
    } else {
      return view('admin.index', $params);
    }
  }
}
