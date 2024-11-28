<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Booking;

class Client extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'company',
        'email',
        'phone',
        'address',
        'city',
        'state',
        'postal_code',
        'country',
        'tax_id',
        'notes',
        'status'
    ];

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }
}
