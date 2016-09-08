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
        School::create(array(
            'name' => 'University of Arizona',
            'url'  => 'https://rec.arizona.edu/'
        ));

        School::create(array(
            'name' => 'Arizona State University',
            'url'  => 'https://fitness.asu.edu/'
        ));

        School::create(array(
            'name' => 'University of California, Berkeley',
            'url'  => 'https://recsports.berkeley.edu/about/events/fitwellweek/'
        ));

        School::create(array(
            'name' => 'University of Oregon',
            'url'  => 'https://uoregon.edu/sports'
        ));

        School::create(array(
            'name' => 'Oregon State University',
            'url'  => 'https://calendar.oregonstate.edu/'
        ));

        School::create(array(
            'name' => 'Stanford University',
            'url'  => 'https://stanford.edu/dept/pe/cgi-bin/cardinalrec/pac-12-fitness-challenge/'
        ));

        School::create(array(
            'name' => 'UCLA',
            'url'  => 'https://recreation.ucla.edu/pac12challenge'
        ));

        School::create(array(
            'name' => 'University of Southern California',
            'url'  => 'https://sait.usc.edu/Recsports/calendars/sports/pac-12-fitness-challenge-week-2014'
        ));

        School::create(array(
            'name' => 'University of Washington',
            'url'  => 'https://washington.edu/ima'
        ));

        School::create(array(
            'name' => 'Washington State University',
            'url'  => 'https://urec.wsu.edu/events/pac-12-challenge/'
        ));

        School::create(array(
            'name' => 'University of Colorado',
            'url'  => 'https://colorado.edu/recreation'
        ));

        School::create(array(
            'name' => 'University of Utah',
            'url'  => 'https://campusrec.utah.edu/'
        ));

    }
}
