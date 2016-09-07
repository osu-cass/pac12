<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateSponsorsAddPublished extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sponsors', function($table) {
            $table->boolean('published')->default(1);
            $table->boolean('published_range')->default(0);
            $table->timestamp('published_start');
            $table->timestamp('published_end');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sponsors', function($table) {
            $table->dropColumn('published');
            $table->dropColumn('published_range');
            $table->dropColumn('published_start');
            $table->dropColumn('published_end');
        });
    }

}
