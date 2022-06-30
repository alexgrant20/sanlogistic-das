<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreUserRequest;
use App\Http\Requests\Admin\UpdateUserRequest;
use App\Models\Address;
use App\Models\Driver;
use App\Models\Person;
use App\Models\Role;
use App\Models\User;
use App\Transaction\Constants\NotifactionTypeConstant;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

  public function create(Request $request)
  {
    # Making sure person exists
    $person = Person::findOrFail($request->person_id);

    # Making sure user not exists
    if ($person->user) return back();

    return view('admin.user.create', [
      'title' => 'Register',
      'roles' => Role::orderBy('name')->get(),
      'person_id' => $person->id,
    ]);
  }

  public function store(StoreUserRequest $request)
  {
    $role = Role::find($request->role_id);

    $userPayload = array_merge(
      $request->safe()->toArray(),
      ['password' => Hash::make($request->password)]
    );

    DB::beginTransaction();

    try {
      $user = User::create($userPayload);
      $role->name !== "driver" ?: Driver::create(array('user_id' => $user->id));
    } catch (Exception $e) {
      DB::rollBack();

      return to_route('admin.person.index')
        ->withInput()
        ->with(genereateNotifaction(NotifactionTypeConstant::ERROR, 'user', 'create'));
    }

    DB::commit();

    return to_route('admin.person.index')
      ->with(genereateNotifaction(NotifactionTypeConstant::SUCCESS, 'user', 'created'));
  }

  public function edit(User $user)
  {
    return view('admin.user.edit', [
      'title' => 'View User',
      'user' => $user,
      'roles' => Role::orderBy('name')->get(),
    ]);
  }

  public function update(UpdateUserRequest $request, User $user)
  {
    $role = Role::find($request->role_id);

    $userPayload = array_merge(
      $request->safe()->toArray(),
      ['password' => $request->password ? Hash::make($request->password) : $user->password],
    );

    DB::beginTransaction();

    try {
      $user->update($userPayload);

      if ($role->name === 'driver') {
        # If Driver already exists than no need to create
        Driver::firstOrCreate([
          'user_id' => $user->id,
        ]);
      }
    } catch (Exception $e) {
      DB::rollBack();

      return redirect("/admin/users/{$user->id}/edit")
        ->withInput()
        ->with(genereateNotifaction(NotifactionTypeConstant::ERROR, 'user', 'update'));
    }
    DB::commit();

    return to_route('admin.person.index')
      ->with(genereateNotifaction(NotifactionTypeConstant::SUCCESS, 'user', 'updated'));
  }
}