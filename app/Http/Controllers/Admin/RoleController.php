<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Transaction\Constants\NotifactionTypeConstant;
use Illuminate\Http\Request;
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
      'roles' => Role::orderBy('name')->paginate(10),
    ]);
  }

  public function create()
  {
    return view('admin.roles.create', [
      'title' => 'Create Roles'
    ]);
  }

  public function store(Request $request)
  {
    $request->validate(['name' => 'required|unique:roles,name']);

    $validated = ['name' => strtolower(preg_replace('/\s+/', '-', $request->name))];

    Role::create($validated);

    return to_route('admin.roles.index')->with(genereateNotifaction(NotifactionTypeConstant::SUCCESS, 'role', 'created'));
  }

  public function edit(Role $role)
  {
    return view('admin.roles.edit', [
      'title' => 'Edit Roles',
      'role' => $role,
      'permissions' => Permission::whereNotIn('name', $role->permissions->pluck('name'))->orderBy('name')->get(),
    ]);
  }

  public function update(Request $request, Role $role)
  {
    $request->validate(['name' => 'required|unique:roles,name,' . $role->id]);

    $validated = ['name' => strtolower(preg_replace('/\s+/', '-', $request->name))];

    $role->update($validated);

    return to_route('admin.roles.index')->with(genereateNotifaction(NotifactionTypeConstant::SUCCESS, 'role', 'updated'));
  }

  public function destroy(Role $role)
  {
    $role->delete();

    return to_route('admin.roles.index')->with(genereateNotifaction(NotifactionTypeConstant::SUCCESS, 'role', 'deleted'));
  }

  public function givePermission(Request $request, Role $role)
  {
    $request->validate(['permission' => 'required']);

    if ($role->hasPermissionTo($request->permission)) {
      return back()->with(genereateNotifaction(NotifactionTypeConstant::ERROR, 'role', 'permission'));
    }

    $role->givePermissionTo($request->permission);
    return back()->with(genereateNotifaction(NotifactionTypeConstant::SUCCESS, 'permission', 'assigned'));
  }

  public function revokePermission(Role $role, Permission $permission)
  {
    if ($role->hasPermissionTo($permission)) {
      $role->revokePermissionTo($permission);
      return back()->with(genereateNotifaction(NotifactionTypeConstant::SUCCESS, 'permission', 'revoked'));
    }
    return back()->with(genereateNotifaction(NotifactionTypeConstant::ERROR, 'permission', 'revoked'));
  }
}