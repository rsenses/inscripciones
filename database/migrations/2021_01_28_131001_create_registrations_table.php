<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRegistrationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('registrations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('product_id');
            $table->string('unique_id')->unique();
            $table->string('status')->default('new');
            $table->string('type')->default('asistente');
            $table->text('metadata')->nullable();
            $table->timestamps();

            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')->onDelete('cascade');

            $table->foreign('product_id')
                  ->references('id')
                  ->on('products')->onDelete('cascade');

            // $table->unique(['product_id', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('registrations');
    }
}
