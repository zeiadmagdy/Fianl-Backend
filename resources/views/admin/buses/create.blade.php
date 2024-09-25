@extends('layouts.app')

@section('title', 'Add Bus')

@section('content')
    <h1>Add Bus</h1>

    <form action="{{ route('admin.buses.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>
        <div class="mb-3">
            <label for="bus_number" class="form-label">Bus Number</label>
            <input type="number" class="form-control" id="bus_number" name="bus_number" required>
        </div>
        <div class="mb-3">
            <label for="capacity" class="form-label">Capacity</label>
            <input type="number" class="form-control" id="capacity" name="capacity" required>
        </div>
        <div class="mb-3">
            <label for="bus_line" class="form-label">Bus Line</label>
            <input type="text" class="form-control" id="bus_line" name="bus_line" required>
        </div>
        <button type="submit" class="btn btn-primary">Create Bus</button>
    </form>
@endsection
