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

<<<<<<< HEAD
                Persona::create([
            'id'                => '2',
            'rut'               => '',
            'nombre'            => 'Pablo',
            'apellido_paterno'  => 'Jimenez',
            'apellido_materno'  => '',
            'direccion'         => 'Av Apoquindo',
            'numero'            => '3669',
            'departamento'      => '1801',
            'id_estado'         => '1',
            'telefono'          => '229023010',
            'email'             => 'pablo@ibaquedano.cl',
            'id_comuna'         => '86',
            'id_region'         => '7',
            'id_provincia'      => '22',
            'tipo_cargo'        => 'Empleado',
            'cargo_id'          => '1',
         ]);


                        Persona::create([
            'id'                => '3',
            'rut'               => '',
            'nombre'            => 'Neila',
            'apellido_paterno'  => 'Chavez',
            'apellido_materno'  => '',
            'direccion'         => 'Av Apoquindo',
            'numero'            => '3669',
            'departamento'      => '1801',
            'id_estado'         => '1',
            'telefono'          => '229023010',
            'email'             => 'neila@ibaquedano.cl',
            'id_comuna'         => '109',
            'id_region'         => '7',
            'id_provincia'      => '25',
            'tipo_cargo'        => 'Empleado',
            'cargo_id'          => '5',
         ]);
                                Persona::create([
            'id'                => '4',
            'rut'               => '',
            'nombre'            => 'Daniela',
            'apellido_paterno'  => 'Gutierrez',
            'apellido_materno'  => '',
            'direccion'         => 'Av Apoquindo',
            'numero'            => '3669',
            'departamento'      => '1801',
            'id_estado'         => '1',
            'telefono'          => '229023010',
            'email'             => 'daniela@ibaquedano.cl',
            'id_comuna'         => '109',
            'id_region'         => '7',
            'id_provincia'      => '25',
            'tipo_cargo'        => 'Empleado',
            'cargo_id'          => '3',
         ]);
                                        Persona::create([
            'id'                => '5',
            'rut'               => '',
            'nombre'            => 'Javier',
            'apellido_paterno'  => 'Faria',
            'apellido_materno'  => '',
            'direccion'         => 'Av Apoquindo',
            'numero'            => '3669',
            'departamento'      => '1801',
            'id_estado'         => '1',
            'telefono'          => '229023010',
            'email'             => 'javier@ibaquedano.cl',
            'id_comuna'         => '109',
            'id_region'         => '7',
            'id_provincia'      => '25',
            'tipo_cargo'        => 'Empleado',
            'cargo_id'          => '3',
         ]);
                                        Persona::create([
            'id'                => '6',
            'rut'               => '',
            'nombre'            => 'Contact',
            'apellido_paterno'  => 'Center',
            'apellido_materno'  => '1',
            'direccion'         => 'Av Apoquindo',
            'numero'            => '3669',
            'departamento'      => '1801',
            'id_estado'         => '1',
            'telefono'          => '229023010',
            'email'             => 'contactcenter1@ibaquedano.cl',
            'id_comuna'         => '109',
            'id_region'         => '7',
            'id_provincia'      => '25',
            'tipo_cargo'        => 'Empleado',
            'cargo_id'          => '3',
         ]);
                                        Persona::create([
            'id'                => '7',
            'rut'               => '',
            'nombre'            => 'Contact',
            'apellido_paterno'  => 'Center',
            'apellido_materno'  => '1',
            'direccion'         => 'Av Apoquindo',
            'numero'            => '3669',
            'departamento'      => '1801',
            'id_estado'         => '1',
            'telefono'          => '229023010',
            'email'             => 'contactcenter2@ibaquedano.cl',
            'id_comuna'         => '109',
            'id_region'         => '7',
            'id_provincia'      => '25',
            'tipo_cargo'        => 'Empleado',
            'cargo_id'          => '3',
         ]);
                                        Persona::create([
            'id'                => '8',
            'rut'               => '',
            'nombre'            => 'Contact',
            'apellido_paterno'  => 'Center',
            'apellido_materno'  => '3',
            'direccion'         => 'Av Apoquindo',
            'numero'            => '3669',
            'departamento'      => '1801',
            'id_estado'         => '1',
            'telefono'          => '229023010',
            'email'             => 'contactcenter3@ibaquedano.cl',
            'id_comuna'         => '109',
            'id_region'         => '7',
            'id_provincia'      => '25',
            'tipo_cargo'        => 'Empleado',
            'cargo_id'          => '3',
         ]);
=======
>>>>>>> 4679f853b0fcb2262a0e335c0f5b7340c138e65c
    }
}
