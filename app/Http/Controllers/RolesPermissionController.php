<?php

namespace App\Http\Controllers;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Http\Request;

class RolesPermissionController extends Controller
{
    public function index()
    {
        $roles = Role::with('permissions')->get();
        $permissions = Permission::all();
        return view('roles-permission.index', compact('roles', 'permissions'));
    }

    public function update(Request $request, $id)
    {
        $role = Role::findOrFail($id);

        $request->validate([
            'permissions' => 'required|array',
            'permissions.*' => 'exists:permissions,id',
        ]);

        $permissions = Permission::whereIn('id', $request->permissions)->get();
        $role->syncPermissions($permissions);

        return redirect()->route('roles-permission.index')->with('success', 'Permissions updated successfully.');
    }
}
