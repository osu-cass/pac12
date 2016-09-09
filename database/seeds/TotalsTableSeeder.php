<?php

use Illuminate\Database\Seeder;

class TotalsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (School::all() as $school) {
            Total::create(array(
                'school' => $school->name,
                'challenge_id' => 1,
                'minutes' => 0,
                'students' => 0,
            ));
        }
    }
}