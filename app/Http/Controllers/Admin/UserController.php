<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\JsonResponse;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class UserController extends Controller
{
    /**
     * Show the admin user index page.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $users = User::all();
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        // Handle file upload to Cloudinary
        $profile_image_url = null;
        if ($request->hasFile('profile_image')) {
            $uploadedFileUrl = Cloudinary::upload($request->file('profile_image')->getRealPath())->getSecurePath();
            $profile_image_url = $uploadedFileUrl;
        }

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'profile_image' => $profile_image_url, // Store profile image URL
        ]);

        return redirect()->route('admin.users.index')->with('success', 'User created successfully.');
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UserRequest  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request, User $user)
    {
        $userNeedsUpdate = false;

        // Process new profile image
        if ($request->hasFile('profile_image')) {
            // Remove old image if it exists
            if ($user->profile_image) {
                Cloudinary::destroy($user->profile_image);
            }
            // Upload the new image
            $image = $request->file('profile_image');
            $uploadedFileUrl = Cloudinary::uploadApi()->upload($image->getRealPath(), [
                'folder' => 'users/',
                'public_id' => $image->getClientOriginalName(),
            ])['secure_url'];
            $user->profile_image = $uploadedFileUrl;
            $userNeedsUpdate = true;
        }

        // Process other user details
        if ($request->filled('name') && $request->name !== $user->name) {
            $user->name = $request->name;
            $userNeedsUpdate = true;
        }
        if ($request->filled('email') && $request->email !== $user->email) {
            $user->email = $request->email;
            $userNeedsUpdate = true;
        }
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
            $userNeedsUpdate = true;
        }

        // Validate the request
        $request->validate([
            'email' => 'sometimes|required|email|unique:users,email,' . $user->id,
        ]);

        if ($userNeedsUpdate) {
            $user->save();
            return redirect()->route('admin.users.index')->with('success', 'User updated successfully.');
        }

        return redirect()->route('admin.users.index')->with('warning', 'No changes were made.');
    }

    /**
     * Remove the specified user from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        if ($user->profile_image) {
            Cloudinary::destroy($user->profile_image); // Assumes Cloudinary public ID stored
        }
        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'User deleted successfully.');
    }

    /**
     * Display the specified user in the admin area.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return view('admin.users.show', compact('user'));
    }


    /**
     * Return a JSON response of the user data with the given ID.
     *
     * @param int $id The ID of the user to retrieve.
     * @return \Illuminate\Http\JsonResponse
     */
    public function getUserById($id): JsonResponse
    {
        $user = User::findOrFail($id); // Retrieve user by ID
        return response()->json($user); // Return user data as JSON
    }








}
