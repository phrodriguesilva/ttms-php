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
        // First, create the vehicles table if it doesn't exist
        if (!Schema::hasTable('vehicles')) {
            Schema::create('vehicles', function (Blueprint $table) {
                $table->id();
                $table->string('plate')->unique();
                $table->string('brand');
                $table->string('model');
                $table->integer('year');
                $table->string('color');
                $table->string('chassis')->unique()->nullable();
                $table->string('renavam')->unique()->nullable();
                $table->string('vehicle_type');
                $table->integer('capacity')->nullable();
                $table->integer('mileage')->nullable();
                $table->string('status')->default('active');
                $table->date('last_maintenance')->nullable();
                $table->date('next_maintenance')->nullable();
                $table->string('insurance_number')->nullable();
                $table->text('notes')->nullable();
                $table->timestamps();
                $table->softDeletes();
            });
        } else {
            // If table exists, modify it
            Schema::table('vehicles', function (Blueprint $table) {
                // Remover colunas não utilizadas
                $table->dropColumn(['vin', 'fuel_type']);
                
                // Adicionar restrições unique
                $table->unique('chassis');
                $table->unique('renavam');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicles');
    }
};
