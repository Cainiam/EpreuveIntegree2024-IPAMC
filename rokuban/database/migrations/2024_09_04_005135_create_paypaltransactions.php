<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// We store the transaction from PayPal only to retrieve the transaction in our PayPal online store manager, to do that we store some information required for easy searching
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('paypaltransactions', function (Blueprint $table) {
            $table->id();
            $table->string('paypal_transactions_id')->unique();
            $table->string('paypal_transactions_status');
            $table->string('paypal_client_mail');
            $table->string('paypal_pricewtax');
            $table->string('paypal_currency_code');
            $table->foreignId('order_id')->constrained(table: 'orders', indexName: 'paypaltransaction_order_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('paypaltransactions');
    }
};
