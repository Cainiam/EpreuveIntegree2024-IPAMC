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
        Schema::create('tvas', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->double('purcent', 1, 2); //maximum 100.00% (1.00 in double) even if irrealist
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tvas');
    }
};
