<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function edit()
    {
        $user = Auth::user();
        return view('profile.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $data = $request->validate([
            'email' => 'required|email|max:191|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
            'profile' => 'nullable|string|max:255',
            'profile_image' => 'nullable|image|max:2048',
        ]);

        // handle password
        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        // handle profile image upload
        if ($request->hasFile('profile_image')) {
            // delete old image if exists
            if ($user->profile && \Illuminate\Support\Facades\Storage::disk('public')->exists($user->profile)) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($user->profile);
            }

            $path = $request->file('profile_image')->store('profile_images', 'public');
            $data['profile'] = $path;
        }

        $user->update($data);

        return redirect()->route('profile.edit')->with('status', 'Profile updated');
    }
}
