<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBadgesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('badges', function($table) {
			$table->engine = 'InnoDB';

			$table->increments('id');
			$table->string('name');
			$table->string('icon');
			$table->string('category');
			$table->integer('minutes');
			$table->text('description');
			$table->timestamps(); // Adds `created_at` and `updated_at` columns
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('badges');
	}

}
