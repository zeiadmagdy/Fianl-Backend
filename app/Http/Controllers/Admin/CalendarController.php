<?php

// app/Http/Controllers/Admin/CalendarController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event; // Adjust the import according to your structure
use Illuminate\Http\Request;

class CalendarController extends Controller
{
    public function index(Request $request)
    {
        $events = Event::all(); // You can customize this as needed

        return view('admin.calendar', compact('events'));
    }
}
