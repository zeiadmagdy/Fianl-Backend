@extends('layouts.app')

@section('content')
<div class="container">
<!-- Additional bus information -->
<h1>Bus Details</h1>

<ul>
    <li><strong>Bus Name: </strong>{{ $bus->name }}</li>
    <li><strong>Bus Number: </strong>{{ $bus->bus_number }}</li>
    <li><strong>Bus Capacity: </strong>{{ $bus->capacity }}</li>
    <li><strong>Route: </strong>{{ $bus->route }}</li>
</ul>
<a href="{{ route('admin.buses.points.create', $bus->id) }}" class="btn btn-primary mb-3">Add Point</a>
<a href="{{ route('admin.buses.index') }}" class="btn btn-primary float-right">Back to Buses</a>
<!-- New PDF Download Button -->
<a href="{{ route('admin.buses.downloadPdf', $bus->id) }}" class="btn btn-secondary mb-3">Download PDF</a>

    <!-- Card for showing bus route map -->
    <div class="card mb-3">
        <div class="card-body">
            <h4 class="card-title">Bus Route</h4>
            <div id="map" style="height: 400px; width: 100%;"></div>
        </div>
    </div>

    <!-- Driver Information -->
<h2>Driver Information</h2>
@if ($bus->driver) <!-- Checking if the bus has a driver assigned -->
    <div class="card border-primary mb-3" style="display: flex; flex-direction: row; padding: 1rem;">
        <!-- Driver Information (left side) -->
        <div style="flex: 1; padding-right: 1rem;">
            <p><strong>Name:</strong> {{ $bus->driver->name }}</p>
            <p><strong>Phone:</strong> {{ $bus->driver->phone_number }}</p>
        </div>
        <!-- Driver Image (right side) -->
        <div style="flex: 0 0 250px;">
            @if($bus->driver->profile_image)
                <img src="{{$bus->driver->profile_image }}" alt="Profile Image" width="100" class="img-thumbnail">
            @else
                <p>No Image Available</p>
            @endif
        </div>
    </div>
@else
    <p>No driver assigned to this bus yet.</p>
@endif

<!-- Points Information -->
    <h2>Points</h2>
    <ul class="list-unstyled">
        @foreach ($bus->points->sortBy('arrived_time') as $point)
            <li class="mb-4">
                <div class="card border-primary" style="display: flex; flex-direction: row; padding: 1rem;">
                    <div style="flex: 1; margin-right: 1rem;">
                        <!-- Embedding the Google Map iframe using latitude and longitude -->
                        <iframe width="400" height="300" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"
                            src="https://maps.google.com/maps?q={{ $point->latitude }},{{ $point->longitude }}&output=embed" allowfullscreen>
                        </iframe>
                        <a href="https://maps.google.com/?q={{ $point->latitude }},{{ $point->longitude }}" target="_blank" class="btn btn-primary mt-2">Open in Google Maps</a>
                    </div>
    
                    <div style="flex: 1;">
                        <h5 class="card-title">Point Name: {{ $point->name }}</h5>
                        <p class="card-text">Description: {{ $point->description }}</p>
                        <p class="card-text">Arrived Time: {{ $point->arrived_time }}</p>
    
                        <a href="{{ route('admin.points.edit', $point) }}" class="btn btn-warning mt-2">Edit</a>
                        <form id="delete-form-{{ $point->id }}" action="{{ route('admin.points.destroy', $point->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="button" onclick="confirmDelete({{ $point->id }})" class="btn btn-danger mt-2">Delete</button>
                        </form>
                    </div>
                </div>
            </li>
        @endforeach
    </ul>
</div>

<!-- Leaflet.js CSS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />

<!-- Leaflet.js JS -->
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

<!-- JavaScript to display bus points on map with a line -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Initialize the map
        var map = L.map('map').setView([51.505, -0.09], 13);

        // Add OpenStreetMap tiles
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        // Fetch the bus points from the backend
        fetch('/api/bus/{{ $bus->id }}/points')
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();  // Parse response as JSON
            })
            .then(data => {
                if (data.length > 0) {
                    var latlngs = [];
                    
                    // Loop through points, place markers, and store coordinates
                    data.forEach(point => {
                        var lat = point.latitude;
                        var lng = point.longitude;

                        // Add each point to the map with a marker
                        L.marker([lat, lng]).addTo(map)
                            .bindPopup(`<b>${point.name}</b><br>Time: ${point.arrived_time}`)
                            .openPopup();

                        // Add lat/lng to latlngs array for polyline
                        latlngs.push([lat, lng]);
                    });

                    // Draw the polyline connecting the points
                    var polyline = L.polyline(latlngs, {color: 'blue'}).addTo(map);

                    // Adjust the view to fit the polyline
                    map.fitBounds(polyline.getBounds());
                } else {
                    alert('No points found for this bus.');
                }
            })
            .catch(error => {
                console.error('Error fetching bus points:', error);
                alert('An error occurred while loading the map.');
            });
    });
</script>
@endsection
