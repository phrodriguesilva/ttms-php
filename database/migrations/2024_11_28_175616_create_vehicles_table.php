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
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->string('plate', 20)->unique();
            $table->string('brand', 50);
            $table->string('model', 50);
            $table->integer('year');
            $table->string('color', 30);
            $table->integer('capacity');
            $table->string('vehicle_type', 30); // sedan, van, minibus
            $table->decimal('mileage', 10, 2);
            $table->string('status', 20); // active, maintenance, inactive
            $table->date('last_maintenance');
            $table->date('next_maintenance');
            $table->string('insurance_number')->nullable();
            $table->date('insurance_expiry');
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
        Schema::dropIfExists('vehicles');
    }
};
