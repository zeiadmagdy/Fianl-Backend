@extends('layouts.app')

@section('title', 'Driver Details')

@section('content')
<h1>Driver Details</h1>

<a href="{{ route('admin.drivers.index') }}" class="btn btn-secondary mb-3">Back to Drivers</a>

<div class="card">
    <div class="card-header">
        <h5>{{ $driver->name }}</h5>
    </div>
    <div class="card-body">
        <p><strong>Phone Number:</strong> {{ $driver->phone_number }}</p>
        <p><strong>Bus Assigned:</strong> {{ $driver->bus->name ?? 'No bus assigned' }}</p>
        @if($driver->profile_image)
            <p><strong>Profile Image:</strong></p>
            <img src="{{ $driver->profile_image }}" alt="Profile Image" width="150">
        @else
            <p>No Profile Image</p>
        @endif
    </div>
</div>
@endsection
