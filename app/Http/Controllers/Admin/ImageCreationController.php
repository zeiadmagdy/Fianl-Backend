<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image; // Add this line

class ImageCreationController extends Controller
{
    public function index()
    {
        // Return the view for the image creation page
        return view('admin.image_creation.create');
    }

    public function create()
    {
        // This method may be removed since we won't store images in a database
        return view('admin.image_creation.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'imageData' => 'required|string', // New validation for image data
            'filename' => 'required|string', // New validation for image filename
        ]);

        // Decode the base64 image data
        $imageData = $request->imageData;
        $image = str_replace('data:image/png;base64,', '', $imageData);
        $image = str_replace(' ', '+', $image);
        $imageName = $request->filename;

        // Save the image to the public directory
        file_put_contents(public_path("created_images/{$imageName}.png"), base64_decode($image));

        // Return a response with a success message
        return response()->json([
            'message' => 'Image created successfully!',
            'image_path' => asset("created_images/{$imageName}.png"), // Return image path
        ]);
    }
}
