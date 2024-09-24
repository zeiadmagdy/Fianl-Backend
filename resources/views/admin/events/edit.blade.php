@extends('layouts.app')

@section('title', 'Edit Event')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Edit Event</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.events.update', $event->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label for="name">Event Name</label>
                        <input type="text" class="form-control" name="name" id="name" value="{{ old('name', $event->name) }}" required>
                    </div>

                    <div class="form-group">
                        <label for="date">Event Date</label>
                        <input type="datetime-local" class="form-control" name="date" id="date" value="{{ old('date', \Carbon\Carbon::parse($event->date)->format('Y-m-d\TH:i')) }}" required>
                    </div>

                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea class="form-control" name="description" id="description">{{ old('description', $event->description) }}</textarea>
                    </div>

                    <div class="form-group">
                        <label for="capacity">Capacity</label>
                        <input type="number" class="form-control" name="capacity" id="capacity" value="{{ old('capacity', $event->capacity) }}">
                    </div>

                    <div class="form-group">
                        <label for="location">Location</label>
                        <input type="text" class="form-control" name="location" id="location" value="{{ old('location', $event->location) }}">
                    </div>

                    <div class="form-group">
                        <label for="event_image">Event Image</label>
                        <input type="file" class="form-control" name="event_image" id="event_image">
                    </div>

                    <div class="form-group">
                        <label for="category_id">Category</label>
                        <select class="form-control" name="categories_id" id="categories_id" required>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ $category->id == $event->categories_id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <button type="submit" class="btn btn-success">Update Event</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
