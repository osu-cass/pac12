<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChallengeTotals extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('totals', function($table) {

            $table->increments('id');
            $table->string('school');
            $table->integer('challenge_id')->unsigned();
            $table->integer('minutes')->unsigned();
            $table->integer('students')->unsigned();

            //$table->foreign('school_id')->references('id')->on('schools')->onDelete('cascade');
            $table->foreign('challenge_id')->references('id')->on('challenges')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('totals');
    }

}
