<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use App\Models\Booking;
use App\Models\Driver;
use App\Models\Supply;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        try {
            $activeVehicles = Vehicle::where('status', 'active')->count();
            $monthlyBookings = Booking::whereMonth('created_at', Carbon::now()->month)->count();
            $availableDrivers = Driver::where('status', 'available')->count();
            $suppliesInStock = Supply::where('stock_quantity', '>', 0)->count();

            $recentBookings = Booking::with(['client', 'vehicle'])
                ->orderBy('created_at', 'desc')
                ->take(5)
                ->get();

            $vehicleStatus = Vehicle::orderBy('updated_at', 'desc')
                ->take(5)
                ->get();

            return view('dashboard.index', compact(
                'activeVehicles',
                'monthlyBookings',
                'availableDrivers',
                'suppliesInStock',
                'recentBookings',
                'vehicleStatus'
            ));
        } catch (\Exception $e) {
            // Log the error for debugging
            \Log::error('Dashboard Error: ' . $e->getMessage());
            
            // Return view with empty data
            return view('dashboard.index', [
                'activeVehicles' => 0,
                'monthlyBookings' => 0,
                'availableDrivers' => 0,
                'suppliesInStock' => 0,
                'recentBookings' => collect(),
                'vehicleStatus' => collect()
            ]);
        }
    }
}
