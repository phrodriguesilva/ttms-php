<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Client;
use App\Models\Vehicle;
use App\Models\Driver;
use App\Models\BookingStatusHistory;

class Booking extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'client_id',
        'vehicle_id',
        'driver_id',
        'start_date',
        'end_date',
        'pickup_location',
        'dropoff_location',
        'status',
        'total_amount',
        'payment_status',
        'notes',
        'special_requirements'
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'total_amount' => 'decimal:2'
    ];

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function vehicle(): BelongsTo
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function driver(): BelongsTo
    {
        return $this->belongsTo(Driver::class);
    }

    public function statusHistory(): HasMany
    {
        return $this->hasMany(BookingStatusHistory::class);
    }

    protected static function booted()
    {
        static::created(function ($booking) {
            $booking->statusHistory()->create([
                'status' => $booking->status,
                'comment' => 'Reserva criada',
                'changed_by' => auth()->id()
            ]);

            $booking->user->notify(new BookingStatusChanged($booking, 'created'));
        });

        static::updating(function ($booking) {
            if ($booking->isDirty('status')) {
                $booking->statusHistory()->create([
                    'status' => $booking->status,
                    'comment' => 'Status atualizado para ' . ucfirst($booking->status),
                    'changed_by' => auth()->id()
                ]);

                $booking->user->notify(new BookingStatusChanged($booking, 'status_changed'));
            }
        });
    }
}
