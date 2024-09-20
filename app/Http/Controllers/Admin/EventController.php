<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::all();
        return view('admin.events.index', compact('events'));
    }

    public function create()
    {
        return view('admin.events.create');
    }

    public function store(Request $request)
    {
        // Validate request data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'date' => 'required|date_format:Y-m-d\TH:i',  // Ensure date format
            'description' => 'nullable|string',
        ]);

        // Create event with validated data
        Event::create($validatedData);

        // Redirect with success message
        return redirect()->route('admin.events.index')->with('success', 'Event created successfully.');
    }

    public function edit(Event $event)
    {
        return view('admin.events.edit', compact('event'));
    }

    public function update(Request $request, Event $event)
    {
        // Validate request data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'date' => 'required|date_format:Y-m-d\TH:i',
            'description' => 'nullable|string',
        ]);

        // Update event with validated data
        $event->update($validatedData);

        // Redirect with success message
        return redirect()->route('admin.events.index')->with('success', 'Event updated successfully.');
    }

    public function destroy(Event $event)
    {
        // Delete event
        $event->delete();

        // Redirect with success message
        return redirect()->route('admin.events.index')->with('success', 'Event deleted successfully.');
    }
}
