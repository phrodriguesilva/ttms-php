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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained();
            $table->foreignId('vehicle_id')->constrained();
            $table->foreignId('driver_id')->constrained();
            $table->string('booking_type', 30); // airport_transfer, hotel_transfer, event_transfer
            $table->string('status', 20); // pending, confirmed, in_progress, completed, cancelled
            $table->dateTime('pickup_datetime');
            $table->text('pickup_location');
            $table->text('dropoff_location');
            $table->integer('passenger_count');
            $table->integer('luggage_count')->nullable();
            $table->string('flight_number')->nullable();
            $table->string('flight_company')->nullable();
            $table->decimal('price', 10, 2);
            $table->string('payment_status', 20); // pending, paid, refunded
            $table->text('special_requirements')->nullable();
            $table->text('notes')->nullable();
            $table->decimal('distance', 10, 2)->nullable(); // in kilometers
            $table->integer('estimated_duration')->nullable(); // in minutes
            $table->dateTime('actual_pickup_time')->nullable();
            $table->dateTime('actual_dropoff_time')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
