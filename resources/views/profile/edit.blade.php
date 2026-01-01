@extends('layouts.app')

@section('content')
<h1>My Profile</h1>

<form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="mb-3">
        <label class="form-label">Username</label>
        <input class="form-control" value="{{ $user->username }}" disabled>
    </div>

    <div class="row">
        <div class="col-md-4 text-center mb-3">
            @if($user->profile)
                <img src="{{ asset('storage/' . $user->profile) }}" class="rounded img-fluid" alt="profile">
            @else
                <div class="rounded-circle bg-secondary text-white d-inline-flex align-items-center justify-content-center" style="width:96px;height:96px;font-size:28px">{{ strtoupper(substr($user->username,0,1)) }}</div>
            @endif
        </div>
        <div class="col-md-8">
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input name="email" value="{{ old('email', $user->email) }}" class="form-control @error('email') is-invalid @enderror">
                @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
                <label class="form-label">New Password (leave blank to keep current)</label>
                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror">
                @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Confirm Password</label>
                <input type="password" name="password_confirmation" class="form-control">
            </div>

            <div class="mb-3">
                <label class="form-label">Profile Image</label>
                <input type="file" name="profile_image" accept="image/*" class="form-control">
                @error('profile_image')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
            </div>

            <button class="btn btn-primary">Update Profile</button>
        </div>
    </div>
</form>
@endsection