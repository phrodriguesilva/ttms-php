<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use App\Models\Booking;
use Illuminate\Http\Request;
use Carbon\Carbon;

class VehicleAvailabilityController extends Controller
{
    public function checkAvailability(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'service_type' => 'required|string'
        ]);

        $startDate = Carbon::parse($request->start_date);
        $endDate = Carbon::parse($request->end_date);

        // Buscar veículos disponíveis
        $availableVehicles = Vehicle::whereDoesntHave('bookings', function ($query) use ($startDate, $endDate) {
            $query->where(function ($q) use ($startDate, $endDate) {
                $q->whereBetween('start_date', [$startDate, $endDate])
                  ->orWhereBetween('end_date', [$startDate, $endDate])
                  ->orWhere(function ($q) use ($startDate, $endDate) {
                      $q->where('start_date', '<=', $startDate)
                        ->where('end_date', '>=', $endDate);
                  });
            });
        })
        ->where('status', 'active')
        ->get()
        ->map(function ($vehicle) {
            return [
                'id' => $vehicle->id,
                'name' => $vehicle->year . ' ' . $vehicle->make . ' ' . $vehicle->model,
                'license_plate' => $vehicle->license_plate
            ];
        });

        return response()->json([
            'vehicles' => $availableVehicles
        ]);
    }
}
