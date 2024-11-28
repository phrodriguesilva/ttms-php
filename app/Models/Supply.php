<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Supply extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'sku',
        'category',
        'unit_price',
        'supplier',
        'stock_quantity',
        'minimum_stock',
        'unit',
        'location',
        'description',
        'notes',
        'photos'
    ];

    protected $casts = [
        'photos' => 'array',
        'unit_price' => 'decimal:2',
        'stock_quantity' => 'decimal:2',
        'minimum_stock' => 'decimal:2'
    ];

    public static function boot()
    {
        parent::boot();

        static::creating(function ($supply) {
            if (!$supply->sku) {
                $supply->sku = self::generateSKU();
            }
        });
    }

    public static function generateSKU()
    {
        $lastSupply = self::orderBy('id', 'desc')->first();
        $nextNumber = $lastSupply ? (intval(substr($lastSupply->sku, 4)) + 1) : 1;
        return 'SKU-' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);
    }

    public function isLowStock(): bool
    {
        return $this->stock_quantity <= $this->minimum_stock;
    }

    public static function getCategories()
    {
        return self::distinct()->pluck('category')->sort()->values();
    }

    public static function getSuppliers()
    {
        return self::distinct()->pluck('supplier')->filter()->sort()->values();
    }

    public static function getUnits()
    {
        return [
            'UN' => 'Unidade',
            'CX' => 'Caixa',
            'PC' => 'Peça',
            'KG' => 'Quilograma',
            'L' => 'Litro',
            'M' => 'Metro',
            'M2' => 'Metro Quadrado',
            'M3' => 'Metro Cúbico'
        ];
    }
}
