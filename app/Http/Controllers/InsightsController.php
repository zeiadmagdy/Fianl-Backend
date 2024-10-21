<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Categories;
use App\Models\Subscription;
use App\Models\Event;
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
            ->whereYear('created_at', $currentYear)
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // Prepare user registration counts for each month
        $userCounts = array_fill(0, 12, 0);
        foreach ($userRegistrations as $registration) {
            $monthIndex = (int)$registration->month - 1;
            $userCounts[$monthIndex] = $registration->count;
        }

        // Labels for the months (January - December)
        $monthNames = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];

        // Fetch all users with their registration month
        $usersPerMonth = User::select('id', 'name', 'email', DB::raw("DATE_FORMAT(created_at, '%m') as month"))
            ->whereYear('created_at', $currentYear)
            ->get()
            ->groupBy('month');

        // Fetch top 10 events by user attendance
        $topEvents = Event::withCount('users')
            ->orderBy('users_count', 'desc')
            ->take(10)
            ->get();

        // Prepare data for the chart
        $eventNames = $topEvents->pluck('name')->toArray();
        $eventCapacities = $topEvents->pluck('capacity')->toArray();
        $eventAttendances = $topEvents->pluck('users_count')->toArray();
        $eventUsers = [];
        $eventIds = $topEvents->pluck('id')->toArray();

        foreach ($topEvents as $event) {
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

        $monthlyAttendanceCounts = array_fill(0, 12, 0);

        foreach ($monthlyAttendance as $attendance) {
            $monthIndex = (int)$attendance->month - 1;
            $monthlyAttendanceCounts[$monthIndex] = $attendance->count;
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

        // Top Attendees
        $topAttendees = User::withCount('events')
            ->orderBy('events_count', 'desc')
            ->take(10)
            ->get();

        $topAttendeeNames = $topAttendees->pluck('name')->toArray();
        $topAttendeeCounts = $topAttendees->pluck('events_count')->toArray();

        // Subscription Growth
        $subscriptionGrowthData = Subscription::select(DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'), DB::raw('COUNT(*) as count'))
            ->whereYear('created_at', $currentYear)
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // Initialize array for subscription growth
        $growthMonths = array_map(function ($m) use ($currentYear) {
            return $currentYear . '-' . str_pad($m, 2, '0', STR_PAD_LEFT);
        }, range(1, 12));

        $subscriptionCounts = array_fill(0, 12, 0);
        foreach ($subscriptionGrowthData as $data) {
            $monthIndex = (int)substr($data->month, 5, 2) - 1;
            $subscriptionCounts[$monthIndex] = $data->count;
        }
        // Prepare subscription month labels (for example, '2024-01', '2024-02', etc.)
        $subscriptionMonths = array_map(function($m) use ($currentYear) {
            return $currentYear . '-' . str_pad($m, 2, '0', STR_PAD_LEFT);
        }, range(1, 12));

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
            'monthlyAttendanceCounts',
            'categoryNames',
            'categoryCounts',
            'locationNames',
            'locationCounts',
            'topAttendeeNames',
            'topAttendeeCounts',
            'growthMonths',
            'subscriptionCounts',
            
        ));
    }
}
