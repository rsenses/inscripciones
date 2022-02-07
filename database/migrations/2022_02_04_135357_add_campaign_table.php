<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCampaignTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('campaigns', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('folder');
            $table->string('image')->nullable();
            $table->unsignedBigInteger('partner_id');
            $table->foreign('partner_id')
                  ->references('id')
                  ->on('partners')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::table('products', function (Blueprint $table) {
            $table->unsignedBigInteger('campaign_id')->nullable();
            $table->foreign('campaign_id')
                  ->references('id')
                  ->on('campaigns')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');

        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['campaign_id']);
        });
    }
}
