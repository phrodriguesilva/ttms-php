<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Client;
use App\Models\Vehicle;
use App\Models\Driver;

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
}
