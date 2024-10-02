<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Driver;
use App\Models\Bus;
use Illuminate\Http\Request;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

use RealRashid\SweetAlert\Facades\Alert;
class DriverController extends Controller
{
    // Display a listing of the drivers
    public function index(Request $request)
    {
        $query = Driver::query()->with('bus');

        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }

        if ($request->filled('phone_number')) {
            $query->where('phone_number', 'like', '%' . $request->phone_number . '%');
        }

        $drivers = $query->get();

        return view('admin.drivers.index', compact('drivers'));
    }

    // Show the details of the specified driver
public function show(Driver $driver)
{
    return view('admin.drivers.show', compact('driver'));
}

    // Show the form for creating a new driver
    public function create()
    {
        $buses = Bus::all(); // Fetching buses for assignment
        return view('admin.drivers.create', compact('buses'));
    }

    // Store a newly created driver in the database
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:20',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'bus_id' => 'nullable|exists:buses,id',
        ]);

        $data = $request->all();

        // Handle file upload to Cloudinary
        if ($request->hasFile('profile_image')) {
            $uploadedFileUrl = Cloudinary::upload($request->file('profile_image')->getRealPath())->getSecurePath();
            $data['profile_image'] = $uploadedFileUrl;
        }

        Driver::create($data);

        Alert::success('Success', 'Driver created successfully.');
        return redirect()->route('admin.drivers.index')->with('success', 'Driver created successfully.');
    }

    // Show the form for editing the specified driver
    public function edit(Driver $driver)
    {
        $buses = Bus::all(); // Fetch all buses for assignment

        return view('admin.drivers.edit', compact('driver', 'buses'));
    }

    // Update the specified driver in the database
    public function update(Request $request, Driver $driver)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:20',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'bus_id' => 'nullable|exists:buses,id',
        ]);

        $data = $request->all();

        // Handle profile image update
        if ($request->hasFile('profile_image')) {
            // Delete the old image from Cloudinary if it exists
            if ($driver->profile_image) {
                Cloudinary::destroy($driver->profile_image); // Assuming Cloudinary public ID stored
            }
            // Upload the new image to Cloudinary
            $uploadedFileUrl = Cloudinary::upload($request->file('profile_image')->getRealPath())->getSecurePath();
            $data['profile_image'] = $uploadedFileUrl;
        }

        $driver->update($data);

        Alert::success('Success', 'Driver updated successfully.');

        return redirect()->route('admin.drivers.index')->with('success', 'Driver updated successfully.');
    }

    // Remove the specified driver from the database
    public function destroy(Driver $driver)
    {
        // Delete the image from Cloudinary if it exists
        if ($driver->profile_image) {
            Cloudinary::destroy($driver->profile_image); // Assumes Cloudinary public ID stored
        }

        $driver->delete();

        Alert::success('Success', 'Driver deleted successfully.');

        return redirect()->route('admin.drivers.index')->with('success', 'Driver deleted successfully.');
    }
}
