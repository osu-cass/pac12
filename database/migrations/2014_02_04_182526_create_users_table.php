<?php

use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function($table) {
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->string('email')->unique();
            $table->string('display_name');
            $table->string('password');
            $table->string('token');
            $table->string('refresh_token');
            $table->integer('token_expires');
            $table->date('joined');
            $table->nullableTimestamps(); // Adds `created_at` and `updated_at` columns
            $table->softDeletes(); // Adds `deleted_at` for SoftDeletes trait on User model
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('users');
    }

}
