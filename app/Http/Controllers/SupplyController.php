<?php

namespace App\Http\Controllers;

use App\Models\Supply;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SupplyController extends Controller
{
    /**
     * Display a listing of supplies
     */
    public function index(Request $request): View
    {
        $query = Supply::query();

        // Apply search filter
        if ($request->has('search')) {
            $search = $request->get('search');
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('code', 'like', "%{$search}%")
                  ->orWhere('category', 'like', "%{$search}%");
            });
        }

        // Apply category filter
        if ($request->has('category') && $request->get('category')) {
            $query->where('category', $request->get('category'));
        }

        $supplies = $query->orderBy('updated_at', 'desc')
                         ->paginate(10);

        return view('supplies.index', compact('supplies'));
    }

    /**
     * Show form to create a new supply
     */
    public function create(): View
    {
        return view('supplies.create');
    }

    /**
     * Store a new supply
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:supplies',
            'category' => 'required|string|max:50',
            'description' => 'nullable|string',
            'unit' => 'required|string|max:20', // unidade de medida (un, kg, l, etc)
            'stock_quantity' => 'required|numeric|min:0',
            'minimum_stock' => 'required|numeric|min:0',
            'unit_price' => 'required|numeric|min:0',
            'supplier' => 'nullable|string|max:255',
            'location' => 'nullable|string|max:100',
            'notes' => 'nullable|string'
        ]);

        Supply::create($validated);

        return redirect()
            ->route('supplies.index')
            ->with('success', 'Suprimento cadastrado com sucesso.');
    }

    /**
     * Show supply details
     */
    public function show(Supply $supply): View
    {
        return view('supplies.show', compact('supply'));
    }

    /**
     * Show form to edit a supply
     */
    public function edit(Supply $supply): View
    {
        return view('supplies.edit', compact('supply'));
    }

    /**
     * Update supply details
     */
    public function update(Request $request, Supply $supply)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:supplies,code,' . $supply->id,
            'category' => 'required|string|max:50',
            'description' => 'nullable|string',
            'unit' => 'required|string|max:20',
            'stock_quantity' => 'required|numeric|min:0',
            'minimum_stock' => 'required|numeric|min:0',
            'unit_price' => 'required|numeric|min:0',
            'supplier' => 'nullable|string|max:255',
            'location' => 'nullable|string|max:100',
            'notes' => 'nullable|string'
        ]);

        $supply->update($validated);

        return redirect()
            ->route('supplies.index')
            ->with('success', 'Suprimento atualizado com sucesso.');
    }

    /**
     * Remove a supply
     */
    public function destroy(Supply $supply)
    {
        $supply->delete();

        return redirect()
            ->route('supplies.index')
            ->with('success', 'Suprimento excluído com sucesso.');
    }

    /**
     * Show form to add stock
     */
    public function addStockForm(Supply $supply): View
    {
        return view('supplies.add-stock', compact('supply'));
    }

    /**
     * Add stock to supply
     */
    public function addStock(Request $request, Supply $supply)
    {
        $validated = $request->validate([
            'quantity' => 'required|numeric|min:0.01',
            'unit_price' => 'required|numeric|min:0',
            'invoice_number' => 'nullable|string|max:50',
            'supplier' => 'nullable|string|max:255',
            'notes' => 'nullable|string'
        ]);

        // Registrar entrada no estoque
        $supply->stock_entries()->create([
            'quantity' => $validated['quantity'],
            'unit_price' => $validated['unit_price'],
            'invoice_number' => $validated['invoice_number'],
            'supplier' => $validated['supplier'],
            'notes' => $validated['notes'],
            'user_id' => auth()->id()
        ]);

        // Atualizar quantidade em estoque
        $supply->increment('stock_quantity', $validated['quantity']);
        
        // Atualizar preço unitário médio
        $supply->update(['unit_price' => $validated['unit_price']]);

        return redirect()
            ->route('supplies.show', $supply)
            ->with('success', 'Entrada de estoque registrada com sucesso.');
    }

    /**
     * Show form to remove stock
     */
    public function removeStockForm(Supply $supply): View
    {
        return view('supplies.remove-stock', compact('supply'));
    }

    /**
     * Remove stock from supply
     */
    public function removeStock(Request $request, Supply $supply)
    {
        $validated = $request->validate([
            'quantity' => [
                'required',
                'numeric',
                'min:0.01',
                'max:' . $supply->stock_quantity
            ],
            'reason' => 'required|string|max:255',
            'notes' => 'nullable|string'
        ]);

        // Registrar saída do estoque
        $supply->stock_exits()->create([
            'quantity' => $validated['quantity'],
            'reason' => $validated['reason'],
            'notes' => $validated['notes'],
            'user_id' => auth()->id()
        ]);

        // Atualizar quantidade em estoque
        $supply->decrement('stock_quantity', $validated['quantity']);

        return redirect()
            ->route('supplies.show', $supply)
            ->with('success', 'Saída de estoque registrada com sucesso.');
    }

    /**
     * Show stock movement history
     */
    public function movements(Supply $supply): View
    {
        $entries = $supply->stock_entries()
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->get();

        $exits = $supply->stock_exits()
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('supplies.movements', compact('supply', 'entries', 'exits'));
    }
}
