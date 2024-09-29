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
        // dd($request->all());  
        \Log::info($request->all()); // Log the request data

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'latitude' => 'required|numeric',   // Validate latitude
            'longitude' => 'required|numeric',  // Validate longitude
            'description' => 'nullable|string',
            'arrived_time' => 'required|date_format:H:i',
        ]);

        // Create the point using latitude and longitude
        $bus->points()->create($validatedData);
        
        Alert::success('Success', 'Point added successfully.');
        return redirect()->route('admin.buses.show', $bus)->with('success', 'Point added successfully.');
    }
    // Method for editing a point
    public function edit($id)
    {
        $point = Point::findOrFail($id);  // Fetch the point by ID
        return view('admin.points.edit', compact('point'));  // Load the edit view with the point data
    }

    // Method for updating a point
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'description' => 'nullable|string',
            'arrived_time' => 'required|date_format:H:i',
        ]);

        $point = Point::findOrFail($id);  // Fetch the point by ID
        $point->update([
            'name' => $request->input('name'),
            'latitude' => $request->input('latitude'),
            'longitude' => $request->input('longitude'),
            'description' => $request->input('description'),
            'arrived_time' => $request->input('arrived_time'),
        ]);

        Alert::success('Success', 'Point updated successfully.');
        return redirect()->route('admin.buses.show', $point->bus_id)
                        ->with('success', 'Point updated successfully');
    }

    // Method for deleting a point
    public function destroy($id)
    {
        $point = Point::findOrFail($id);  // Fetch the point by ID
        $bus_id = $point->bus_id;  // Get the bus ID for redirection
        $point->delete();  // Delete the point

        Alert::success('Success', 'Point deleted successfully.');

        return redirect()->route('admin.buses.show', $bus_id)
                        ->with('success', 'Point deleted successfully');
    }
}
