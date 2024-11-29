<?php

namespace Database\Seeders;

use App\Models\Airport;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AirportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $airports = [
            [
                'name' => 'Aeroporto Internacional de Guarulhos',
                'code' => 'GRU',
                'city' => 'Guarulhos',
                'state' => 'SP',
                'country' => 'Brasil',
                'latitude' => -23.4356,
                'longitude' => -46.4731,
                'status' => 'active',
                'airport_type' => 'International',
                'airport_size' => 'Large',
                'runway_length' => '3,700m',
                'runway_width' => '45m',
                'terminal_count' => '3',
                'gate_count' => '44',
                'parking_capacity' => '8,000 vehicles',
                'security_checkpoints' => '12'
            ],
            [
                'name' => 'Aeroporto Santos Dumont',
                'code' => 'SDU',
                'city' => 'Rio de Janeiro',
                'state' => 'RJ',
                'country' => 'Brasil',
                'latitude' => -22.9108,
                'longitude' => -43.1634,
                'status' => 'active',
                'airport_type' => 'Domestic',
                'airport_size' => 'Medium',
                'runway_length' => '1,323m',
                'runway_width' => '30m',
                'terminal_count' => '1',
                'gate_count' => '15',
                'parking_capacity' => '2,000 vehicles',
                'security_checkpoints' => '6'
            ],
            [
                'name' => 'Aeroporto Internacional de Brasília',
                'code' => 'BSB',
                'city' => 'Brasília',
                'state' => 'DF',
                'country' => 'Brasil',
                'latitude' => -15.8697,
                'longitude' => -47.9101,
                'status' => 'active',
                'airport_type' => 'International',
                'airport_size' => 'Large',
                'runway_length' => '3,300m',
                'runway_width' => '45m',
                'terminal_count' => '2',
                'gate_count' => '30',
                'parking_capacity' => '5,000 vehicles',
                'security_checkpoints' => '10'
            ]
        ];

        foreach ($airports as $airport) {
            Airport::create($airport);
        }
    }
}
