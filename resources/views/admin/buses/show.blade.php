@extends('layouts.app')

@section('title', 'Bus Details')

@section('content')
    <h1>{{ $bus->name }} (Bus Number: {{ $bus->bus_number }})</h1>
    <p>Capacity: {{ $bus->capacity }}</p>
    <p>Bus Line: {{ $bus->bus_line }}</p>

    <a href="{{ route('admin.points.create', $bus) }}" class="btn btn-primary mb-3">Add Point</a>

    <h2>Points</h2>
    <ul>
        @foreach ($bus->points as $point)
            <li>
                {{ $point->name }} - {{ $point->location }} (Arrived: {{ $point->arrived_time }})
                <a href="{{ route('admin.points.edit', $point) }}" class="btn btn-warning">Edit</a>
                <form action="{{ route('admin.points.destroy', $point) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </li>
        @endforeach
    </ul>
@endsection
