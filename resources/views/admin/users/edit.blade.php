@extends('layouts.app')

@section('title', 'Edit User')

@section('content')
<h1>Edit User</h1>

<form action="{{ route('admin.users.update', $user) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="mb-3">
        <label for="name" class="form-label">Name</label>
        <input type="text" class="form-control" id="name" name="name" value="{{ $user->name }}" required>
    </div>
    <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" class="form-control" id="email" name="email" value="{{ $user->email }}" required>
    </div>
    <div class="mb-3">
        <label for="password" class="form-label">Password (leave blank to keep current)</label>
        <input type="password" class="form-control" id="password" name="password">
    </div>
    <div class="mb-3">
        <label for="profile_image" class="form-label">Profile Image</label>
        <input type="file" class="form-control" id="profile_image" name="profile_image">
    </div>

    @if($user->profile_image)
        <img src="{{ $user->profile_image }}" alt="Profile Image" width="100">
    @endif

    <button type="submit" class="btn btn-primary">Update User</button>
</form>
@endsection
