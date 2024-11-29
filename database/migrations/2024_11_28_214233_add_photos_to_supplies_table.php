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
            if (!Schema::hasColumn('supplies', 'sku')) {
                $table->string('sku')->unique()->after('id');
            }
            if (!Schema::hasColumn('supplies', 'photos')) {
                $table->json('photos')->nullable();
            }
            if (!Schema::hasColumn('supplies', 'category')) {
                $table->string('category')->after('name');
            }
            if (!Schema::hasColumn('supplies', 'unit_price')) {
                $table->decimal('unit_price', 10, 2)->default(0)->after('category');
            }
            if (!Schema::hasColumn('supplies', 'supplier')) {
                $table->string('supplier')->nullable()->after('unit_price');
            }
            if (!Schema::hasColumn('supplies', 'stock_quantity')) {
                $table->decimal('stock_quantity', 10, 2)->default(0)->after('supplier');
            }
            if (!Schema::hasColumn('supplies', 'minimum_stock')) {
                $table->decimal('minimum_stock', 10, 2)->default(0)->after('stock_quantity');
            }
            if (!Schema::hasColumn('supplies', 'unit')) {
                $table->string('unit')->default('UN')->after('minimum_stock');
            }
            if (!Schema::hasColumn('supplies', 'location')) {
                $table->string('location')->nullable()->after('unit');
            }
            if (!Schema::hasColumn('supplies', 'description')) {
                $table->text('description')->nullable()->after('location');
            }
            if (!Schema::hasColumn('supplies', 'notes')) {
                $table->text('notes')->nullable()->after('description');
            }
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
