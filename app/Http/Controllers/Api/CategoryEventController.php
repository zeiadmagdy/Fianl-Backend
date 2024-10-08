<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Categories;
use Illuminate\Http\Request;

class CategoryEventController extends Controller
{
    // Function to return events by category ID
    public function getEventsByCategory($categoryId)
    {
        // Fetch the category by ID with events
        $category = Categories::with('events')->find($categoryId);

        if (!$category) {
            return response()->json(['message' => 'Category not found'], 404);
        }

        // Return the category with its events
        return response()->json([
            'category' => $category->name,
            'events' => $category->events
        ]);
    }
}
