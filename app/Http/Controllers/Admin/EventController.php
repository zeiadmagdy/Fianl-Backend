<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Categories;  // Include the Categories model
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use RealRashid\SweetAlert\Facades\Alert;
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
                $publicId = basename($event->event_image, '.'.$event->event_image->getExtension());
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
        $publicId = basename($event->event_image, '.'.$event->event_image->getExtension());
        Cloudinary::destroy($publicId);
    }
        $event->delete();

        Alert::success('Success', 'Event deleted successfully.');

        return redirect()->route('admin.events.index')->with('success', 'Event deleted successfully.');
    }

    public function attendEvent(Request $request, $eventId)
    {
        $event = Event::findOrFail($eventId);
        $user = Auth::user();

        if ($event->attendees()->where('user_id', $user->id)->exists()) {
            $event->attendees()->detach($user->id);
            return response()->json(['message' => 'You have successfully left the event.'], 200);
        } else {
            $event->attendees()->attach($user->id);
            return response()->json(['message' => 'You are now attending the event.'], 200);
        }
    }
}
