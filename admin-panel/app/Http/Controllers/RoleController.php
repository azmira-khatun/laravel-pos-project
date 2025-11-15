<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class RoleController extends Controller
{
    // Show all roles
    public function index()
    {
        $roles = Role::all();
        return view('pages.roles.index', compact('roles'));
    }

    // Show create form
    public function create()
    {
        return view('pages.roles.create');
    }

    // Store new role
    public function store(Request $request)
    {
        $request->validate([
            'role_name' => 'required|string|unique:roles,role_name|max:50',
        ]);

        Role::create([
            'role_name' => $request->role_name,
        ]);

        return Redirect::route('roles.index')->with('success', 'Role created successfully!');
    }

    // Show edit form
    public function edit($id)
    {
        $role = Role::findOrFail($id);
        return view('pages.roles.edit', compact('role'));
    }

    // Update role
    public function update(Request $request, $id)
    {
        $role = Role::findOrFail($id);

        $request->validate([
            'role_name' => 'required|string|unique:roles,role_name,' . $id . '|max:50',
        ]);

        $role->update([
            'role_name' => $request->role_name,
        ]);

        return Redirect::route('roles.index')->with('success', 'Role updated successfully!');
    }

    // Delete role
    public function destroy($id)
    {
        $role = Role::findOrFail($id);
        $role->delete();

        return Redirect::route('roles.index')->with('success', 'Role deleted successfully!');
    }
}
