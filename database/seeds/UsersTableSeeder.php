<?php

use Illuminate\Database\Seeder;
use App\User;


class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        User::create([
            'id'    => '1',
            'name'    => 'Administrador del Sistema',
            'email'    => 'admin@ibaquedano.cl',
            'password' => bcrypt('123456'),
            'id_persona' => 1
        ]);


    }
}
