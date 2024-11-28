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
        Schema::create('drivers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('cpf', 14)->unique();
            $table->string('rg', 20)->nullable();
            $table->string('cnh', 20)->unique();
            $table->date('cnh_expiry');
            $table->string('cnh_category', 5);
            $table->string('phone', 20);
            $table->string('emergency_phone', 20)->nullable();
            $table->string('email')->unique();
            $table->text('address');
            $table->date('birth_date');
            $table->string('blood_type', 5)->nullable();
            $table->string('status', 20); // active, inactive, vacation, sick_leave
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
        Schema::dropIfExists('drivers');
    }
};
