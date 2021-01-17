<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFreeProductSaleDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('free_product_sale_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('product_sale_detail_id')->unsigned();
            $table->bigInteger('free_product_id')->unsigned();
            $table->timestamps();
            $table->foreign('product_sale_detail_id')->references('id')->on('product_sale_details')->onDelete('cascade');
            $table->foreign('free_product_id')->references('id')->on('free_products')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('free_product_sale_details');
    }
}
