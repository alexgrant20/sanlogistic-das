<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Models\Role;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{

  public function create($id)
  {
    return view('user.register.index', [
      'title' => 'Register',
      'roles' => Role::all(),
      'person_id' => $id
    ]);
  }

  public function store(StoreUserRequest $request)
  {
    $data = $request->safe()->all();

    $data['password'] = Hash::make($data['password']);

    try {
      DB::beginTransaction();

      User::create($data);

      DB::commit();

      return redirect("/people")->with('success', 'User successfully created!');
    } catch (Exception $e) {
      return redirect("/register/{$data['person_id']}")->withInput()->with('error', $e->getMessage());
    }
  }
}