<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Ensure the supplies table exists
        if (!Schema::hasTable('supplies')) {
            Schema::create('supplies', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('category');
                $table->string('unit_of_measurement');
                $table->decimal('current_quantity', 10, 2)->default(0);
                $table->decimal('stock_quantity', 10, 2)->default(0);
                $table->integer('minimum_stock')->default(0);
                $table->timestamps();
                $table->softDeletes();
            });
        }

        // Rename parts table to supplies if it exists
        if (Schema::hasTable('parts') && !Schema::hasTable('supplies')) {
            Schema::rename('parts', 'supplies');
        }

        Schema::table('supplies', function (Blueprint $table) {
            // Remove old columns if they exist
            $columns = [
                'part_number',
                'manufacturer',
                'location',
                'condition',
                'purchase_date',
                'warranty_expiry',
                'notes'
            ];

            foreach ($columns as $column) {
                if (Schema::hasColumn('supplies', $column)) {
                    $table->dropColumn($column);
                }
            }

            // Add minimum_stock if it doesn't exist
            if (!Schema::hasColumn('supplies', 'minimum_stock')) {
                $table->integer('minimum_stock')->default(0);
            }
        });
    }

    public function down()
    {
        Schema::table('supplies', function (Blueprint $table) {
            $table->string('part_number')->nullable();
            $table->string('manufacturer')->nullable();
            $table->string('location')->nullable();
            $table->string('condition')->nullable();
            $table->date('purchase_date')->nullable();
            $table->date('warranty_expiry')->nullable();
            $table->text('notes')->nullable();
            
            if (Schema::hasColumn('supplies', 'minimum_stock')) {
                $table->dropColumn('minimum_stock');
            }
        });

        // Revert rename if possible
        if (Schema::hasTable('supplies') && !Schema::hasTable('parts')) {
            Schema::rename('supplies', 'parts');
        }
    }
};
