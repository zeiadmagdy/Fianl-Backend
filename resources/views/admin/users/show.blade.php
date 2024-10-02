@extends('layouts.app')

@section('title', 'User Details')

@section('content')
<h1 class="mb-3 animated-heading" style="text-align: center; display: inline-block; font-weight: bold;">Users DEtails</h1> <br>

<a href="{{ route('admin.users.index') }}" class="btn btn-primary mb-3">Back to Users</a><br>
@if($user->profile_image)
    <img src="{{ $user->profile_image }}" alt="Profile Image" width="150">
@else
    <p>No profile image available</p>
@endif

<p><strong>Name:</strong> {{ $user->name }}</p>
<p><strong>Email:</strong> {{ $user->email }}</p>
<p><strong>Location:</strong> {{ $user->location }}</p>
<p><strong>Gender:</strong> {{ ucfirst($user->gender) }}</p>
<p><strong>Bio:</strong> {{ $user->bio }}</p>
<p><strong>Birth Date:</strong> {{ $user->birth_date }}</p>
<p><strong>Admin:</strong> {{ $user->is_admin ? 'Yes' : 'No' }}</p>

    
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
  </style>