<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Admin\EventController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\BusController;
use App\Http\Controllers\Admin\PointController;
use App\Http\Controllers\Admin\DriverController;
use App\Http\Controllers\TranslationController;
use App\Http\Controllers\Admin\CalendarController;


use APP\Mail\ResetOtpMail;
use illuminate\support\Facades\Mail;
use App\Mail\RegistrationSuccessMail;
use App\Models\User;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Display login page
Route::get('/', function () {
    return view('admin.login');
});

// Translation
Route::post('/translate', [TranslationController::class, 'translate'])->name('translate');

// Admin login routes
Route::get('/admin/login', [AdminController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [AdminController::class, 'login'])->name('admin.login.post');

// Protect routes with 'admin' middleware
Route::middleware('admin')->prefix('admin')->name('admin.')->group(function () {

    // Dashboard route
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard'); // Updated this line

     // Calendar route
     Route::get('/calendar', [CalendarController::class, 'index'])->name('calendar.index'); // Add this line for the calendar route

    // Define the route for showing a specific point
    Route::get('/admin/points/{id}', [PointController::class, 'show'])->name('admin.points.show');
    
    // User routes (resourceful)
    Route::resource('users', UserController::class);

    // Event routes (resourceful)
    Route::resource('events', EventController::class);

    Route::resource('categories', CategoryController::class);

    // Bus routes (resourceful)
    Route::resource('buses', BusController::class);

    Route::resource('buses.points', PointController::class)->shallow(); // nested resource

    Route::resource('drivers', DriverController::class);

    Route::get(('/'), function () {
        $otp = rand(100000, 999999);
        Mail::to('zeiadmagdy2019@gmail.com')->send(new ResetOtpMail($otp));
    });

    Route::get('/', function () {
        // Assuming you have a user with this email in your database
        $user = User::first();
        Mail::to('zeiadmagdy2019@gmail.com')->send(new RegistrationSuccessMail($user));
        return 'Email sent!';
    });



});

