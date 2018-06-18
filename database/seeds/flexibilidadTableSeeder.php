<?php

use Illuminate\Database\Seeder;
use App\Flexibilidad;

class flexibilidadTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Flexibilidad::create([
            'id'    => '1',
            'nombre'    => 'Sin Flexibilidad',
            'descripcion'    => 'Uso para contratos que no tengan flexibilidad',
            'estado' => 1
        ]);
    }
}