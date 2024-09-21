@extends('layouts.app')

@section('title', 'User Details')

@section('content')
<h1>Event Details</h1>

<p><strong>Name:</strong> {{ $event->name }}</p>
<p><strong>Email:</strong> {{ $event->description }}</p>

<a href="{{ route('admin.events.index') }}" class="btn btn-primary">Back to Users</a>
@endsection
