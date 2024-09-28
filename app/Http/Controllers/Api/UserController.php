<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\UserRequest;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;

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


        // Update the user
        $user->update($data);

        return new UserResource($user);
    }

}


