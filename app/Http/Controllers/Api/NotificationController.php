<?php

namespace App\Http\Controllers\Api;

    use App\Http\Controllers\Controller;
    use Illuminate\Http\Request;
    use App\Models\Event; // Assuming you have an Event model
    use Carbon\Carbon;
    
    class NotificationController extends Controller
    {
        public function getNotifications(Request $request)
        {
            $userId = $request->user()->id; // Get the logged-in user's ID
    
            // 1. New events added to the database
            $newEvents = Event::where('created_at', '>=', Carbon::now()->subDays(7))->get();
    
            // 2. Upcoming events in the next week
            $upcomingEvents = Event::where('date', '>=', Carbon::now())
                                    ->where('date', '<=', Carbon::now()->addWeek())
                                    ->get();
    
            // 3. User-attended events starting in the next three days
            $userAttendedEvents = Event::whereHas('attendees', function ($query) use ($userId) {
                $query->where('user_id', $userId);
            })
            ->where('date', '>=', Carbon::now())
            ->where('date', '<=', Carbon::now()->addDays(3))
            ->get();
    
            return response()->json([
                'new_events' => $newEvents,
                'upcoming_events' => $upcomingEvents,
                'user_attended_events' => $userAttendedEvents,
            ]);
        }
    }
