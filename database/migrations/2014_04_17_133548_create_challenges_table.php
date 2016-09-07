<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChallengesTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('challenges', function($table) {
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->string('name');
            $table->text('description');
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->boolean('published')->default(1);
            $table->boolean('published_range')->default(0);
            $table->timestamp('published_start')->nullable();
            $table->timestamp('published_end')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('challenges');
    }

}
