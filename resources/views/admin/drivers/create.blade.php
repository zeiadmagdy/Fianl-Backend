@extends('layouts.app')

@section('title', 'Add Driver')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Add New Driver</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.drivers.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group mb-3">
                            <label for="name">Name</label>
                            <input type="text" name="name" id="name" class="form-control" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="phone_number">Phone Number</label>
                            <input type="text" name="phone_number" id="phone_number" class="form-control" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="profile_image">Profile Image</label>
                            <input type="file" name="profile_image" id="profile_image" class="form-control">
                        </div>
                        <div class="form-group mb-3">
                            <label for="bus_id">Assign Bus</label>
                            <select name="bus_id" id="bus_id" class="form-control">
                                <option value="">-- Select Bus --</option>
                                @foreach($buses as $bus)
                                    <option value="{{ $bus->id }}">{{ $bus->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="btn btn-success float-right">Add Driver</button>
                        <a href="{{ route('admin.drivers.index') }}" class="btn btn-primary float-left">Back to Drivers</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
