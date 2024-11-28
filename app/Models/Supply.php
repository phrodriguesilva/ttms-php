<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Supply extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description', 
        'stock_quantity',
        'minimum_stock',
        'unit_price',
        'supplier',
        'category'
    ];

    protected $casts = [
        'stock_quantity' => 'integer',
        'minimum_stock' => 'integer',
        'unit_price' => 'decimal:2'
    ];

    public function stockEntries()
    {
        return $this->hasMany(StockEntry::class);
    }

    public function stockExits() 
    {
        return $this->hasMany(StockExit::class);
    }

    public function isLowStock()
    {
        return $this->stock_quantity <= $this->minimum_stock;
    }

    public function addStock($quantity, $notes = null)
    {
        $this->stock_quantity += $quantity;
        $this->save();

        return $this->stockEntries()->create([
            'quantity' => $quantity,
            'notes' => $notes
        ]);
    }

    public function removeStock($quantity, $notes = null)
    {
        if ($this->stock_quantity < $quantity) {
            throw new \Exception('Insufficient stock');
        }

        $this->stock_quantity -= $quantity;
        $this->save();

        return $this->stockExits()->create([
            'quantity' => $quantity,
            'notes' => $notes
        ]);
    }
}
