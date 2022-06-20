<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
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

    return view('admin.user.register.index', [
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

      $notification = array(
        'message' => 'User successfully created!',
        'alert-type' => 'success',
      );

      return to_route('admin.person.index')->with($notification);
    } catch (Exception $e) {

      $notification = array(
        'message' => 'User failed to create!',
        'alert-type' => 'error',
      );

      return to_route('admin.person.index')->withInput()->with($notification);
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
    return view('admin.user.index', [
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

      $notification = array(
        'message' => 'User successfully updated!',
        'alert-type' => 'success',
      );

      return to_route('admin.person.index')->with($notification);
    } catch (Exception $e) {

      $notification = array(
        'message' => 'User failed to update!',
        'alert-type' => 'error',
      );

      return to_route('admin.person.index')->withInput()->with($notification);
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
