<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\View\View;

class VehicleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $query = Vehicle::query();

        // Apply search filter
        if ($request->has('search')) {
            $search = $request->get('search');
            $query->where(function($q) use ($search) {
                $q->where('license_plate', 'like', "%{$search}%")
                  ->orWhere('model', 'like', "%{$search}%")
                  ->orWhere('make', 'like', "%{$search}%");
            });
        }

        // Apply status filter
        if ($request->has('status') && $request->get('status')) {
            $query->where('status', $request->get('status'));
        }

        $vehicles = $query->orderBy('updated_at', 'desc')
                         ->paginate(10);

        // Add status color for badges
        $vehicles->each(function($vehicle) {
            $vehicle->status_color = match($vehicle->status) {
                'available' => 'success',
                'maintenance' => 'warning',
                'booked' => 'danger',
                'out_of_service' => 'danger',
                default => 'secondary'
            };
        });

        return view('vehicles.index', compact('vehicles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('vehicles.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'make' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'year' => 'required|integer|min:1900|max:' . (date('Y') + 1),
            'license_plate' => 'required|string|max:20|unique:vehicles',
            'vin' => 'required|string|max:17|unique:vehicles',
            'status' => 'required|string|in:available,maintenance,booked,out_of_service',
            'mileage' => 'required|numeric|min:0',
            'fuel_type' => 'required|string|max:50',
            'last_maintenance' => 'nullable|date',
            'next_maintenance' => 'nullable|date|after:last_maintenance',
            'notes' => 'nullable|string'
        ]);

        Vehicle::create($validated);

        return redirect()
            ->route('vehicles.index')
            ->with('success', 'Veículo criado com sucesso.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Vehicle $vehicle): View
    {
        $vehicle->load('bookings.client', 'bookings.driver');
        return view('vehicles.show', compact('vehicle'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Vehicle $vehicle): View
    {
        return view('vehicles.edit', compact('vehicle'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Vehicle $vehicle)
    {
        $validated = $request->validate([
            'make' => 'sometimes|string|max:255',
            'model' => 'sometimes|string|max:255',
            'year' => 'sometimes|integer|min:1900|max:' . (date('Y') + 1),
            'license_plate' => 'sometimes|string|max:20|unique:vehicles,license_plate,' . $vehicle->id,
            'vin' => 'sometimes|string|max:17|unique:vehicles,vin,' . $vehicle->id,
            'status' => 'sometimes|string|in:available,maintenance,booked,out_of_service',
            'mileage' => 'sometimes|numeric|min:0',
            'fuel_type' => 'sometimes|string|max:50',
            'last_maintenance' => 'nullable|date',
            'next_maintenance' => 'nullable|date|after:last_maintenance',
            'notes' => 'nullable|string'
        ]);

        $vehicle->update($validated);

        return redirect()
            ->route('vehicles.index')
            ->with('success', 'Veículo atualizado com sucesso.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Vehicle $vehicle)
    {
        $vehicle->delete();

        return redirect()
            ->route('vehicles.index')
            ->with('success', 'Veículo excluído com sucesso.');
    }

    /**
     * Get all bookings for a specific vehicle.
     */
    public function bookings(Vehicle $vehicle): View
    {
        $bookings = $vehicle->bookings()
            ->with(['client', 'driver'])
            ->orderBy('start_date', 'desc')
            ->get();
            
        return view('vehicles.bookings', compact('vehicle', 'bookings'));
    }
}
