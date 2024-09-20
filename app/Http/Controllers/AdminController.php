<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use app\Models\User;
class AdminController extends Controller
{
    // Show the login form for admin
    public function showLoginForm()
    {
        return view('admin.login');
    }

    // Handle admin login
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials) && Auth::user()->is_admin) {
            return redirect()->intended('admin/dashboard');
        }

        return redirect('admin/login')->withErrors('Login details are not valid or you do not have admin access.');
    }

    // Display admin dashboard
    public function dashboard()
    {
        return view('admin.dashboard');
        
    }

    public function users()
{
    $users = User::all();
    return view('admin.users', compact('users'));
}



//     public function dashboard()
// {
//     $userCount = User::count();
//     $eventCount = Event::count();

//     return view('admin.dashboard', compact('userCount', 'eventCount'));
// }

}
