<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\DriverController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\SupplyController;

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Auth::routes();

Route::middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');
    
    // Profile routes
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.show');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');

    // Vehicles routes
    Route::resource('vehicles', VehicleController::class);

    // Bookings routes
    Route::resource('bookings', BookingController::class);

    // Drivers routes
    Route::resource('drivers', DriverController::class);

    // Clients routes
    Route::resource('clients', ClientController::class);
    Route::post('/clients/import', [ClientController::class, 'import'])->name('clients.import');
    Route::get('/clients/export', [ClientController::class, 'export'])->name('clients.export');

    // Supplies routes
    Route::resource('supplies', SupplyController::class);
    Route::get('/supplies/generate-sku', [SupplyController::class, 'generateSku'])->name('supplies.generate-sku');
});
