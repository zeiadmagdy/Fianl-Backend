@extends('layouts.app')

@section('title', 'Event Details')

@section('content')
<div class="container mt-5">
    <h1>Event Details</h1>

    <div class="card">
        <div class="card-body d-flex justify-content-between align-items-start">
            <!-- Details Section -->
            <div>
                <h5><strong>Name:</strong> {{ $event->name }}</h5>
                <h6><strong>Date:</strong> {{ \Carbon\Carbon::parse($event->date)->format('d-m-Y H:i') }}</h6>
                <p><strong>Description:</strong> {{ $event->description }}</p>
                <p><strong>Location:</strong> {{ $event->location }}</p>
                <p><strong>Capacity:</strong> {{ $event->capacity }}</p>
                <p><strong>Category:</strong> {{ $event->category->name }}</p>

                <a href="{{ route('admin.events.index') }}" class="btn btn-primary mt-3">Back to Events</a>
            </div>

            <!-- Image Section -->
            <div class="ms-3" style="align-self: flex-end;">
                @if($event->event_image)
                    <img src="{{ $event->event_image }}" alt="Event Image" class="img-fluid" style="max-width: 150px; height: auto;">
                @else
                    <div class="text-muted">No Image</div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
