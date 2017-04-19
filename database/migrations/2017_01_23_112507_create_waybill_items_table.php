<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWaybillItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('waybill_items', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('id_waybills')->unsigned();
            $table->integer('id_products');
            $table->integer('quantity');
            $table->decimal('price', 10, 2);
            $table->string('description');
            $table->timestamps();

            $table->foreign('id_waybills')->references('id')->on('waybills');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('waybill_items');
    }
}
