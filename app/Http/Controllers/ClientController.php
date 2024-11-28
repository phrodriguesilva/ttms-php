<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use League\Csv\Writer;
use League\Csv\Reader;
use SplTempFileObject;
use Illuminate\Http\JsonResponse;

class ClientController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $query = Client::query();

        // Apply search filter
        if ($request->has('search')) {
            $search = $request->get('search');
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('address', 'like', "%{$search}%")
                  ->orWhere('document_type', 'like', "%{$search}%")
                  ->orWhere('document_number', 'like', "%{$search}%")
                  ->orWhere('company_name', 'like', "%{$search}%")
                  ->orWhere('notes', 'like', "%{$search}%");
            });
        }

        $clients = $query->orderBy('name')->paginate(10);

        return view('clients.index', compact('clients'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('clients.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'type' => 'required|string|in:individual,corporate',
            'name' => 'required|string|max:255',
            'document' => 'required|string|unique:clients',
            'email' => 'required|email|unique:clients',
            'phone' => 'required|string|max:20',
            'address' => 'nullable|string',
            'contact_person' => 'nullable|string|max:255',
            'contact_phone' => 'nullable|string|max:20',
            'payment_method' => 'nullable|string|in:credit_card,bank_transfer,cash',
            'payment_terms' => 'nullable|string|in:immediate,15_days,30_days',
            'is_active' => 'boolean',
            'notes' => 'nullable|string'
        ]);

        $client = Client::create($validated);

        return redirect()
            ->route('clients.index')
            ->with('success', 'Cliente criado com sucesso!');
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
     * Show the form for editing the specified resource.
     */
    public function edit(Client $client): View
    {
        return view('clients.create', compact('client'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Client $client): RedirectResponse
    {
        $validated = $request->validate([
            'type' => 'required|string|in:individual,corporate',
            'name' => 'required|string|max:255',
            'document' => 'required|string|unique:clients,document,' . $client->id,
            'email' => 'required|email|unique:clients,email,' . $client->id,
            'phone' => 'required|string|max:20',
            'address' => 'nullable|string',
            'contact_person' => 'nullable|string|max:255',
            'contact_phone' => 'nullable|string|max:20',
            'payment_method' => 'nullable|string|in:credit_card,bank_transfer,cash',
            'payment_terms' => 'nullable|string|in:immediate,15_days,30_days',
            'is_active' => 'boolean',
            'notes' => 'nullable|string'
        ]);

        $client->update($validated);

        return redirect()
            ->route('clients.index')
            ->with('success', 'Cliente atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Client $client): RedirectResponse
    {
        $client->delete();
        return redirect()
            ->route('clients.index')
            ->with('success', 'Cliente excluído com sucesso!');
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

    /**
     * Export clients to CSV
     */
    public function export()
    {
        $clients = Client::all();
        
        $csv = Writer::createFromFileObject(new SplTempFileObject());
        
        // Add headers
        $csv->insertOne([
            'Nome',
            'Email',
            'Telefone',
            'Endereço',
            'Documento',
            'Número do Documento',
            'Nome da Empresa',
            'Observações'
        ]);
        
        // Add data
        foreach ($clients as $client) {
            $csv->insertOne([
                $client->name,
                $client->email,
                $client->phone,
                $client->address,
                $client->document_type,
                $client->document_number,
                $client->company_name,
                $client->notes
            ]);
        }
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="clientes.csv"',
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0'
        ];
        
        return response($csv->getContent(), 200, $headers);
    }

    /**
     * Import clients from CSV
     */
    public function import(Request $request): RedirectResponse
    {
        $request->validate([
            'file' => 'required|file|mimes:csv,txt'
        ]);

        $file = $request->file('file');
        $csv = Reader::createFromPath($file->getPathname());
        $csv->setHeaderOffset(0);

        $records = $csv->getRecords();
        $imported = 0;
        $errors = [];

        foreach ($records as $offset => $record) {
            try {
                Client::create([
                    'name' => $record['nome'],
                    'email' => $record['email'],
                    'phone' => $record['telefone'],
                    'address' => $record['endereço'],
                    'document_type' => $record['documento'],
                    'document_number' => $record['número do documento'],
                    'company_name' => $record['nome da empresa'] ?? null,
                    'notes' => $record['observações'] ?? null
                ]);
                $imported++;
            } catch (\Exception $e) {
                $errors[] = "Linha " . ($offset + 2) . ": " . $e->getMessage();
            }
        }

        if (empty($errors)) {
            return redirect()
                ->route('clients.index')
                ->with('success', "{$imported} clientes importados com sucesso!");
        }

        return redirect()
            ->route('clients.index')
            ->with('success', "{$imported} clientes importados com sucesso!")
            ->with('error', "Erros encontrados: " . implode(", ", $errors));
    }
}
