<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Categories;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class EventController extends Controller
{
    public function index(Request $request)
    {
        $query = Event::with('category', 'attendees');

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

        $events = $query->get();
        $categories = Categories::all();

        if ($request->expectsJson()) {
            return response()->json($events, 200);
        }

        return view('admin.events.index', compact('events', 'categories'));
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

        // Handle image upload
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

        if ($request->expectsJson()) {
            return response()->json($event, 200);
        }

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

        // Handle image upload
        if ($request->hasFile('event_image')) {
            if ($event->event_image) {
                // Remove old image from Cloudinary
                $publicId = basename($event->event_image, '.' . pathinfo($event->event_image, PATHINFO_EXTENSION));
                Cloudinary::destroy($publicId);
            }

            // Upload the new image
            $uploadedFileUrl = Cloudinary::upload($request->file('event_image')->getRealPath())->getSecurePath();
            $validatedData['event_image'] = $uploadedFileUrl;
        }

        $event->update($validatedData);

        Alert::success('Success', 'Event updated successfully.');
        return redirect()->route('admin.events.index')->with('success', 'Event updated successfully.');
    }

    public function destroy(Event $event)
    {
        if ($event->event_image) {
            // Remove old image from Cloudinary
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
            // User is currently attending, so leave the event
            $event->attendees()->detach($user->id);
            return response()->json(['message' => 'You are no longer attending the event.'], 200);
        } else {
            // User is not attending, so attend the event
            $event->attendees()->attach($user->id);
            return response()->json(['message' => 'You are now attending the event.'], 200);
        }
    }

    public function getEventAttendeesCount($eventId)
    {
        $event = Event::findOrFail($eventId);
        $attendeesCount = $event->attendees()->count();

        return response()->json(['attendees_count' => $attendeesCount], 200);
    }

    public function getEventAttendees($id)
    {
        $event = Event::with('attendees')->findOrFail($id);
        return response()->json(['attendees' => $event->attendees]);
    }

    /**
     * Handle file upload to Cloudinary.
     *
     * @param \Illuminate\Http\UploadedFile $file
     * @return string
     */
    private function handleProfileImage($file)
    {
        return Cloudinary::upload($file->getRealPath())->getSecurePath();
    }
}
