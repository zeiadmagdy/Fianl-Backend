@extends('layouts.app')

@section('title', 'Admin Calendar')

@section('content')
<script>
    // Define the base URL for events
    const baseUrl = '{{ url('/admin/events') }}';
</script>

<div class="row mb-3">
    <div class="col-lg-3">
        <select id="categoryFilter" class="form-control">
            <option value="0">All Categories</option>
            @foreach($categories as $category)
                <option value="{{ $category->id }}">{{ $category->name }}</option>
            @endforeach
        </select>
    </div>
</div>

<div class="row">
    <div class="col-lg-11">
        <div id="calendar"></div>
    </div>
</div>

<!-- Modal for event details -->
<div class="modal fade" id="eventModal" tabindex="-1" aria-labelledby="eventModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalEventTitle"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p id="modalEventDescription"></p>
                <p id="modalEventStart"></p>
                <a id="eventDetailsLink" class="btn btn-primary" href="#">View Event Details</a>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
    <script src="{{ asset('js/app.js') }}"></script>
@endsection
