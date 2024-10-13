<?php 

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Bus;
use App\Models\Driver;
use App\Models\Point;
use Illuminate\Http\Request;


class BusController extends Controller
{
    // Fetch all buses with drivers and points (existing)
    public function index()
    {
        $buses = Bus::with(['driver', 'points'])->get();
        return response()->json($buses);
    }

    // Fetch a single bus by ID (existing)
    public function show($id)
    {
        $bus = Bus::find($id);
        if (!$bus) {
            return response()->json(['message' => 'Bus not found.'], 404);
        }
        return response()->json($bus);
    }

    // Fetch points for a specific bus (updated to work with the route /api/buses/{id}/points)
    public function getBusPoints($busId)
    {
        $bus = Bus::findOrFail($busId);

        // Retrieve points related to the bus and order them by arrived_time
        $points = Point::where('bus_id', $bus->id)
            ->orderBy('arrived_time', 'asc')
            ->get(['id', 'name', 'latitude', 'longitude', 'arrived_time', 'description']); // Specify columns

        return response()->json($points);
    }

    // Fetch driver for a specific bus (new method)
    public function getDriver($busId)
    {
        $bus = Bus::with('driver')->findOrFail($busId);

        if (!$bus->driver) {
            return response()->json(['message' => 'Driver not assigned'], 404);
        }

        return response()->json($bus->driver);
    }

    // Fetch buses related to a specific event (existing)
    public function getBusesForEvent($eventId)
    {
        $user = auth()->user();
        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $buses = Bus::with(['driver', 'points'])
            ->whereHas('points', function ($query) use ($eventId) {
                $query->where('event_id', $eventId);
            })
            ->get();

        return response()->json($buses);
    }
    public function downloadPdf($id)
{
    $bus = Bus::with('driver', 'points')->findOrFail($id);
    $pdf = \App::make('snappy.pdf.wrapper');

    $pdf->loadView('admin.buses.pdf', compact('bus'));
    return $pdf->download('bus-details-' . $bus->name . '.pdf');
}
}
