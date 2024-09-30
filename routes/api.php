<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\EventController;
use App\Http\Controllers\Api\UserController as ApiUserController;
use App\Http\Controllers\Api\ForgetPasswordController;
use App\Http\Controllers\TranslationController;
use App\Http\Controllers\Api\PointsController;
use App\Http\Controllers\Api\BusController;




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
    Route::put('/user', [ApiUserController::class, 'update']); // PUT method for updating
    

});
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

Route::get('/users', [UserController::class, 'index']);
Route::get('/users/{id}', [UserController::class, 'getUserById']);

Route::get('/events', [EventController::class, 'index']);
Route::get('/events/{id}', [EventController::class, 'show']);


Route::post('/send-reset-otp', [ForgetPasswordController::class, 'sendResetOtp']);
Route::post('/verify-otp', [ForgetPasswordController::class, 'verifyOtp']);
Route::post('/reset-password', [ForgetPasswordController::class, 'resetPassword']);

Route::post('/verify-otp', [ForgetPasswordController::class, 'verifyOtp']);
Route::post('/reset-password', [ForgetPasswordController::class, 'resetPassword']);
Route::post('/register', [AuthController::class, 'register']);

Route::post('/translate', [TranslationController::class, 'translate']);


use App\Http\Controllers\Api\ExampleController;

Route::get('/trigger-error', [ExampleController::class, 'triggerError']);
