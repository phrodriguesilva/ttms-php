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
            $pendingBookings = Booking::where('status', 'pending')->count();
            $activeVehicles = Vehicle::where('status', 'active')->count();
            $totalVehicles = Vehicle::count();
            $availableDrivers = Driver::where('status', 'available')->count();
            $totalDrivers = Driver::count();

            // Faturamento mensal
            $startOfMonth = Carbon::now()->startOfMonth();
            $endOfMonth = Carbon::now()->endOfMonth();
            $monthlyRevenue = Booking::whereBetween('start_date', [$startOfMonth, $endOfMonth])
                ->where('status', 'completed')
                ->sum('total_amount');
            $completedBookingsThisMonth = Booking::whereBetween('start_date', [$startOfMonth, $endOfMonth])
                ->where('status', 'completed')
                ->count();

            // Reservas por status
            $bookingsByStatus = Booking::select('status', DB::raw('count(*) as count'))
                ->groupBy('status')
                ->get()
                ->map(function ($item) {
                    return [
                        'status_text' => ucfirst($item->status),
                        'count' => $item->count
                    ];
                });

            // Próximas reservas
            $upcomingBookings = Booking::with(['client', 'vehicle'])
                ->where('start_date', '>=', Carbon::now())
                ->where('status', 'confirmed')
                ->orderBy('start_date')
                ->limit(5)
                ->get();

            return view('dashboard.index', compact(
                'totalBookings',
                'pendingBookings',
                'activeVehicles',
                'totalVehicles',
                'availableDrivers',
                'totalDrivers',
                'monthlyRevenue',
                'completedBookingsThisMonth',
                'bookingsByStatus',
                'upcomingBookings'
            ));
        } catch (\Exception $e) {
            return back()->with('error', 'Erro ao carregar o dashboard: ' . $e->getMessage());
        }
    }
}
