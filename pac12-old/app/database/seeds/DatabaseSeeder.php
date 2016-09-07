<?php

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Eloquent::unguard();

		//$this->call('UserTableSeeder');
		$this->call('FrontPageSeeder');
	}

}

class UserTableSeeder extends Seeder {

	public function run()
	{
		$user = User::find(3);
		if ($user) {
			$user->delete();
		}

		User::create(array(
			'id'		=> 1,
			'type'		=> 'superadmin',
			'username'	=> 'avadmin',
			'email'		=> 'jacobm@angelvisiontech.com',
			'password'	=> Hash::make('avsauce'),
		));

		DB::statement("
			UPDATE `users`
			SET `username` = `display_name`
			WHERE `display_name` <> ''
		");
	}

}

class FrontPageSeeder extends Seeder {

	public function run()
	{
		Page::create(array(
			'name' => 'Welcome',
			'url' => 'welcome',
			'html' => '
<p>Building on the success of the annual Fitness Challenge, Pac 12 Recreation Departments are collaborating each year to create a series of events and challenges to inspire and engage individuals to be active and healthy. These annual events are designed to help our campuses build healthy communities.</p>

<p>Help your school secure the title of the conference&rsquo;s most active school by participating in the Pac-12 Fitness Challenge! The Pac-12 Fitness Challenge is a conference-wide initiative promoting regular physical activity. From February 24-28 all twelve schools will be competing to accumulate the most minutes of activity and earn the title of Pac-12 Fitness Challenge Champion!</p>
			'
		));
		PageModule::create(array(
			'page_id'	=> 2,
			'number'	=> 1,
			'html'		=> '
<h1>DON&#39;T WANT TO GO MOBILE?</h1>

<ol>
	<li><a href="signup">Register</a></li>
	<li><a href="signin">Log minutes</a></li>
</ol>
			'
		));
		PageModule::create(array(
			'page_id'	=> 2,
			'number'	=> 2,
			'html'		=> '
<h1>CLICK YOUR SCHOOL&#39;S ICON</h1>

			'
		));
		PageModule::create(array(
			'page_id'	=> 2,
			'number'	=> 3,
			'html'		=> '
<h1>WHAT&#39;S NEW FOR 2014?</h1>

<ol>
	<li><span style="line-height: 1.6;">Anyone can participate! Sign up and indicate your school - no need to have an EDU email address.</span></li>
	<li><span style="line-height: 1.6;">Log up to 120 minutes per day for your school</span></li>
	<li><span style="line-height: 1.6;">Download the Preva Mobile app from the App store or Google Play!</span></li>
</ol>

			'
		));
		PageModule::create(array(
			'page_id'	=> 2,
			'number'	=> 4,
			'html'		=> '
<p><img alt="" src="/uploads/kcfinder/images/section-5_img.png" style="width: 454px; height: 290px;" /></p>

			'
		));
		PageModule::create(array(
			'page_id'	=> 2,
			'number'	=> 5,
			'html'		=> '
<p><img alt="" src="/uploads/kcfinder/images/section-6_img.png" style="width: 454px; height: 290px;" /></p>

			'
		));
		PageModule::create(array(
			'page_id'	=> 2,
			'number'	=> 6,
			'html'		=> '
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