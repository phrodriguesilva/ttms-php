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
        Schema::create('parts', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('part_number')->unique();
            $table->string('manufacturer')->nullable();
            $table->text('description')->nullable();
            $table->integer('stock_quantity');
            $table->integer('minimum_stock');
            $table->decimal('unit_price', 10, 2);
            $table->string('location')->nullable(); // Storage location
            $table->string('category');
            $table->string('condition', 20); // new, used, refurbished
            $table->date('purchase_date')->nullable();
            $table->date('warranty_expiry')->nullable();
            $table->string('supplier')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('parts');
    }
};
