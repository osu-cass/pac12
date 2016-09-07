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
		Schema::create('challenge_totals', function($table) {

			$table->increments('id');
			$table->integer('school_id')->unsigned();
			$table->integer('challenge_id')->unsigned();
			$table->integer('times')->unsigned();
			
			$table->foreign('school_id')->references('id')->on('schools')->onDelete('cascade');
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
		Schema::drop('challenge_totals');
	}

}
