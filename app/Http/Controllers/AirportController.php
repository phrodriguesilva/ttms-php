<?php

namespace App\Http\Controllers;

use App\Models\Airport;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class AirportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Airport::query();

        // Search by name or code
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('code', 'like', "%{$search}%");
            });
        }

        // Filter by state
        if ($request->filled('state')) {
            $query->where('state', $request->input('state'));
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        // Sorting
        $sortField = $request->input('sort', 'name');
        $sortDirection = $request->input('direction', 'asc');
        
        // Validate sort field to prevent SQL injection
        $allowedSortFields = ['name', 'code', 'city', 'state', 'country', 'status'];
        $sortField = in_array($sortField, $allowedSortFields) ? $sortField : 'name';
        $sortDirection = in_array(strtolower($sortDirection), ['asc', 'desc']) ? $sortDirection : 'asc';

        $query->orderBy($sortField, $sortDirection);

        $airports = $query->paginate(10);

        return view('airports.index', compact('airports'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('airports.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|unique:airports,code',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'status' => 'in:active,inactive',
        ]);

        $airport = Airport::create($validatedData);

        return redirect()->route('airports.index')
            ->with('success', 'Airport created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Airport $airport)
    {
        return view('airports.edit', compact('airport'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Airport $airport)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|unique:airports,code,' . $airport->id,
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'status' => 'in:active,inactive',
        ]);

        $airport->update($validatedData);

        return redirect()->route('airports.index')
            ->with('success', 'Airport updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Airport $airport)
    {
        $airport->delete();

        return redirect()->route('airports.index')
            ->with('success', 'Airport deleted successfully.');
    }

    /**
     * Display a listing of the resource in JSON format.
     */
    public function indexJson(): JsonResponse
    {
        $airports = Airport::all();
        return response()->json($airports);
    }

    /**
     * Store a newly created resource in storage in JSON format.
     */
    public function storeJson(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'code' => 'required|unique:airports,code',
            'name' => 'required|string|max:255',
            'city' => 'required|string|max:255',
        ]);

        $airport = Airport::create($validated);
        return response()->json($airport, 201);
    }

    /**
     * Display the specified resource in JSON format.
     */
    public function showJson(Airport $airport): JsonResponse
    {
        return response()->json($airport);
    }

    /**
     * Update the specified resource in storage in JSON format.
     */
    public function updateJson(Request $request, Airport $airport): JsonResponse
    {
        $validated = $request->validate([
            'code' => 'sometimes|unique:airports,code,' . $airport->id,
            'name' => 'sometimes|string|max:255',
            'city' => 'sometimes|string|max:255',
        ]);

        $airport->update($validated);
        return response()->json($airport);
    }

    /**
     * Remove the specified resource from storage in JSON format.
     */
    public function destroyJson(Airport $airport): JsonResponse
    {
        $airport->delete();
        return response()->json(null, 204);
    }
}
