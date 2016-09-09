<?php

use Illuminate\Database\Seeder;

class LanguagesTableSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Language::create(array(
            'uri'  => 'en',
            'name' => 'English'
        ));
    }

}
