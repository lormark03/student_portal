<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Authentication routes
use App\Http\Controllers\AuthController;

Route::middleware('guest')->group(function () {
    Route::get('register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('register', [AuthController::class, 'register']);

    Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('login', [AuthController::class, 'login']);
});

Route::post('logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

    // Profile routes
    Route::middleware('auth')->group(function () {
        Route::get('profile', [\App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
        Route::put('profile', [\App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
    });
// Role-based dashboards
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        $user = auth()->user();
        return match ($user->role) {
            \App\Models\User::ROLE_ADMIN => redirect()->route('dashboard.admin'),
            \App\Models\User::ROLE_INSTRUCTOR => redirect()->route('dashboard.instructor'),
            default => redirect()->route('dashboard.student'),
        };
    })->name('dashboard');

    Route::get('/admin/dashboard', function () {
        $totalUsers = \App\Models\User::count();
        $adminsCount = \App\Models\User::where('role', \App\Models\User::ROLE_ADMIN)->count();
        $instructorsCount = \App\Models\User::where('role', \App\Models\User::ROLE_INSTRUCTOR)->count();
        $studentsCount = \App\Models\User::where('role', \App\Models\User::ROLE_STUDENT)->count();

        $recentUsers = \App\Models\User::latest()->limit(10)->get();

        // fetch latest active announcement
        $announcement = \App\Models\Announcement::where('is_active', true)->latest()->first();

        return view('dashboards.admin', compact('totalUsers','adminsCount','instructorsCount','studentsCount','recentUsers','announcement'));
    })->middleware(\App\Http\Middleware\IsAdmin::class)->name('dashboard.admin');

    // Admin user management
    Route::prefix('admin')->name('admin.')->middleware(\App\Http\Middleware\IsAdmin::class)->group(function () {
        Route::resource('users', \App\Http\Controllers\Admin\UserController::class);
        // Announcement management
        Route::resource('announcements', \App\Http\Controllers\Admin\AnnouncementController::class);
    });

    Route::get('/instructor/dashboard', function () { return view('dashboards.instructor'); })->middleware(\App\Http\Middleware\IsInstructor::class)->name('dashboard.instructor');
    Route::get('/student/dashboard', function () { return view('dashboards.student'); })->middleware(\App\Http\Middleware\IsStudent::class)->name('dashboard.student');
});
