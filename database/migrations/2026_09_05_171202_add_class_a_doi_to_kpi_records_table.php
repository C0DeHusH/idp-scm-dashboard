<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('kpi_records', function (Blueprint $table) {
            if (!Schema::hasColumn('kpi_records', 'class_a_doi')) {
                $table->decimal('class_a_doi', 8, 2)->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('kpi_records', function (Blueprint $table) {
            if (Schema::hasColumn('kpi_records', 'class_a_doi')) {
                $table->dropColumn('class_a_doi');
            }
        });
    }
};