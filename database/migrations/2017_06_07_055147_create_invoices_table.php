<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
         Schema::create('invoices', function (Blueprint $table) {
            $table->increments('id');
            
            $table->integer('order_id')
                ->unsigned()
                ->references('id')
                ->on('orders')
                ->onDelete('cascade')
                ->onUpdate('cascade');
                
            $table->integer('invoice_number');
            
            $table->integer('invoice_status_code');
            $table->date('invoice_date');
            $table->string('invoice_details', 100)->nullable();
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invoices');
    }
}
