@extends('layouts.app')

@section('title', 'Buses')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h1 class="animated-heading" style="text-align: center;font-weight: bold;">Buses Table</h1>
                <a href="{{ route('admin.buses.create') }}" class="btn btn-primary float-right">Add Bus</a>
                <a href="{{ route('admin.dashboard') }}" class="btn btn-primary float-left">Back to Dashboard</a>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
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
            </div>
        </div>
    </div>
</div>
@endsection

<script>
    function confirmDelete(busId) {
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
                document.getElementById('delete-form-' + busId).submit();
            }
        });
    }
</script>
<style>
    /* CSS Animation for smooth appearance */
    .animated-heading {
        animation: fadeInDown 1s ease-out;
        color: #333;
        font-family: 'Roboto', sans-serif;
        text-transform: uppercase;
        letter-spacing: 2px;
    }

    /* Keyframes for the fade-in-down animation */
    @keyframes fadeInDown {
        0% {
            opacity: 0;
            transform: translateY(-20px);
        }
        100% {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Add subtle shadow effect */
    .animated-heading {
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.1);
    }

    /* Additional styling for sortable table */
    th {
        position: relative;
    }

    th i {
        margin-left: 5px;
        opacity: 0.5;
    }

    th:hover i {
        opacity: 1;
    }
</style>