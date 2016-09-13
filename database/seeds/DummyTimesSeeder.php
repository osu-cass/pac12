<?php

use Illuminate\Database\Seeder;

use Carbon\Carbon;

class DummyTimesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (Challenge::all() as $challenge) {
            $challenge_start = Carbon::createFromFormat('Y-m-d H:i:s', $challenge->published_start);
            foreach (School::all() as $school) {
                foreach (User::all()->where('school_id', '=', $school->id)
                                    ->where('type', '=', 'user')
                         as $user) {
                    $date = $challenge_start->copy();

                    for ($i = 0; $i < 6; $i++) {
                        Time::create(array(
                            'user_id' => $user->id,
                            'school_id' => $school->id,
                            'date' => $date,
                            'activity' => '',
                            'type' => '',
                            'minutes' => random_int(1, 120),
                        ));
                        $date->addDay();
                    }
                }
            }
        }
    }
}
