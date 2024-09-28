<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
{
    public function authorize()
    {
        // Set this to true to allow the request (you can add authorization logic if needed)
        return true;
    }

    public function rules()
    {
        // Retrieve the category ID from the route if updating an existing category
        $categoryId = $this->route('category') ? $this->route('category')->id : null;

        return [
            'name' => 'required|string|max:255|unique:categories,name,' . $categoryId,
            'description' => 'nullable|string',
            'category_image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ];
    }
}
