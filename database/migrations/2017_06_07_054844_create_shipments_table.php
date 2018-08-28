<?php
// READY! == READY!
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShipmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //COLUMNAS
        Schema::create('shipments', function (Blueprint $table) {
            $table->increments('id');
            
            $table->integer('order_id')
                ->unsigned()
                ->references('id')
                ->on('orders')
                ->onDelete('CASCADE')
                ->onUpdate('CASCADE');
                
            $table->integer('invoice_number')
                ->unsigned()
                ->references('invoice_number')
                ->on('invoices')
                ->onDelete('CASCADE')
                ->onUpdate('CASCADE');
                
            $table->integer('tracking_number');
            $table->date('date');
            $table->string('other_details', 100)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shipments');
    }
}
