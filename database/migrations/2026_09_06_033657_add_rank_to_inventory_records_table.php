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
        Schema::table('inventory_records', function (Blueprint $table) {
            if (!Schema::hasColumn('inventory_records', 'rank')) {
                $table->string('rank')->nullable()->after('model');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('inventory_records', function (Blueprint $table) {
            if (Schema::hasColumn('inventory_records', 'rank')) {
                $table->dropColumn('rank');
            }
        });
    }
};