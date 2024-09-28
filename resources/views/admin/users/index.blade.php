@extends('layouts.app')

@section('title', 'Users')

@section('content')
<a href="{{ route('admin.users.create') }}" class="btn btn-primary mb-3">Add User</a>
<a href="{{ route('admin.dashboard') }}" class="btn btn-primary mb-3">Back to Dashboard</a>

<!-- Table to list users -->
<table class="table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Profile Image</th>
            <th>Name</th>
            <th>Email</th>
            <th>Role</th>

            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($users as $user)
            <tr>
                <td>{{ $user->id }}</td>
                <td>
                    @if($user->profile_image)
                        <img src="{{ $user->profile_image }}" alt="Profile Image" width="50">
                    @else
                        No Image
                    @endif
                </td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->is_admin ? 'Admin' : 'User' }}</td>

                <td>
                    <a href="{{ route('admin.users.show', $user->id) }}" class="btn btn-info">View</a>
                    <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-warning">Edit</a>
                    <form id="delete-form-{{ $user->id }}" action="{{ route('admin.users.destroy', $user) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="button" onclick="confirmDelete({{ $user->id }})" class="btn btn-danger">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
@endsection
<script>
    function confirmDelete(userId) {
        const title = 'Delete User!';
        const text = 'Are you sure you want to delete?';
        
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
                document.getElementById('delete-form-' + userId).submit();
            } else {
                // Optionally show a message for cancellation
                Swal.fire('Cancelled', 'User deletion has been cancelled.', 'error');
            }
        });
    }
    </script>