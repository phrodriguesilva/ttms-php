<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Booking;

class Vehicle extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'make',
        'model',
        'year',
        'license_plate',
        'vin',
        'status',
        'mileage',
        'fuel_type',
        'last_maintenance',
        'next_maintenance',
        'notes'
    ];

    protected $casts = [
        'last_maintenance' => 'datetime',
        'next_maintenance' => 'datetime'
    ];

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }
}
