<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Categories;
use Illuminate\Http\Request;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Http\JsonResponse;


class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $categories = Categories::with('events')->get();

        // Check if the request expects a JSON response (API)
        if ($request->expectsJson()) {
            return response()->json($categories, 200);
        }

        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
            'description' => 'nullable|string',
            'category_image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Handle the image upload if present
        if ($request->hasFile('category_image')) {
            $uploadedFileUrl = Cloudinary::upload($request->file('category_image')->getRealPath())->getSecurePath();
            $validatedData['category_image'] = $uploadedFileUrl; // Store Cloudinary URL
        }

        Categories::create($validatedData);

        Alert::success('Success', 'Category created successfully.');

        return redirect()->route('admin.categories.index');
    }

    public function show(Categories $category)
    {
        $events = $category->events; // Get events related to the category
        return view('admin.categories.show', compact('category', 'events'));
    }

    public function edit(Categories $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, Categories $category)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $category->id,
            'description' => 'nullable|string',
            'category_image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Handle the new image upload
        if ($request->hasFile('category_image')) {
            // Remove old image from Cloudinary if it exists
            if ($category->category_image) {
                $publicId = pathinfo($category->category_image, PATHINFO_FILENAME);
                Cloudinary::destroy($publicId);
            }

            // Upload the new image
            $uploadedFileUrl = Cloudinary::upload($request->file('category_image')->getRealPath())->getSecurePath();
            $validatedData['category_image'] = $uploadedFileUrl; // Store Cloudinary URL
        }

        // Update the category data
        $category->update($validatedData);

        Alert::success('Success', 'Category updated successfully.');

        return redirect()->route('admin.categories.index');
    }

    public function destroy(Categories $category)
    {
        // Remove old image from Cloudinary if it exists
        if ($category->category_image) {
            $publicId = pathinfo($category->category_image, PATHINFO_FILENAME);
            Cloudinary::destroy($publicId);
        }

        $category->delete();

        Alert::success('Success', 'Category deleted successfully.');

        return redirect()->route('admin.categories.index');
    }
    public function getAllCategories(): JsonResponse
    {
        // Fetch all categories
        $categories = Categories::all();

        // Return categories in JSON format
        return response()->json($categories, 200);
    }
}
