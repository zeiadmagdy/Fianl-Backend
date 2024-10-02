@extends('layouts.app')

@section('title', 'Edit Point: ' . $point->name)

@section('content')
<div class="container">
    <h1>Edit Point: {{ $point->name }}</h1>

    <form action="{{ route('admin.points.update', $point->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="name" class="form-label">Point Name</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ $point->name }}" required>
        </div>

        <!-- Leaflet map for point selection -->
        <div class="mb-3">
            <label for="map" class="form-label">Select Point on Map</label>
            <div id="map" style="height: 400px; width: 100%;"></div>
        </div>

        <!-- Hidden inputs to store selected coordinates -->
        <input type="hidden" id="latitude" name="latitude" value="{{ $point->latitude }}" required>
        <input type="hidden" id="longitude" name="longitude" value="{{ $point->longitude }}" required>

        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control" id="description" name="description">{{ $point->description }}</textarea>
        </div>

        <div class="mb-3">
            <label for="arrived_time" class="form-label">Arrived Time (HH:MM)</label>
            <input type="time" class="form-control" id="arrived_time" name="arrived_time" 
                   value="{{ \Carbon\Carbon::createFromFormat('H:i:s', $point->arrived_time)->format('H:i') }}" required>
        </div>

        <button type="submit" class="btn btn-primary mb-5">Update Point</button>
        <a href="{{ route('admin.buses.index') }}" class="btn btn-secondary mb-5">Back to Buses</a>

    </form>

</div>

<!-- Leaflet.js CSS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />

<!-- Leaflet.js JS -->
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Initialize the map with the current point coordinates
        var map = L.map('map').setView([{{ $point->latitude }}, {{ $point->longitude }}], 13);

        // Add OpenStreetMap tiles
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        // Place marker at the current point coordinates
        var marker = L.marker([{{ $point->latitude }}, {{ $point->longitude }}]).addTo(map);

        // Event listener to select a new point on the map
        map.on('click', function (e) {
            var lat = e.latlng.lat;
            var lng = e.latlng.lng;
            marker.setLatLng([lat, lng]);

            // Update hidden input values for latitude and longitude
            document.getElementById('latitude').value = lat;
            document.getElementById('longitude').value = lng;
        });
    });
</script>
@endsection
