<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:191|unique:users,username',
            'email' => 'required|email|max:191|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'profile_image' => 'nullable|image|max:2048',
        ]);

        $profilePath = null;
        if ($request->hasFile('profile_image')) {
            $profilePath = $request->file('profile_image')->store('profile_images', 'public');
        }

        $user = User::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => User::ROLE_STUDENT, // default to student
            'profile' => $profilePath,
        ]);

        // Do NOT auto-login after registration. Redirect users to the login page so they can sign in.
        return redirect()->route('login')->with('status', 'Registration successful. Please log in.')->with('username', $request->username);
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        // Allow login by username OR email
        $login = $request->input('username');
        $field = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        $credentials = [$field => $login, 'password' => $request->input('password')];

        if (Auth::attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();

            return $this->redirectAccordingToRole(Auth::user());
        }

        // Log failed attempt for debugging (remove or reduce in production)
        logger()->warning('Login failed', ['login' => $login, 'ip' => $request->ip()]);

        return back()->withErrors(['username' => 'The provided credentials do not match our records.'])->onlyInput('username');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    protected function redirectAccordingToRole(User $user)
    {
        return match($user->role) {
            User::ROLE_ADMIN => redirect()->route('dashboard.admin'),
            User::ROLE_INSTRUCTOR => redirect()->route('dashboard.instructor'),
            default => redirect()->route('dashboard.student'),
        };
    }
}
