@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Image Creation Dashboard</h2>
    <a href="{{ route('image_creation.create') }}" class="btn btn-primary">Create New Image</a>
    
    <table class="table table-bordered mt-4">
        <thead>
            <tr>
                <th>ID</th>
                <th>Image</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($images as $image)
            <tr>
                <td>{{ $image->id }}</td>
                <td><img src="{{ asset('storage/'.$image->path) }}" alt="Image" width="100" /></td>
                <td>
                    <a href="{{ route('image_creation.edit', $image->id) }}" class="btn btn-warning">Edit</a>
                    <form action="{{ route('image_creation.destroy', $image->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
