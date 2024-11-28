<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Client;
use App\Models\Vehicle;
use App\Models\Driver;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Carbon\Carbon;

class BookingController extends Controller
{
    /**
     * Display a listing of bookings
     */
    public function index(Request $request): View
    {
        $query = Booking::with(['client', 'vehicle', 'driver']);

        // Apply status filter
        if ($request->has('status') && $request->get('status')) {
            $query->where('status', $request->get('status'));
        }

        // Apply date range filter
        if ($request->has('date_from') && $request->get('date_from')) {
            $query->where('start_date', '>=', Carbon::parse($request->get('date_from')));
        }
        if ($request->has('date_to') && $request->get('date_to')) {
            $query->where('end_date', '<=', Carbon::parse($request->get('date_to')));
        }

        // Apply search filter
        if ($request->has('search')) {
            $search = $request->get('search');
            $query->whereHas('client', function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            })->orWhereHas('vehicle', function($q) use ($search) {
                $q->where('plate', 'like', "%{$search}%")
                  ->orWhere('model', 'like', "%{$search}%");
            });
        }

        $bookings = $query->orderBy('start_date', 'desc')->paginate(10);

        return view('bookings.index', compact('bookings'));
    }

    /**
     * Show form to create a new booking
     */
    public function create(): View
    {
        $clients = Client::orderBy('name')->get();
        $vehicles = Vehicle::where('status', 'active')->orderBy('model')->get();
        $drivers = Driver::where('status', 'available')->orderBy('name')->get();

        return view('bookings.create', compact('clients', 'vehicles', 'drivers'));
    }

    /**
     * Store a new booking
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'client_id' => 'required|exists:clients,id',
            'vehicle_id' => 'required|exists:vehicles,id',
            'driver_id' => 'required|exists:drivers,id',
            'start_date' => 'required|date|after:today',
            'end_date' => 'required|date|after:start_date',
            'pickup_location' => 'required|string|max:255',
            'dropoff_location' => 'required|string|max:255',
            'status' => 'required|string|in:pending,confirmed,in_progress,completed,cancelled',
            'payment_status' => 'required|string|in:pending,paid,partially_paid,refunded',
            'total_amount' => 'required|numeric|min:0',
            'notes' => 'nullable|string',
            'special_requirements' => 'nullable|string'
        ]);

        // Convert dates to Carbon instances
        $validated['start_date'] = Carbon::parse($validated['start_date']);
        $validated['end_date'] = Carbon::parse($validated['end_date']);

        // Check if vehicle is available for the selected date range
        $conflictingBooking = Booking::where('vehicle_id', $validated['vehicle_id'])
            ->where('status', '!=', 'cancelled')
            ->where(function($query) use ($validated) {
                $query->whereBetween('start_date', [$validated['start_date'], $validated['end_date']])
                    ->orWhereBetween('end_date', [$validated['start_date'], $validated['end_date']]);
            })->first();

        if ($conflictingBooking) {
            return back()
                ->withInput()
                ->withErrors(['vehicle_id' => 'O veículo selecionado não está disponível neste período.']);
        }

        // Check if driver is available for the selected date range
        $conflictingDriver = Booking::where('driver_id', $validated['driver_id'])
            ->where('status', '!=', 'cancelled')
            ->where(function($query) use ($validated) {
                $query->whereBetween('start_date', [$validated['start_date'], $validated['end_date']])
                    ->orWhereBetween('end_date', [$validated['start_date'], $validated['end_date']]);
            })->first();

        if ($conflictingDriver) {
            return back()
                ->withInput()
                ->withErrors(['driver_id' => 'O motorista selecionado não está disponível neste período.']);
        }

        Booking::create($validated);

        return redirect()
            ->route('bookings.index')
            ->with('success', 'Reserva criada com sucesso.');
    }

    /**
     * Show booking details
     */
    public function show(Booking $booking): View
    {
        $booking->load(['client', 'vehicle', 'driver']);
        return view('bookings.show', compact('booking'));
    }

    /**
     * Show form to edit a booking
     */
    public function edit(Booking $booking): View
    {
        $clients = Client::orderBy('name')->get();
        $vehicles = Vehicle::where('status', 'active')->orderBy('model')->get();
        $drivers = Driver::where('status', 'available')->orderBy('name')->get();

        return view('bookings.edit', compact('booking', 'clients', 'vehicles', 'drivers'));
    }

    /**
     * Update booking details
     */
    public function update(Request $request, Booking $booking)
    {
        $validated = $request->validate([
            'client_id' => 'required|exists:clients,id',
            'vehicle_id' => 'required|exists:vehicles,id',
            'driver_id' => 'required|exists:drivers,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'pickup_location' => 'required|string|max:255',
            'dropoff_location' => 'required|string|max:255',
            'status' => 'required|string|in:pending,confirmed,in_progress,completed,cancelled',
            'payment_status' => 'required|string|in:pending,paid,partially_paid,refunded',
            'total_amount' => 'required|numeric|min:0',
            'notes' => 'nullable|string',
            'special_requirements' => 'nullable|string'
        ]);

        // Convert dates to Carbon instances
        $validated['start_date'] = Carbon::parse($validated['start_date']);
        $validated['end_date'] = Carbon::parse($validated['end_date']);

        // Check for vehicle availability only if vehicle or dates changed
        if ($booking->vehicle_id != $validated['vehicle_id'] || 
            $booking->start_date != $validated['start_date'] || 
            $booking->end_date != $validated['end_date']) {
            
            $conflictingBooking = Booking::where('vehicle_id', $validated['vehicle_id'])
                ->where('id', '!=', $booking->id)
                ->where('status', '!=', 'cancelled')
                ->where(function($query) use ($validated) {
                    $query->whereBetween('start_date', [$validated['start_date'], $validated['end_date']])
                        ->orWhereBetween('end_date', [$validated['start_date'], $validated['end_date']]);
                })->first();

            if ($conflictingBooking) {
                return back()
                    ->withInput()
                    ->withErrors(['vehicle_id' => 'O veículo selecionado não está disponível neste período.']);
            }
        }

        // Check for driver availability only if driver or dates changed
        if ($booking->driver_id != $validated['driver_id'] || 
            $booking->start_date != $validated['start_date'] || 
            $booking->end_date != $validated['end_date']) {
            
            $conflictingDriver = Booking::where('driver_id', $validated['driver_id'])
                ->where('id', '!=', $booking->id)
                ->where('status', '!=', 'cancelled')
                ->where(function($query) use ($validated) {
                    $query->whereBetween('start_date', [$validated['start_date'], $validated['end_date']])
                        ->orWhereBetween('end_date', [$validated['start_date'], $validated['end_date']]);
                })->first();

            if ($conflictingDriver) {
                return back()
                    ->withInput()
                    ->withErrors(['driver_id' => 'O motorista selecionado não está disponível neste período.']);
            }
        }

        $booking->update($validated);

        return redirect()
            ->route('bookings.show', $booking)
            ->with('success', 'Reserva atualizada com sucesso.');
    }

    /**
     * Cancel a booking
     */
    public function destroy(Booking $booking)
    {
        $booking->update(['status' => 'cancelled']);
        
        return redirect()
            ->route('bookings.index')
            ->with('success', 'Reserva cancelada com sucesso.');
    }
}
