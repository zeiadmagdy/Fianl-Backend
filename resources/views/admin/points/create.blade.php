@extends('layouts.app')

@section('title', 'Add Point to Bus: ' . $bus->name)

@section('content')
<div class="container">
    <h1>Add Point to Bus: {{ $bus->name }}</h1>

    <form action="{{ route('admin.buses.points.store', $bus->id) }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Point Name</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>

        <!-- Search bar for searching location -->
        <div class="mb-3">
            <label for="location-search" class="form-label">Search for Location</label>
            <input type="text" class="form-control" id="location-search" placeholder="Search for a location">
            <button type="button" id="search-btn" class="btn btn-primary mt-2">Search</button>
        </div>

        <!-- Leaflet map for point selection -->
        <div class="mb-3">
            <label for="map" class="form-label">Select Point on Map</label>
            <div id="map" style="height: 400px; width: 100%;"></div>
        </div>

        <!-- Hidden inputs to store selected coordinates -->
        <input type="hidden" id="latitude" name="latitude" required>
        <input type="hidden" id="longitude" name="longitude" required>

        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control" id="description" name="description"></textarea>
        </div>

        <div class="mb-3">
            <label for="arrived_time" class="form-label">Arrived Time (HH:MM)</label>
            <input type="time" class="form-control" id="arrived_time" name="arrived_time" required>
        </div>

        <button type="submit" class="btn btn-primary">Create Point</button>
    </form>

    <a href="{{ route('admin.buses.show', $bus->id) }}" class="btn btn-secondary mt-3">Back to Bus</a>
</div>

<!-- Leaflet.js CSS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />

<!-- Leaflet.js JS -->
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

<!-- JavaScript for the map and search functionality -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Initialize the map with a default view
        var map = L.map('map').setView([51.505, -0.09], 13);

        // Add OpenStreetMap tiles
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        // Initialize the marker
        var marker;

        // Function to place a marker on the map
        function placeMarker(lat, lng) {
            if (marker) {
                marker.setLatLng([lat, lng]);
            } else {
                marker = L.marker([lat, lng]).addTo(map);
            }
            map.setView([lat, lng], 13);

            // Update hidden input values for latitude and longitude
            document.getElementById('latitude').value = lat;
            document.getElementById('longitude').value = lng;
        }

        // Event listener to select a point on the map
        map.on('click', function (e) {
            var lat = e.latlng.lat;
            var lng = e.latlng.lng;
            placeMarker(lat, lng);
        });

        // Function to perform search using Nominatim API
        document.getElementById('search-btn').addEventListener('click', function () {
            var query = document.getElementById('location-search').value;
            if (!query) {
                alert('Please enter a location to search.');
                return;
            }

            // Nominatim API URL
            var apiURL = `https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(query)}`;

            // Fetch location data from Nominatim API
            fetch(apiURL)
                .then(response => response.json())
                .then(data => {
                    if (data.length > 0) {
                        var lat = data[0].lat;
                        var lon = data[0].lon;
                        placeMarker(lat, lon);  // Place marker at the first search result
                    } else {
                        alert('Location not found.');
                    }
                })
                .catch(error => {
                    console.error('Error fetching location data:', error);
                    alert('An error occurred while searching for the location.');
                });
        });
    });
</script>
@endsection
