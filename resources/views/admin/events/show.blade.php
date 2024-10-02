@extends('layouts.app')

@section('title', 'Event Details')

@section('content')
<div class="container mt-5">
    <!-- Header Section -->
    <div class="card-header">
        <h1 class="animated-heading" style="text-align: center; font-weight: bold;">Event Details</h1>
        <a href="{{ route('admin.events.edit', $event->id) }}" class="btn btn-warning float-right">Edit Event</a>
        <a href="{{ route('admin.events.index') }}" class="btn btn-primary float-left">Back to Events</a>
    </div>

    <div class="card mt-3">
        <div class="card-body d-flex justify-content-between align-items-start">
            <!-- Details Section -->
            <div>
                <h5><strong>Name:</strong> {{ $event->name }}</h5>
                <h6><strong>Date:</strong> {{ \Carbon\Carbon::parse($event->date)->format('d-m-Y H:i') }}</h6>
                <p><strong>Description:</strong> {{ $event->description }}</p>
                <p><strong>Location:</strong> {{ $event->location }}</p>
                <p><strong>Capacity:</strong> {{ $event->capacity }}</p>
                <p><strong>Category:</strong> {{ $event->category->name }}</p>
                <p><strong>Attendees:</strong> {{ $event->attendees->count() }}</p>
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

    <!-- Attended Events Section -->
    <div class="card mt-4">
        <div class="card-body">
            <h5 class="card-title">Attended Users</h5>
            @if($event->attendees->isNotEmpty())
                <ul class="list-group">
                    @foreach($event->attendees as $attendee)
                        <li class="list-group-item">
                            <a href="{{ route('admin.users.show', $attendee->id) }}" class="text-decoration-none">
                                {{ $attendee->name }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            @else
                <p>No attendees for this event yet.</p>
            @endif
        </div>
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
</style>
