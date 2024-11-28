<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use App\Models\Booking;
use App\Models\Driver;
use App\Models\Supply;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
            // Estatísticas gerais
            $totalBookings = Booking::count();
            $activeVehicles = Vehicle::where('status', 'active')->count();
            $availableDrivers = Driver::where('status', 'available')->count();

            // Reservas recentes
            $recentBookings = Booking::with(['client'])
                ->orderBy('created_at', 'desc')
                ->take(5)
                ->get();

            // Dados para os gráficos
            $bookingsByStatus = Booking::select('status', DB::raw('count(*) as count'))
                ->groupBy('status')
                ->get()
                ->map(function ($item) {
                    return [
                        'status_text' => ucfirst($item->status),
                        'count' => $item->count
                    ];
                });

            $vehiclesByStatus = Vehicle::select('status', DB::raw('count(*) as count'))
                ->groupBy('status')
                ->get()
                ->map(function ($item) {
                    return [
                        'status_text' => ucfirst($item->status),
                        'count' => $item->count
                    ];
                });

            return view('dashboard.index', compact(
                'totalBookings',
                'activeVehicles',
                'availableDrivers',
                'recentBookings',
                'bookingsByStatus',
                'vehiclesByStatus'
            ));
        } catch (\Exception $e) {
            return back()->with('error', 'Erro ao carregar o dashboard: ' . $e->getMessage());
        }
    }
}
