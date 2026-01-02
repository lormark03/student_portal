@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Create User</h1>

    <form method="POST" action="{{ route('admin.users.store') }}" enctype="multipart/form-data">
        @csrf

        {{-- Username --}}
        <div class="mb-3">
            <label class="form-label">Username</label>
            <input 
                type="text" 
                name="username" 
                value="{{ old('username') }}" 
                class="form-control @error('username') is-invalid @enderror"
                required
            >
            @error('username')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Email --}}
        <div class="mb-3">
            <label class="form-label">Email</label>
            <input 
                type="email" 
                name="email" 
                value="{{ old('email') }}" 
                class="form-control @error('email') is-invalid @enderror"
                required
            >
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Password --}}
        <div class="mb-3">
            <label class="form-label">Password</label>
            <input 
                type="password" 
                name="password" 
                class="form-control @error('password') is-invalid @enderror"
                required
            >
            @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Confirm Password --}}
        <div class="mb-3">
            <label class="form-label">Confirm Password</label>
            <input 
                type="password" 
                name="password_confirmation" 
                class="form-control"
                required
            >
        </div>

        {{-- Role --}}
        <div class="mb-3">
            <label class="form-label">Role</label>
            <select name="role" class="form-control">
                <option value="{{ \App\Models\User::ROLE_STUDENT }}" {{ old('role') == \App\Models\User::ROLE_STUDENT ? 'selected' : '' }}>Student</option>
                <option value="{{ \App\Models\User::ROLE_INSTRUCTOR }}" {{ old('role') == \App\Models\User::ROLE_INSTRUCTOR ? 'selected' : '' }}>Instructor</option>
                <option value="{{ \App\Models\User::ROLE_ADMIN }}" {{ old('role') == \App\Models\User::ROLE_ADMIN ? 'selected' : '' }}>Admin</option>
            </select>
        </div>

        {{-- Profile Image --}}
        <div class="mb-3">
            <label class="form-label">Profile Image</label>
            <input 
                type="file" 
                name="profile_image" 
                accept="image/*" 
                class="form-control @error('profile_image') is-invalid @enderror"
            >
            @error('profile_image')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>

        {{-- Submit --}}
        <button type="submit" class="btn btn-primary">Create</button>
    </form>
</div>
@endsection
