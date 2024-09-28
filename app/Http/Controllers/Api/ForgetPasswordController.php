<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Models\User;

class ForgetPasswordController extends Controller
{
    public function sendResetOtp(Request $request)
    {
        // Validate the request
        $request->validate(['email' => 'required|email']);

        // Find the user by email
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json(['message' => 'Email address not found'], 404);
        }

        // Generate a random OTP
        $otp = rand(100000, 999999);

        // Save OTP and expiration time (valid for 10 minutes)
        $user->otp = $otp;
        $user->otp_expires_at = now()->addMinutes(10);
        $user->save();

        // Send the OTP via email
        Mail::send('emails.reset_otp', ['otp' => $otp], function ($message) use ($user) {
            $message->to($user->email)
                    ->subject('Password Reset OTP');
        });

        return response()->json(['message' => 'OTP sent successfully']);
    }
}