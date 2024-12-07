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
        Schema::create('figures', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique(); //no character limit for name in case of long name
            $table->longText('description')->nullable(); //description not mandatory when creating new figure
            $table->double('price',6,2); //price is maximum 999999,99 euro
            $table->foreignId('tva_id')->constrained(table: 'tvas', indexName: 'figure_tva_id'); //id from the tva
            $table->foreignId('brand_id')->constrained(table: 'brands', indexName: 'figure_brand_id'); //id from the brand
            $table->string('collection', 30); //30 characters should be enough to write collection name
            $table->string('character_name', 100); //100 characters to write the characters name (and if they're more than one, some extra letters)
            $table->string('series_title', 50); //50 characters to write the series name
            $table->string('sculptor_name', 30)->nullable(); //sculptor name not mandatory when creating new figure, 30 characters should be enough to write sculptor name
            $table->string('material'); //no limit in case of multiple material
            $table->string('height', 8); //8 characters should be enough to write xx cm or xxx cm
            $table->foreignId('scale_id')->constrained(table: 'scales', indexName: 'figure_scale_id'); //id from the scale
            $table->string('release_date', 10)->nullable(); //release date not mandatory when creating new figure, xx/xx/xxxx <- 10 character
            $table->integer('stock_qty')->unsigned(); //only positive integer
            $table->string('reference', 13)->nullable(); //reference not mandatory when creating new figure, reference are 13 alphanumeric, 3 letters then 10 numbers in our website
            $table->string('ean', 13)->nullable(); //ean not mandatory when creating new figure, they are maximum 13 numbers for EAN in our website
            $table->string('state', 15)->nullable(); //state not mandatory when creating new figure
            $table->foreignId('category_id')->constrained(table: 'categories', indexName: 'figure_category_id'); //id from the category
            $table->boolean('isVisible')->default(1); //visible by default
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('figures');
    }
};
