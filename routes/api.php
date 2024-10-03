<?php

use App\Http\Controllers\Admin\CalendarController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Api\UserController as ApiUserController;
use App\Http\Controllers\Admin\EventController;
use App\Http\Controllers\Api\EventController as ApiEventController;
use App\Http\Controllers\Api\ForgetPasswordController;
use App\Http\Controllers\TranslationController;
use App\Http\Controllers\Api\PointsController;
use App\Http\Controllers\Api\BusController;
use App\Http\Controllers\Api\ExampleController;
use App\Http\Controllers\Api\NotificationController;
use App\Http\Controllers\Admin\CategoryController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->get('/bus/{busId}/points', [BusController::class, 'getBusPoints']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('user', [ApiUserController::class, 'view']);
    Route::put('user', [ApiUserController::class, 'update']); // PUT method for updating
    Route::get('/notifications', [NotificationController::class, 'getNotifications']);
    Route::post('user/{user}/profile-image', [ApiUserController::class, 'uploadProfileImage']);

        // // New route to fetch buses for a specific event
        // Route::get('/buses', [BusController::class, 'index']); // Fetch all buses
        // Route::get('/bus/{busId}/points', [BusController::class, 'getBusPoints']); // Get points for a bus
        // Route::get('/events/{eventId}/buses', [BusController::class, 'getBusesForEvent']); // Get buses for an event
    

});

Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

Route::get('/users', [UserController::class, 'index']);
Route::get('/users/{id}', [UserController::class, 'getUserById']);

Route::get('/events', [EventController::class, 'index']);
Route::get('/events/{id}', [EventController::class, 'show']);

// Updated routes for events
Route::get('/eventss', [ApiEventController::class, 'index']); // Fetch all events
Route::get('/eventsss', [ApiEventController::class, 'getFilteredEvents']); // Fetch filtered events by category

// New Route for filtering, searching, and sorting events
// Route::get('/events/search', [ApiEventController::class, 'getAllEventsWithSearchAndFilter']); // New search, filter, and sort feature


Route::post('/send-reset-otp', [ForgetPasswordController::class, 'sendResetOtp']);
Route::post('/verify-otp', [ForgetPasswordController::class, 'verifyOtp']);
Route::post('/reset-password', [ForgetPasswordController::class, 'resetPassword']);

Route::post('/admin/events/{eventId}/attend', [EventController::class, 'attendEvent']);
Route::get('/events/{eventId}/attendees-count', [EventController::class, 'getEventAttendeesCount']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('events/{id}/attend', [EventController::class, 'attendEvent']);
});

Route::middleware('auth:sanctum')->get('user/events', [UserController::class, 'getUserEvents']);

Route::get('/trigger-error', [ExampleController::class, 'triggerError']);

Route::get('/buses', [BusController::class, 'index']);
// Route::get('/bus/{busId}/points', [BusController::class, 'getBusPoints']);
Route::get('/buses/{id}', [BusController::class, 'show']);
Route::get('buses/{id}/driver', [BusController::class, 'getDriver']);
Route::get('buses/{id}/points', [BusController::class, 'getBusPoints']);

Route::get('/eventssearch', [ApiEventController::class, 'getAllEventsWithSearchAndFilter']); // Search, filter, and sort events

Route::get('/categories', [CategoryController::class, 'getAllCategories']);
