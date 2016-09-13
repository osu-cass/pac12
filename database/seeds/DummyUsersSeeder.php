<?php

use Illuminate\Database\Seeder;

class DummyUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (School::all() as $school) {
            User::create(array(
                'school_id' => $school->id,
                'type' => 'admin',
                'username' => 'admin'.$school->id,
                'email' => 'admin'.$school->id.'@test.com',
                'password' => Hash::make('password')
            ));

            for ($i = 0; $i < 8; $i++) {
                User::create(array(
                    'school_id' => $school->id,
                    'type' => 'user',
                    'username' => 'user'.$school->id.$i,
                    'email' => 'user'.$school->id.$i.'@test.com',
                    'password' => Hash::make('password')
                ));
            }
        }
    }
}
