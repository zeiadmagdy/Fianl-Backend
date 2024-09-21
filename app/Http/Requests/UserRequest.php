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
        $userId = $this->route('user') ? $this->route('user')->id : null; // Get user ID if updating

        return [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $userId,
            'password' => 'nullable|string|min:8|confirmed', // Password is nullable for updates
        ];
    }
}
