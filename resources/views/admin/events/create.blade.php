@extends('layouts.app')

@section('title', 'Create Event')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Create Event</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.events.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="name">Event Name</label>
                        <input type="text" class="form-control" name="name" id="name" required>
                    </div>
                    <div class="form-group">
                        <label for="date">Event Date</label>
                        <input type="datetime-local" class="form-control" name="date" id="date" required>
                    </div>
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea class="form-control" name="description" id="description"></textarea>
                    </div>
                    <button type="submit" class="btn btn-success">Create Event</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
