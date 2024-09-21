<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Admin\EventController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\DashboardController;

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

Route::get('/', function () {
    return view('admin.login');
});

Route::get('/admin/login', [AdminController::class, 'showLoginForm']);
Route::post('/admin/login', [AdminController::class, 'login']);

// Protect routes with 'admin' middleware
Route::middleware('admin')->prefix('admin')->name('admin.')->group(function () {
    
    // Dashboard route
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // User routes (resource)
    Route::resource('users', UserController::class);

    // Event routes (resource)
    Route::resource('events', EventController::class);
});
