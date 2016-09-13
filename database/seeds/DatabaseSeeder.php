<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{

    public function run_dummy()
    {
        $this->call(DummyChallengesSeeder::class);
        $this->call(DummyUsersSeeder::class);
        $this->call(DummyTimesSeeder::class);
        $this->call(DummyTotalsSeeder::class);
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(LanguagesTableSeeder::class);
        $this->call(SchoolsTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(PagesTableSeeder::class);
        $this->call(PagesModulesTableSeeder::class);
        $this->call(ChallengesTableSeeder::class);
        $this->call(TotalsTableSeeder::class);

        // Uncomment to run seeders that fill the database with dummy data
        // $this->run_dummy();
    }

}
