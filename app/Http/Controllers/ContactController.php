<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;


class ContactController extends Controller
{
   
    // Store contact form data
    public function store(Request $request)
    {
        // Validate the incoming request
        $validatedData = $request->validate([
            'first_name' => 'required|string|min:2',
            'last_name' => 'required|string|min:2',
            'phone_number' => 'required|string|max:15',
            'email' => 'required|email',
            'subject' => 'required|string|min:5',
            'message' => 'required|string|min:10',
        ]);

        // Create a new contact record
        $contact = Contact::create($validatedData);

        // Return a response
        return response()->json([
            'message' => 'Contact form submitted successfully!',
            'contact' => $contact
        ], 201);
    }

    // Retrieve all contacts for the admin dashboard
    public function index()
    {
        $contacts = Contact::all();  // Fetch all records from the database
        return response()->json($contacts);
    } 
}
