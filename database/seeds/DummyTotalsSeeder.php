<?php

use Illuminate\Database\Seeder;

class DummyTotalsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (Challenge::all() as $challenge) {
            foreach (School::all() as $school) {
                $time_total = Time::select(DB::raw('sum(minutes) as minutes, count(distinct user_id) as students'))
                                  ->where('times.school_id', '=', $school->id)
                                  ->first();
                Total::create(array(
                    'school_id' => $school->id,
                    'challenge_id' => $challenge->id,
                    'minutes' => $time_total->minutes,
                    'students' => $time_total->students
                ));
            }
        }
    }
}
