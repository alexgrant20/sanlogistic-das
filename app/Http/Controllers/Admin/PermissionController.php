<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Transaction\Constants\NotifactionTypeConstant;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionController extends Controller
{
  public function __construct()
  {
    $this->middleware('can:create-user-role-and-permission');
  }

  public function index()
  {
    return view('admin.permissions.index', [
      'title' => 'Permission',
      'permissions' => Permission::orderBy('created_at')->paginate(10),
    ]);
  }

  public function create()
  {
    return view('admin.permissions.create', [
      'title' => 'Create Permission'
    ]);
  }

  public function store(Request $request)
  {
    $request->validate(['name' => 'required']);

    $validated = ['name' => strtolower(preg_replace('/\s+/', '-', $request->name))];

    Permission::create($validated);

    return to_route('admin.permissions.index')->with(genereateNotifaction(NotifactionTypeConstant::SUCCESS, 'permission', 'created'));
  }

  public function edit(Permission $permission)
  {
    return view('admin.permissions.edit', [
      'title' => 'Edit Permissions',
      'permission' => $permission,
      'roles' => Role::orderBy('name')->get(),
    ]);
  }

  public function update(Request $request, Permission $permission)
  {
    $request->validate(['name' => 'required']);

    $validated = ['name' => strtolower(preg_replace('/\s+/', '-', $request->name))];

    $permission->update($validated);

    return to_route('admin.permissions.index')->with(genereateNotifaction(NotifactionTypeConstant::SUCCESS, 'permission', 'updated'));
  }


  public function destroy(Permission $permission)
  {
    $permission->delete();

    return to_route('admin.permissions.index')->with(genereateNotifaction(NotifactionTypeConstant::SUCCESS, 'permission', 'deleted'));
  }

  public function assignRole(Request $request, Permission $permission)
  {
    if ($permission->hasRole($request->role)) {
      return back()->with(genereateNotifaction(NotifactionTypeConstant::ERROR, 'role', 'assign'));
    }

    $permission->assignRole($request->role);
    return back()->with(genereateNotifaction(NotifactionTypeConstant::SUCCESS, 'role', 'assigned'));
  }

  public function removeRole(Permission $permission, Role $role)
  {
    if ($permission->hasRole($role)) {
      $permission->removeRole($role);
      return back()->with(genereateNotifaction(NotifactionTypeConstant::SUCCESS, 'role', 'removed'));
    }
    return back()->with(genereateNotifaction(NotifactionTypeConstant::ERROR, 'role', 'remove'));
  }
}