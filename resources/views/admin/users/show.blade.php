@extends('layouts.app')

@section('content')
<h1>User Details</h1>

<ul class="list-group mb-3">
    <li class="list-group-item"><strong>ID:</strong> {{ $user->id }}</li>
    <li class="list-group-item"><strong>Username:</strong> {{ $user->username }}</li>
    <li class="list-group-item"><strong>Email:</strong> {{ $user->email }}</li>
    <li class="list-group-item"><strong>Role:</strong> 
        @switch($user->role)
            @case(App\Models\User::ROLE_ADMIN) Admin @break
            @case(App\Models\User::ROLE_INSTRUCTOR) Instructor @break
            @default Student
        @endswitch
    </li>
    <li class="list-group-item">
        <strong>Profile:</strong>
        @if($user->profile && file_exists(storage_path('app/public/' . $user->profile)))
            <img src="{{ asset('storage/' . $user->profile) }}" 
                 alt="Profile Image" 
                 class="rounded" 
                 style="width:100px; height:100px; object-fit:cover;">
        @else
            <span class="text-muted">No profile image</span>
        @endif
    </li>
</ul>

<a href="{{ route('admin.users.index') }}" class="btn btn-link mt-3">Back to list</a>
@endsection
