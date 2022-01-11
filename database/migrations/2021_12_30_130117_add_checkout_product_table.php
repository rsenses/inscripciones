<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCheckoutProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('checkout_product', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('checkout_id')->unsigned();
            $table->foreign('checkout_id')
                  ->references('id')
                  ->on('checkouts')->onDelete('cascade');
            $table->bigInteger('product_id')->unsigned();
            $table->foreign('product_id')
                  ->references('id')
                  ->on('products')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('checkout_product');
    }
}
