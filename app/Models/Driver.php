<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Booking;

class Driver extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'license_number',
        'license_expiry',
        'phone',
        'email',
        'address',
        'status',
        'notes',
        'emergency_contact',
        'emergency_phone'
    ];

    protected $casts = [
        'license_expiry' => 'date'
    ];

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }
}
