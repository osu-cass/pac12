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
			$table->int('reps');
			$table->int('weight');
			$table->int('calories');
			$table->int('distance');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		$table->dropColumn('workout_id');
		$table->dropColumn('reps');
		$table->dropColumn('weight');
		$table->dropColumn('calories');
		$table->dropColumn('distance');
	}

}
