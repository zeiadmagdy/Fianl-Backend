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
        $user->otp = null;
        $user->otp_expires_at = null;
        $user->save();
        return response()->json(['message' => 'Password reset successfully']);
    }
    
}

