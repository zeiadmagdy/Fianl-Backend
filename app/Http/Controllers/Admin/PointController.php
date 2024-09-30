<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Point;
use App\Models\Bus;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class PointController extends Controller
{
    public function create(Bus $bus)
    {
        return view('admin.points.create', compact('bus'));
    }

    public function store(Request $request, Bus $bus)
    {
        // Log the request data
        \Log::info($request->all());  

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'latitude' => 'required|numeric',   
            'longitude' => 'required|numeric',  
            'description' => 'nullable|string',
            'arrived_time' => 'required|date_format:H:i',
        ]);

        // Create the point using latitude and longitude
        $bus->points()->create($validatedData);
        
        Alert::success('Success', 'Point added successfully.');
        return redirect()->route('admin.buses.show', $bus)->with('success', 'Point added successfully.');
    }

    public function edit($id)
    {
        $point = Point::findOrFail($id);
        return view('admin.points.edit', compact('point'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'description' => 'nullable|string',
            'arrived_time' => 'required|date_format:H:i',
        ]);

        $point = Point::findOrFail($id);
        $point->update($request->only(['name', 'latitude', 'longitude', 'description', 'arrived_time']));

        Alert::success('Success', 'Point updated successfully.');
        return redirect()->route('admin.buses.show', $point->bus_id)->with('success', 'Point updated successfully');
    }

    public function destroy($id)
    {
        $point = Point::findOrFail($id);
        $bus_id = $point->bus_id;
        $point->delete();

        Alert::success('Success', 'Point deleted successfully.');
        return redirect()->route('admin.buses.show', $bus_id)->with('success', 'Point deleted successfully');
    }
    public function show($id)
    {
        // Find the point by ID or fail
        $point = Point::findOrFail($id);
        
        // Fetch all points related to the specific bus
        $points = Point::where('bus_id', $point->bus_id)->orderBy('arrived_time', 'asc')->get();
        
        // Pass the point and related points to the view
        return view('admin.points.show', compact('point', 'points'));
    }
    
    

    // public function getBusPoints(Bus $bus)
    // {
    //     \Log::info('Fetching points for bus ID: ' . $bus->id);

    //     $points = Point::where('bus_id', $bus->id)
    //             ->orderBy('arrived_time', 'asc')
    //             ->get(['name', 'latitude', 'longitude', 'arrived_time']);
                
    // return response()->json($points); // Return points as JSON
    // }
}
