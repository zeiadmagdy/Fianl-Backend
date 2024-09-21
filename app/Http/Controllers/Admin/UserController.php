<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Http\Requests\UserRequest; // Using UserRequest for validation
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // Display a listing of users
    public function index()
    {
        $users = User::all();
        return view('admin.users.index', compact('users'));
    }

    // Show the form for creating a new user
    public function create()
    {
        return view('admin.users.create');
    }

    // Store a newly created user
    public function store(UserRequest $request)
    {
        // Create user with validated data
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('admin.users.index')->with('success', 'User created successfully.');
    }

    // Show the form for editing the specified user
    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    // Update the specified user
    public function update(UserRequest $request, User $user)
    {
        // Update user with validated data
        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('admin.users.index')->with('success', 'User updated successfully.');
    }

    // Remove the specified user
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'User deleted successfully.');
    }
}
