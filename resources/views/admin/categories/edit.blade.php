@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Category</h1>

    <form action="{{ route('admin.categories.update', $category->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" class="form-control" name="name" value="{{ $category->name }}" required>
        </div>

        <div class="form-group">
            <label for="description">Description:</label>
            <textarea class="form-control" name="description">{{ $category->description }}</textarea>
        </div>

        <div class="form-group">
            <label for="category_image" class="form-label">Category Image:</label>
            <input type="file" class="form-control" id="category_image" name="category_image">
            @if($category->category_image)
                <img src="{{ $category->category_image }}" alt="Category Image" style="max-width: 150px; margin-top: 10px;">
            @endif
        </div>

        <button type="submit" class="btn btn-success">Update Category</button>
        <a href="{{ route('admin.categories.index') }}" class="btn btn-primary">Back to Categories</a>

    </form>
</div>
@endsection
