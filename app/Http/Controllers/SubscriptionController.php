<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subscription; // Import the Subscription model
use Illuminate\Support\Facades\Validator;

class SubscriptionController extends Controller
{
    public function subscribe(Request $request)
    {
        // Validate the email input
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:subscriptions,email',
        ]);

        if ($validator->fails()) {
            \Log::error('Subscription error', [
                'errors' => $validator->errors(),
                'request' => $request->all(),
            ]);
            return response()->json(['error' => 'Invalid email or email already subscribed'], 422);
        }

        // Store the email in the database
        Subscription::create([
            'email' => $request->email,
        ]);

        return response()->json(['success' => 'You have successfully subscribed!']);
    }

}

