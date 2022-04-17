<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
  public function index()
  {
    return view('user.login.index');
  }

  public function authenticate(Request $request)
  {
    try {
      $credentials = $request->validate([
        'username' => 'required',
        'password' => 'required'
      ]);

      $user = User::where('username', $request->username)->first();

      if ($user) {
        if (Hash::check($request->password, $user->password) && !$user->hasRole('driver')) {
          Auth::login($user);
          $request->session()->regenerate();
          return redirect()->intended('/');
        }
      }

      return back()->with('error', 'Login Failed!');
    } catch (QueryException $e) {
      return back()->with('error', 'Failed to Connect to Server!');
    } catch (Exception $e) {
      return back()->with('error', $e->getMessage());
    }
  }

  public function logout(Request $request)
  {
    Auth::logout();

    $request->session()->invalidate();

    $request->session()->regenerateToken();

    return redirect('/login');
  }
}