<?php

use Illuminate\Database\Seeder;
use App\Role_User;

class RoleUserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        Role_User::create([
            'role_id'    => '1',
            'user_id'    => '1'
        ]);
<<<<<<< HEAD
        Role_User::create([
            'role_id'    => '1',
            'user_id'    => '2'
        ]);
        Role_User::create([
            'role_id'    => '1',
            'user_id'    => '3'
        ]);
        Role_User::create([
            'role_id'    => '1',
            'user_id'    => '4'
        ]);
        Role_User::create([
            'role_id'    => '1',
            'user_id'    => '5'
        ]);
        Role_User::create([
            'role_id'    => '2',
            'user_id'    => '6'
        ]);
        Role_User::create([
            'role_id'    => '2',
            'user_id'    => '6'
        ]);
        Role_User::create([
            'role_id'    => '2',
            'user_id'    => '6'
        ]);
=======
>>>>>>> 4679f853b0fcb2262a0e335c0f5b7340c138e65c
    }
}
