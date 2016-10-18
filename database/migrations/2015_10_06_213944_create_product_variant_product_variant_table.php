<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductVariantProductVariantTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       
        Schema::create('product_variant_product_variant', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('parent_id')->unsigned()->index();
            $table->foreign('parent_id')->references('id')->on('product_variants')->onDelete('cascade');
            $table->integer('child_id')->unsigned()->index();
            $table->foreign('child_id')->references('id')->on('product_variants')->onDelete('cascade');
            $table->integer('quantity')->default(1);
            $table->string('badge')->nullable();
            $table->integer('sort_order')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
      
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('product_variant_product_variant');
        
    }
}