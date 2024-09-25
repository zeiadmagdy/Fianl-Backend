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

// Admin login routes
Route::get('/admin/login', [AdminController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [AdminController::class, 'login'])->name('admin.login.post');

// Protect routes with 'admin' middleware
Route::middleware('admin')->prefix('admin')->name('admin.')->group(function () {

    // Dashboard route
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard'); // Updated this line

    // User routes (resourceful)
    Route::resource('users', UserController::class);

    // Event routes (resourceful)
    Route::resource('events', EventController::class);

    Route::resource('categories', CategoryController::class);

    // Bus routes (resourceful)
    Route::resource('buses', BusController::class);

    Route::resource('buses.points', PointController::class)->shallow(); // nested resource

    Route::resource('drivers', DriverController::class);

});
