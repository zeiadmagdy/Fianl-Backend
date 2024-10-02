<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Authorize all users for this example
    }

    public function rules()
    {
        $userId = auth()->id(); // Always use the authenticated user ID for updates
    
        return [
            'name' => 'nullable|string|max:255',
            'email' => 'nullable|string|email|max:255|unique:users,email,' . $userId,
            'password' => 'nullable|string|min:8', // Remove `confirmed` if not required
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'location' => 'nullable|string|max:255',
            'gender' => 'nullable|string|in:male,female,other',
            'bio' => 'nullable|string',
            'birth_date' => 'nullable|date',
            'is_admin' => 'nullable|boolean',
        ];
    }
}
