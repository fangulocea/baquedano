<?php

use Illuminate\Database\Seeder;
use App\Mensajes;

class MensajesSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Mensajes::create([
            'id'    => '1',
        	'id_modulo'    => '1',
        	'nombre_modulo'    => 'Captación',
        	'id_estado'    => '0',
        	'nombre' => 'Descartado'
        ]);
          Mensajes::create([
            'id'    => '2',
        	'id_modulo'    => '1',
        	'nombre_modulo'    => 'Captación',
        	'id_estado'    => '1',
        	'nombre' => 'Sin Gestión'
        ]);
           Mensajes::create([
            'id'    => '3',
        	'id_modulo'    => '1',
        	'nombre_modulo'    => 'Captación',
        	'id_estado'    => '2',
        	'nombre' => 'Sin Respuesta'
        ]);
            Mensajes::create([
            'id'    => '4',
        	'id_modulo'    => '1',
        	'nombre_modulo'    => 'Captación',
        	'id_estado'    => '3',
        	'nombre' => 'Reenvío'
        ]);
             Mensajes::create([
            'id'    => '5',
        	'id_modulo'    => '1',
        	'nombre_modulo'    => 'Captación',
        	'id_estado'    => '4',
        	'nombre' => 'Expirado'
        ]);
              Mensajes::create([
            'id'    => '6',
        	'id_modulo'    => '1',
        	'nombre_modulo'    => 'Captación',
        	'id_estado'    => '5',
        	'nombre' => 'Negociación'
        ]);
               Mensajes::create([
            'id'    => '7',
        	'id_modulo'    => '1',
        	'nombre_modulo'    => 'Captación',
        	'id_estado'    => '6',
        	'nombre' => 'Contrato Borrador'
        ]);
                Mensajes::create([
            'id'    => '8',
        	'id_modulo'    => '1',
        	'nombre_modulo'    => 'Captación',
        	'id_estado'    => '7',
        	'nombre' => 'Contrato Firmado'
        ]);
         Mensajes::create([
            'id'    => '9',
        	'id_modulo'    => '1',
        	'nombre_modulo'    => 'Captación',
        	'id_estado'    => '8',
        	'nombre' => 'Seguimiento Correo'
        ]);
         Mensajes::create([
            'id'    => '10',
        	'id_modulo'    => '1',
        	'nombre_modulo'    => 'Captación',
        	'id_estado'    => '9',
        	'nombre' => 'Captación Terreno'
        ]);
         Mensajes::create([
            'id'    => '11',
        	'id_modulo'    => '1',
        	'nombre_modulo'    => 'Captación',
        	'id_estado'    => '10',
        	'nombre' => 'Contrato Proceso Firma'
        ]);
          Mensajes::create([
            'id'    => '12',
            'id_modulo'    => '1',
            'nombre_modulo'    => 'Vigencia',
            'id_estado'    => '0',
            'nombre' => 'No Vigente'
        ]);
          Mensajes::create([
            'id'    => '13',
            'id_modulo'    => '1',
            'nombre_modulo'    => 'Vigencia',
            'id_estado'    => '1',
            'nombre' => 'Vigente'
        ]);
           Mensajes::create([
            'id'    => '14',
            'id_modulo'    => '1',
            'nombre_modulo'    => 'Vigencia',
            'id_estado'    => '2',
            'nombre' => 'Sin Respuesta'
        ]);
            Mensajes::create([
            'id'    => '15',
            'id_modulo'    => '1',
            'nombre_modulo'    => 'Inmueble',
            'id_estado'    => '0',
            'nombre' => 'No Vigente'
        ]);
             Mensajes::create([
            'id'    => '16',
            'id_modulo'    => '1',
            'nombre_modulo'    => 'Inmueble',
            'id_estado'    => '1',
            'nombre' => 'Vigente'
        ]);
              Mensajes::create([
            'id'    => '17',
            'id_modulo'    => '1',
            'nombre_modulo'    => 'Inmueble',
            'id_estado'    => '2',
            'nombre' => 'Reservado'
        ]);
    }
}
