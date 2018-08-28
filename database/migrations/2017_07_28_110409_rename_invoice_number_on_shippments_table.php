<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameInvoiceNumberOnShippmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('shippments', function (Blueprint $table) {
            $table->renameColumn('invoice_number', 'invoice_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('shippments', function (Blueprint $table) {
            $table->renameColumn('invoice_id', 'invoice_number');
        });
    }
}
