@extends('layouts.app')

@section('title', 'Admin Calendar')

@section('content')
<script>
    // Define the base URL for events
    const baseUrl = '{{ url('/admin/events') }}';
</script>

<div class="row">
    <div class="col-lg-11">
        <div id="calendar"></div> <!-- This is where FullCalendar will render -->
    </div>
</div>

<!-- Modal for event details -->
<div class="modal fade" id="eventModal" tabindex="-1" aria-labelledby="eventModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="eventModalLabel">Event Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p id="modalEventTitle"></p>
                <p id="modalEventDescription"></p>
                <p id="modalEventStart"></p>
            </div>
            <div class="modal-footer">
                <a href="#" id="eventDetailsLink" class="btn btn-primary">Event Details</a>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endsection
