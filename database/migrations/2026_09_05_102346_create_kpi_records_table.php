<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('kpi_records', function (Blueprint $table) {
            $table->id();
            $table->string('type'); // 'YTD' or 'Weekly'
            $table->string('period'); // 'Jan', '08/10', etc.
            $table->decimal('after_po_oos', 8, 2)->default(0);
            $table->decimal('per_branch_oos', 8, 2)->default(0);
            $table->decimal('before_po_oos', 8, 2)->default(0);
            $table->decimal('class_a_oos', 8, 2)->default(0);
            $table->decimal('doi', 8, 2)->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('kpi_records');
    }
};