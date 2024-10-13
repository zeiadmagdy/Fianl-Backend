<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bus;
use App\Models\BusPoint;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Barryvdh\DomPDF\Facade\Pdf;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Support\Facades\Storage;
use Knp\Snappy\Pdf as SnappyPdf;



class BusController extends Controller
{
    public function index(Request $request)
    {
        $query = Bus::query()->with('points');

        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }

        if ($request->filled('bus_number')) {
            $query->where('bus_number', $request->bus_number);
        }

        if ($request->filled('bus_line')) {
            $query->where('bus_line', 'like', '%' . $request->bus_line . '%');
        }

        $buses = $query->get();

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
    public function downloadPdf($id)
{
    $bus = Bus::with('driver', 'points')->findOrFail($id);
    $pdf = \App::make('snappy.pdf.wrapper');

    $pdf->loadView('admin.buses.pdf', compact('bus'));
    return $pdf->download('bus-details-' . $bus->name . '.pdf');
}
}
