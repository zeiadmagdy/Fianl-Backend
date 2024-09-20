<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EventRequest extends FormRequest
{
    public function authorize()
    {
        return true; // You can adjust authorization as needed
    }

    public function rules()
    {
        return [
            'title' => 'required|string|max:255',
            'date' => 'required|date',
            'description' => 'nullable|string',
            'location' => 'nullable|string', // Add this if you have a location field
        ];
    }
}
