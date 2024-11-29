<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSupplyManagementColumns extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('supplies', function (Blueprint $table) {
            // Add columns if they don't exist
            if (!Schema::hasColumn('supplies', 'consumption_quantity')) {
                $table->decimal('consumption_quantity', 10, 2)->default(0);
            }
            
            if (!Schema::hasColumn('supplies', 'last_consumption_date')) {
                $table->timestamp('last_consumption_date')->nullable();
            }
            
            if (!Schema::hasColumn('supplies', 'alert_threshold')) {
                $table->decimal('alert_threshold', 10, 2)->default(0);
            }
            
            if (!Schema::hasColumn('supplies', 'category_order')) {
                $table->integer('category_order')->default(0);
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
                'consumption_quantity',
                'last_consumption_date',
                'alert_threshold',
                'category_order'
            ]);
        });
    }
}
