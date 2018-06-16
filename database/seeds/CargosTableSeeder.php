<?php

use Illuminate\Database\Seeder;
use App\Cargo;

class CargosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       Cargo::create(['nombre' => 'Administrador','descripcion' => 'Administrador del Sistema','estado' => '1']);
       Cargo::create(['nombre' => 'Contact Center','descripcion' => 'Captación','estado' => '1']);
       Cargo::create(['nombre' => 'Captación Central','descripcion' => 'Captación Central','estado' => '1']);
       Cargo::create(['nombre' => 'Captación Externa','descripcion' => 'Captación Externa','estado' => '1']);
       Cargo::create(['nombre' => 'Administración','descripcion' => 'Administración','estado' => '1']);
    }
}
