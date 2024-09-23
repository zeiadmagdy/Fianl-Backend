@extends('layouts.app')

@section('title', 'Event Details')

@section('content')
<h1>Event Details</h1>

<p><strong>Name:</strong> {{ $event->name }}</p>
<p><strong>Date:</strong> {{ \Carbon\Carbon::parse($event->date)->format('d-m-Y H:i') }}</p>
<p><strong>Description:</strong> {{ $event->description }}</p>
<p><strong>Location:</strong> {{ $event->location }}</p>
<p><strong>Capacity:</strong> {{ $event->capacity }}</p>
<p><strong>Category:</strong> {{ $event->category->name }}</p>

<a href="{{ route('admin.events.index') }}" class="btn btn-primary">Back to Events</a>
@endsection
