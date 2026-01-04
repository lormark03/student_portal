@extends('layouts.app')

@section('content')
<div class="container">
    @php
        $prefix = auth()->user()->role === \App\Models\User::ROLE_ADMIN
            ? 'admin'
            : (auth()->user()->role === \App\Models\User::ROLE_INSTRUCTOR ? 'instructor' : 'admin');
    @endphp

    <h3>Create Announcement</h3>

    <form action="{{ route($prefix . '.announcements.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label class="form-label">Title</label>
            <input type="text" name="title" class="form-control" value="{{ old('title') }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Body</label>
            <textarea name="body" class="form-control" rows="5" required>{{ old('body') }}</textarea>
        </div>
        <div class="form-check mb-3">
            <input type="checkbox" name="is_active" class="form-check-input" id="is_active" checked>
            <label class="form-check-label" for="is_active">Active</label>
        </div>

        <button class="btn btn-primary">Create</button>
        <a href="{{ route($prefix . '.announcements.index') }}" class="btn btn-link">Cancel</a>
    </form>
</div>
@endsection
