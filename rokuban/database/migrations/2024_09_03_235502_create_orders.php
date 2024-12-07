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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained(table: 'users', indexName: 'order_user_id');
            $table->string('status')->default("paiement confirmé"); //default is paid validated since order are only created when user buy something
            $table->double('price'); //automaticaly calculated with pricettc and tva when creating an order
            $table->double('pricettc'); //automaticaly calculated with figure price and qty
            $table->string('paypal_status')->nullable(); //nullable since paypal isn t the only payment method
            $table->foreignId('shipping_id')->constrained(table: 'shippings', indexName: 'order_shipping_id');
            $table->string('tracker')->nullable(); //nullable since the tracker is avalaible only when the shipping company send it
            $table->boolean('isVisible')->default(1); //visible by default
            $table->timestamps(); //using auto timestamp as date for order
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
