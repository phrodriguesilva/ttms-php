<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Client;
use App\Models\Vehicle;
use App\Models\Driver;
use App\Http\Requests\BookingRequest;
use App\Services\BookingService;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Carbon\Carbon;

class BookingController extends Controller
{
    protected $bookingService;

    public function __construct(BookingService $bookingService)
    {
        $this->bookingService = $bookingService;
    }

    /**
     * Display a listing of bookings
     */
    public function index(Request $request): View
    {
        $query = Booking::with(['client', 'vehicle', 'driver']);

        // Apply status filter
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Apply date range filter
        if ($request->filled('date_from')) {
            $query->where('start_date', '>=', Carbon::parse($request->date_from));
        }

        if ($request->filled('date_to')) {
            $query->where('end_date', '<=', Carbon::parse($request->date_to));
        }

        // Apply search filter
        if ($request->filled('search')) {
            $search = $request->search;
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
        $validatedData = $request->validate([
            'client_id' => 'required|exists:clients,id',
            'vehicle_id' => 'required|exists:vehicles,id',
            'driver_id' => 'required|exists:drivers,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'pickup_location' => 'required|string',
            'dropoff_location' => 'required|string',
            'service_type' => 'required|string',
            'payment_method' => 'required|string',
            'payment_status' => 'required|string',
            'price_type' => 'required|in:auto,manual',
            'passengers' => 'required|integer|min:1',
            // Campos opcionais
            'distance' => 'nullable|numeric|min:0',
            'hours' => 'nullable|numeric|min:1',
            'days' => 'nullable|numeric|min:1',
            'base_rate' => 'nullable|numeric|min:0',
            'additional_charges' => 'nullable|numeric|min:0',
            'discount' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string',
            'special_requirements' => 'nullable|string'
        ]);

        // Calcular o valor total
        $totalAmount = 0;

        if ($request->price_type === 'auto') {
            // Usar o serviço de cálculo de preço
            $priceCalculator = new PriceCalculationController();
            $priceResponse = $priceCalculator->calculate($request);
            $totalAmount = str_replace(['.', ','], ['', '.'], $priceResponse->getData()->final_price);
        } else {
            // Usar valores manuais
            $totalAmount = ($request->base_rate ?? 0) + ($request->additional_charges ?? 0) - ($request->discount ?? 0);
        }

        // Criar a reserva
        $booking = Booking::create([
            'client_id' => $validatedData['client_id'],
            'vehicle_id' => $validatedData['vehicle_id'],
            'driver_id' => $validatedData['driver_id'],
            'start_date' => $validatedData['start_date'],
            'end_date' => $validatedData['end_date'],
            'pickup_location' => $validatedData['pickup_location'],
            'dropoff_location' => $validatedData['dropoff_location'],
            'service_type' => $validatedData['service_type'],
            'payment_method' => $validatedData['payment_method'],
            'payment_status' => $validatedData['payment_status'],
            'total_amount' => $totalAmount,
            'status' => 'pending',
            'notes' => $request->notes,
            'special_requirements' => $request->special_requirements
        ]);

        // Registrar detalhes do cálculo
        if ($request->price_type === 'auto') {
            $booking->priceDetails()->create([
                'calculation_type' => 'auto',
                'service_type' => $validatedData['service_type'],
                'distance' => $request->distance,
                'hours' => $request->hours,
                'days' => $request->days,
                'passengers' => $validatedData['passengers']
            ]);
        } else {
            $booking->priceDetails()->create([
                'calculation_type' => 'manual',
                'base_rate' => $request->base_rate,
                'additional_charges' => $request->additional_charges,
                'discount' => $request->discount
            ]);
        }

        return redirect()->route('bookings.show', $booking)
            ->with('success', 'Reserva criada com sucesso!');
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
        $booking->load(['client', 'vehicle', 'driver']);
        $clients = Client::orderBy('name')->get();
        $vehicles = Vehicle::orderBy('model')->get();
        $drivers = Driver::orderBy('name')->get();

        return view('bookings.edit', compact('booking', 'clients', 'vehicles', 'drivers'));
    }

    /**
     * Update booking details
     */
    public function update(BookingRequest $request, Booking $booking)
    {
        try {
            $this->bookingService->update($booking, $request->validated());
            return redirect()->route('bookings.show', $booking)
                ->with('success', 'Reserva atualizada com sucesso!');
        } catch (\Exception $e) {
            return back()->withInput()
                ->with('error', 'Erro ao atualizar reserva: ' . $e->getMessage());
        }
    }

    /**
     * Cancel a booking
     */
    public function destroy(Booking $booking)
    {
        try {
            $booking->update(['status' => 'cancelled']);
            $this->bookingService->update($booking, ['status' => 'cancelled']);
            return redirect()->route('bookings.index')
                ->with('success', 'Reserva cancelada com sucesso!');
        } catch (\Exception $e) {
            return back()->with('error', 'Erro ao cancelar reserva: ' . $e->getMessage());
        }
    }
}
