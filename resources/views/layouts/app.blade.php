<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Campus Announcement System</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        :root {
            --header-height: 56px;
            --sidebar-width: 260px;
        }

        html, body {
            height: 100%;
            margin: 0;
        }

        body {
            background: #f5f7fb;
            overflow-x: hidden;
        }

        /* ================= HEADER ================= */
        .app-header {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            height: var(--header-height);
            background: #ffffff;
            border-bottom: 1px solid #dee2e6;
            z-index: 1030;
            display: flex;
            align-items: center;
            padding: 0 20px;
            justify-content: space-between;
        }

        /* ================= SIDEBAR ================= */
        .sidebar {
            position: fixed;
            top: var(--header-height);
            left: 0;
            width: var(--sidebar-width);
            height: calc(100vh - var(--header-height));
            background: #ffffff;
            border-right: 1px solid #dee2e6;
            display: flex;
            flex-direction: column;
            z-index: 1020;
        }

        .sidebar-header {
            padding: 16px;
            display: flex;
            align-items: center;
            gap: 12px;
            border-bottom: 1px solid #dee2e6;
        }

        /* ================= AVATAR ================= */
        .avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;       /* perfect circle */
            background: #0d6efd;      /* fallback bg color */
            color: #fff;
            font-weight: bold;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;         /* ensures image doesn't overflow */
            flex-shrink: 0;
        }

        .avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;        /* cover the circle perfectly */
        }

        /* ================= SIDEBAR LINKS ================= */
        .sidebar-menu {
            flex: 1;
            overflow-y: auto;
            padding: 12px;
        }

        .sidebar-link {
            display: block;
            padding: 10px 14px;
            margin-bottom: 6px;
            border-radius: 6px;
            text-decoration: none;
            color: #495057;
            font-weight: 500;
        }

        .sidebar-link:hover {
            background: #f1f3f5;
            color: #0d6efd;
        }

        .sidebar-logout {
            padding: 12px;
            border-top: 1px solid #dee2e6;
        }

        /* ================= MAIN CONTENT ================= */
        .main-content {
            margin-left: var(--sidebar-width);
            margin-top: var(--header-height);
            padding: 24px;
            min-height: calc(100vh - var(--header-height));
        }
    </style>
</head>
<body>

{{-- ================= HEADER ================= --}}
<header class="app-header">
    <span class="fw-bold h5 mb-0">Campus Announcement System</span>
    @auth
        <span class="small text-muted">{{ auth()->user()->username }}</span>
    @endauth
</header>

{{-- ================= SIDEBAR ================= --}}
<div class="sidebar">
    @auth
        @php $user = auth()->user(); @endphp

        {{-- User Info --}}
        <div class="sidebar-header">
            <div class="avatar">
                @if($user->profile && file_exists(storage_path('app/public/' . $user->profile)))
                    <img src="{{ asset('storage/' . $user->profile) }}" alt="Avatar">
                @else
                    {{ strtoupper(substr($user->username, 0, 1)) }}
                @endif
            </div>
            <div>
                <div class="fw-bold">{{ $user->username }}</div>
                <div class="text-muted small">
                    @switch($user->role)
                        @case(App\Models\User::ROLE_ADMIN) Admin @break
                        @case(App\Models\User::ROLE_INSTRUCTOR) Instructor @break
                        @default Staff
                    @endswitch
                </div>
            </div>
        </div>

        {{-- Menu Links --}}
        <div class="sidebar-menu">
            <a href="{{ route('dashboard') }}" class="sidebar-link">Dashboard</a>

            @if($user->role === App\Models\User::ROLE_ADMIN)
                <a href="{{ route('admin.users.index') }}" class="sidebar-link">Manage Users</a>
                <a href="{{ route('admin.announcements.index') }}" class="sidebar-link">Announcements</a>
            @endif

            @if($user->role === App\Models\User::ROLE_INSTRUCTOR)
                <a href="{{ route('instructor.announcements.index') }}" class="sidebar-link">Announcements</a>
            @endif

            <a href="{{ route('profile.edit') }}" class="sidebar-link">My Profile</a>
        </div>

        {{-- Sidebar Logout --}}
        <div class="sidebar-logout">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn btn-danger w-100">Logout</button>
            </form>
        </div>
    @else
        <div class="p-3">
            <p>Please <a href="{{ route('login') }}">login</a> or <a href="{{ route('register') }}">register</a>.</p>
        </div>
    @endauth
</div>

{{-- ================= MAIN CONTENT ================= --}}
<div class="main-content">
    <div class="container-fluid">
        @yield('content')
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
