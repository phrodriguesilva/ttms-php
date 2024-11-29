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
        Schema::table('vehicles', function (Blueprint $table) {
            // Remover colunas não utilizadas
            $table->dropColumn(['vin', 'fuel_type']);
            
            // Adicionar restrições unique
            $table->unique('chassis');
            $table->unique('renavam');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vehicles', function (Blueprint $table) {
            // Remover restrições unique
            $table->dropUnique(['chassis']);
            $table->dropUnique(['renavam']);
            
            // Recriar colunas removidas
            $table->string('vin', 17)->nullable()->unique();
            $table->string('fuel_type', 50)->nullable();
        });
    }
};
