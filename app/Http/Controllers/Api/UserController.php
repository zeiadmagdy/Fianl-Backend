<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Api\UserRequest;
use App\Http\Resources\UserResource;
use Cloudinary\Cloudinary;
use Cloudinary\Transformation\Transformation;

class UserController extends Controller
{
    public function view()
    {
        $user = auth()->user();

        if (!$user) {
            return response()->json(['error' => 'User not authenticated'], 401);
        }

        return new UserResource($user);
    }


    public function uploadProfileImage(Request $request, User $user)
    {
        if (auth()->id() !== $user->id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
    
        $request->validate([
            'image' => 'required|image|max:2048', // max file size 2MB
        ]);
    
        if ($request->hasFile('image')) {
            $image = $request->file('image');
    
            // Upload to Cloudinary
            $cloudinary = new Cloudinary();
            $uploadResult = $cloudinary->uploadApi()->upload($image->getRealPath(), [
                'folder' => 'profile_images', // Optional: specify a folder in Cloudinary
            ]);
    
            // Update the user's profile_image attribute with the URL
            $user->profile_image = $uploadResult['secure_url'];
            $user->save();
    
            return response()->json(['message' => 'Profile image updated successfully', 'path' => $uploadResult['secure_url']], 200);
        }
    
        return response()->json(['error' => 'No image file provided'], 400);
    }


    public function update(UserRequest $request)
    {
        $user = auth()->user();

        if (!$user) {
            return response()->json(['error' => 'User not authenticated'], 401);
        }

        $data = $request->only(['name', 'email', 'location', 'gender', 'bio', 'birth_date', 'profile_image']);

        // Hash the password if provided
        if ($request->filled('password')) {
            $data['password'] = bcrypt($request->password);
        }
        $user = User::find($user->id);
        $user->update($data);

        return new UserResource($user);
    }


}
