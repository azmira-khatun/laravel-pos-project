<?php

namespace App\Http\Controllers;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // ✅ Show all users
    public function index()
    {
        $users = User::all();
        return view('pages.user.view', compact('users'));
    }

    // ✅ Show create form
    public function create()
    {
        $roles = Role::all();
        return view('pages.user.add-user', compact('roles'));
    }

    // ✅ Store new user
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'role_id' => 'nullable|integer'
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password), // ✅ নিরাপত্তার জন্য পাসওয়ার্ড hash করা হলো
            'role_id' => $request->role_id,
        ]);

        return Redirect::route('user.index')->with('success', 'User created successfully!');
    }

    // ✅ Delete user
    public function destroy(Request $request)
    {
        $user = User::findOrFail($request->user_id);
        $user->delete();

        return Redirect::route('user.index')->with('success', 'User deleted successfully!');
    }

    // ✅ Show edit form
    public function update($user_id)
    {
        $user = User::findOrFail($user_id);
        $roles = Role::all();
        return view('pages.user.edit', compact('user', 'roles'));
    }

    // ✅ Update existing user
    public function editStoreU(Request $request)
    {
        $request->validate([
            'user_id' => 'required|integer',
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $request->user_id,
            'password' => 'nullable|min:6',
            'role_id' => 'nullable|integer'
        ]);

        $user = User::findOrFail($request->user_id);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'role_id' => $request->role_id,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return Redirect::route('user.index')->with('success', 'User updated successfully!');
    }
}
