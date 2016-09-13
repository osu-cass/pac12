<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create(array(
            'school_id' => 1,
            'type'      => 'superadmin',
            'username'  => 'avadmin',
            'email'     => 'jacobm@angelvisiontech.com',
            'password'  => Hash::make('avsauce')
        ));
    }

}
