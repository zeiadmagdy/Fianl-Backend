@extends('layouts.app')

@section('content')
<div class="container">
    <h1>{{ $category->name }}</h1>

    <div class="card">
        <div class="card-body">
            <p><strong>Description: </strong>{{ $category->description }}</p>
            <p><strong>Capacity: </strong>{{ $category->capacity }}</p>
        </div>
    </div>

    <a href="{{ route('admin.categories.index') }}" class="btn btn-primary mt-3">Back to Categories</a>
</div>
@endsection
