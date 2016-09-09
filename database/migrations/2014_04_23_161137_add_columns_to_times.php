<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsToTimes extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('times', function($table) {
            $table->integer('workout_id')->unsigned()->unique()->nullable();
            $table->integer('reps');
            $table->integer('weight');
            $table->integer('calories');
            $table->integer('distance');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('times', function($table) {
            $table->dropColumn('workout_id');
            $table->dropColumn('reps');
            $table->dropColumn('weight');
            $table->dropColumn('calories');
            $table->dropColumn('distance');
        });
    }

}
