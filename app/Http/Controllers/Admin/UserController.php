<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware(\App\Http\Middleware\IsAdmin::class);
    }

    public function index()
    {
        $users = User::paginate(15);
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'username' => 'required|string|max:191|unique:users,username',
            'email' => 'required|email|max:191|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:0,1,3',
            'profile' => 'nullable|string|max:255',
            'profile_image' => 'nullable|image|max:2048',
        ]);

        $data['password'] = Hash::make($data['password']);

        if ($request->hasFile('profile_image')) {
            $data['profile'] = $request->file('profile_image')->store('profile_images', 'public');
        }

        User::create($data);

        return redirect()->route('admin.users.index')->with('status', 'User created');
    }

    public function show(User $user)
    {
        return view('admin.users.show', compact('user'));
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'username' => 'required|string|max:191|unique:users,username,' . $user->id,
            'email' => 'required|email|max:191|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
            'role' => 'required|in:0,1,3',
            'profile' => 'nullable|string|max:255',
            'profile_image' => 'nullable|image|max:2048',
        ]);

        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        // handle profile image
        if ($request->hasFile('profile_image')) {
            if ($user->profile && \Illuminate\Support\Facades\Storage::disk('public')->exists($user->profile)) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($user->profile);
            }
            $data['profile'] = $request->file('profile_image')->store('profile_images', 'public');
        }

        $user->update($data);

        return redirect()->route('admin.users.index')->with('status', 'User updated');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('admin.users.index')->with('status', 'User deleted');
    }
}
