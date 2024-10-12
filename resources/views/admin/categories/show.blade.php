@extends('layouts.app')

@section('title', 'Category Details')

@section('content')
<div class="container mt-5">
    <!-- Category Title -->
    <h1 class="animated-heading" style="text-align: center;">{{ $category->name }}</h1>
    <a href="{{ route('admin.categories.index') }}" class="btn btn-primary mt-3">Back to Categories</a>

    <!-- Category Description Card -->
    <div class="card mt-4">
        <div class="card-body">
            <p><strong>Description: </strong>{{ $category->description }}</p>
            <img src="{{ $category->category_image }}" alt="{{ $category->name }}" class="img-fluid" style="max-height: 300px; object-fit: cover;">
        </div>
    </div>

    <!-- Related Events Section -->
    <h2 class="mt-4">Related Events</h2>
    <div class="row mt-3">
        @if($events->isEmpty())
            <div class="col-12">
                <div class="alert alert-warning">No events found for this category.</div>
            </div>
        @else
            @foreach ($events as $event)
                <div class="col-md-4 mb-4">
                    <div class="card event-card animated-card">
                        <div class="card-body">
                            <h5 class="card-title">{{ $event->name }}</h5>
                            <p class="card-text">Date: {{ \Carbon\Carbon::parse($event->date)->format('d-m-Y') }}</p>
                            <a href="{{ route('admin.events.show', $event->id) }}" class="btn btn-info">View Details</a>
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
    </div>
</div>

@endsection

<style>
    /* CSS Animation for smooth appearance */
    .animated-heading {
        animation: fadeInDown 1s ease-out;
        color: #333;
        font-family: 'Roboto', sans-serif;
        text-transform: uppercase;
        letter-spacing: 2px;
        text-align: center;
    }

    /* Keyframes for the fade-in-down animation */
    @keyframes fadeInDown {
        0% {
            opacity: 0;
            transform: translateY(-20px);
        }
        100% {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Card hover effect */
    .animated-card {
        transition: transform 0.3s, box-shadow 0.3s;
    }

    .animated-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
    }
</style>
