<?php

namespace App\Http\Controllers;

use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;

class HakAksesController extends Controller
{
    public function index()
    {
        $roles = Role::with('permissions')->get();
        return view('hak-akses.index', compact('roles'));
    }

    public function create()
    {
        return view('hak-akses.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:roles,name',
        ]);

        Role::create(['name' => $request->name, 'guard_name' => 'web']);

        return redirect()->route('hak-akses.index')->with('success', 'Role created successfully.');
    }

    public function edit($id)
    {
        $role = Role::findOrFail($id);
        return view('hak-akses.edit', compact('role'));
    }

    public function update(Request $request, $id)
    {
        $role = Role::findOrFail($id);

        $request->validate([
            'name' => 'required|string|unique:roles,name,' . $id,
        ]);

        $role->update(['name' => $request->name]);

        return redirect()->route('hak-akses.index')->with('success', 'Role updated successfully.');
    }

    public function destroy($id)
    {
        $role = Role::findOrFail($id);
        $role->delete();

        return redirect()->route('hak-akses.index')->with('success', 'Role deleted successfully.');
    }
}
