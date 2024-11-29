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
        // Only create table if it doesn't exist
        if (!Schema::hasTable('vehicles')) {
            Schema::create('vehicles', function (Blueprint $table) {
                $table->id();
                $table->string('plate', 20)->unique();
                $table->string('brand', 50);
                $table->string('model', 50);
                $table->integer('year');
                $table->string('color', 30);
                $table->integer('capacity')->nullable();
                $table->string('vehicle_type', 30)->nullable(); // sedan, van, minibus
                $table->decimal('mileage', 10, 2)->nullable();
                $table->string('status', 20)->default('active'); // active, maintenance, inactive
                $table->date('last_maintenance')->nullable();
                $table->date('next_maintenance')->nullable();
                $table->string('insurance_number')->nullable();
                $table->date('insurance_expiry')->nullable();
                $table->text('notes')->nullable();
                $table->timestamps();
                $table->softDeletes();
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
