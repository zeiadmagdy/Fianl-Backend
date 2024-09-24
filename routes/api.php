<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\EventController;

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

Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
Route::get('/users/{id}', [UserController::class, 'getUserById']);

Route::get('/events', [EventController::class, 'index'])->middleware('auth:sanctum');
Route::get('/events/{id}', [EventController::class, 'show'])->middleware('auth:sanctum');
Route::post('/events', [EventController::class, 'store'])->name('events.create')->middleware('auth:sanctum');
Route::post('/events/{id}', [EventController::class, 'update'])->name('events.update')->middleware('auth:sanctum');
Route::delete('/events/{id}', [EventController::class, 'destroy'])->middleware('auth:sanctum');
