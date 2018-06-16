<?php

use Illuminate\Database\Seeder;
use Caffeinated\Shinobi\Models\Role;
use Caffeinated\Shinobi\Models\PermissionRole;
use Illuminate\Support\Facades\DB;


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

        Role::create([
            'id'    => '2',
            'name'    => 'Contact Center',
            'slug'    => 'Contact Center',
            'special' => null
        ]);

        DB::table('permission_role')->insert(
             ['permission_id' => 1, 'role_id' => 2]
        );
                DB::table('permission_role')->insert(
             ['permission_id' => 2, 'role_id' => 2]
        );
                DB::table('permission_role')->insert(
             ['permission_id' => 3, 'role_id' => 2]
        );
                DB::table('permission_role')->insert(
             ['permission_id' => 4, 'role_id' => 2]
        );
                DB::table('permission_role')->insert(
             ['permission_id' => 5, 'role_id' => 2]
        );
                DB::table('permission_role')->insert(
             ['permission_id' => 6, 'role_id' => 2]
        );

    }
}
