@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <div>
        <h1 class="h3 mb-0">Student Dashboard</h1>
        <p class="text-muted mb-0">Welcome, {{ auth()->user()->username }}.</p>
    </div>
</div>

<div class="row g-3">
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">My Courses</h5>
                <p class="card-text">You are not enrolled in any courses yet. Browse available courses and enroll.</p>
                <a href="#" class="btn btn-sm btn-primary">Browse Courses</a>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Profile</h5>
                <p class="card-text">Username: {{ auth()->user()->username }}</p>
                <a href="{{ route('profile.edit') }}" class="btn btn-sm btn-outline-primary">Edit Profile</a>
            </div>
        </div>
    </div>
</div>
@endsection