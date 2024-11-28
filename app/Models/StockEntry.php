<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StockEntry extends Model
{
    use HasFactory;

    protected $fillable = [
        'supply_id',
        'quantity',
        'notes'
    ];

    protected $casts = [
        'quantity' => 'integer'
    ];

    public function supply()
    {
        return $this->belongsTo(Supply::class);
    }
}
