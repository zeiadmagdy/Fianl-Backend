<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Categories;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    // Display a listing of the categories.
    public function index()
    {
        $categories = Categories::all();
        return view('admin.categories.index', compact('categories'));
    }

    // Show the form for creating a new category.
    public function create()
    {
        return view('admin.categories.create');
    }

    // Store a newly created category in storage.
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'capacity' => 'nullable|integer',
        ]);

        Categories::create($request->all());

        return redirect()->route('admin.categories.index')->with('success', 'Category created successfully.');
    }

    // Display the specified category.
    public function show(Categories $category)
    {
        return view('admin.categories.show', compact('category'));
    }

    // Show the form for editing the specified category.
    public function edit(Categories $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    // Update the specified category in storage.
    public function update(Request $request, Categories $category)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'capacity' => 'nullable|integer',
        ]);

        $category->update($request->all());

        return redirect()->route('admin.categories.index')->with('success', 'Category updated successfully.');
    }

    // Remove the specified category from storage.
    public function destroy(Categories $category)
    {
        $category->delete();

        return redirect()->route('admin.categories.index')->with('success', 'Category deleted successfully.');
    }
}
