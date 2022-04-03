<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

      if (Auth::attempt($credentials)) {
        $request->session()->regenerate();

        return redirect()->intended('/');
      }

      return back()->with('error', 'Login Failed!');
    } catch (QueryException $e) {
      return back()->with('error', 'Failed to Connect to Server!');
    } catch (Exception $e) {
      return back()->with('error', 'Server is Busy!');
    }
  }

  public function logout(Request $request)
  {
    Auth::logout();

    $request->session()->invalidate();

    $request->session()->regenerateToken();

    return redirect('/');
  }
}