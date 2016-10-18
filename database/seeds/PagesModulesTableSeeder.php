<?php

use Illuminate\Database\Seeder;

class PagesModulesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PageModule::create(array(
            'page_id'   => 2,
            'number'    => 1,
            'html'      => '
<h1>CLICK YOUR SCHOOL&#39;S ICON</h1>

            '
        ));
         PageModule::create(array(
            'page_id'   => 2,
            'number'    => 2,
            'html'      => '
<h1>DON&#39;T WANT TO GO MOBILE?</h1>

<ol>
    <li><a href="signup">Register</a></li>
    <li><a href="signin">Log minutes</a></li>
</ol>
            '
        ));
        PageModule::create(array(
            'page_id'   => 2,
            'number'    => 3,
            'html'      => '
<h1>WHAT&#39;S NEW FOR 2014?</h1>

<ol>
    <li><span style="line-height: 1.6;">Anyone can participate! Sign up and indicate your school - no need to have an EDU email address.</span></li>
    <li><span style="line-height: 1.6;">Log up to 120 minutes per day for your school</span></li>
    <li><span style="line-height: 1.6;">Download the Preva Mobile app from the App store or Google Play!</span></li>
</ol>

            '
        ));
        PageModule::create(array(
            'page_id'   => 2,
            'number'    => 4,
            'html'      => '
<p><img alt="" src="/uploads/kcfinder/images/section-5_img.png" style="width: 454px; height: 290px;" /></p>

            '
        ));
        PageModule::create(array(
            'page_id'   => 2,
            'number'    => 5,
            'html'      => '
<p><img alt="" src="/uploads/kcfinder/images/section-6_img.png" style="width: 454px; height: 290px;" /></p>

            '
        ));
        PageModule::create(array(
            'page_id'   => 2,
            'number'    => 6,
            'html'      => '
<h1>WHO WILL BE THIS YEAR&#39;S CHAMPION?</h1>

<p>Previous Winners:</p>

<ul>
    <li>UCLA</li>
    <li>ASU</li>
    <li>Stanford</li>
</ul>

            '
        ));
    }
}
