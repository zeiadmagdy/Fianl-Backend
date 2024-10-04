@extends('layouts.app')

@section('title', 'Edit User')

@section('content')
<div class="card">
    <div class="card-header">
        <h1 class="animated-heading" style="text-align: center; font-weight: bold;">User Details</h1>
        <a href="{{ route('admin.users.index') }}" class="btn btn-primary float-right">Back to Users</a>
        <button type="button" class="btn btn-primary float-left" onclick="document.getElementById('updateForm').submit();">Update User</button>
    </div>

    <div class="card-body">
        <form id="updateForm" action="{{ route('admin.users.update', $user->id) }}" method="POST" enctype="multipart/form-data">
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
            <div class="mb-3">
                <label for="location" class="form-label">Location</label>
                <input type="text" class="form-control" id="location" name="location" value="{{ $user->location }}">
            </div>
            <div class="mb-3">
                <label for="gender" class="form-label">Gender</label>
                <select class="form-control" id="gender" name="gender">
                    <option value="male" {{ $user->gender == 'male' ? 'selected' : '' }}>Male</option>
                    <option value="female" {{ $user->gender == 'female' ? 'selected' : '' }}>Female</option>
                    <option value="other" {{ $user->gender == 'other' ? 'selected' : '' }}>Other</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="bio" class="form-label">Bio</label>
                <textarea class="form-control" id="bio" name="bio">{{ $user->bio }}</textarea>
            </div>
            <div class="mb-3">
                <label for="birth_date" class="form-label">Birth Date</label>
                <input type="date" class="form-control" id="birth_date" name="birth_date" value="{{ $user->birth_date }}">
            </div>
            <div class="mb-3">
                <label for="is_admin" class="form-label">Admin Role</label>
                <select class="form-control" id="is_admin" name="is_admin">
                    <option value="0" {{ $user->is_admin == 0 ? 'selected' : '' }}>No</option>
                    <option value="1" {{ $user->is_admin == 1 ? 'selected' : '' }}>Yes</option>
                </select>
            </div>
        </form>
    </div>
</div>
@endsection
