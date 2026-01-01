<div class="card mb-3">
    <div class="card-body">
        @auth
            <div class="d-flex align-items-center mb-3">
                <div class="me-2" style="width:48px;height:48px;border-radius:8px;background:var(--primary);display:flex;align-items:center;justify-content:center;color:#fff;font-weight:700;">{{ strtoupper(substr(auth()->user()->username,0,1)) }}</div>
                <div>
                    <div class="fw-bold">{{ auth()->user()->username }}</div>
                    <div class="small text-muted">
                        @switch(auth()->user()->role)
                            @case(App\Models\User::ROLE_ADMIN) Admin @break
                            @case(App\Models\User::ROLE_INSTRUCTOR) Instructor @break
                            @default Student
                        @endswitch
                    </div>
                </div>
            </div>

            <a href="{{ route('dashboard') }}" class="btn btn-sm btn-outline-primary mb-2">Dashboard</a>
            <div class="list-group">
                @if(auth()->user()->role === App\Models\User::ROLE_ADMIN)
                    <a href="{{ route('admin.users.index') }}" class="list-group-item list-group-item-action">Manage Users</a>
                    <a href="{{ route('admin.announcements.index') }}" class="list-group-item list-group-item-action">Announcements</a>
                @endif

                @if(auth()->user()->role === App\Models\User::ROLE_INSTRUCTOR)
                    <a href="#" class="list-group-item list-group-item-action">Courses</a>
                @endif

                <a href="{{ route('profile.edit') }}" class="list-group-item list-group-item-action">My Profile</a>
            </div>
        @else
            <p class="mb-0">Please <a href="{{ route('login') }}">login</a> or <a href="{{ route('register') }}">register</a>.</p>
        @endauth
    </div>
</div>
