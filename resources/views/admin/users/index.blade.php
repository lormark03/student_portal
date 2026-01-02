@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1>Users</h1>
    <a href="{{ route('admin.users.create') }}" class="btn btn-primary">Create User</a>
</div>

<table class="table table-striped align-middle">
    <thead>
        <tr>
            <th>ID</th>
            <th>Username</th>
            <th>Email</th>
            <th>Avatar</th>
            <th>Role</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($users as $user)
            <tr>
                <td>{{ $user->id }}</td>
                <td>{{ $user->username }}</td>
                <td>{{ $user->email }}</td>

                <!-- Avatar / Profile Image -->
                <td>
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
                </td>

                <td>
                    @switch($user->role)
                        @case(App\Models\User::ROLE_ADMIN) Admin @break
                        @case(App\Models\User::ROLE_INSTRUCTOR) Instructor @break
                        @default Student
                    @endswitch
                </td>

                <td>
                    <a href="{{ route('admin.users.show', $user) }}" class="btn btn-sm btn-outline-secondary">View</a>
                    <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                    <form method="POST" action="{{ route('admin.users.destroy', $user) }}" class="d-inline" onsubmit="return confirm('Delete user?');">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-outline-danger">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

{{ $users->links() }}
@endsection
