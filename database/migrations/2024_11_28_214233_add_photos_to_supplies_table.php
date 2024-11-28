<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('supplies', function (Blueprint $table) {
            $table->string('sku')->unique()->after('id');
            $table->json('photos')->nullable();
            $table->string('category')->after('name');
            $table->decimal('unit_price', 10, 2)->default(0)->after('category');
            $table->string('supplier')->nullable()->after('unit_price');
            $table->decimal('stock_quantity', 10, 2)->default(0)->after('supplier');
            $table->decimal('minimum_stock', 10, 2)->default(0)->after('stock_quantity');
            $table->string('unit')->default('UN')->after('minimum_stock');
            $table->string('location')->nullable()->after('unit');
            $table->text('description')->nullable()->after('location');
            $table->text('notes')->nullable()->after('description');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('supplies', function (Blueprint $table) {
            $table->dropColumn([
                'sku',
                'photos',
                'category',
                'unit_price',
                'supplier',
                'stock_quantity',
                'minimum_stock',
                'unit',
                'location',
                'description',
                'notes'
            ]);
        });
    }
};
