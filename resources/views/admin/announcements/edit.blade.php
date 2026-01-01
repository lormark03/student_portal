@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Edit Announcement</h3>

    <form action="{{ route('admin.announcements.update', $announcement) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Title</label>
            <input type="text" name="title" class="form-control" value="{{ old('title', $announcement->title) }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Body</label>
            <textarea name="body" class="form-control" rows="5" required>{{ old('body', $announcement->body) }}</textarea>
        </div>
        <div class="form-check mb-3">
            <input type="checkbox" name="is_active" class="form-check-input" id="is_active" {{ $announcement->is_active ? 'checked' : '' }}>
            <label class="form-check-label" for="is_active">Active</label>
        </div>

        <button class="btn btn-primary">Save</button>
        <a href="{{ route('admin.announcements.index') }}" class="btn btn-link">Cancel</a>
    </form>
</div>
@endsection
