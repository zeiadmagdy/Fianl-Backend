@extends('layouts.app') 

@section('content')
<div class="container">
    <h1>Point Details</h1>
    
    <div class="card">
        <div class="card-header">
            <h2>{{ $point->name }}</h2>
        </div>
        <div class="card-body">
            <p><strong>Bus ID:</strong> {{ $point->bus_id }}</p>
            <p><strong>Latitude:</strong> {{ $point->latitude }}</p>
            <p><strong>Longitude:</strong> {{ $point->longitude }}</p>
            <p><strong>Arrived Time:</strong> {{ $point->arrived_time }}</p>
            <p><strong>Description:</strong> {{ $point->description ?? 'N/A' }}</p>
            <a href="{{ route('admin.buses.show', $point->bus_id) }}" class="btn btn-primary">Back to Bus</a>
            <a href="{{ route('admin.points.edit', $point->id) }}" class="btn btn-warning">Edit</a>
            <form action="{{ route('admin.points.destroy', $point->id) }}" method="POST" style="display: inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">Delete</button>
            </form>
        </div>
    </div>

    <h2 class="mt-4">Related Points for Bus ID: {{ $point->bus_id }}</h2>
    
    <ul class="list-group mt-3">
        @foreach($points as $relatedPoint)
            <li class="list-group-item">
                <strong>{{ $relatedPoint->name }}</strong> - 
                Latitude: {{ $relatedPoint->latitude }}, 
                Longitude: {{ $relatedPoint->longitude }}, 
                Arrived Time: {{ $relatedPoint->arrived_time }}
                <a href="{{ route('admin.points.show', $relatedPoint->id) }}" class="btn btn-link">View</a>
            </li>
        @endforeach
    </ul>
</div>
@endsection
