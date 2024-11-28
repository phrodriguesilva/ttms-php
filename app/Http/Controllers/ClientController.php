<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $clients = Client::with(['bookings'])->get();
        return response()->json($clients);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:clients',
            'phone' => 'required|string|max:20',
            'address' => 'required|string',
            'document_type' => 'required|string|in:cpf,cnpj',
            'document_number' => 'required|string|unique:clients',
            'company_name' => 'nullable|string|max:255',
            'notes' => 'nullable|string'
        ]);

        $client = Client::create($validated);
        return response()->json($client, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Client $client): JsonResponse
    {
        $client->load('bookings');
        return response()->json($client);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Client $client): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'email' => 'sometimes|email|unique:clients,email,' . $client->id,
            'phone' => 'sometimes|string|max:20',
            'address' => 'sometimes|string',
            'document_type' => 'sometimes|string|in:cpf,cnpj',
            'document_number' => 'sometimes|string|unique:clients,document_number,' . $client->id,
            'company_name' => 'nullable|string|max:255',
            'notes' => 'nullable|string'
        ]);

        $client->update($validated);
        return response()->json($client);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Client $client): JsonResponse
    {
        $client->delete();
        return response()->json(null, 204);
    }

    /**
     * Get all bookings for a specific client.
     */
    public function bookings(Client $client): JsonResponse
    {
        $bookings = $client->bookings()
            ->with(['vehicle', 'driver'])
            ->orderBy('start_date', 'desc')
            ->get();
            
        return response()->json($bookings);
    }
}
