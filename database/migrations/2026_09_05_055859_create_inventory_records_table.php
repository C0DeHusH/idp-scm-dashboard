<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inventory_records', function (Blueprint $table) {
            $table->id();
            $table->string('area')->index();
            $table->string('pareto_class')->index(); // Class A, B, C
            $table->string('branch')->index();
            $table->string('model');
            $table->string('stock_status'); // Over, Stockout, Re-order
            $table->integer('stock_status_count')->default(1);
            $table->integer('remaining_inventory')->nullable();
            $table->integer('suggested_transfer')->nullable();
            $table->integer('doi')->nullable(); // Days of Inventory
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inventory_records');
    }
};