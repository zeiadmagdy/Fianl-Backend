<?php

namespace App\Http\Controllers\Api;

use App\Models\User; // Make sure this is present
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Api\UserRequest;
use App\Http\Resources\UserResource;
use \Illuminate\Support\Facades\Facade;

class UserController extends Controller
{
    public function view()
    {
        $user = auth()->user();

        return new UserResource($user);
    }

    public function update(UserRequest $request)
    {
        $user = auth()->user();
        $data = $request->all();

        // Hash the password if provided
        if (isset($data['password'])) {
            $data['password'] = bcrypt($data['password']);
        }

        /** @var \App\Models\User $user */
        // Update the user
        $user->update($data);

        return new UserResource($user);
    }


}


