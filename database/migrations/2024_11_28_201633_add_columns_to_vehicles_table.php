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
            if (!Schema::hasColumn('vehicles', 'vin')) {
                $table->string('vin', 17)->unique()->nullable();
            }
            if (!Schema::hasColumn('vehicles', 'fuel_type')) {
                $table->string('fuel_type', 50)->nullable();
            }
            if (!Schema::hasColumn('vehicles', 'last_maintenance')) {
                $table->date('last_maintenance')->nullable();
            }
            if (!Schema::hasColumn('vehicles', 'next_maintenance')) {
                $table->date('next_maintenance')->nullable();
            }
            if (!Schema::hasColumn('vehicles', 'notes')) {
                $table->text('notes')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vehicles', function (Blueprint $table) {
            $table->dropColumn([
                'vin',
                'fuel_type',
                'last_maintenance',
                'next_maintenance',
                'notes'
            ]);
        });
    }
};
