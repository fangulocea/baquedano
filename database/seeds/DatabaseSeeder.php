<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         $this->call(PermissionsTableSeeder::class);
         $this->call(NotariasTableSeeder::class);
         $this->call(CargosTableSeeder::class);
         $this->call(RegionsTableSeeder::class);
         $this->call(ProvinciasTableSeeder::class);
         $this->call(ComunasTableSeeder::class);
         $this->call(RoleTableSeeder::class);
         $this->call(PersonasSeeder::class);
         $this->call(UsersTableSeeder::class);
         $this->call(RoleUserTableSeeder::class);
         $this->call(PortalesTableSeeder::class);
         $this->call(flexibilidadTableSeeder::class);
    }
}
