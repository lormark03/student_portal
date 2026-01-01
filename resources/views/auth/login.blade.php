@extends('layouts.auth')

@section('content')
<div class="text-center mb-4">
    <h3 class="mb-0">Sign in to your account</h3>
    <p class="text-muted small">Use username or email and your password</p>
</div>

@if(session('status'))
    <div class="alert alert-success">{{ session('status') }}</div>
@endif

<form method="POST" action="{{ route('login') }}">
    @csrf

    <div class="mb-3">
        <label class="form-label">Username or Email</label>
        <input type="text" name="username" value="{{ old('username', session('username')) }}" class="form-control @error('username') is-invalid @enderror" autofocus>
        @error('username')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="mb-3">
        <label class="form-label">Password</label>
        <div class="input-group">
            <input id="loginPassword" type="password" name="password" class="form-control @error('password') is-invalid @enderror">
            <button id="toggleLoginPw" class="btn btn-outline-secondary pw-toggle-btn">Show</button>
            @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
    </div>

    <div class="d-flex justify-content-between align-items-center mb-3">
        <div class="form-check">
            <input type="checkbox" name="remember" class="form-check-input" id="remember">
            <label class="form-check-label" for="remember">Remember me</label>
        </div>
        <a href="#" class="small">Forgot password?</a>
    </div>

    <div class="d-grid">
        <button class="btn btn-primary">Login</button>
    </div>

    <p class="text-center text-muted mt-3 small">No account? <a href="{{ route('register') }}">Register</a></p>
</form>
@endsection