<?php

use Illuminate\Database\Migrations\Migration;

class CreateMenusItemsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menus_items', function($table) {
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->integer('order')->unsigned();
            $table->integer('menu_id')->unsigned();
            $table->string('fmodel');
            $table->integer('fid')->unsigned();
            $table->timestamps(); // Adds `created_at` and `updated_at` columns
            $table->softDeletes(); // Adds `deleted_at` column

            $table->foreign('menu_id')->references('id')->on('menus')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('menus_items');
    }

}