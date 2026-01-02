<style>
    .sidebar {
        position: fixed;
        top: 0;
        left: 0;
        width: 260px;
        height: 100vh;
        background: #ffffff;
        border-right: 1px solid #dee2e6;
        display: flex;
        flex-direction: column;
        z-index: 1030;
    }

    .sidebar-header {
        padding: 16px;
        display: flex;
        align-items: center;
        gap: 12px;
        border-bottom: 1px solid #dee2e6;
    }

    .sidebar .avatar {
        width: 42px;
        height: 42px;
        border-radius: 50%;
        background: #0d6efd;
        color: #fff;
        font-weight: bold;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
    }

    .sidebar .avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

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

    .main-content {
        margin-left: 260px;
        padding: 24px;
    }
</style>

<div class="sidebar">
    @auth
        <div class="sidebar-header">
            <div class="avatar">
                 @if($user->profile && file_exists(storage_path('app/public/' . $user->profile)))
                        <img src="{{ asset('storage/' . $user->profile) }}" 
                             alt="Avatar" class="rounded-circle" 
                             style="width:50px; height:50px; object-fit:cover;">
                    @else
                        <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center"
                             style="width:50px; height:50px; font-weight:bold;">
                            {{ strtoupper(substr($user->username,0,1)) }}
                        </div>
                    @endif
            </div>
            <div>
                <div class="fw-bold">{{ auth()->user()->username }}</div>
                <div class="text-muted small">
                    @switch(auth()->user()->role)
                        @case(App\Models\User::ROLE_ADMIN) Admin @break
                        @case(App\Models\User::ROLE_INSTRUCTOR) Instructor @break
                        @default Student
                    @endswitch
                </div>
            </div>
        </div>

        <div class="sidebar-menu">
            <a href="{{ route('dashboard') }}" class="sidebar-link">Dashboard</a>

            @if(auth()->user()->role === App\Models\User::ROLE_ADMIN)
                <a href="{{ route('admin.users.index') }}" class="sidebar-link">Manage Users</a>
                <a href="{{ route('admin.announcements.index') }}" class="sidebar-link">Announcements</a>
            @endif

            @if(auth()->user()->role === App\Models\User::ROLE_INSTRUCTOR)
                <a href="#" class="sidebar-link">Courses</a>
            @endif

            <a href="{{ route('profile.edit') }}" class="sidebar-link">My Profile</a>
        </div>
    @else
        <div class="p-3">
            <p>Please <a href="{{ route('login') }}">login</a> or <a href="{{ route('register') }}">register</a>.</p>
        </div>
    @endauth
</div>
