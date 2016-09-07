<?php

use Illuminate\Database\Migrations\Migration;

class CreateTimesTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('times', function($table) {
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->date('date');
            $table->string('activity');
            $table->integer('minutes');
//            $table->integer('calories');
//            $table->integer('distance');
//            $table->integer('weight');
//            $table->integer('reps');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('times');
    }

}
