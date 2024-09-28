@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Create Category</h1>

    <form action="{{ route('admin.categories.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" class="form-control" name="name" required>
        </div>

        <div class="form-group">
            <label for="description">Description:</label>
            <textarea class="form-control" name="description"></textarea>
        </div>

        <div class="mb-3">
            <label for="category_image" class="form-label">Category Image</label>
            <input type="file" class="form-control" id="category_image" name="category_image">
        </div>

        <button type="submit" class="btn btn-success">Add Category</button>
        <a href="{{ route('admin.categories.index') }}" class="btn btn-primary">Back to Categories</a>

    </form>
</div>
@endsection
