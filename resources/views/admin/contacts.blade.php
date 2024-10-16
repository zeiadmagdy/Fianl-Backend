<!-- resources/views/admin/contacts.blade.php -->

@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Contact Form Submissions</h1>

    @if($contacts->isEmpty())
        <p>No contacts available.</p>
    @else
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Phone Number</th>
                    <th>Email</th>
                    <th>Subject</th>
                    <th>Message</th>
                    <th>Submitted At</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($contacts as $contact)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $contact->first_name }}</td>
                        <td>{{ $contact->last_name }}</td>
                        <td>{{ $contact->phone_number }}</td>
                        <td>{{ $contact->email }}</td>
                        <td>{{ $contact->subject }}</td>
                        <td>{{ $contact->message }}</td>
                        <td>{{ $contact->created_at->format('Y-m-d H:i:s') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>

<div class="d-flex justify-content-center mt-4">
        {{ $contacts->links('pagination::bootstrap-5') }} <!-- Use Bootstrap 5 pagination links -->
    </div>

@endsection
