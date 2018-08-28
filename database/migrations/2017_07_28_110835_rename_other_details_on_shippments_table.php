<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameOtherDetailsOnShippmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('shippments', function (Blueprint $table) {
            $table->renameColumn('other_details', 'details');
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
            $table->renameColumn('details', 'other_details');
        });
    }
}
