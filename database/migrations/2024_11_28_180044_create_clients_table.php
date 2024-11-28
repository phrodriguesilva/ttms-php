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
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('type', 20); // individual, corporate
            $table->string('document', 20)->unique(); // CPF or CNPJ
            $table->string('phone', 20);
            $table->string('email')->unique();
            $table->text('address')->nullable();
            $table->string('contact_person')->nullable(); // For corporate clients
            $table->string('contact_phone', 20)->nullable();
            $table->string('payment_method', 20)->nullable(); // credit_card, bank_transfer, cash
            $table->string('payment_terms', 50)->nullable(); // immediate, 15_days, 30_days
            $table->boolean('is_active')->default(true);
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
        Schema::dropIfExists('clients');
    }
};
