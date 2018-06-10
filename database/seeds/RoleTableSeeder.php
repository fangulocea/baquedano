<?php

use Illuminate\Database\Seeder;
use Caffeinated\Shinobi\Models\Role;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create([
            'id'    => '1',
        	'name'    => 'Admin',
        	'slug'    => 'admin',
        	'special' => 'all-access'
        ]);
    }
}
