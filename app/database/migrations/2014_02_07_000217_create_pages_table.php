<?php

use Illuminate\Database\Migrations\Migration;

class CreatePagesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('pages', function($table) {
			$table->engine = 'InnoDB';

			$table->increments('id');
			$table->integer('language_id')->unsigned()->default(1);
			$table->string('name');
			$table->string('url');
			$table->text('html');
			$table->text('js');
			$table->text('css');
			$table->string('title');
			$table->string('meta_description');
			$table->string('meta_keywords');
			$table->string('og_type');
			$table->string('og_image');
			$table->string('twitter_card');
			$table->string('twitter_image');
			$table->boolean('published')->default(1);
			$table->boolean('published_range')->default(0);
			$table->timestamp('published_start');
			$table->timestamp('published_end');
			$table->timestamps(); // Adds `created_at` and `updated_at` columns
			$table->softDeletes(); // Adds `deleted_at` column

			$table->foreign('language_id')->references('id')->on('languages')->onDelete('cascade');
		});

		// Create the home page
		DB::table('pages')->insert(
			array(
				'url'	=> 'home',
				'name'	=> 'Home',
				'title'	=> 'Home',
				'html'	=> '
					<h1>Welcome!</h1>
					<p>This is the default home page.</p>
				'
			)
		);
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('pages');
	}

}