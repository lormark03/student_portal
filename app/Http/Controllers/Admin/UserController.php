<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    // Display list of users
    public function index()
    {
        $users = User::latest()->paginate(10); // fetch all users with pagination
        return view('admin.users.index', compact('users'));
    }

    // Show user details
    public function show(User $user)
    {
        return view('admin.users.show', compact('user'));
    }

    // Show create form
    public function create()
    {
        return view('admin.users.create');
    }

    // Store new user
    public function store(Request $request)
    {
        $data = $request->validate([
            'username' => 'required|string|max:50',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:admin,instructor,student',
            'profile_image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('profile_image')) {
            $data['profile'] = $request->file('profile_image')->store('profile_images', 'public');
        }

        $data['password'] = bcrypt($data['password']);

        User::create($data);

        return redirect()->route('admin.users.index')->with('status', 'User created successfully.');
    }

    // Show edit form
    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    // Update user
    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'username' => 'required|string|max:50',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
            'role' => 'required|in:admin,instructor,student',
            'profile_image' => 'nullable|image|max:2048',
        ]);

        if ($request->filled('password')) {
            $data['password'] = bcrypt($data['password']);
        } else {
            unset($data['password']);
        }

        if ($request->hasFile('profile_image')) {
            // Delete old profile if exists
            if ($user->profile && \Storage::disk('public')->exists($user->profile)) {
                \Storage::disk('public')->delete($user->profile);
            }

            $data['profile'] = $request->file('profile_image')->store('profile_images', 'public');
        }

        $user->update($data);

        return redirect()->route('admin.users.index')->with('status', 'User updated successfully.');
    }

    // Delete user
    public function destroy(User $user)
    {
        if ($user->profile && \Storage::disk('public')->exists($user->profile)) {
            \Storage::disk('public')->delete($user->profile);
        }

        $user->delete();

        return redirect()->route('admin.users.index')->with('status', 'User deleted successfully.');
    }
}
