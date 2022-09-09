<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Models\User;
use App\Transaction\Constants\NotifactionTypeConstant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
  public function index()
  {
    return view('login.index');
  }

  public function login(Request $request)
  {
    $request->validate([
      'username' => 'required',
      'password' => 'required'
    ]);

    $user = User::where('username', $request->username)->first();

    if ($user && Hash::check($request->password, $user->password)) {
      Auth::login($user);
      $request->session()->regenerate();

      if ($user->hasRole('driver')) {
        $activity = Activity::whereRelation('activityStatus', 'status', 'draft')
          ->where('user_id', $user->id)
          ->where('created_by', $user->id)
          ->latest()
          ->limit(1)
          ->first();
        if ($activity && $activity->id) $request->session()->put('activity_id', $activity->id);
      }

      Auth::logoutOtherDevices(request('password'));

      return to_route('index')
        ->with(genereateNotifaction(NotifactionTypeConstant::SUCCESS, 'Login Successfull!'));
    }

    return to_route('login')
      ->with(genereateNotifaction(NotifactionTypeConstant::ERROR, "Username or Password Not Found!"));
  }

  public function logout(Request $request)
  {
    Auth::logout();

    $request->session()->invalidate();

    $request->session()->regenerateToken();

    Cache::flush();

    return to_route('login')
      ->with(genereateNotifaction(NotifactionTypeConstant::SUCCESS, 'Logout Successfull!'));
  }
}