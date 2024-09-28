@extends('layouts.app')

@section('title', 'Buses')

@section('content')
<a href="{{ route('admin.buses.create') }}" class="btn btn-primary mb-3">Add Bus</a>
<a href="{{ route('admin.dashboard') }}" class="btn btn-primary mb-3">Back to Dashboard</a>

<table class="table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Bus Name</th>
            <th>Bus Number</th>
            <th>Capacity</th>
            <th>Bus Line</th>
            <th>Driver</th>
            <th>Points</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($buses as $bus)
            <tr>
                <td>{{ $bus->id }}</td>
                <td>{{ $bus->name }}</td>
                <td>{{ $bus->bus_number }}</td>
                <td>{{ $bus->capacity }}</td>
                <td>{{ $bus->bus_line }}</td>
                <td>
                    @if ($bus->driver)
                        <a href="{{ route('admin.drivers.show', $bus->driver->id) }}">{{ $bus->driver->name }}</a>
                    @else
                        No Driver Assigned
                    @endif
                </td>
                <td>
                    <ul>
                        @foreach ($bus->points->sortBy('arrived_time') as $point)
                            <li>{{ $point->name }} - Arrived at: {{ $point->arrived_time }}</li>
                        @endforeach
                    </ul>
                    <a href="{{ route('admin.buses.points.create', $bus->id) }}" class="btn btn-primary btn-sm">Add Point</a>
                </td>
                <td>
                    <a href="{{ route('admin.buses.show', $bus) }}" class="btn btn-info">View</a>
                    <a href="{{ route('admin.buses.edit', $bus) }}" class="btn btn-warning">Edit</a>
                    <form id="delete-form-{{ $bus->id }}" action="{{ route('admin.buses.destroy', $bus) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="button" onclick="confirmDelete({{ $bus->id }})" class="btn btn-danger">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

@endsection

<script>
function confirmDelete(busId) {
    console.log("Attempting to delete bus with ID: " + busId);
    const title = 'Delete Bus!';
    const text = 'Are you sure you want to delete this Bus?';

    Swal.fire({
        title: title,
        text: text,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'No, cancel!'
    }).then((result) => {
        if (result.isConfirmed) {
            console.log("Deletion confirmed for bus ID: " + busId);
            document.getElementById('delete-form-' + busId).submit();
        } else {
            console.log("Deletion cancelled for bus ID: " + busId);
            Swal.fire('Cancelled', 'Bus deletion has been cancelled.', 'error');
        }
    });
}
</script>
