<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // Login method
    public function login(Request $request)
    {
        // Validate incoming request
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Attempt to find user
        $user = User::where('email', $request->email)->first();

        // Verify user and password
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Invalid login credentials'], 401);
        }

        // Generate Sanctum token for user
        $token = $user->createToken('user-token')->plainTextToken;

        return response()->json([
            'token' => $token,
            'user' => $user,
        ]);
    }

    // Logout method
    public function logout(Request $request)
    {
        $request->user()->tokens()->delete(); // Revoke all tokens
        return response()->json(['message' => 'Logged out successfully']);
    }
}
