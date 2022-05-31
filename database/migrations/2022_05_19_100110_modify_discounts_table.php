<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyDiscountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('discounts', function (Blueprint $table) {
            $table->morphs('discountable');
            $table->tinyInteger('value')->unsigned();
            $table->string('type')->default('percentage');
            $table->string('concept')->nullable();
            $table->boolean('automatic')->default(false);
            $table->boolean('cumulable')->default(false);
            $table->smallInteger('min_amount')->default(0);
            $table->tinyInteger('min_quantity')->default(0);
            $table->dropForeign('discounts_product_id_foreign');
            $table->dropColumn('product_id');
            $table->dropColumn('quantity');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
