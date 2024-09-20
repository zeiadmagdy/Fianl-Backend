@extends('layouts.app')

@section('title', 'User Details')

@section('content')
<h1>User Details</h1>

<p><strong>Name:</strong> {{ $user->name }}</p>
<p><strong>Email:</strong> {{ $user->email }}</p>

<a href="{{ route('admin.users.index') }}" class="btn btn-primary">Back to Users</a>
@endsection
