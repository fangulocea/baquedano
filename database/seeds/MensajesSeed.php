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
            'id'    => '1',
        	'id_modulo'    => '1',
        	'nombre_modulo'    => 'Captación',
        	'id_estado'    => '1',
        	'nombre' => 'Sin Gestión'
        ]);
           Mensajes::create([
            'id'    => '1',
        	'id_modulo'    => '1',
        	'nombre_modulo'    => 'Captación',
        	'id_estado'    => '2',
        	'nombre' => 'Sin Respuesta'
        ]);
            Mensajes::create([
            'id'    => '1',
        	'id_modulo'    => '1',
        	'nombre_modulo'    => 'Captación',
        	'id_estado'    => '3',
        	'nombre' => 'Reenvío'
        ]);
             Mensajes::create([
            'id'    => '1',
        	'id_modulo'    => '1',
        	'nombre_modulo'    => 'Captación',
        	'id_estado'    => '4',
        	'nombre' => 'Expirado'
        ]);
              Mensajes::create([
            'id'    => '1',
        	'id_modulo'    => '1',
        	'nombre_modulo'    => 'Captación',
        	'id_estado'    => '5',
        	'nombre' => 'Negociación'
        ]);
               Mensajes::create([
            'id'    => '1',
        	'id_modulo'    => '1',
        	'nombre_modulo'    => 'Captación',
        	'id_estado'    => '6',
        	'nombre' => 'Contrato Borrador'
        ]);
                Mensajes::create([
            'id'    => '1',
        	'id_modulo'    => '1',
        	'nombre_modulo'    => 'Captación',
        	'id_estado'    => '7',
        	'nombre' => 'Contrato Firmado'
        ]);
         Mensajes::create([
            'id'    => '1',
        	'id_modulo'    => '1',
        	'nombre_modulo'    => 'Captación',
        	'id_estado'    => '8',
        	'nombre' => 'Seguimiento Correo'
        ]);
         Mensajes::create([
            'id'    => '1',
        	'id_modulo'    => '1',
        	'nombre_modulo'    => 'Captación',
        	'id_estado'    => '9',
        	'nombre' => 'Captación Terreno'
        ]);
         Mensajes::create([
            'id'    => '1',
        	'id_modulo'    => '1',
        	'nombre_modulo'    => 'Captación',
        	'id_estado'    => '9',
        	'nombre' => 'Contrato Proceso Firma'
        ]);
    }
}
