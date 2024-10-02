<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Categories; // Add this line to import the Category model
use Illuminate\Http\Request;

class CalendarController extends Controller
{
    public function index(Request $request)
    {
        $categories = Categories::all(); // Fetch all categories

        return view('admin.calendar', compact('categories'));
    }

    public function fetchEvents(Request $request)
    {
        // Get the query parameters
        $start = $request->input('start');
        $end = $request->input('end');
        $categoryId = $request->input('category_id');

        // Query the events based on date range and category
        $query = Event::whereBetween('date', [$start, $end]);

        if ($categoryId) {
            $query->where('category_id', $categoryId);
        }

        $events = $query->get();

        return response()->json($events);
    }
}
