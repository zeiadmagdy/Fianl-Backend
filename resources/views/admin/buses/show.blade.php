@extends('layouts.app')

@section('title', 'Bus Details')

@section('content')
<h1>{{ $bus->name }} (Bus Number: {{ $bus->bus_number }})</h1>
<p>Capacity: {{ $bus->capacity }}</p>
<p>Bus Line: {{ $bus->bus_line }}</p>

<a href="{{ route('admin.buses.points.create', $bus->id) }}" class="btn btn-primary mb-3">Add Point</a>

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

<a href="{{ route('admin.buses.index') }}" class="btn btn-secondary mb-5">Back to Buses</a>
@endsection
<script>
    function confirmDelete(pointId) {
        Swal.fire({
            title: 'Delete Category!',
            text: 'Are you sure you want to delete?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'No, cancel!'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + pointId).submit();
            } else {
                Swal.fire('Cancelled', 'Category deletion has been cancelled.', 'error');
            }
        });
    }
</script>
