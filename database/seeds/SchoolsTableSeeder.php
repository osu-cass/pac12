<?php

use Illuminate\Database\Seeder;

class SchoolsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (School::schools() as $school => $_) {
            School::create(array(
                'name' => $school,
            ));
        }
    }
}
