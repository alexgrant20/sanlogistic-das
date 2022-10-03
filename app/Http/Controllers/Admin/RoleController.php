<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Transaction\Constants\NotifactionTypeConstant;
use App\Transaction\Constants\PermissionConstant;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
  public function __construct()
  {
    $this->middleware('can:create-user-role-and-permission');
  }

  public function index()
  {
    return view('admin.roles.index', [
      'title' => 'Role',
      'roles' => Role::whereNotIn('name', ['super-admin'])->orderBy('name')->paginate(10),
    ]);
  }

  public function create()
  {
    return view('admin.roles.create', [
      'title' => 'Create Roles',
      'permissions' => Permission::orderBy('name')->get(),
    ]);
  }

  public function store(Request $request)
  {
    $request->validate(['name' => 'required|unique:roles,name']);

    $validated = ['name' => strtolower(preg_replace('/\s+/', '-', $request->name))];

    $role = Role::create($validated);

    $permissions = array_keys($request->except(['_token', 'name']));

    $role->syncPermissions($permissions);

    return to_route('admin.roles.index')->with(genereateNotifaction(NotifactionTypeConstant::SUCCESS, 'role', 'created'));
  }

  public function edit(Role $role)
  {
    $currentPermission = Arr::flatten(Permission::get('name')->toArray());
    $appPermissions = PermissionConstant::APP_PERMISSION;

    $permissionsToAdd = array_diff($appPermissions, $currentPermission);
    $permissionsToDelete = array_diff($currentPermission, $appPermissions);

    if (count($permissionsToAdd) > 0) {
      $permissionsNeedToCreate = [];

      foreach ($permissionsToAdd as $permission) {
        array_push($permissionsNeedToCreate, [
          'name' => $permission,
          'guard_name' => 'web',
          'created_at' => now(),
          'updated_at' => now(),
        ]);
      }

      Permission::insert($permissionsNeedToCreate);
    }

    if (count($permissionsToDelete) > 0) {
      foreach ($permissionsToDelete as $value) {
        Permission::where('name', $value)->delete();
      }
    }

    return view('admin.roles.edit', [
      'title' => 'Edit Roles',
      'role' => $role,
      'permissions' => Permission::orderBy('name')->get(),
    ]);
  }

  public function update(Request $request, Role $role)
  {
    $request->validate(['name' => 'required|unique:roles,name,' . $role->id]);

    $validated = ['name' => strtolower(preg_replace('/\s+/', '-', $request->name))];

    $role->update($validated);

    $appPermissions = PermissionConstant::APP_PERMISSION;
    $permissionToAdd = array_keys($request->except(['_token', '_method', 'name']));

    // Delete permission that allowed
    $permissionToDeny = array_diff($appPermissions, $permissionToAdd);

    $role->revokePermissionTo($permissionToDeny);
    $role->givePermissionTo($permissionToAdd);

    return to_route('admin.roles.index')->with(genereateNotifaction(NotifactionTypeConstant::SUCCESS, 'role', 'updated'));
  }

  public function destroy(Role $role)
  {
    $role->delete();

    return to_route('admin.roles.index')->with(genereateNotifaction(NotifactionTypeConstant::SUCCESS, 'role', 'deleted'));
  }

  // public function givePermission(Request $request, Role $role)
  // {
  //   $appPermissions = PermissionConstant::APP_PERMISSION;
  //   $permissionToAdd = array_keys($request->except('_token'));

  //   // Delete permission that allowed
  //   $permissionToDeny = array_diff($appPermissions, $permissionToAdd);

  //   $role->revokePermissionTo($permissionToDeny);
  //   $role->givePermissionTo($permissionToAdd);

  //   return back()->with(genereateNotifaction(NotifactionTypeConstant::SUCCESS, 'permission', 'assigned'));
  // }

  // public function revokePermission(Role $role, Permission $permission)
  // {
  //   if ($role->hasPermissionTo($permission)) {
  //     $role->revokePermissionTo($permission);
  //     return back()->with(genereateNotifaction(NotifactionTypeConstant::SUCCESS, 'permission', 'revoked'));
  //   }
  //   return back()->with(genereateNotifaction(NotifactionTypeConstant::ERROR, 'permission', 'revoked'));
  // }
}