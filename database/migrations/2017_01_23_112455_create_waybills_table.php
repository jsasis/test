<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWaybillsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('waybills', function(Blueprint $table) {
            $table->increments('id');
            $table->string('consignee');
            $table->string('consignor');
            $table->string('dr_number');
            $table->string('status');
            $table->string('payment_terms');
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
        Schema::drop('waybills');
    }
}
