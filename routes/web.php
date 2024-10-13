<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Admin\EventController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\BusController;
use App\Http\Controllers\Api\BusController as ApiBusController;

use App\Http\Controllers\Admin\PointController;
use App\Http\Controllers\Admin\DriverController;
use App\Http\Controllers\Admin\CalendarController;
use App\Mail\ResetOtpMail;
use Illuminate\Support\Facades\Mail;
use App\Mail\RegistrationSuccessMail;
use App\Models\User;
use App\Http\Controllers\Payment\CreditController;
use App\Http\Controllers\Admin\ImageCreationController;


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
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Calendar route
    Route::get('/calendar', [CalendarController::class, 'index'])->name('calendar.index');

    // User routes (resourceful)
    Route::resource('users', UserController::class);

    // Event routes (resourceful)
    Route::resource('events', EventController::class);

    // Attendees list for an event (for popup)
    Route::get('events/{event}/attendees', [EventController::class, 'getEventAttendees'])->name('events.attendees');

    // Route to filter events by category and search by name/date
    Route::get('events/filter', [EventController::class, 'filterEvents'])->name('events.filter');

    // Category routes (resourceful)
    Route::resource('categories', CategoryController::class);

    // Bus routes (resourceful)
    Route::resource('buses', BusController::class);
    Route::resource('buses.points', PointController::class)->shallow(); // nested resource
    Route::get('buses/{id}/download-pdf', [ApiBusController::class, 'downloadPdf'])->name('buses.downloadPdf'); // Ensure this route is defined


    // Driver routes (resourceful)
    Route::resource('drivers', DriverController::class);

    // Email sending routes for OTP and registration success
    Route::get('/send-otp', function () {
        $otp = rand(100000, 999999);
        Mail::to('zeiadmagdy2019@gmail.com')->send(new ResetOtpMail($otp));
        return 'OTP email sent!';
    })->name('send.otp');

    Route::get('/send-registration-mail', function () {
        $user = User::first(); // Assuming you have a user in your database
        Mail::to('zeiadmagdy2019@gmail.com')->send(new RegistrationSuccessMail($user));
        return 'Registration success email sent!';
    })->name('send.registration.mail');

    // Image Creation Routes
// Image Creation Routes
Route::get('image-creation', [ImageCreationController::class, 'index'])->name('image_creation.index');
Route::get('image-creation/create', [ImageCreationController::class, 'create'])->name('image_creation.create'); // Adding create route
Route::post('image-creation', [ImageCreationController::class, 'store'])->name('image_creation.store');
});
// paymob
Route::get('/checkout', function () {
    return view('payment.checkout');
});
Route::post('/credit', [CreditController::class, 'credit'])->name('credit');
Route::get('/callback', [CreditController::class, 'callback'])->name('callback');

//Subscriptions
Route::post('/subscribe', 'SubscriptionController@subscribe')->name('subscribe');
