<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\AdminController;
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

Route::post('admin/login', [AdminController::class, 'login']);

Route::middleware('admin')->group(function() {

    Route::get('admin/dashboard', [AdminController::class, 'dashboard']);
});

Route::get('admin/users', [AdminController::class, 'users']);

Route::delete('admin/users/{id}', [AdminController::class, 'deleteUser']);

Route::get('/admin/login', function () {
    return view('admin.login');
})->name('admin.login');

Route::get('/admin/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->name('admin.dashboard');

Route::resource('admin/events', EventController::class);
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    Route::resource('users', UserController::class);

    // Event routes
    Route::resource('events', EventController::class);
});