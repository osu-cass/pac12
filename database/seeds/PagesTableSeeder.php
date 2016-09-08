<?php

use Illuminate\Database\Seeder;

class PagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Page::create(array(
            'url'   => 'home',
            'name'  => 'Home',
            'title' => 'Home',
            'html'  => '
                <h1>Welcome!</h1>
                <p>This is the default home page.</p>
            '
        ));

        Page::create(array(
            'name' => 'Welcome',
            'url' => 'welcome',
            'html' => '
<p>Building on the success of the annual Fitness Challenge, Pac 12 Recreation Departments are collaborating each year to create a series of events and challenges to inspire and engage individuals to be active and healthy. These annual events are designed to help our campuses build healthy communities.</p>

<p>Help your school secure the title of the conference&rsquo;s most active school by participating in the Pac-12 Fitness Challenge! The Pac-12 Fitness Challenge is a conference-wide initiative promoting regular physical activity. From February 24-28 all twelve schools will be competing to accumulate the most minutes of activity and earn the title of Pac-12 Fitness Challenge Champion!</p>
            '
        ));
    }
}
