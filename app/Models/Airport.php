<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Airport extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name', 
        'code', 
        'city', 
        'state', 
        'country', 
        'latitude', 
        'longitude', 
        'status',
        'airport_type',
        'airport_size',
        'runway_length',
        'runway_width',
        'terminal_count',
        'gate_count',
        'parking_capacity',
        'security_checkpoints'
    ];

    protected $casts = [
        'latitude' => 'float',
        'longitude' => 'float',
    ];
}
