<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use Illuminate\Http\Request;
use App\Http\Middleware\IsAdminOrInstructor;

class AnnouncementController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', IsAdminOrInstructor::class]);
    }

    public function index()
    {
        $user = auth()->user();

        if ($user->role === \App\Models\User::ROLE_ADMIN) {
            $announcements = Announcement::with('user')->latest()->paginate(10);
        } else {
            $announcements = Announcement::with('user')->where('user_id', $user->id)->latest()->paginate(10);
        }

        return view('admin.announcements.index', compact('announcements'));
    }

    public function create()
    {
        return view('admin.announcements.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
            'is_active' => 'nullable',
        ]);

        Announcement::create([
            'title' => $data['title'],
            'body' => $data['body'],
            'is_active' => $request->has('is_active'),
            'user_id' => auth()->id(),
        ]);

        $prefix = auth()->user()->role === \App\Models\User::ROLE_ADMIN ? 'admin' : (auth()->user()->role === \App\Models\User::ROLE_INSTRUCTOR ? 'instructor' : 'admin');

        return redirect()
            ->route($prefix . '.announcements.index')
            ->with('success', 'Announcement created successfully.');
    }

    public function edit(Announcement $announcement)
    {
        return view('admin.announcements.edit', compact('announcement'));
    }

    public function update(Request $request, Announcement $announcement)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
            'is_active' => 'nullable',
        ]);

        $announcement->update([
            'title' => $data['title'],
            'body' => $data['body'],
            'is_active' => $request->has('is_active'),
        ]);

        $prefix = auth()->user()->role === \App\Models\User::ROLE_ADMIN ? 'admin' : (auth()->user()->role === \App\Models\User::ROLE_INSTRUCTOR ? 'instructor' : 'admin');

        return redirect()
            ->route($prefix . '.announcements.index')
            ->with('success', 'Announcement updated successfully.');
    }

    public function destroy(Announcement $announcement)
    {
        $announcement->delete();

        $prefix = auth()->user()->role === \App\Models\User::ROLE_ADMIN ? 'admin' : (auth()->user()->role === \App\Models\User::ROLE_INSTRUCTOR ? 'instructor' : 'admin');

        return redirect()
            ->route($prefix . '.announcements.index')
            ->with('success', 'Announcement deleted successfully.');
    }
}
