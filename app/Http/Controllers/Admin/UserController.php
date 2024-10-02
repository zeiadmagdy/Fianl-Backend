<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\JsonResponse;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Show the admin user index page.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Eager load events attended by users
        $users = User::with('attendedEvents')->get();
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\UserRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        // Handle file upload
        $profile_image_url = $request->hasFile('profile_image') ? $this->handleProfileImage($request->file('profile_image')) : null;

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'profile_image' => $profile_image_url, 
            'location' => $request->location ?? null, 
            'gender' => $request->gender ?? null, 
            'bio' => $request->bio ?? null, 
            'birth_date' => $request->birth_date ?? null,
            'is_admin' => $request->is_admin ?? 0,
        ]);

        Alert::success('Success', 'User created successfully.');

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

        // Handle profile image update
        if ($request->hasFile('profile_image')) {
            if ($user->profile_image) {
                Cloudinary::destroy($user->profile_image);
            }
            $user->profile_image = $this->handleProfileImage($request->file('profile_image'));
            $userNeedsUpdate = true;
        }

        // Update other fields
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
        if ($request->location !== $user->location) {
            $user->location = $request->location;
            $userNeedsUpdate = true;
        }
        if ($request->gender !== $user->gender) {
            $user->gender = $request->gender;
            $userNeedsUpdate = true;
        }
        if ($request->bio !== $user->bio) {
            $user->bio = $request->bio;
            $userNeedsUpdate = true;
        }
        if ($request->birth_date !== $user->birth_date) {
            $user->birth_date = $request->birth_date;
            $userNeedsUpdate = true;
        }
        if ($request->is_admin !== $user->is_admin) {
            $user->is_admin = $request->is_admin;
            $userNeedsUpdate = true;
        }

        // Save changes if any
        if ($userNeedsUpdate) {
            $user->save();
            Alert::success('Success', 'User updated successfully.');
        } else {
            Alert::warning('Warning', 'No changes were made.');
        }

        return redirect()->route('admin.users.index')->with('success', 'User updated successfully.');
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
            Cloudinary::destroy($user->profile_image);
        }
        $user->delete();

        Alert::success('Success', 'User deleted successfully.');

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
        $user = User::findOrFail($id);
        return response()->json($user);
    }

    /**
     * Get the events attended by the authenticated user.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getUserEvents(Request $request)
    {
        $user = auth()->user();

        if (!$user) {
            return response()->json(['message' => 'No authenticated user found'], 401);
        }

        $events = $user->events()->with('category')->get();

        return response()->json($events, 200);
    }

    /**
     * Handle file upload to Cloudinary.
     *
     * @param \Illuminate\Http\UploadedFile $file
     * @return string
     */
    private function handleProfileImage($file)
    {
        return Cloudinary::upload($file->getRealPath())->getSecurePath();
    }
}
