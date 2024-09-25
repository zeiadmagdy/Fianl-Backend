@extends('layouts.app')

@section('title', 'Bus Details')

@section('content')
<h1>{{ $bus->name }} (Bus Number: {{ $bus->bus_number }})</h1>
<p>Capacity: {{ $bus->capacity }}</p>
<p>Bus Line: {{ $bus->bus_line }}</p>

<a href="{{ route('admin.buses.points.create', $bus->id) }}" class="btn btn-primary mb-3">Add Point</a>

<h2>Points</h2>
<ul class="list-unstyled">
    @foreach ($bus->points->sortBy('arrived_time') as $point)
        <li class="mb-4">
            <div class="card border-primary" style="display: flex; flex-direction: row; padding: 1rem;">
                <div style="flex: 1; margin-right: 1rem;">
                    <!-- Embedding the Google Map iframe -->
                    @php
                        // Extract latitude and longitude from the location URL
                        $locationUrl = trim($point->location); // Clean up any whitespace

                        // Match the coordinates from the URL
                        if (preg_match('/@([0-9.-]+),([0-9.-]+)/', $locationUrl, $matches)) {
                            $latitude = $matches[1];
                            $longitude = $matches[2];
                        } else {
                            $latitude = '30.0587034'; // Default latitude if not found
                            $longitude = '31.243474';  // Default longitude if not found
                        }
                    @endphp

                    <iframe
                        width="400"
                        height="300"
                        frameborder="0"
                        scrolling="no"
                        marginheight="0"
                        marginwidth="0"
                        src="https://maps.google.com/maps?q={{ $latitude }},{{ $longitude }}&output=embed"
                        allowfullscreen>
                    </iframe>
                    <a href="{{ $locationUrl }}" target="_blank" class="btn btn-primary mt-2">Open in Google Maps</a>
                </div>

                <div style="flex: 1;">
                    <h5 class="card-title">Point Name:{{ $point->name }}</h5>
                    <p class="card-text">Description: {{ $point->description }}</p>
                    <p class="card-text">Arrived Time: {{ $point->arrived_time }}</p>

                    <a href="{{ route('admin.points.edit', $point) }}" class="btn btn-warning mt-2">Edit</a>
                    <form action="{{ route('admin.points.destroy', $point) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger mt-2">Delete</button>
                    </form>
                </div>
            </div>
        </li>
    @endforeach
    <a href="{{ route('admin.buses.index') }}" class="btn btn-secondary mt-3">Back to Buses</a>

</ul>
@endsection
