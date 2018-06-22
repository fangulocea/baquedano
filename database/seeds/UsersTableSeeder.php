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
<<<<<<< HEAD
        User::create([
            'id'    => '2',
            'name'    => 'Pablo Jimenez',
            'email'    => 'pablo@ibaquedano.cl',
            'password' => bcrypt('123456'),
            'id_persona' => 2
        ]);
        User::create([
            'id'    => '3',
            'name'    => 'Neila Chavez',
            'email'    => 'neila@ibaquedano.cl',
            'password' => bcrypt('123456'),
            'id_persona' => 3
        ]);
        User::create([
            'id'    => '4',
            'name'    => 'Daniel Gutierrez',
            'email'    => 'daniela@ibaquedano.cl',
            'password' => bcrypt('123456'),
            'id_persona' => 4
        ]);

        User::create([
            'id'    => '5',
            'name'    => 'Javier Faria',
            'email'    => 'javier@ibaquedano.cl',
            'password' => bcrypt('123456'),
            'id_persona' => 5
        ]);
        User::create([
            'id'    => '6',
            'name'    => 'Conctact Center 1',
            'email'    => 'contactcenter1@ibaquedano.cl',
            'password' => bcrypt('123456'),
            'id_persona' => 6
        ]);
        User::create([
            'id'    => '7',
            'name'    => 'Conctact Center 2',
            'email'    => 'contactcenter2@ibaquedano.cl',
            'password' => bcrypt('123456'),
            'id_persona' => 7
        ]);
        User::create([
            'id'    => '8',
            'name'    => 'Conctact Center 3',
            'email'    => 'contactcenter3@ibaquedano.cl',
            'password' => bcrypt('123456'),
            'id_persona' => 8
        ]);
=======


>>>>>>> 4679f853b0fcb2262a0e335c0f5b7340c138e65c
    }
}
