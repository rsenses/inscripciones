<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCheckoutsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('checkouts', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->unsigned();
            $table->bigInteger('product_id')->unsigned();
            $table->decimal('amount', 8, 2)->default(0.00);
            $table->tinyInteger('quantity')->default(1)->unsigned();
            $table->string('method');
            $table->string('token');
            $table->string('status')->default('new');
            $table->dateTime('paid_at')->nullable();
            $table->timestamps();
            $table->unique(['product_id', 'user_id', 'amount']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('checkouts');
    }
}
