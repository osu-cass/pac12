<?php

use Illuminate\Database\Migrations\Migration;

class CreatePagesModulesTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pages_modules', function($table) {
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->integer('page_id')->unsigned();
            $table->integer('number')->unsigned();
            $table->text('html');
            $table->timestamps(); // Adds `created_at` and `updated_at` columns
            $table->softDeletes(); // Adds `deleted_at` column

            $table->foreign('page_id')->references('id')->on('pages')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('pages_modules');
    }

}