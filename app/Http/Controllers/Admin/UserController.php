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
    public function index(Request $request)
    {
        // Eager load events attended by users
        $query = User::query()->with('attendedEvents');

        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }
    
        if ($request->filled('email')) {
            $query->where('email', 'like', '%' . $request->email . '%');
        }
    
        if ($request->filled('role')) {
            $query->where('is_admin', $request->role === 'admin' ? 1 : 0);
        }
    
        $users = $query->get();
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
    public function update(Request $request, User $user)
{
    // Validate incoming request data
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'password' => 'nullable|string|min:8',
        'profile_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        'location' => 'nullable|string|max:255',
        'gender' => 'nullable|string|in:male,female,other',
        'bio' => 'nullable|string',
        'birth_date' => 'nullable|date',
        'is_admin' => 'required|boolean',
    ]);

    // Update user attributes
    $user->name = $request->name;
    $user->email = $request->email;

    // Handle password update
    if ($request->filled('password')) {
        $user->password = bcrypt($request->password);
    }

    // Handle profile image upload
    if ($request->hasFile('profile_image')) {
        // Assuming you are using Cloudinary for image storage
        $user->profile_image = Cloudinary::upload($request->file('profile_image')->getRealPath())->getSecurePath();
    }

    $user->location = $request->location;
    $user->gender = $request->gender;
    $user->bio = $request->bio;
    $user->birth_date = $request->birth_date;
    $user->is_admin = $request->is_admin;

    $user->save();

    Alert::success('Success', 'User updated successfully.');

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

    /**
 * Update user details by Admin.
 *
 * @param  \Illuminate\Http\Request  $request
 * @param  int  $id
 * @return \Illuminate\Http\JsonResponse
 */
public function updateUserByAdmin(Request $request, $id)
{
    // Find the user by ID
    $user = User::findOrFail($id);

    // Update fields
    if ($request->filled('name')) {
        $user->name = $request->name;
    }
    if ($request->filled('email')) {
        $user->email = $request->email;
    }
    if ($request->filled('password')) {
        $user->password = Hash::make($request->password);
    }
    if ($request->hasFile('profile_image')) {
        if ($user->profile_image) {
            Cloudinary::destroy($user->profile_image);
        }
        $user->profile_image = $this->handleProfileImage($request->file('profile_image'));
    }
    if ($request->filled('location')) {
        $user->location = $request->location;
    }
    if ($request->filled('gender')) {
        $user->gender = $request->gender;
    }
    if ($request->filled('bio')) {
        $user->bio = $request->bio;
    }
    if ($request->filled('birth_date')) {
        $user->birth_date = $request->birth_date;
    }
    if ($request->filled('is_admin')) {
        $user->is_admin = $request->is_admin;
    }

    // Save the updated user
    $user->save();

    return response()->json([
        'message' => 'User updated successfully',
        'user' => $user,
    ]);
}

}
