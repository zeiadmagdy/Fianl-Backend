@extends('layouts.app')

@section('title', 'Add Point to Bus: ' . $bus->name)

@section('content')
<div class="container">
    <h1>Add Point to Bus: {{ $bus->name }}</h1>

    <form action="{{ route('admin.buses.points.store', $bus->id) }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Point Name</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>
        <div class="mb-3">
            <label for="location" class="form-label">Location</label>
            <input type="text" class="form-control" id="location" name="location" required>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control" id="description" name="description"></textarea>
        </div>
        <div class="mb-3">
            <label for="arrived_time" class="form-label">Arrived Time (HH:MM)</label>
            <input type="time" class="form-control" id="arrived_time" name="arrived_time" required>
        </div>
        
        <button type="submit" class="btn btn-primary">Create Point</button>
    </form>

    <a href="{{ route('admin.buses.show', $bus->id) }}" class="btn btn-secondary mt-3">Back to Bus</a>
</div>
@endsection
