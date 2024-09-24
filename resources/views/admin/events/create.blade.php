@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Add New Event</h4>
                </div>
                <div class="card-body">
                    <!-- Display validation errors -->
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('admin.events.store') }}" method="POST">
                        @csrf
                        <!-- Event Name -->
                        <div class="form-group mb-3">
                            <label for="name">Event Name</label>
                            <input type="text" name="name" class="form-control" placeholder="Enter event name"
                                value="{{ old('name') }}" required>
                        </div>

                        <!-- Event Date -->
                        <div class="form-group mb-3">
                            <label for="date">Event Date</label>
                            <input type="datetime-local" name="date" class="form-control" value="{{ old('date') }}"
                                required>
                        </div>

                        <!-- Event Description -->
                        <div class="form-group mb-3">
                            <label for="description">Event Description</label>
                            <textarea name="description" class="form-control" rows="4"
                                placeholder="Enter event description">{{ old('description') }}</textarea>
                        </div>

                        <!-- Event Category -->
                        <div class="form-group mb-3">
                            <label for="category">Event Category</label>
                            <select name="category_id" class="form-control" required>
                                <option value="">Select Category</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Submit Button -->
                        <div class="form-group">
                            <button type="submit" class="btn btn-success w-100">Add Event</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection