<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Categories;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use RealRashid\SweetAlert\Facades\Alert;
use App\Models\User;

class EventController extends Controller
{
    public function index(Request $request)
    {
        $events = Event::with('category')->get();

        // Return JSON response if requested from an API
        if ($request->expectsJson()) {
            return response()->json($events, 200);
        }

        // Otherwise, return the view (Web)
        return view('admin.events.index', compact('events'));
    }

    public function create()
    {
        $categories = Categories::all();
        return view('admin.events.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'date' => 'required|date_format:Y-m-d\TH:i',
            'description' => 'nullable|string',
            'capacity' => 'nullable|integer',
            'location' => 'nullable|string|max:255',
            'event_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'category_id' => 'required|exists:categories,id',
        ]);
        if ($request->hasFile('event_image')) {
            $uploadedFileUrl = Cloudinary::upload($request->file('event_image')->getRealPath())->getSecurePath();
            $validatedData['event_image'] = $uploadedFileUrl; // Store Cloudinary URL
        }

        Event::create($validatedData);

        Alert::success('Success', 'Event created successfully.');

        return redirect()->route('admin.events.index')->with('success', 'Event created successfully.');
    }

    public function edit(Event $event)
    {
        $categories = Categories::all();
        return view('admin.events.edit', compact('event', 'categories'));
    }

    public function show(Request $request, $id)
    {
        $event = Event::with('category')->findOrFail($id);

        // Check if the request expects a JSON response (API)
        if ($request->expectsJson()) {
            return response()->json($event, 200);
        }

        // Otherwise, return the view (Web)
        return view('admin.events.show', compact('event'));
    }

    public function update(Request $request, Event $event)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'date' => 'required|date_format:Y-m-d\TH:i',
            'description' => 'nullable|string',
            'capacity' => 'nullable|integer',
            'location' => 'nullable|string|max:255',
            'event_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'category_id' => 'required|exists:categories,id',
        ]);

        // Process new profile image
        if ($request->hasFile('event_image')) {
            // Remove old image from Cloudinary if it exists
            if ($event->event_image) {
                // Extract public ID from URL for deletion
                $publicId = basename($event->event_image, '.' . pathinfo($event->event_image, PATHINFO_EXTENSION));
                Cloudinary::destroy($publicId);
            }
            // Upload the new image
            $uploadedFileUrl = Cloudinary::upload($request->file('event_image')->getRealPath())->getSecurePath();
            $validatedData['event_image'] = $uploadedFileUrl; // Store Cloudinary URL
        }

        $event->update($validatedData);

        Alert::success('Success', 'Event updated successfully.');

        return redirect()->route('admin.events.index')->with('success', 'Event updated successfully.');
    }

    public function destroy(Event $event)
    {
        if ($event->event_image) {
            // Remove old image from Cloudinary if it exists
            $publicId = basename($event->event_image, '.' . pathinfo($event->event_image, PATHINFO_EXTENSION));
            Cloudinary::destroy($publicId);
        }
        $event->delete();

        Alert::success('Success', 'Event deleted successfully.');

        return redirect()->route('admin.events.index')->with('success', 'Event deleted successfully.');
    }

    public function attendEvent(Request $request, $eventId)
    {
        $user = auth()->user(); // Get the authenticated user
        $event = Event::findOrFail($eventId); // Find the event
    
        // Check if the user is already attending
        $attendance = $event->attendees()->where('user_id', $user->id)->first();
    
        if ($attendance) {
            // User is currently attending, so we will leave the event
            $event->attendees()->detach($user->id); // Remove user from attendees
            return response()->json(['message' => 'You are no longer attending the event.'], 200);
        } else {
            // User is not attending, so we will attend the event
            $event->attendees()->attach($user->id); // Add user to attendees
            return response()->json(['message' => 'You are now attending the event.'], 200);
        }
    }
    
    

    public function getEventAttendeesCount($eventId)
    {
        $event = Event::findOrFail($eventId);
        $attendeesCount = $event->attendees()->count();

        return response()->json(['attendees_count' => $attendeesCount], 200);
    }


}
