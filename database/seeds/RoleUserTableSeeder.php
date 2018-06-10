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
    }
}
