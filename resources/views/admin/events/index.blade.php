@extends('layouts.app')

@section('title', 'Events')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h1 class="animated-heading" style="text-align: center;  font-weight: bold;">Event Table</h1>
                <a href="{{ route('admin.events.create') }}" class="btn btn-primary float-right">Add Event</a>
                <a href="{{ route('admin.dashboard') }}" class="btn btn-primary  float-left">Back to Dashboard</a>
            </div>

            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <!-- Filter and Search Section -->
                <form action="{{ route('admin.events.index') }}" method="GET" class="mb-3">
                    <div class="row">
                        <div class="col-md-4">
                            <input type="text" name="search_name" class="form-control" placeholder="Search by event name" value="{{ request('search_name') }}">
                        </div>
                        <div class="col-md-3">
                            <input type="date" name="search_date" class="form-control" value="{{ request('search_date') }}">
                        </div>
                        <div class="col-md-3">
                            <select name="category_filter" class="form-control">
                                <option value="">All Categories</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ request('category_filter') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-primary">Filter</button>
                        </div>
                    </div>
                </form>

                <!-- Events Table -->
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th onclick="sortTable(1)" style="cursor: pointer;">
                                Name <i class="fas fa-sort"></i>
                            </th>
                            <th onclick="sortTable(2)" style="cursor: pointer;">
                                Date <i class="fas fa-sort"></i>
                            </th>                            
                            <th>Category</th>
                            <th onclick="sortTable(3)" style="cursor: pointer;">
                                Capacity <i class="fas fa-sort"></i>
                            </th>
                            <th>Attendees</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="eventTableBody">
                        @foreach($events as $event)
                            <tr>
                                <td>{{ $event->id }}</td>
                                <td>{{ $event->name }}</td>
                                <td>{{ $event->date }}</td>
                                <td>
                                    <a href="{{ route('admin.categories.show', $event->category->id) }}">
                                        {{ $event->category->name }}
                                    </a>
                                </td>
                                <td>{{ $event->capacity }}</td>
                                <td>
                                    <a href="javascript:void(0)" onclick="showAttendeesModal({{ $event->id }})">
                                        {{ $event->attendees_count }} attendees
                                    </a>
                                </td>
                                <td>
                                    <a href="{{ route('admin.events.show', $event->id) }}" class="btn btn-info">View</a>
                                    <a href="{{ route('admin.events.edit', $event->id) }}" class="btn btn-warning">Edit</a>
                                    <form id="delete-form-{{ $event->id }}" action="{{ route('admin.events.destroy', $event->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" onclick="confirmDelete({{ $event->id }})" class="btn btn-danger">Delete</button>
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

<!-- Modal for Attendees List -->
<div class="modal fade" id="attendeesModal" tabindex="-1" aria-labelledby="attendeesModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="attendeesModalLabel">Attendees List</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="attendeesList">
                <!-- Attendees will be loaded here via AJAX -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

@endsection

<script>
    function showAttendeesModal(eventId) {
        // Fetch the attendees for the event via AJAX
        fetch(`/admin/events/${eventId}/attendees`)
            .then(response => response.json())
            .then(data => {
                let attendeesHtml;
                if (data.attendees.length === 0) {
                    attendeesHtml = '<p>No Attendees yet!</p>'; // Message when there are no attendees
                } else {
                    attendeesHtml = '<ul>';
                    data.attendees.forEach(user => {
                        attendeesHtml += `<li><a href="/admin/users/${user.id}">${user.name}</a></li>`;
                    });
                    attendeesHtml += '</ul>';
                }

                // Set the content in the modal
                document.getElementById('attendeesList').innerHTML = attendeesHtml;

                // Show the modal
                $('#attendeesModal').modal('show');
            })
            .catch(error => console.error('Error fetching attendees:', error)); // Optional: Handle any errors
    }

    function confirmDelete(eventId) {
        Swal.fire({
            title: 'Delete event!',
            text: 'Are you sure you want to delete this event?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'No, cancel!',
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + eventId).submit();
            }
        });
    }

    function sortTable(columnIndex) {
        const table = document.getElementById('eventTableBody');
        const rows = Array.from(table.getElementsByTagName('tr'));

        const sortedRows = rows.sort((a, b) => {
            const aText = a.getElementsByTagName('td')[columnIndex].innerText;
            const bText = b.getElementsByTagName('td')[columnIndex].innerText;

            return aText.localeCompare(bText);
        });

        // Clear the table and append the sorted rows
        while (table.firstChild) {
            table.removeChild(table.firstChild);
        }
        sortedRows.forEach(row => table.appendChild(row));
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
