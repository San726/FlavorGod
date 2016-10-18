<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductVariantsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
 public function up()
    {
        Schema::create('product_variants', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('product_id')->unsigned()->index();
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->integer('variant_type')->index();
            $table->integer('product_type_id')->nullable();
            $table->string('name')->index();
            $table->string('internal_sku')->default('');
            $table->string('sku')->index();
            $table->string('upc')->index();
            $table->string('buy_button_text')->nullable();
            $table->string('in_stock_text')->nullable();
            $table->string('download_link')->index();
            $table->integer('free_product_tier_id')->nullable();
            $table->integer('quantity')->default(1);
            $table->tinyInteger('hide_options_from_display_name')->nullable();
            $table->tinyInteger('customer_service_can_add')->nullable();
            $table->decimal('commission_value_supplement', 3, 1)->nullable();
            $table->decimal('commission_value_apparel', 3, 1)->nullable();
            $table->decimal('commission_value_accessory', 3, 1)->nullable();
            $table->decimal('commission_value_ebook', 3, 1)->nullable();
            $table->decimal('commission_value_custom_ebook', 3, 1)->nullable();
            $table->decimal('commission_value_custom_workout', 3, 1)->nullable();
            $table->string('gender', 6)->nullable();
            $table->tinyInteger('enabled')->index();
            $table->integer('sort_order')->nullable()->index();
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
        Schema::drop('product_variants');
    }

}