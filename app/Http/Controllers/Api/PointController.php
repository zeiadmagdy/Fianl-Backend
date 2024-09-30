<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Point;
use App\Models\Bus;
use Illuminate\Http\Request;

class PointController extends Controller
{
    // public function getBusPoints(Bus $bus)
    // {
    //     $points = Point::where('bus_id', $bus->id)
    //         ->orderBy('arrived_time', 'asc')
    //         ->get(['name', 'latitude', 'longitude', 'arrived_time']);
        
    //     return response()->json($points);
    // }

    // You can add more methods here as needed
    
}
