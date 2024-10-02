@extends('layouts.app')

@section('title', 'Drivers')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h1 class="animated-heading" style="text-align: center;font-weight: bold;">Drivers Table</h1>
                <a href="{{ route('admin.drivers.create') }}" class="btn btn-primary float-right">Add Driver</a>
                <a href="{{ route('admin.dashboard') }}" class="btn btn-primary float-left">Back to Dashboard</a>
            </div>
            <div class="card-body">
                @if($drivers->isEmpty())
                    <p>No drivers available.</p>
                @else
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Phone Number</th>
                                <th>Profile Image</th>
                                <th>Bus Assigned</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($drivers as $driver)
                            <tr>
                                <td>{{ $driver->name }}</td>
                                <td>{{ $driver->phone_number }}</td>
                                <td>
                                    @if($driver->profile_image)
                                        <img src="{{ $driver->profile_image }}" alt="Profile Image" width="50">
                                    @else
                                        No Image
                                    @endif
                                </td>
                                <td>
                                    @if($driver->bus)
                                        <a href="{{ route('admin.buses.show', $driver->bus->id) }}">{{ $driver->bus->name }}</a>
                                    @else
                                        No bus assigned
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('admin.drivers.show', $driver->id) }}" class="btn btn-info">View</a>
                                    <a href="{{ route('admin.drivers.edit', $driver->id) }}" class="btn btn-warning">Edit</a>
                                    <form action="{{ route('admin.drivers.destroy', $driver->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" onclick="confirmDelete({{ $driver->id }})" class="btn btn-danger">Delete</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

<script>
    function confirmDelete(driverId) {
        const title = 'Delete Driver!';
        const text = 'Are you sure you want to delete this driver?';
        
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
                document.querySelector('form[action="{{ route('admin.drivers.destroy', '') }}' + driverId + '"]').submit();
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