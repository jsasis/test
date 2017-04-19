<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateManifestsWaybillsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('manifests_waybills', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('id_manifests');
            $table->integer('id_waybills');
            $table->string('status');
            $table->timestamps();

            $table->foreign('id_manifests')->references('id')->on('manifests')->onDelete('cascade');
        }); 
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('manifests_waybills');
    }
}
