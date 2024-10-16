<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;


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
        // Use paginate instead of all
        $contacts = Contact::paginate(5); // Display 5 contacts per page
        return view('admin.contacts', compact('contacts')); // Pass paginated contacts to the view
    }

}
