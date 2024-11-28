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
        'type',
        'document',
        'phone',
        'email',
        'address',
        'contact_person',
        'contact_phone',
        'payment_method',
        'payment_terms',
        'is_active',
        'notes'
    ];

    protected $casts = [
        'is_active' => 'boolean'
    ];

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }
}
