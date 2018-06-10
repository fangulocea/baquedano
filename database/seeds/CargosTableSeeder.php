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
    }
}
