<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class IndexController extends Controller
{
  public function index()
  {
    $userID = auth()->user()->id;

    $isUserDriver = User::find($userID)->hasRole('driver');

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