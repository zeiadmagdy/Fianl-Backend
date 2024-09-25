@extends('layouts.app')

@section('title', 'Edit Bus')

@section('content')
<h1>Edit Bus</h1>

<form action="{{ route('admin.buses.update', $bus->id) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="mb-3">
        <label for="name" class="form-label">Bus Name</label>
        <input type="text" class="form-control" id="name" name="name" value="{{ $bus->name }}" required>
    </div>
    <div class="mb-3">
        <label for="bus_number" class="form-label">Bus Number</label>
        <input type="number" class="form-control" id="bus_number" name="bus_number" value="{{ $bus->bus_number }}" required>
    </div>
    <div class="mb-3">
        <label for="capacity" class="form-label">Capacity</label>
        <input type="number" class="form-control" id="capacity" name="capacity" value="{{ $bus->capacity }}" required>
    </div>
    <div class="mb-3">
        <label for="bus_line" class="form-label">Bus Line</label>
        <input type="text" class="form-control" id="bus_line" name="bus_line" value="{{ $bus->bus_line }}" required>
    </div>
    <button type="submit" class="btn btn-primary">Update Bus</button>
</form>

<a href="{{ route('admin.buses.index') }}" class="btn btn-secondary mt-3">Back to Buses</a>
@endsection
