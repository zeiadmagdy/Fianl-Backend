<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Bus;
use App\Models\Point;
use Illuminate\Http\Request;

class BusController extends Controller
{
    public function getBusPoints($busId)
    {
        // Find the bus by its ID
        $bus = Bus::findOrFail($busId);

        // Retrieve points related to the bus and order them by arrived_time
        $points = Point::where('bus_id', $bus->id)
            ->orderBy('arrived_time', 'asc')
            ->get(['id', 'name', 'latitude', 'longitude', 'arrived_time']); // Specify the columns you want to return

        // Return the points as a JSON response
        return response()->json($points);
    }
}
