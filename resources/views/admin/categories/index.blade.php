@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-3">Categories</h1>
    <a href="{{ route('admin.categories.create') }}" class="btn btn-primary mb-3">Add New Category</a>
    <a href="{{ route('admin.dashboard') }}" class="btn btn-primary mb-3">Back to Dashboard</a>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Description</th>
                <th>Category Image</th>
                <th>Related Events</th> <!-- New Column for Related Events -->
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($categories as $category)
                <tr>
                    <td>{{ $category->id }}</td>
                    <td>{{ $category->name }}</td>
                    <td>{{ $category->description }}</td>
                    <td>
                        @if($category->category_image)
                            <img src="{{ $category->category_image }}" alt="Category Image" style="max-width: 50px;">
                        @else
                            No Image
                        @endif
                    </td>
                    <td>
                        @if ($category->events->count() > 0)
                            <ul>
                                @foreach ($category->events as $event)
                                    <li>
                                        <a href="{{ route('admin.events.show', $event->id) }}">
                                            {{ $event->name }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            No events related
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('admin.categories.show', $category->id) }}" class="btn btn-info">View</a>
                        <a href="{{ route('admin.categories.edit', $category->id) }}" class="btn btn-warning">Edit</a>
                        <form id="delete-form-{{ $category->id }}" action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="button" onclick="confirmDelete({{ $category->id }})" class="btn btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection

<script>
    function confirmDelete(categoryId) {
        Swal.fire({
            title: 'Delete Category!',
            text: 'Are you sure you want to delete?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'No, cancel!'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + categoryId).submit();
            } else {
                Swal.fire('Cancelled', 'Category deletion has been cancelled.', 'error');
            }
        });
    }
</script>
