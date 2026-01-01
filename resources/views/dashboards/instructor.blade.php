@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <div>
        <h1 class="h3 mb-0">Instructor Dashboard</h1>
        <p class="text-muted mb-0">Welcome, {{ auth()->user()->username }}.</p>
    </div>
</div>

<div class="row g-3">
    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">My Courses</h5>
                <p class="card-text">You have no courses yet. Use the links in the sidebar to create content or manage classes.</p>
                <a href="#" class="btn btn-sm btn-primary">Create Course</a>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Recent Activity</h5>
                <p class="card-text">No recent activity.</p>
            </div>
        </div>
    </div>
</div>
@endsection