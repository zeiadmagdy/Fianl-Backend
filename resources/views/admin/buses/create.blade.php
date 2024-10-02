@extends('layouts.app')

@section('title', 'Add Bus')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Add New Bus</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.buses.store') }}" method="POST">
                        @csrf
                        <div class="form-group mb-3">
                            <label for="name">Bus Name</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="bus_number">Bus Number</label>
                            <input type="number" class="form-control" id="bus_number" name="bus_number" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="capacity">Capacity</label>
                            <input type="number" class="form-control" id="capacity" name="capacity" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="bus_line">Bus Line</label>
                            <input type="text" class="form-control" id="bus_line" name="bus_line" required>
                        </div>
                        <button type="submit" class="btn btn-success float-right">Add Bus</button>
                        <a href="{{ route('admin.buses.index') }}" class="btn btn-primary float-left">Back to Buses</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
