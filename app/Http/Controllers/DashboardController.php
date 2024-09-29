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
use App\Services\TranslationService;

class DashboardController extends Controller
{
    protected $translationService;

    public function __construct(TranslationService $translationService)
    {
        $this->translationService = $translationService;
    }
    public function index()
    {
        $userCount = User::count();
        $eventCount = Event::count();
        $busCount = Bus::count();
        $driverCount = Driver::count();
        $categoryCount = Categories::count();
        $text = "Welcome to Eventoria!";
        $translatedText = $this->translationService->translate($text);
        // dd($translatedText); // Display DD for testing

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
