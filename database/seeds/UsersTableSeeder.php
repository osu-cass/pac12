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
            'id'        => 1,
            'school_id' => 1,
            'type'      => 'superadmin',
            'username'  => 'avadmin',
            'email'     => 'jacobm@angelvisiontech.com',
            'password'  => Hash::make('avsauce')
        ));
    }

}
