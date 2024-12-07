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
        Schema::create('figuresorders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained(table: 'orders', indexName: 'figuresorder_order_id');
            $table->foreignId('figure_id')->constrained(table: 'figures', indexName: 'figuresorder_figure_id');
            $table->double('price_at_date'); //storing price at order date for future invoice in case of price update
            $table->double('pricettc_at_date'); //see price_at_date
            $table->integer('quantity')->unsigned();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('figuresorders');
    }
};
