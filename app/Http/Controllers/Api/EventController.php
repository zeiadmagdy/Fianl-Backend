<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Carbon\Carbon;


class EventController extends Controller
{
    /**
     * Fetch all events formatted for calendar display.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */

     public function index(Request $request)
    {
        $events = Event::with('category')->get();

        // Return JSON response if requested from an API
        if ($request->expectsJson()) {
            return response()->json($events, 200);
        }
    }



    public function getCalendarEvents(Request $request): JsonResponse
    {
        // Retrieve start and end dates from the request
        $start = $request->query('start');
        $end = $request->query('end');
    
        // Fetch events based on start and end dates
        $events = Event::where('date', '>=', $start) // Assuming 'date' is the actual date of the event
                        ->where('date', '<=', $end)
                        ->get();
    
        // Check if there are no events and return an empty array
        if ($events->isEmpty()) {
            return response()->json([], 200);
        }
    
        // Format the events for FullCalendar
        $formattedEvents = $events->map(function ($event) {
            $start = Carbon::parse($event->date . ' ' . $event->start_time); // Combine date and start time
            $end = Carbon::parse($event->date . ' ' . $event->end_time); // Combine date and end time
    
            return [
                'id' => $event->id,
                'title' => $event->name,
                'start' => $start->format('Y-m-d\TH:i:s'), // Format to ISO 8601
                'end' => $end->format('Y-m-d\TH:i:s'),
                'description' => $event->description,
            ];
        });
    
        // Return the formatted events as JSON
        return response()->json($formattedEvents, 200);
    }
    
    
    
}
