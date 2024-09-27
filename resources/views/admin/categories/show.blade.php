@extends('layouts.app')

@section('content')
<div class="container">
    <h1>{{ $category->name }}</h1>

    <div class="card">
        <div class="card-body">
            <p><strong>Description: </strong>{{ $category->description }}</p>
            <img src="{{ $category->category_image }}" alt="{{ $category->name }}" class="img-fluid">
        </div>
    </div>

    <h2>Related Events</h2>
    <ul>
        @if($events->isEmpty())
            <li>No events found for this category.</li>
        @else
            @foreach ($events as $event)
                <li>{{ $event->name }} - {{ $event->date }}</li>
            @endforeach
        @endif
    </ul>

    <a href="{{ route('admin.categories.index') }}" class="btn btn-primary mt-3">Back to Categories</a>
</div>
@endsection
