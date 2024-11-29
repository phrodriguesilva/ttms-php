<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\DriverController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\PartController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\VehicleAvailabilityController;
use App\Http\Controllers\PriceCalculationController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Public routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Protected routes
Route::middleware('auth:sanctum')->group(function () {
    // Auth routes
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', [AuthController::class, 'user']);
    Route::post('/change-password', [AuthController::class, 'changePassword']);

    // Profile routes
    Route::prefix('profile')->group(function () {
        Route::get('/', [ProfileController::class, 'show']);
        Route::put('/', [ProfileController::class, 'update']);
        Route::put('/password', [ProfileController::class, 'updatePassword']);
        Route::put('/preferences', [ProfileController::class, 'updatePreferences']);
        Route::post('/email/verification-notification', [ProfileController::class, 'requestEmailVerification']);
    });

    // Admin only routes
    Route::middleware('role:admin')->group(function () {
        // User management would go here
        Route::post('/users', [AuthController::class, 'createUser']);
        Route::get('/users', [AuthController::class, 'listUsers']);
        Route::delete('/users/{user}', [AuthController::class, 'deleteUser']);
    });

    // Admin and Manager routes
    Route::middleware('role:admin,manager')->group(function () {
        // Vehicle management
        Route::post('/vehicles', [VehicleController::class, 'store']);
        Route::put('/vehicles/{vehicle}', [VehicleController::class, 'update']);
        Route::delete('/vehicles/{vehicle}', [VehicleController::class, 'destroy']);

        // Driver management
        Route::post('/drivers', [DriverController::class, 'store']);
        Route::put('/drivers/{driver}', [DriverController::class, 'update']);
        Route::delete('/drivers/{driver}', [DriverController::class, 'destroy']);

        // Parts inventory management
        Route::post('/parts', [PartController::class, 'store']);
        Route::put('/parts/{part}', [PartController::class, 'update']);
        Route::delete('/parts/{part}', [PartController::class, 'destroy']);
        Route::patch('/parts/{part}/adjust-stock', [PartController::class, 'adjustStock']);
    });

    // Routes accessible by all authenticated users
    // Vehicle routes
    Route::get('/vehicles', [VehicleController::class, 'index']);
    Route::get('/vehicles/{vehicle}', [VehicleController::class, 'show']);
    Route::get('/vehicles/{vehicle}/bookings', [VehicleController::class, 'bookings']);
    Route::post('/vehicle-availability', [VehicleAvailabilityController::class, 'checkAvailability']);

    // Driver routes
    Route::get('/drivers', [DriverController::class, 'index']);
    Route::get('/drivers/{driver}', [DriverController::class, 'show']);
    Route::get('/drivers/{driver}/bookings', [DriverController::class, 'bookings']);

    // Client routes
    Route::apiResource('clients', ClientController::class);
    Route::get('/clients/{client}/bookings', [ClientController::class, 'bookings']);

    // Booking routes
    Route::apiResource('bookings', BookingController::class);
    Route::patch('/bookings/{booking}/status', [BookingController::class, 'updateStatus']);
    Route::patch('/bookings/{booking}/payment', [BookingController::class, 'updatePaymentStatus']);

    // Parts routes
    Route::get('/parts', [PartController::class, 'index']);
    Route::get('/parts/{part}', [PartController::class, 'show']);
    Route::get('/parts/low-stock', [PartController::class, 'lowStock']);

    // Price calculation route
    Route::post('/calculate-price', [PriceCalculationController::class, 'calculate']);

    // Notification routes
    Route::prefix('notifications')->group(function () {
        Route::get('/', [NotificationController::class, 'index']);
        Route::get('/unread-count', [NotificationController::class, 'unreadCount']);
        Route::post('/{notification}/mark-as-read', [NotificationController::class, 'markAsRead']);
        Route::post('/{notification}/mark-as-unread', [NotificationController::class, 'markAsUnread']);
        Route::post('/mark-all-as-read', [NotificationController::class, 'markAllAsRead']);
        Route::delete('/{notification}', [NotificationController::class, 'destroy']);
        Route::delete('/clear-all', [NotificationController::class, 'clearAll']);
    });
});
