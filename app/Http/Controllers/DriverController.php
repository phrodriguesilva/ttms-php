<?php

namespace App\Http\Controllers;

use App\Models\Driver;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class DriverController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $query = Driver::query();

        // Filtro de busca por nome, CNH, email
        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('license_number', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        // Filtro por status
        if ($request->filled('status')) {
            $query->where('status', $request->get('status'));
        }

        // Ordenação
        $sortField = $request->get('sort', 'name');
        $sortDirection = $request->get('direction', 'asc');

        // Validar campos de ordenação
        $allowedSortFields = ['name', 'license_number', 'license_expiry', 'email', 'status'];
        $sortField = in_array($sortField, $allowedSortFields) ? $sortField : 'name';
        $sortDirection = in_array(strtolower($sortDirection), ['asc', 'desc']) ? $sortDirection : 'asc';

        $drivers = $query->orderBy($sortField, $sortDirection)
                         ->paginate(10)
                         ->withQueryString(); // Preservar parâmetros da query

        // Adicionar informações de status
        $drivers->each(function($driver) {
            $driver->status_color = $driver->status === 'active' ? 'success' : 'danger';
            $driver->status_text = $driver->status === 'active' ? 'Ativo' : 'Inativo';
        });

        return view('drivers.index', compact('drivers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('drivers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'license_number' => 'required|string|max:50|unique:drivers',
            'license_expiry' => 'required|date|after:today',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|unique:drivers',
            'address' => 'required|string',
            'status' => 'required|in:active,inactive',
            'emergency_contact' => 'nullable|string|max:255',
            'emergency_phone' => 'nullable|string|max:20',
            'notes' => 'nullable|string'
        ]);

        Driver::create($validated);

        return redirect()
            ->route('drivers.index')
            ->with('success', 'Motorista cadastrado com sucesso!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Driver $driver): View
    {
        return view('drivers.create', compact('driver'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Driver $driver): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'license_number' => 'required|string|max:50|unique:drivers,license_number,' . $driver->id,
            'license_expiry' => 'required|date|after:today',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|unique:drivers,email,' . $driver->id,
            'address' => 'required|string',
            'status' => 'required|in:active,inactive',
            'emergency_contact' => 'nullable|string|max:255',
            'emergency_phone' => 'nullable|string|max:20',
            'notes' => 'nullable|string'
        ]);

        $driver->update($validated);

        return redirect()
            ->route('drivers.index')
            ->with('success', 'Motorista atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Driver $driver): RedirectResponse
    {
        $driver->delete();

        return redirect()
            ->route('drivers.index')
            ->with('success', 'Motorista excluído com sucesso!');
    }
}
