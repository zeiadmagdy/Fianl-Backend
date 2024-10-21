<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Categories;
use App\Models\Event; // Make sure to include the Event model
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class InsightsController extends Controller
{
    public function index(Request $request)
    {
        // Get the current year
        $currentYear = Carbon::now()->year;

        // Data for user registrations per month
        $userRegistrations = User::select(DB::raw("COUNT(*) as count"), DB::raw("DATE_FORMAT(created_at, '%m') as month"))
            ->whereYear('created_at', $currentYear) // Only current year
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // Prepare user registration counts for each month
        $userCounts = array_fill(0, 12, 0); // Initialize counts for each month
        foreach ($userRegistrations as $registration) {
            $monthIndex = (int)$registration->month - 1; // Adjust to 0-based index
            $userCounts[$monthIndex] = $registration->count; // Set user count for respective month
        }

        // Labels for the months (January - December)
        $monthNames = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];

        // Fetch all users with their registration month
        $usersPerMonth = User::select('id', 'name', 'email', DB::raw("DATE_FORMAT(created_at, '%m') as month"))
            ->whereYear('created_at', $currentYear)
            ->get()
            ->groupBy('month'); // Group users by month

        // Fetch top 10 events by user attendance
        $topEvents = Event::withCount('users') // Assuming a 'users' relationship exists in the Event model
            ->orderBy('users_count', 'desc')
            ->take(10)
            ->get();

        // Prepare data for the chart
        $eventNames = $topEvents->pluck('name')->toArray();
        $eventCapacities = $topEvents->pluck('capacity')->toArray();
        $eventAttendances = $topEvents->pluck('users_count')->toArray();
        $eventUsers = []; // To hold user lists for each event
        $eventIds = $topEvents->pluck('id')->toArray(); // Adjust according to your model

        foreach ($topEvents as $event) {
            // Specify the table name for the id column to avoid ambiguity
            $eventUsers[$event->id] = $event->users()->select('users.id', 'users.name', 'users.email')->get();
        }

        // User Demographics
        $demographics = User::select('gender', DB::raw('COUNT(*) as count'))
            ->groupBy('gender')
            ->get();

        $demographicLabels = $demographics->pluck('gender')->toArray();
        $demographicCounts = $demographics->pluck('count')->toArray();

        // Monthly Event Attendance
        $monthlyAttendance = Event::select(DB::raw('MONTH(date) as month'), DB::raw('COUNT(*) as count'))
            ->whereYear('date', $currentYear)
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // Initialize an array for attendance counts
        $monthlyAttendanceCounts = array_fill(0, 12, 0); // Default counts for each month

        // Populate the attendance counts based on fetched data
        foreach ($monthlyAttendance as $attendance) {
            $monthIndex = (int)$attendance->month - 1; // Adjust to 0-based index
            $monthlyAttendanceCounts[$monthIndex] = $attendance->count; // Set attendance count for respective month
        }

        // Events by Category
        $categoryCounts = Event::select('category_id', DB::raw('COUNT(*) as count'))
            ->groupBy('category_id')
            ->get();

        $categoryNames = Categories::whereIn('id', $categoryCounts->pluck('category_id'))->pluck('name')->toArray();
        $categoryCounts = $categoryCounts->pluck('count')->toArray();

        // User Registrations by Location
        $locationCounts = User::select('location', DB::raw('COUNT(*) as count'))
            ->groupBy('location')
            ->get();
        
        $locationNames = $locationCounts->pluck('location')->toArray();
        $locationCounts = $locationCounts->pluck('count')->toArray();

        // User Engagement Over Time
        $engagementData = User::select(DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'), DB::raw('COUNT(*) as count'))
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $engagementMonths = $engagementData->pluck('month')->toArray();
        $engagementCounts = $engagementData->pluck('count')->toArray();

        // Top Attendees
        $topAttendees = User::withCount('events')
            ->orderBy('events_count', 'desc')
            ->take(10)
            ->get();

        $topAttendeeNames = $topAttendees->pluck('name')->toArray();
        $topAttendeeCounts = $topAttendees->pluck('events_count')->toArray();

        // Subscription Growth
        $subscriptionGrowthData = User::select(DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'), DB::raw('COUNT(*) as count'))
            ->whereYear('created_at', $currentYear) // Include year filter
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // Initialize array for subscription growth
        $growthMonths = array_map(function ($m) use ($currentYear) {
            return $currentYear . '-' . str_pad($m, 2, '0', STR_PAD_LEFT);
        }, range(1, 12));

        // Fill subscription counts
        $subscriptionCounts = array_fill(0, 12, 0); // Default counts for each month
        foreach ($subscriptionGrowthData as $data) {
            $monthIndex = (int)substr($data->month, 5, 2) - 1; // Extract month index (0-based)
            $subscriptionCounts[$monthIndex] = $data->count; // Set count for respective month
        }

        // Pass the data to the view
        return view('admin.insights', compact(
            'monthNames', 
            'userCounts', 
            'usersPerMonth', 
            'eventNames', 
            'eventCapacities', 
            'eventAttendances', 
            'eventUsers', 
            'eventIds',
            'demographicLabels', 
            'demographicCounts',
            'monthlyAttendanceCounts', // Updated to use filled counts
            'categoryNames',
            'categoryCounts',
            'locationNames',
            'locationCounts',
            'engagementMonths',
            'engagementCounts',
            'topAttendeeNames',
            'topAttendeeCounts',
            'growthMonths',
            'subscriptionCounts'
        ));
    }
}
