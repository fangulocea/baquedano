<?php

use Illuminate\Database\Seeder;
use App\Persona;

class PersonasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Persona::create([
         	'id'				=> '1',
         	'rut'				=> '11111111-1',
        	'nombre'			=> 'Administrador',
        	'apellido_paterno'	=> 'del',
        	'apellido_materno'	=> 'Sistema',
        	'direccion'			=> 'Av Apoquindo',
            'numero'            => '1111',
            'departamento'      => '1111',
            'id_estado'         => '1',
         	'telefono'			=> '229023010',
         	'email'				=> 'admin@ibaquedano.cl',
         	'id_comuna'			=> '86',
         	'id_region'			=> '7',
         	'id_provincia'		=> '22',
         	'tipo_cargo'		=> 'Empleado',
         	'cargo_id'			=> '1',
         ]);

    }
}
