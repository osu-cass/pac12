<?php

use Illuminate\Database\Seeder;

use Carbon\Carbon;

class DummyChallengesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i < 3; $i++) {
            $start_date = Carbon::now()->subWeeks(4 - $i * 2 - 1);
            $end_date = $start_date->copy()->addWeeks(2)->subDay();
            Challenge::create(array(
                'name' => 'Dummy challenge #'.($i + 1),
                'description' => 'Dummy challenge',
                'published' => 1,
                'published_range' => 1,
                'published_start' => $start_date,
                'published_end' => $end_date
            ));
        }
    }
}
