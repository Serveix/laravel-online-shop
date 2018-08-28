<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_addresses', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->integer('address_type'); // 1 = envio, 2 = facturacion
            $table->string('street_address1', 150);
            $table->string('street_address2', 150)->nullable();
            $table->string('state', 150);
            $table->string('city', 150);
            $table->integer('postal_code');
            $table->string('indications', 150)->nullable;
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
        Schema::dropIfExists('user_addresses');
    }
}
