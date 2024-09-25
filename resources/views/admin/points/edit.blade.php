@extends('layouts.app')

@section('title', 'Edit Point')

@section('content')
<h1>Edit Point: {{ $point->name }}</h1>

<form action="{{ route('admin.points.update', $point->id) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="mb-3">
        <label for="name" class="form-label">Point Name</label>
        <input type="text" class="form-control" id="name" name="name" value="{{ $point->name }}" required>
    </div>
    <div class="mb-3">
        <label for="location" class="form-label">Google Maps Location Link</label>
        <input type="url" class="form-control" id="location" name="location" value="{{ old('location', $point->location ?? '') }}" required>
    </div>
    
    <div class="mb-3">
        <label for="description" class="form-label">Description</label>
        <textarea class="form-control" id="description" name="description">{{ $point->description }}</textarea>
    </div>
    <div class="mb-3">
        <label for="arrived_time" class="form-label">Arrived Time</label>
        <input type="time" class="form-control" id="arrived_time" name="arrived_time" 
               value="{{ \Carbon\Carbon::createFromFormat('H:i:s', $point->arrived_time)->format('H:i') }}" required>
    </div>
    
    <button type="submit" class="btn btn-primary">Update Point</button>
</form>

<a href="{{ route('admin.buses.index') }}" class="btn btn-secondary mt-3">Back to Buses</a>
@endsection
