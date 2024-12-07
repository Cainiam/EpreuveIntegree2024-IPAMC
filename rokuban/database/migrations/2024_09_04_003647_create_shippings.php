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
        Schema::create('shippings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('shippingcompany_id')->constrained(table: 'shippingcompanies', indexName: 'shipping_shippingcompany_id');
            $table->string('name')->unique(); //unique because we only want one shipping type per company
            $table->longText('description')->nullable();
            $table->double('price',3,2); //999,99 as maximum for shipping seems realistic, more not realy since we transport package of figures
            $table->boolean('isVisible')->default(1); //visible by default
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shippings');
    }
};
