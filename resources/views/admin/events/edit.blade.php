@extends('layouts.app')

@section('title', 'Edit Event')

@section('content')
<div class="card">
    <div class="card-header">
        <h1 class="animated-heading" style="text-align: center; font-weight: bold;">Edit Event</h1>
        <a href="{{ route('admin.events.index') }}" class="btn btn-primary float-right">Back to Events</a>
        <button type="button" class="btn btn-primary float-left" onclick="document.getElementById('updateForm').submit();">Update Event</button>
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

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <form id="updateForm" action="{{ route('admin.events.update', $event->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-group mb-3">
                <label for="name">Event Name</label>
                <input type="text" class="form-control" name="name" id="name" value="{{ old('name', $event->name) }}" required>
            </div>

            <div class="form-group mb-3">
                <label for="date">Event Date</label>
                <input type="datetime-local" class="form-control" name="date" id="date" value="{{ old('date', \Carbon\Carbon::parse($event->date)->format('Y-m-d\TH:i')) }}" required>
            </div>

            <div class="form-group mb-3">
                <label for="description">Description</label>
                <textarea class="form-control" name="description" id="description">{{ old('description', $event->description) }}</textarea>
            </div>

            <div class="form-group mb-3">
                <label for="capacity">Capacity</label>
                <input type="number" class="form-control" name="capacity" id="capacity" value="{{ old('capacity', $event->capacity) }}">
            </div>

            <div class="form-group mb-3">
                <label for="location">Location</label>
                <input type="text" class="form-control" name="location" id="location" value="{{ old('location', $event->location) }}">
            </div>

            <div class="form-group mb-3">
                <label for="event_image">Event Image</label>
                <input type="file" class="form-control" name="event_image" id="event_image">
                <small>Leave empty to keep the current image.</small>
                @if($event->event_image)
                    <div class="mt-2">
                        <strong>Current Image:</strong><br>
                        <img src="{{ $event->event_image }}" alt="{{ $event->name }}" class="img-fluid" style="max-width: 200px;">
                    </div>
                @endif
            </div>

            <div class="form-group mb-3">
                <label for="category_id">Category</label>
                <select class="form-control" name="category_id" id="category_id" required>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ $category->id == $event->category_id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

        </form>
    </div>
</div>
@endsection
