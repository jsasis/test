<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateManifestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('manifests', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('id_trucks');
            $table->string('driver');
            $table->date('trip_date');
            $table->string('status');
            $table->timestamps();

            $table->foreign('id_trucks')->references('id')->on('trucks');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('manifests');
    }
}
