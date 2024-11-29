<?php

namespace App\Services;

use App\Models\Booking;
use App\Models\Vehicle;
use App\Models\Driver;
use App\Models\Client;
use App\Notifications\BookingStatusChanged;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Exception;

class BookingService
{
    public function create(array $data)
    {
        return DB::transaction(function () use ($data) {
            // Verificar disponibilidade do veículo
            $this->checkVehicleAvailability($data['vehicle_id'], $data['start_date'], $data['end_date']);
            
            // Verificar disponibilidade do motorista
            $this->checkDriverAvailability($data['driver_id'], $data['start_date'], $data['end_date']);
            
            // Criar a reserva
            $booking = Booking::create($data);
            
            // Atualizar status do veículo e motorista
            $this->updateResourceStatus($booking);
            
            // Enviar notificações
            $this->sendNotifications($booking, 'created');
            
            return $booking;
        });
    }

    public function update(Booking $booking, array $data)
    {
        return DB::transaction(function () use ($booking, $data) {
            $oldStatus = $booking->status;
            
            // Se houver mudança de veículo ou período
            if (($data['vehicle_id'] ?? null) != $booking->vehicle_id ||
                ($data['start_date'] ?? null) != $booking->start_date ||
                ($data['end_date'] ?? null) != $booking->end_date) {
                
                $this->checkVehicleAvailability(
                    $data['vehicle_id'] ?? $booking->vehicle_id,
                    $data['start_date'] ?? $booking->start_date,
                    $data['end_date'] ?? $booking->end_date,
                    $booking->id
                );
            }
            
            // Se houver mudança de motorista ou período
            if (($data['driver_id'] ?? null) != $booking->driver_id ||
                ($data['start_date'] ?? null) != $booking->start_date ||
                ($data['end_date'] ?? null) != $booking->end_date) {
                
                $this->checkDriverAvailability(
                    $data['driver_id'] ?? $booking->driver_id,
                    $data['start_date'] ?? $booking->start_date,
                    $data['end_date'] ?? $booking->end_date,
                    $booking->id
                );
            }
            
            $booking->update($data);
            
            // Se o status mudou
            if (($data['status'] ?? null) && $data['status'] !== $oldStatus) {
                $this->updateResourceStatus($booking);
                $this->sendNotifications($booking, 'status_changed');
            }
            
            return $booking;
        });
    }

    private function checkVehicleAvailability($vehicleId, $startDate, $endDate, $excludeBookingId = null)
    {
        $vehicle = Vehicle::findOrFail($vehicleId);
        
        if ($vehicle->status === 'maintenance') {
            throw new Exception('Veículo em manutenção');
        }
        
        $query = Booking::where('vehicle_id', $vehicleId)
            ->where(function ($q) use ($startDate, $endDate) {
                $q->whereBetween('start_date', [$startDate, $endDate])
                    ->orWhereBetween('end_date', [$startDate, $endDate])
                    ->orWhere(function ($q) use ($startDate, $endDate) {
                        $q->where('start_date', '<=', $startDate)
                            ->where('end_date', '>=', $endDate);
                    });
            })
            ->where('status', '!=', 'cancelled');
            
        if ($excludeBookingId) {
            $query->where('id', '!=', $excludeBookingId);
        }
        
        if ($query->exists()) {
            throw new Exception('Veículo não disponível para o período selecionado');
        }
    }

    private function checkDriverAvailability($driverId, $startDate, $endDate, $excludeBookingId = null)
    {
        $driver = Driver::findOrFail($driverId);
        
        if ($driver->status === 'unavailable') {
            throw new Exception('Motorista indisponível');
        }
        
        $query = Booking::where('driver_id', $driverId)
            ->where(function ($q) use ($startDate, $endDate) {
                $q->whereBetween('start_date', [$startDate, $endDate])
                    ->orWhereBetween('end_date', [$startDate, $endDate])
                    ->orWhere(function ($q) use ($startDate, $endDate) {
                        $q->where('start_date', '<=', $startDate)
                            ->where('end_date', '>=', $endDate);
                    });
            })
            ->where('status', '!=', 'cancelled');
            
        if ($excludeBookingId) {
            $query->where('id', '!=', $excludeBookingId);
        }
        
        if ($query->exists()) {
            throw new Exception('Motorista não disponível para o período selecionado');
        }
    }

    private function updateResourceStatus(Booking $booking)
    {
        $vehicle = $booking->vehicle;
        $driver = $booking->driver;
        
        switch ($booking->status) {
            case 'confirmed':
                if (Carbon::parse($booking->start_date)->isToday()) {
                    $vehicle->update(['status' => 'reserved']);
                    $driver->update(['status' => 'reserved']);
                }
                break;
            case 'in_progress':
                $vehicle->update(['status' => 'in_use']);
                $driver->update(['status' => 'busy']);
                break;
            case 'completed':
            case 'cancelled':
                $vehicle->update(['status' => 'active']);
                $driver->update(['status' => 'available']);
                break;
        }
    }

    private function sendNotifications(Booking $booking, $event)
    {
        // Notificar cliente
        $booking->client->notify(new BookingStatusChanged($booking, $event));
        
        // Notificar motorista (se confirmado ou em andamento)
        if (in_array($booking->status, ['confirmed', 'in_progress'])) {
            $booking->driver->notify(new BookingStatusChanged($booking, $event));
        }
    }
}
