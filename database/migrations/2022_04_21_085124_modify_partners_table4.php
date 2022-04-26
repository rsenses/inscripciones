<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyPartnersTable4 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('partners', function (Blueprint $table) {
            $table->string('legal_name');
            $table->string('bank_name');
            $table->string('bank_account');
            $table->string('iban');
            $table->string('bic');
            $table->string('cookies')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('partners', function (Blueprint $table) {
            $table->dropColumn(['legal_name', 'bank_name', 'bank_account', 'iban', 'bic', 'cookies']);
        });
    }
}
