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
                <form action="{{ route('admin.events.update', $event) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="name">Event Name</label>
                        <input type="text" class="form-control" name="name" id="name" value="{{ $event->name }}"
                            required>
                    </div>
                    <div class="form-group">
                        <label for="date">Event Date</label>
                        <input type="datetime-local" class="form-control" name="date" id="date"
                            value="{{ \Carbon\Carbon::parse($event->date)->format('Y-m-d\TH:i') }}" required>
                    </div>
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea class="form-control" name="description"
                            id="description">{{ $event->description }}</textarea>
                    </div>
                    <button type="submit" class="btn btn-success">Update Event</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection