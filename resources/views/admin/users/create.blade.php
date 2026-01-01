@extends('layouts.app')

@section('content')
<h1>Create User</h1>

<form method="POST" action="{{ route('admin.users.store') }}" enctype="multipart/form-data">
    @csrf

    <div class="mb-3">
        <label class="form-label">Username</label>
        <input name="username" value="{{ old('username') }}" class="form-control @error('username') is-invalid @enderror">
        @error('username')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="mb-3">
        <label class="form-label">Email</label>
        <input name="email" value="{{ old('email') }}" class="form-control @error('email') is-invalid @enderror">
        @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="mb-3">
        <label class="form-label">Password</label>
        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror">
        @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="mb-3">
        <label class="form-label">Confirm Password</label>
        <input type="password" name="password_confirmation" class="form-control">
    </div>

    <div class="mb-3">
        <label class="form-label">Role</label>
        <select name="role" class="form-control">
            <option value="0">Admin</option>
            <option value="1">Instructor</option>
            <option value="3" selected>Student</option>
        </select>
    </div>

    <div class="mb-3">
        <label class="form-label">Profile Image</label>
        <input type="file" name="profile_image" accept="image/*" class="form-control">
        @error('profile_image')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
    </div>

    <button class="btn btn-primary">Create</button>
</form>
@endsection