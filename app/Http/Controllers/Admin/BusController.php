<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bus;
use App\Models\Point;
use Illuminate\Http\Request;

use RealRashid\SweetAlert\Facades\Alert;
class BusController extends Controller
{
    public function index()
    {
        $buses = Bus::with('points')->get();  // Load buses with their points
        return view('admin.buses.index', compact('buses'));
    }

    public function create()
    {
        return view('admin.buses.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'bus_number' => 'required|integer',
            'capacity' => 'required|integer',
            'bus_line' => 'required',
        ]);

        Bus::create($validatedData);
        Alert::success('Success', 'Bus created successfully.');
        return redirect()->route('admin.buses.index')->with('success', 'Bus created successfully.');
    }

    public function show(Bus $bus)
    {
        return view('admin.buses.show', compact('bus'));
    }

    public function edit(Bus $bus)
    {
        return view('admin.buses.edit', compact('bus'));
    }

    public function update(Request $request, Bus $bus)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'bus_number' => 'required|integer',
            'capacity' => 'required|integer',
            'bus_line' => 'required',
        ]);

        $bus->update($validatedData);
        Alert::success('Success', 'Bus updated successfully.');

        return redirect()->route('admin.buses.index')->with('success', 'Bus updated successfully.');
    }

    public function destroy(Bus $bus)
    {
        $bus->delete();
        Alert::success('Success', 'Bus deleted successfully.');
        return redirect()->route('admin.buses.index')->with('success', 'Bus deleted successfully.');
    }
}
