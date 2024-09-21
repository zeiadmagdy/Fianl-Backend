<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Event;

class DashboardController extends Controller
{
    public function index()
{
    $userCount = User::count(); // Assuming you have a User model
    $eventCount = Event::count(); // Assuming you have an Event model

    return view('admin.dashboard', compact('userCount', 'eventCount'));
}

}
