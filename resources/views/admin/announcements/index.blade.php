@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Announcements</h3>
        <a href="{{ route('admin.announcements.create') }}" class="btn btn-primary">New Announcement</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card">
        <div class="card-body">
            @if($announcements->count())
                <table class="table">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Active</th>
                            <th>Created</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($announcements as $a)
                        <tr>
                            <td>{{ $a->title }}</td>
                            <td>{{ $a->is_active ? 'Yes' : 'No' }}</td>
                            <td>{{ $a->created_at->diffForHumans() }}</td>
                            <td class="text-end">
                                <a href="{{ route('admin.announcements.edit', $a) }}" class="btn btn-sm btn-secondary">Edit</a>
                                <form action="{{ route('admin.announcements.destroy', $a) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Delete announcement?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $announcements->links() }}
            @else
                <p class="mb-0">No announcements yet.</p>
            @endif
        </div>
    </div>
</div>
@endsection
