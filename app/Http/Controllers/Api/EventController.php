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
    public function index(Request $request): JsonResponse
    {
        // Fetch all events with category relationships
        $events = Event::with('category')->get();

        // Return JSON response if requested from an API
        return response()->json($this->formatEvents($events), 200);
    }

    /**
     * Fetch events based on category and date range.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getFilteredEvents(Request $request): JsonResponse
    {
        // Get the query parameters
        $start = $request->query('start');
        $end = $request->query('end');
        $categoryId = $request->query('category_id');

        // Query the events based on date range and category
        $query = Event::with('category')
            ->whereBetween('date', [$start, $end]);

        if ($categoryId) {
            $query->where('category_id', $categoryId);
        }

        $events = $query->get();

        return response()->json($this->formatEvents($events), 200);
    }

    /**
     * Handle event search, filter, and sorting for API.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAllEventsWithSearchAndFilter(Request $request): JsonResponse
    {
        \Log::info('Search request received', $request->all()); // Log the request parameters

        $query = Event::with('category'); // Eager load the category relationship

        // Search filters
        if ($request->search_name) {
            $query->where('name', 'like', '%' . $request->search_name . '%');
        }

        if ($request->search_date) {
            $query->whereDate('date', $request->search_date);
        }

        if ($request->category_filter) {
            $query->where('category_id', $request->category_filter);
        }

        // Sorting logic
        if ($request->has('sort_by')) {
            $query->orderBy($request->sort_by, 'asc');
        }

        // Execute query and get results
        $events = $query->get();

        // Return the complete event attributes including the related category
        return response()->json($this->formatCompleteEvents($events), 200);
    }

    /**
     * Format events for FullCalendar.
     *
     * @param $events
     * @return array
     */
    protected function formatEvents($events): array
    {
        return $events->map(function ($event) {
            $start = Carbon::parse($event->date . ' ' . $event->start_time);
            $end = Carbon::parse($event->date . ' ' . $event->end_time);

            return [
                'id' => $event->id,
                'title' => $event->name,
                'start' => $start->format('Y-m-d\TH:i:s'), // Format to ISO 8601
                'end' => $end->format('Y-m-d\TH:i:s'),
                'description' => $event->description,
            ];
        })->toArray();
    }

    /**
     * Format events to include all attributes.
     *
     * @param $events
     * @return array
     */
    protected function formatCompleteEvents($events): array
    {
        return $events->map(function ($event) {
            $start = Carbon::parse($event->date . ' ' . $event->start_time);
            $end = Carbon::parse($event->date . ' ' . $event->end_time);

            return [
                'id' => $event->id,
                'name' => $event->name,
                'date' => $event->date,
                'description' => $event->description,
                'capacity' => $event->capacity,
                'location' => $event->location,
                'event_image' => $event->event_image,
                'category_id' => $event->category_id,
                'category' => $event->category, // Include the category details
                'start_time' => $start->format('Y-m-d H:i:s'),
                'end_time' => $end->format('Y-m-d H:i:s'),
            ];
        })->toArray();
    }

    public function getUpcomingEvents() {
        $events = Event::where('date', '>=', now())
                        ->orderBy('date', 'asc')
                        ->take(5)
                        ->get();
    
        return response()->json($events);
    }
}
