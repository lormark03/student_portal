@extends('layouts.app')

@section('content')
<div class="container">
    @php
        $prefix = auth()->user()->role === \App\Models\User::ROLE_ADMIN
            ? 'admin'
            : (auth()->user()->role === \App\Models\User::ROLE_INSTRUCTOR ? 'instructor' : 'admin');
    @endphp

    <div class="d-flex justify-content-between mb-3">
        <h4>Announcements</h4>
        <a href="{{ route($prefix . '.announcements.create') }}" class="btn btn-primary">
            New Announcement
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card">
        <div class="card-body">
            @if($announcements->count())
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Title</th>
                                @if(auth()->user()->role === \App\Models\User::ROLE_ADMIN)
                                    <th>Author</th>
                                @endif
                                <th>Active</th>
                                <th>Created</th>
                                <th width="180">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($announcements as $a)
                            <tr>
                                <td>{{ $a->title }}</td>
                                @if(auth()->user()->role === \App\Models\User::ROLE_ADMIN)
                                    <td>{{ $a->user->username ?? '—' }}</td>
                                @endif
                                <td>{{ $a->is_active ? 'Yes' : 'No' }}</td>
                                <td>{{ $a->created_at->format('M d, Y') }}</td>
                                <td>
                                    <a href="{{ route($prefix . '.announcements.edit', $a) }}"
                                       class="btn btn-sm btn-warning">Edit</a>

                                    <form action="{{ route($prefix . '.announcements.destroy', $a) }}"
                                          method="POST"
                                          class="d-inline"
                                          onsubmit="return confirm('Delete this announcement?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger">
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{ $announcements->links() }}
            @else
                <p>No announcements found.</p>
            @endif
        </div>
    </div>
</div>
@endsection
