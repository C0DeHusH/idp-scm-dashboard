<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('manpowers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('section');
            $table->string('position');
            $table->string('status')->default('Active'); // Active, On Leave, Resigned, etc.
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('manpowers');
    }
};