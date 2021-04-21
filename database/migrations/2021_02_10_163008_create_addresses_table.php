<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('addresses', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->unsigned();
            $table->string('name');
            $table->string('tax_type')->default('CIF'); // 'CIF','NIF','NIE','Pasaporte','Extranjero'
            $table->string('tax_id', 32);
            $table->string('street');
            $table->string('street_address', 10);
            $table->string('zip', 10);
            $table->string('city', 100);
            $table->string('state');
            $table->string('country');
            $table->string('ofcont')->nullable();
            $table->string('gestor')->nullable();
            $table->string('untram')->nullable();
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
        Schema::dropIfExists('addresses');
    }
}
