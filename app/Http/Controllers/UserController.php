<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\Person;
use App\Models\Role;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create(Request $request)
  {
    $data = $request->all();

    $person = Person::findOrFail($data['person_id']);

    if ($person->user) return abort(404);

    return view('user.register.index', [
      'title' => 'Register',
      'roles' => Role::all(),
      'person_id' => $person->id,
    ]);
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
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
      return redirect("/people")->withInput()->with('error', $e->getMessage());
    }
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Models\User  $user
   * @return \Illuminate\Http\Response
   */
  public function show(User $user)
  {
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Models\User  $user
   * @return \Illuminate\Http\Response
   */
  public function edit(User $user)
  {
    return view('user.index', [
      'title' => 'View User',
      'user' => $user,
      'roles' => Role::all(),
    ]);
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Models\User  $user
   * @return \Illuminate\Http\Response
   */
  public function update(UpdateUserRequest $request, User $user)
  {
    $data = $request->safe()->all();

    $data['password'] = $data['password'] ? Hash::make($data['password']) : $user->password;

    try {
      DB::beginTransaction();

      $user->update($data);

      DB::commit();

      return redirect("/people")->with('success', 'User successfully updated!');
    } catch (Exception $e) {
      return redirect("/people")->withInput()->with('error', $e->getMessage());
    }
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\User  $user
   * @return \Illuminate\Http\Response
   */
  public function destroy(User $user)
  {
    //
  }
}