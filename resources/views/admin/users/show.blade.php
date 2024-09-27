@extends('layouts.app')

@section('title', 'User Details')

@section('content')
<h1>User Details</h1>

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

    <a href="{{ route('admin.users.index') }}" class="btn btn-primary mt-3">Back to Users</a>
@endsection
