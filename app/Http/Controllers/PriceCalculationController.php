<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PriceCalculationController extends Controller
{
    public function calculate(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'service_type' => 'required|string',
            'vehicle_id' => 'required|exists:vehicles,id',
            'distance' => 'required_if:service_type,transfer|numeric|min:0',
            'hours' => 'required_if:service_type,hourly|numeric|min:1',
            'days' => 'required_if:service_type,daily|numeric|min:1',
            'passengers' => 'required|integer|min:1'
        ]);

        $startDate = Carbon::parse($request->start_date);
        $endDate = Carbon::parse($request->end_date);
        $vehicle = Vehicle::findOrFail($request->vehicle_id);
        
        // Base rates (você pode ajustar conforme necessário)
        $rates = [
            'transfer' => [
                'base' => 150, // Taxa base para transfer
                'per_km' => 2.5, // Taxa por km
            ],
            'hourly' => [
                'minimum' => 200, // Mínimo para serviço por hora
                'per_hour' => 150, // Taxa por hora
            ],
            'daily' => [
                'per_day' => 800, // Taxa por dia
            ],
            'event' => [
                'base' => 500, // Taxa base para eventos
                'per_hour' => 200, // Taxa por hora para eventos
            ],
            'tour' => [
                'base' => 400, // Taxa base para tours
                'per_person' => 50, // Taxa adicional por pessoa
            ]
        ];

        // Cálculo base do preço
        $basePrice = 0;
        $details = [];

        switch ($request->service_type) {
            case 'transfer':
                $basePrice = $rates['transfer']['base'] + ($request->distance * $rates['transfer']['per_km']);
                $details = [
                    'Taxa base' => $rates['transfer']['base'],
                    'Distância (km)' => $request->distance,
                    'Taxa por km' => $rates['transfer']['per_km'],
                    'Custo da distância' => $request->distance * $rates['transfer']['per_km']
                ];
                break;

            case 'hourly':
                $hours = max($request->hours, ceil($endDate->diffInHours($startDate)));
                $basePrice = max($rates['hourly']['minimum'], $hours * $rates['hourly']['per_hour']);
                $details = [
                    'Horas' => $hours,
                    'Taxa por hora' => $rates['hourly']['per_hour'],
                    'Taxa mínima' => $rates['hourly']['minimum']
                ];
                break;

            case 'daily':
                $days = max($request->days, ceil($endDate->diffInDays($startDate)));
                $basePrice = $days * $rates['daily']['per_day'];
                $details = [
                    'Dias' => $days,
                    'Taxa por dia' => $rates['daily']['per_day']
                ];
                break;

            case 'event':
                $hours = ceil($endDate->diffInHours($startDate));
                $basePrice = $rates['event']['base'] + ($hours * $rates['event']['per_hour']);
                $details = [
                    'Taxa base' => $rates['event']['base'],
                    'Horas' => $hours,
                    'Taxa por hora' => $rates['event']['per_hour'],
                    'Custo das horas' => $hours * $rates['event']['per_hour']
                ];
                break;

            case 'tour':
                $basePrice = $rates['tour']['base'] + ($request->passengers * $rates['tour']['per_person']);
                $details = [
                    'Taxa base' => $rates['tour']['base'],
                    'Passageiros' => $request->passengers,
                    'Taxa por pessoa' => $rates['tour']['per_person'],
                    'Custo adicional passageiros' => $request->passengers * $rates['tour']['per_person']
                ];
                break;
        }

        // Ajustes baseados no veículo
        $vehicleMultiplier = 1.0;
        if (strpos(strtolower($vehicle->model), 'luxo') !== false) {
            $vehicleMultiplier = 1.3; // 30% a mais para veículos de luxo
        } elseif (strpos(strtolower($vehicle->model), 'executivo') !== false) {
            $vehicleMultiplier = 1.2; // 20% a mais para veículos executivos
        }

        $finalPrice = $basePrice * $vehicleMultiplier;

        // Adiciona detalhes do multiplicador se aplicável
        if ($vehicleMultiplier > 1.0) {
            $details['Multiplicador do veículo'] = $vehicleMultiplier;
        }

        return response()->json([
            'base_price' => number_format($basePrice, 2, ',', '.'),
            'final_price' => number_format($finalPrice, 2, ',', '.'),
            'details' => $details
        ]);
    }
}
