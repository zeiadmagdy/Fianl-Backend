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
}
