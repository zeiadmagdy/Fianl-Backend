@extends('layouts.app')

@section('title', 'Add User')

@section('content')
<h1>Add User</h1>

<form action="{{ route('admin.users.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="mb-3">
        <label for="name" class="form-label">Name</label>
        <input type="text" class="form-control" id="name" name="name" required>
    </div>
    <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" class="form-control" id="email" name="email" required>
    </div>
    <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <input type="password" class="form-control" id="password" name="password" required>
    </div>
    <div class="mb-3">
        <label for="password_confirmation" class="form-label">Confirm Password</label>
        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
    </div>
    <div class="mb-3">
        <label for="profile_image" class="form-label">Profile Image</label>
        <input type="file" class="form-control" id="profile_image" name="profile_image">
    </div>
    <div class="mb-3">
        <label for="location" class="form-label">Location</label>
        <input type="text" class="form-control" id="location" name="location">
    </div>
    <div class="mb-3">
        <label for="gender" class="form-label">Gender</label>
        <select class="form-control" id="gender" name="gender">
            <option value="male">Male</option>
            <option value="female">Female</option>
            <option value="other">Other</option>
        </select>
    </div>
    <div class="mb-3">
        <label for="bio" class="form-label">Bio</label>
        <textarea class="form-control" id="bio" name="bio"></textarea>
    </div>
    <div class="mb-3">
        <label for="birth_date" class="form-label">Birth Date</label>
        <input type="date" class="form-control" id="birth_date" name="birth_date">
    </div>
    <div class="mb-3">
        <label for="is_admin" class="form-label">Role</label>
        <select class="form-control" id="is_admin" name="is_admin">
            <option value="0">User</option>
            <option value="1">Admin</option>
        </select>
    </div>
    <button type="submit" class="btn btn-primary">Create User</button>
</form>
@endsection
