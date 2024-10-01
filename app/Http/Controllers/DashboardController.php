<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Bus;
use App\Models\Driver;
use App\Models\Categories;
use Carbon\Carbon;

class DashboardController extends Controller
{

    public function index()
    {
        $userCount = User::count();
        $eventCount = Event::count();
        $busCount = Bus::count();
        $driverCount = Driver::count();
        $categoryCount = Categories::count();

        $upcomingEvents = Event::where('date', '>=', now())
        ->orderBy('date')
        ->take(3)
        ->get()
        ->map(function($event) {
            $event->date = Carbon::parse($event->date); // Convert to Carbon
            return $event;
        });
        return view('admin.dashboard', compact('userCount', 'eventCount', 'busCount', 'driverCount', 'categoryCount', 'upcomingEvents'));
    }
}
