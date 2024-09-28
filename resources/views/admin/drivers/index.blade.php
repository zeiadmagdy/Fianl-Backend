@extends('layouts.app')

@section('title', 'Drivers')

@section('content')
<h1>Drivers</h1>

<a href="{{ route('admin.drivers.create') }}" class="btn btn-primary mb-3">Add Driver</a>
<a href="{{ route('admin.dashboard') }}" class="btn btn-primary mb-3">Back to Dashboard</a>

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
                </td>                <td>
                    <a href="{{ route('admin.drivers.show', $driver->id) }}" class="btn btn-info">View</a>
                    <a href="{{ route('admin.drivers.edit', $driver->id) }}" class="btn btn-warning">Edit</a>
                    <form action="{{ route('admin.drivers.destroy', $driver->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
@endif
@endsection
