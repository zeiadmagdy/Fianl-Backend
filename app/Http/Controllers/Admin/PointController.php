<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Point;
use App\Models\Bus;
use Illuminate\Http\Request;

class PointController extends Controller
{
    public function create(Bus $bus)
    {
        return view('admin.points.create', compact('bus'));
    }

    public function store(Request $request, Bus $bus)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'location' => 'required',
            'description' => 'nullable',
            'arrived_time' => 'nullable|date',
        ]);

        $bus->points()->create($validatedData);
        return redirect()->route('admin.buses.show', $bus)->with('success', 'Point added successfully.');
    }

    public function edit(Point $point)
    {
        return view('admin.points.edit', compact('point'));
    }

    public function update(Request $request, Point $point)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'location' => 'required',
            'description' => 'nullable',
            'arrived_time' => 'nullable|date',
        ]);

        $point->update($validatedData);
        return redirect()->route('admin.buses.show', $point->bus)->with('success', 'Point updated successfully.');
    }

    public function destroy(Point $point)
    {
        $bus = $point->bus;
        $point->delete();
        return redirect()->route('admin.buses.show', $bus)->with('success', 'Point deleted successfully.');
    }
}
