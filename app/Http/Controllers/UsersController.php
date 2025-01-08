<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{


    public function index()
    {
        if (!auth()->check()) {
            return redirect('/')->with('error', 'You need to log in to access this page.');
        }

        if (!auth()->user()->can('list user')) {
            return redirect()->route('admin.dashboard')->with('error', 'You do not have permission to view this page.');
        }

        // Check the role of the logged-in user
        if (auth()->user()->hasRole('super admin')) {
            // If the user is a superadmin, show all users
            $users = User::all();
        } elseif (auth()->user()->hasRole('Admin')) {
            // If the user is an admin, show only users with the 'user' role
            $users = User::role('user')->get();
        } else {
            // If the user is neither superadmin nor admin, handle the case (optional)
            $users = collect();  // Empty collection or handle accordingly
        }

        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        if (!auth()->check()) {
            return redirect('/')->with('error', 'You need to log in to access this page.');
        }

        if (!auth()->user()->can('add user')) {
            return redirect()->route('admin.dashboard')->with('error', 'You do not have permission to view this page.');
        }
        $roles = Role::all();
        return view('admin.users.add', compact('roles'));
    }

    public function store(Request $request)
    {
        if (!auth()->check()) {
            return redirect('/')->with('error', 'You need to log in to access this page.');
        }

        if (!auth()->user()->can('add user')) {
            return redirect()->route('admin.dashboard')->with('error', 'You do not have permission to view this page.');
        }

        $request->validate([
            'first_name' => 'required',
            'second_name' => 'required',
            'email' => 'required|email|unique:users',
            'phone_number' => 'required',
            'password' => 'required|min:6',
            'role' => 'required',
        ]);

        $username = $request->first_name . $request->second_name;

        $user = User::create([
            'first_name' => $request->first_name,
            'second_name' => $request->second_name,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'username' => $username,
            'name'=>$username,
            'email_verified_at' => now(),
                        'password' => Hash::make($request->password),
        ]);

        $user->assignRole($request->role);

        return redirect()->route('users.index')->with('success', 'User created successfully.');
    }

    public function edit(User $user)
    {
        if (!auth()->check()) {
            return redirect('/')->with('error', 'You need to log in to access this page.');
        }

        if (!auth()->user()->can('edit user')) {
            return redirect()->route('admin.dashboard')->with('error', 'You do not have permission to view this page.');
        }
        $roles = Role::all();
        return view('admin.users.add', compact('user', 'roles'));
    }

    public function update(Request $request, User $user)
    {
        if (!auth()->check()) {
            return redirect('/')->with('error', 'You need to log in to access this page.');
        }

        if (!auth()->user()->can('edit user')) {
            return redirect()->route('admin.dashboard')->with('error', 'You do not have permission to view this page.');
        }
        $request->validate([
            'first_name' => 'required',
            'second_name' => 'required',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone_number' => 'required',
            'role' => 'required',
        ]);

        $user->update([
            'first_name' => $request->first_name,
            'second_name' => $request->second_name,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'username' => $user->username, // Username remains unchanged
        ]);

        if ($request->filled('password')) {
            $user->update(['password' => Hash::make($request->password)]);
        }

        $user->syncRoles($request->role);

        return redirect()->route('users.index')->with('success', 'User updated successfully.');
    }

    public function destroy(User $user)
    {
        if (!auth()->check()) {
            return redirect('/')->with('error', 'You need to log in to access this page.');
        }

        if (!auth()->user()->can('delete user')) {
            return redirect()->route('admin.dashboard')->with('error', 'You do not have permission to view this page.');
        }
        $user->delete();
        return redirect()->route('users.index')->with('success', 'User deleted successfully.');
    }

    public function bulkDelete(Request $request)
    {
        if (!auth()->check()) {
            return redirect('/')->with('error', 'You need to log in to access this page.');
        }

        if (!auth()->user()->can('delete user')) {
            return redirect()->route('admin.dashboard')->with('error', 'You do not have permission to view this page.');
        }
        $userIds = $request->input('user_ids');

        if ($userIds) {
            User::whereIn('id', $userIds)->delete();
            return redirect()->route('users.index')->with('success', 'Selected users deleted successfully.');
        }

        return redirect()->route('users.index')->with('error', 'No users selected for deletion.');
    }
}
