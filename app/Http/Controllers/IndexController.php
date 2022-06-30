<?php

namespace App\Http\Controllers;

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
      return view('driver.index', $params);
    } else {
      return view('admin.index', $params);
    }
  }
}