<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreUserRequest;
use App\Http\Requests\Admin\UpdateUserRequest;
use App\Models\Driver;
use App\Models\Person;
use App\Models\User;
use App\Transaction\Constants\NotifactionTypeConstant;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
  public function __construct()
  {
    $this->middleware('can:assign-user-role-and-permission', ['only' => [
      'show', 'create', 'removeRole',  'assignRole', 'givePermission', 'revokePermission'
    ]]);
  }

  public function create(Person $person)
  {
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
    DB::beginTransaction();

    try {
      $user = User::create([
        'username' => $request->username,
        'password' => Hash::make($request->password),
        'person_id' => $request->person_id,
      ]);

      $request->role !== "driver" ?: Driver::create(array('user_id' => $user->id));
      $user->assignRole($request->role);
    } catch (Exception $e) {

      dd($e->getMessage());

      DB::rollBack();

      return back()->withInput()->with(genereateNotifaction(NotifactionTypeConstant::ERROR, 'user', 'create'));
    }

    DB::commit();

    return to_route('admin.people.index')->with(genereateNotifaction(NotifactionTypeConstant::SUCCESS, 'user', 'created'));
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
    DB::beginTransaction();
    try {
      $user->update([
        'username' => $request->username,
        'password' => Hash::make($request->password),
      ]);

      $user->syncRoles(array($request->role));

      if ($request->role === 'driver') {
        # If Driver already exists than no need to create
        Driver::firstOrCreate([
          'user_id' => $user->id,
        ]);
      }
    } catch (Exception $e) {
      DB::rollBack();

      return back()->withInput()->with(genereateNotifaction(NotifactionTypeConstant::ERROR, 'user', 'update'));
    }
    DB::commit();

    return to_route('admin.people.index')->with(genereateNotifaction(NotifactionTypeConstant::SUCCESS, 'user', 'updated'));
  }

  // public function show(User $user)
  // {
  //   if (empty($user->roles()->first())) return back()->with(genereateNotifaction('error', 'Please Assign User a Role!'));

  //   $roles = Role::orderBy('name')->get();
  //   $permissions = Permission::orderBy('name')->get();

  //   return view('admin.user.role', [
  //     'title' => 'User',
  //     'roles' => $roles,
  //     'permissions' => $permissions,
  //     'user' => $user
  //   ]);
  // }

  public function assignRole(Request $request, User $user)
  {
    if ($user->hasRole($request->role)) {
      return back()->with(genereateNotifaction(NotifactionTypeConstant::ERROR, 'role', 'assign'));
    }

    $user->assignRole($request->role);
    return back()->with(genereateNotifaction(NotifactionTypeConstant::SUCCESS, 'role', 'assigned'));
  }

  public function removeRole(User $user, Role $role)
  {
    if ($user->hasRole($role)) {
      $user->removeRole($role);
      return back()->with(genereateNotifaction(NotifactionTypeConstant::SUCCESS, 'role', 'removed'));
    }
    return back()->with(genereateNotifaction(NotifactionTypeConstant::ERROR, 'role', 'remove'));
  }

  public function givePermission(Request $request, User $user)
  {
    $request->validate(['permission' => 'required']);

    if ($user->hasPermissionTo($request->permission)) {
      return back()->with(genereateNotifaction(NotifactionTypeConstant::ERROR, 'user', 'permission'));
    }

    $user->givePermissionTo($request->permission);
    return back()->with(genereateNotifaction(NotifactionTypeConstant::SUCCESS, 'permission', 'assigned'));
  }

  public function revokePermission(User $user, Permission $permission)
  {
    if ($user->hasPermissionTo($permission)) {
      $user->revokePermissionTo($permission);
      return back()->with(genereateNotifaction(NotifactionTypeConstant::SUCCESS, 'permission', 'revoked'));
    }
    return back()->with(genereateNotifaction(NotifactionTypeConstant::ERROR, 'permission', 'revoked'));
  }
}