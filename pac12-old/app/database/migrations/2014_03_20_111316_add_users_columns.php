<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUsersColumns extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('users', function($table) {
			$table->string('type')->default('user');
			$table->string('username')->nullable();
			$table->date('dob')->nullable();
			$table->string('gender', 1)->nullable();
			$table->string('gender_other')->nullable();
			$table->float('weight')->nullable();
			$table->integer('height_feet')->nullable();
			$table->integer('height_inches')->nullable();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('users', function($table) {
			$table->dropColumn('type');
			$table->dropColumn('username');
			$table->dropColumn('dob');
			$table->dropColumn('gender');
			$table->dropColumn('gender_other');
			$table->dropColumn('weight');
			$table->dropColumn('height_feet');
			$table->dropColumn('height_inches');
		});
	}

}
