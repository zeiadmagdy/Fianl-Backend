@extends('layouts.app')

@section('title', 'Add Driver')

@section('content')
<h1>Add Driver</h1>

<form action="{{ route('admin.drivers.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="form-group">
        <label for="name">Name</label>
        <input type="text" name="name" id="name" class="form-control" required>
    </div>

    <div class="form-group">
        <label for="phone_number">Phone Number</label>
        <input type="text" name="phone_number" id="phone_number" class="form-control" required>
    </div>

    <div class="form-group">
        <label for="profile_image">Profile Image</label>
        <input type="file" name="profile_image" id="profile_image" class="form-control">
    </div>

    <div class="form-group">
        <label for="bus_id">Assign Bus</label>
        <select name="bus_id" id="bus_id" class="form-control">
            <option value="">-- Select Bus --</option>
            @foreach($buses as $bus)
                <option value="{{ $bus->id }}">{{ $bus->name }}</option>
            @endforeach
        </select>
    </div>

    <button type="submit" class="btn btn-success">Add Driver</button>
</form>
@endsection
