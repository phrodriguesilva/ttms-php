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
        'plate',
        'brand',
        'model',
        'year',
        'chassis',
        'renavam',
        'observations'
    ];

    protected $casts = [
        'last_maintenance' => 'datetime',
        'next_maintenance' => 'datetime',
        'insurance_expiry' => 'datetime'
    ];

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }
}
