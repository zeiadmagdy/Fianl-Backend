@extends('layouts.app')

@section('title', 'Buses')

@section('content')
    <a href="{{ route('admin.buses.create') }}" class="btn btn-primary mb-3">Add Bus</a>

    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Bus Number</th>
                <th>Capacity</th>
                <th>Bus Line</th>
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
                        <a href="{{ route('admin.buses.show', $bus) }}" class="btn btn-info">View</a>
                        <a href="{{ route('admin.buses.edit', $bus) }}" class="btn btn-warning">Edit</a>
                        <form action="{{ route('admin.buses.destroy', $bus) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
