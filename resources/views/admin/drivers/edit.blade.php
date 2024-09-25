@extends('layouts.app')

@section('title', 'Edit Driver')

@section('content')
<h1>Edit Driver</h1>

<form action="{{ route('admin.drivers.update', $driver->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="form-group">
        <label for="name">Name</label>
        <input type="text" name="name" id="name" class="form-control" value="{{ $driver->name }}" required>
    </div>

    <div class="form-group">
        <label for="phone_number">Phone Number</label>
        <input type="text" name="phone_number" id="phone_number" class="form-control" value="{{ $driver->phone_number }}" required>
    </div>

    <div class="form-group">
        <label for="profile_image">Profile Image</label>
        <input type="file" name="profile_image" id="profile_image" class="form-control">
        @if($driver->profile_image)
            <img src="{{ $driver->profile_image }}" alt="Profile Image" width="100">
        @endif
    </div>

    <div class="form-group">
        <label for="bus_id">Assign Bus</label>
        <select name="bus_id" id="bus_id" class="form-control">
            <option value="">-- Select Bus --</option>
            @foreach($buses as $bus)
                <option value="{{ $bus->id }}" {{ $driver->bus_id == $bus->id ? 'selected' : '' }}>
                    {{ $bus->name }}
                </option>
            @endforeach
        </select>
    </div>

    <button type="submit" class="btn btn-success">Update Driver</button>
    <a href="{{ route('admin.drivers.index') }}" class="btn btn-secondary mt-3">Back to Drivers</a>
</form>
@endsection
