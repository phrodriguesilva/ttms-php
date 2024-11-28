<?php

namespace App\Http\Controllers;

use App\Models\Driver;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class DriverController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $drivers = Driver::with(['bookings'])->get();
        return response()->json($drivers);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'license_number' => 'required|string|max:50|unique:drivers',
            'license_expiry' => 'required|date|after:today',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|unique:drivers',
            'address' => 'required|string',
            'status' => 'required|string|in:available,unavailable,on_trip',
            'notes' => 'nullable|string'
        ]);

        $driver = Driver::create($validated);
        return response()->json($driver, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Driver $driver): JsonResponse
    {
        $driver->load('bookings');
        return response()->json($driver);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Driver $driver): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'license_number' => 'sometimes|string|max:50|unique:drivers,license_number,' . $driver->id,
            'license_expiry' => 'sometimes|date|after:today',
            'phone' => 'sometimes|string|max:20',
            'email' => 'sometimes|email|unique:drivers,email,' . $driver->id,
            'address' => 'sometimes|string',
            'status' => 'sometimes|string|in:available,unavailable,on_trip',
            'notes' => 'nullable|string'
        ]);

        $driver->update($validated);
        return response()->json($driver);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Driver $driver): JsonResponse
    {
        $driver->delete();
        return response()->json(null, 204);
    }

    /**
     * Get all bookings for a specific driver.
     */
    public function bookings(Driver $driver): JsonResponse
    {
        $bookings = $driver->bookings()
            ->with(['vehicle', 'client'])
            ->orderBy('start_date', 'desc')
            ->get();
            
        return response()->json($bookings);
    }
}
