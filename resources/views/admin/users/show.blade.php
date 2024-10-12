@extends('layouts.app')

@section('title', 'User Details')

@section('content')

<!-- Header Section -->
<div class="card-header">
    <h1 class="animated-heading" style="text-align: center; font-weight: bold;">User Details</h1>
    <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-warning float-right">Edit User</a>
    <a href="{{ route('admin.users.index') }}" class="btn btn-primary float-left">Back to Users</a>
</div>

<!-- User Information Cards -->
<div class="container mt-4">
    <div class="row">
        <!-- Card for Profile Image -->
        <div class="col-md-6">
            <div class="card mb-3">
                <div class="card-body text-center">
                    <h5 class="card-title" style="font-weight: bold">Profile Image</h5>
                    @if($user->profile_image)
                        <img src="{{ $user->profile_image }}" alt="Profile Image" class="img-fluid rounded" width="305">
                    @else
                        <p>No profile image available</p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Card for Personal Information -->
        <div class="col-md-6">
            <div class="card mb-3">
                <div class="card-body">
                    <p style="font-weight: bold; text-align: center ">Personal Information</p><br>
                    <p><strong>Name:</strong> {{ $user->name }}</p>
                    <p><strong>Email:</strong> {{ $user->email }}</p>
                    <p><strong>Location:</strong> {{ $user->location }}</p>
                    <p><strong>Gender:</strong> {{ ucfirst($user->gender) }}</p>
                    <p><strong>Bio:</strong> {{ $user->bio }}</p>
                    <p><strong>Birth Date:</strong> {{ $user->birth_date }}</p>
                    <p><strong>Admin:</strong> {{ $user->is_admin ? 'Yes' : 'No' }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Card for Attended Events -->
    <div class="row">
        <div class="col-12">
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title">Attended Events</h5>
                    @if($user->attendedEvents->isNotEmpty())
                        <ul class="list-group">
                            @foreach($user->attendedEvents as $event)
                                <li class="list-group-item">
                                    <a href="{{ route('admin.events.show', $event->id) }}" class="text-decoration-none">
                                        {{ $event->name }} on {{ $event->date }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p>No attended events available.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

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

    /* Optional: Add styles for card separation */
    .card {
        border: 1px solid #e0e0e0; /* Default border */
        transition: box-shadow 0.3s; /* Transition for hover effect */
    }

    .card:hover {
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1); /* Hover shadow effect */
    }
</style>
