<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductPriceProductVariantTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_price_product_variant', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('product_price_id')->unsigned()->index();
            $table->foreign('product_price_id')->references('id')->on('product_prices')->onDelete('cascade');
            $table->integer('product_variant_id')->unsigned()->index();
            $table->foreign('product_variant_id')->references('id')->on('product_variants')->onDelete('cascade');
            $table->string('price');
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {   
        Schema::drop('product_price_product_variant');
       
    }
}