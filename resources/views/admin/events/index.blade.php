@extends('layouts.app')

@section('title', 'Events')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"></h3>
                <a href="{{ route('admin.events.create') }}" class="btn btn-primary float-right">Add Event</a>
                <a href="{{ route('admin.dashboard') }}" class="btn btn-primary mb-3">Back to Dashboard</a>
            </div>
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Date</th>
                            <th>Category</th> <!-- Category Column -->
                            <th>Capacity</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($events as $event)
                            <tr>
                                <td>{{ $event->id }}</td>
                                <td>{{ $event->name }}</td>
                                <td>{{ $event->date }}</td>
                                <td>
                                    <a href="{{ route('admin.categories.show', $event->category->id) }}">
                                        {{ $event->category->name }}
                                    </a> <!-- Category is clickable now -->
                                </td>
                                <td>{{ $event->capacity }}</td>
                                <td>
                                    <a href="{{ route('admin.events.show', $event->id) }}" class="btn btn-info">View</a>
                                    <a href="{{ route('admin.events.edit', $event) }}" class="btn btn-warning">Edit</a>
                                    <form id="delete-form-{{ $event->id }}" action="{{ route('admin.events.destroy', $event) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" onclick="confirmDelete({{ $event->id }})" class="btn btn-danger">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

<script>
    function confirmDelete(eventId) {
        const title = 'Delete event!';
        const text = 'Are you sure you want to delete this Event?';
        
        Swal.fire({
            title: title,
            text: text,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'No, cancel!'
        }).then((result) => {
            if (result.isConfirmed) {
                // If confirmed, submit the form
                document.getElementById('delete-form-' + eventId).submit();
            } else {
                // Optionally show a message for cancellation
                Swal.fire('Cancelled', 'Event deletion has been cancelled.', 'error');
            }
        });
    }
</script>
