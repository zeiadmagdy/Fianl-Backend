@extends('layouts.app')

@section('title', 'Users')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card"> 
            <div class="card-header">
                    <h1 class="animated-heading" style="text-align: center;font-weight: bold;">Users Table</h1>
                    <a href="{{ route('admin.users.create') }}" class="btn btn-primary float-right">Add User</a>
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-primary float-left">Back to Dashboard</a>
            </div>
            <div class="card-body">

<form action="{{ route('admin.users.index') }}" method="GET" class="mb-3">
    <div class="form-row">
        <div class="col">
            <input type="text" name="name" class="form-control" placeholder="Search by Name" value="{{ request('name') }}">
        </div>
        <div class="col">
            <input type="text" name="email" class="form-control" placeholder="Search by Email" value="{{ request('email') }}">
        </div>
        <div class="col">
            <select name="role" class="form-control">
                <option value="">Filter by Role</option>
                <option value="admin" {{ request('role') === 'admin' ? 'selected' : '' }}>Admin</option>
                <option value="user" {{ request('role') === 'user' ? 'selected' : '' }}>User</option>
            </select>
        </div>
        <div class="col">
            <button type="submit" class="btn btn-primary">Search</button>
        </div>
    </div>
</form>
<!-- Table to list users -->
<table class="table table-bordered">
    <thead>
        <tr>
            <th>ID</th>
            <th>Profile Image</th>
            <th onclick="sortTable(2)" style="cursor: pointer;">
                Name <i class="fas fa-sort"></i>
            </th>
            <th onclick="sortTable(3)" style="cursor: pointer;">
                Email <i class="fas fa-sort"></i>
            </th>
            <th>Attended Events</th>
            <th onclick="sortTable(5)" style="cursor: pointer;">
                Role <i class="fas fa-sort"></i>
            </th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody id="usersTable">
        @foreach ($users as $user)
            <tr>
                <td>{{ $user->id }}</td>
                <td>
                    @if($user->profile_image)
                        <img src="{{ $user->profile_image }}" alt="Profile Image" width="50">
                    @else
                        No Image
                    @endif
                </td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td> <!-- Fetch and display attended events -->
                    @if($user->attendedEvents->isNotEmpty())
                        <ul>
                            @foreach($user->attendedEvents as $event)
                            <li><a href="{{ route('admin.events.show', $event->id) }}">
                                {{ $event->name }}
                            </a><br>{{ $event->date }}</li> <!-- Adjust to show desired event fields -->
                            @endforeach
                        </ul>
                    @else
                        No Events Attended
                    @endif
                </td>
                <td>{{ $user->is_admin ? 'Admin' : 'User' }}</td>
                <td>
                    <a href="{{ route('admin.users.show', $user->id) }}" class="btn btn-info">View</a>
                    <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-warning">Edit</a>
                    <form id="delete-form-{{ $user->id }}" action="{{ route('admin.users.destroy', $user) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="button" onclick="confirmDelete({{ $user->id }})" class="btn btn-danger">Delete</button>
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

<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script> <!-- Font Awesome for icons -->
<script>
    function confirmDelete(userId) {
        const title = 'Delete User!';
        const text = 'Are you sure you want to delete?';
        
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
                // If confirmed, submit the form
                document.getElementById('delete-form-' + userId).submit();
            } else {
                // Optionally show a message for cancellation
                Swal.fire('Cancelled', 'User deletion has been cancelled.', 'error');
            }
        });
    }

    // JavaScript function to sort the table
    function sortTable(columnIndex) {
        const table = document.getElementById("usersTable");
        const rows = Array.from(table.rows);
        let isAscending = table.getAttribute("data-sort-order") === "asc";

        // Toggle sort order
        table.setAttribute("data-sort-order", isAscending ? "desc" : "asc");

        // Sort the rows based on the column
        rows.sort((a, b) => {
            const cellA = a.cells[columnIndex].innerText.toLowerCase();
            const cellB = b.cells[columnIndex].innerText.toLowerCase();

            if (cellA < cellB) return isAscending ? -1 : 1;
            if (cellA > cellB) return isAscending ? 1 : -1;
            return 0;
        });

        // Remove existing rows
        table.innerHTML = '';

        // Append sorted rows
        rows.forEach(row => table.appendChild(row));
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
