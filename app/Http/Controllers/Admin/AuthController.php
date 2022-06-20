<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
  public function index()
  {
    return view('login.index');
  }

  public function login(Request $request)
  {
    try {
      $request->validate([
        'username' => 'required',
        'password' => 'required'
      ]);

      $user = User::where('username', $request->username)->first();

      if ($user) {
        if (Hash::check($request->password, $user->password)) {
          Auth::login($user);
          $request->session()->regenerate();


          $notification = array(
            'message' => 'Login Successfull!',
            'alert-type' => 'success',
          );

          if ($user->hasRole('driver')) {
            $request->session()->put('activity_id', $user->last_activity_id);
          }
          return to_route('index')->with($notification);
        }
      }

      $notification = array(
        'message' => 'Login Failed!',
        'alert-type' => 'error',
      );
    } catch (QueryException $e) {
      $notification['message'] = 'Failed to Connect to Server!';
    } catch (Exception $e) {
      $notification['message'] = $e->getMessage();
    }
    return to_route('login')->with($notification);
  }

  public function logout(Request $request)
  {
    Auth::logout();

    $request->session()->invalidate();

    $request->session()->regenerateToken();

    $notification = array(
      'message' => 'Logout Success!',
      'alert-type' => 'success',
    );

    return to_route('login')->with($notification);
  }
}