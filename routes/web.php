<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Models\Announcement;
use App\Models\User;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Home
Route::get('/', fn() => view('welcome'));

// Guest auth routes
Route::middleware('guest')->group(function () {
    Route::get('register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('register', [AuthController::class, 'register']);

    Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('login', [AuthController::class, 'login']);
});

// Logout
Route::post('logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

// Profile
Route::middleware('auth')->group(function () {
    Route::get('profile', [\App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('profile', [\App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
});

// Role-based dashboard redirect
Route::middleware('auth')->get('/dashboard', function () {
    $user = auth()->user();
    return match($user->role) {
        User::ROLE_ADMIN => redirect()->route('dashboard.admin'),
        User::ROLE_INSTRUCTOR => redirect()->route('dashboard.instructor'),
        default => redirect()->route('dashboard.student'),
    };
})->name('dashboard');

// Admin Dashboard
Route::get('/admin/dashboard', function () {
    $totalUsers = User::count();
    $adminsCount = User::where('role', User::ROLE_ADMIN)->count();
    $instructorsCount = User::where('role', User::ROLE_INSTRUCTOR)->count();
    $studentsCount = User::where('role', User::ROLE_STUDENT)->count();

    $recentUsers = User::latest()->limit(10)->get();

    $announcements = Announcement::where('is_active', true)->latest()->get();

    return view('dashboards.admin', compact(
        'totalUsers','adminsCount','instructorsCount','studentsCount','recentUsers','announcements'
    ));
})->middleware(\App\Http\Middleware\IsAdmin::class)->name('dashboard.admin');

// Admin management
Route::prefix('admin')->name('admin.')->middleware(\App\Http\Middleware\IsAdmin::class)->group(function () {
    Route::resource('users', \App\Http\Controllers\Admin\UserController::class);
    Route::resource('announcements', \App\Http\Controllers\Admin\AnnouncementController::class);
});

// Instructor dashboard
Route::get('/instructor/dashboard', function () {
    $announcements = Announcement::where('is_active', true)->latest()->get();
    return view('dashboards.instructor', compact('announcements'));
})->middleware(\App\Http\Middleware\IsInstructor::class)->name('dashboard.instructor');

// Student dashboard
Route::get('/student/dashboard', function () {
    $announcements = Announcement::where('is_active', true)->latest()->get();
    return view('dashboards.student', compact('announcements'));
})->middleware(\App\Http\Middleware\IsStudent::class)->name('dashboard.student');
