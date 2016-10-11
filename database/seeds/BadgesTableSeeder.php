<?php

use Illuminate\Database\Seeder;

class BadgesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (array('Cardio', 'Mind', 'Sports', 'Strength') as $category) {
            foreach (array(1 => 30, 2 => 60, 3 => 120) as $rank => $duration) {
                Badge::create(array(
                    'name' => $category.' '.$duration,
                    'icon' => 'uploads/kcfinder/images/Fitness-Badge---'.$category.$rank.'---Spring2015---draft1-01.png',
                    'category' => strtolower($category),
                    'minutes' => $duration,
                    'description' => $duration.' minutes of '.$category.'! Congratulations!',
                ));
            }
        }
    }
}
