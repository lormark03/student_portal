@extends('layouts.app')

@section('content')
<div class="mb-4">
    <h1 class="h4 mb-1">Dashboard</h1>
    <p class="text-muted mb-0">Welcome back, {{ auth()->user()->username }}.</p>
</div>

<div class="row g-3">
    <div class="col-12">
        <div class="card shadow-sm">
            <div class="card-body">
                <h6 class="card-title">📢 Announcements</h6>
                @forelse($announcements as $announcement)
                    <div class="border rounded p-3 mb-3">
                        <h6>{{ $announcement->title }}</h6>
                        <p class="small text-muted">Posted {{ $announcement->created_at->diffForHumans() }}</p>
                        <p>{{ $announcement->body }}</p>
                    </div>
                @empty
                    <p class="text-muted mb-0">No announcements available.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
