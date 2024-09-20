<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $userCount = User::count(); // Get the total number of registered users
        return view('admin.dashboard', compact('userCount'));
    }
}
