@extends('layouts.auth')

@section('content')
<div class="text-center mb-4">
    <h3 class="mb-0">Create an account</h3>
    <p class="text-muted small">Join as a student. Instructors and admins are created by admin.</p>
</div>

<form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
    @csrf

    <div class="mb-3">
        <label class="form-label">Username</label>
        <input type="text" name="username" value="{{ old('username') }}" class="form-control @error('username') is-invalid @enderror" autofocus>
        @error('username')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="mb-3">
        <label class="form-label">Email</label>
        <input type="email" name="email" value="{{ old('email') }}" class="form-control @error('email') is-invalid @enderror">
        @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="mb-3">
        <label class="form-label">Password</label>
        <div class="input-group">
            <input id="registerPassword" type="password" name="password" class="form-control @error('password') is-invalid @enderror">
            <button id="toggleRegisterPw" class="btn btn-outline-secondary pw-toggle-btn">Show</button>
        </div>
        @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
        <div class="mt-2">
            <div class="pw-strength bg-light rounded">
                <div id="pw-strength-bar" style="width:0%; height:100%; transition:width 150ms"></div>
            </div>
            <small id="pw-strength-text" class="text-muted"></small>
        </div>
    </div>

    <div class="mb-3">
        <label class="form-label">Confirm Password</label>
        <input type="password" name="password_confirmation" class="form-control">
    </div>

    <div class="mb-3">
        <label class="form-label">Profile Image (optional)</label>
        <div class="d-flex align-items-center gap-2">
            <input type="file" name="profile_image" accept="image/*" class="form-control-file">
            <img id="profilePreview" src="#" alt="preview" style="display:none;width:64px;height:64px;object-fit:cover;border-radius:8px;" />
        </div>
        @error('profile_image')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
    </div>

    <div class="d-grid">
        <button class="btn btn-primary">Register</button>
    </div>

    <p class="text-center text-muted mt-3 small">Already have an account? <a href="{{ route('login') }}">Sign in</a></p>
</form>

<script>
    document.querySelector('input[name="profile_image"]')?.addEventListener('change', function (e) {
        const file = e.target.files[0];
        const img = document.getElementById('profilePreview');
        if (!file) { img.style.display = 'none'; return; }
        const reader = new FileReader();
        reader.onload = function (ev) {
            img.src = ev.target.result;
            img.style.display = 'inline-block';
        };
        reader.readAsDataURL(file);
    });
</script>

@endsection