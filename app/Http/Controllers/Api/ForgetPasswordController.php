<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ResetOtpMail; // Import your Mailable class
use App\Models\User;
use Illuminate\Support\Facades\RateLimiter; // Import for rate limiting

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

        // Rate limiting: Limit to 10 requests per minute
        if (RateLimiter::tooManyAttempts('otp.' . $request->email, 10)) {
            return response()->json(['message' => 'Too many requests. Please try again later.'], 429);
        }

        // Generate a random OTP
        $otp = rand(100000, 999999);

        // Save OTP and expiration time (valid for 10 minutes)
        $user->otp = $otp;
        $user->otp_expires_at = now()->addMinutes(10);
        $user->save();

        // Send the OTP via email using the Mailable class
        Mail::to($user->email)->send(new ResetOtpMail($otp));

        // Increment attempts for the rate limiter
        RateLimiter::hit('otp.' . $request->email);

        return response()->json(['message' => 'OTP sent successfully']);
    }

    public function verifyOtp(Request $request)
    {
        // Validate the request
        $request->validate(['otp' => 'required|digits:6']);

        // Find the user by OTP
        $user = User::where('otp', $request->otp)->first();

        if (!$user) {
            return response()->json(['message' => 'Invalid OTP'], 400);
        }

        // Check if OTP is valid
        if ($user->otp_expires_at < now()) {
            return response()->json(['message' => 'OTP expired'], 400);
        }

        return response()->json(['message' => 'OTP verified successfully']);
    }

    public function resetPassword(Request $request)
    {
        // Validate the request
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|confirmed|min:8',
        ]);

        // Find the user by email
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json(['message' => 'Email address not found'], 404);
        }

        // Reset the password
        $user->password = bcrypt($request->password);
        $user->otp = null; // Clear OTP
        $user->otp_expires_at = null; // Clear expiration time
        $user->save();
        
        return response()->json(['message' => 'Password reset successfully']);
    }
}
