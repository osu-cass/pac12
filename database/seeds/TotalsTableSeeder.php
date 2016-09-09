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
                'school_id' => $school->id,
                'challenge_id' => 1,
                'times' => 0,
            ));
        }
    }
}
