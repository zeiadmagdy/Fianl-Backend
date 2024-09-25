@extends('layouts.app')

@section('title', 'Events')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Events</h3>
                <a href="{{ route('admin.events.create') }}" class="btn btn-primary float-right">Add Event</a>
            </div>
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Date</th>
                            <th>Actions</th>
                            <th>Category</th>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach($events as $event)
                            <tr>
                                <td>{{ $event->id }}</td>
                                <td>{{ $event->name }}</td>
                                <td>{{ $event->date }}</td>
                                <td>{{ $event->category->name }}</td>

                                <td>
                                    <a href="{{ route('admin.events.show', $event->id) }}" class="btn btn-info">View</a>
                                    <a href="{{ route('admin.events.edit', $event) }}" class="btn btn-warning">Edit</a>
                                    <form action="{{ route('admin.events.destroy', $event) }}" method="POST"
                                        style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection