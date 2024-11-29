<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\DriverController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\SupplyController;
use App\Http\Controllers\AirportController;

Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('dashboard');
    }
    return redirect()->route('login');
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

    // Supply Management Routes
    Route::prefix('supplies')->group(function () {
        Route::get('/alerts', [SupplyController::class, 'alerts'])->name('supplies.alerts');
        Route::get('/reports', [SupplyController::class, 'reports'])->name('supplies.reports');
        Route::get('/categories', [SupplyController::class, 'categories'])->name('supplies.categories');
    });

    // Airports routes
    Route::resource('airports', AirportController::class);

    // Rota de teste para email
    Route::get('/test-email', function () {
        try {
            // Exibir configurações de email (sem senha)
            $config = [
                'driver' => config('mail.default'),
                'host' => config('mail.mailers.smtp.host'),
                'port' => config('mail.mailers.smtp.port'),
                'encryption' => config('mail.mailers.smtp.encryption'),
                'from_address' => config('mail.from.address'),
                'from_name' => config('mail.from.name'),
            ];
            
            \Log::info('Tentando enviar email com as configurações:', $config);
            
            Mail::raw('Teste de configuração de email - ' . now(), function($message) {
                $message->to('relter.borges@gmail.com')
                       ->subject('Teste de Email - ' . now());
            });
            
            \Log::info('Email enviado com sucesso');
            
            return [
                'status' => 'success',
                'message' => 'Comando de envio executado',
                'config' => $config,
                'time' => now()->toDateTimeString()
            ];
        } catch (\Exception $e) {
            \Log::error('Erro ao enviar email: ' . $e->getMessage());
            \Log::error($e->getTraceAsString());
            
            return [
                'status' => 'error',
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'time' => now()->toDateTimeString()
            ];
        }
    });
});
