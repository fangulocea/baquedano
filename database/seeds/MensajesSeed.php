<?php

use Illuminate\Database\Seeder;
use App\Mensajes;
use App\Condicion;
use App\CatalogoServicios;

class MensajesSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      /*  Condicion::create([
            'id'            => '1', 
            'descripcion'   => 'Traspaso Reserva',
            'nombre'        => 'Traspaso Reserva',
            'estado'        => '1'
        ]); */

        CatalogoServicios::create([
            'id'            => '1', 
            'id_creador'   => '1',
            'id_modificador'        => '1',
            'moneda'        => 'CLP',
            'detalle'        => 'Cargo por Servicio Post Venta Propietario',
            'fecha_moneda'        => '2018-08-01',
            'valor_moneda'        => '1',
            'valor_en_pesos'        => '1',
            'valor_en_moneda'        => '1',
            'nombre_servicio'        => 'Post Venta Propietario',
            'unidad_medida'        => 'C/U',
            'id_estado'        => '1'
        ]);

                CatalogoServicios::create([
            'id'            => '2', 
            'id_creador'   => '1',
            'id_modificador'        => '1',
            'moneda'        => 'CLP',
            'detalle'        => 'Cargo por Servicio Post Venta Arrendatario',
            'fecha_moneda'        => '2018-08-01',
            'valor_moneda'        => '1',
            'valor_en_pesos'        => '1',
            'valor_en_moneda'        => '1',
            'nombre_servicio'        => 'Post Venta Arrendatario',
            'unidad_medida'        => 'C/U',
            'id_estado'        => '1'
        ]);

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

                  Mensajes::create([
            'id'    => '18',
            'id_modulo'    => '1',
            'nombre_modulo'    => 'Solicitud Servicio',
            'id_estado'    => '0',
            'nombre' => 'No Vigente'
        ]);
             Mensajes::create([
            'id'    => '19',
            'id_modulo'    => '1',
            'nombre_modulo'    => 'Solicitud Servicio',
            'id_estado'    => '1',
            'nombre' => 'Vigente'
        ]);
              Mensajes::create([
            'id'    => '20',
            'id_modulo'    => '1',
            'nombre_modulo'    => 'Solicitud Servicio',
            'id_estado'    => '2',
            'nombre' => 'Asignado'
        ]);
         Mensajes::create([
            'id'    => '21',
            'id_modulo'    => '1',
            'nombre_modulo'    => 'Solicitud Servicio',
            'id_estado'    => '3',
            'nombre' => 'Autorizado'
        ]);
          Mensajes::create([
            'id'    => '22',
            'id_modulo'    => '1',
            'nombre_modulo'    => 'Solicitud Servicio',
            'id_estado'    => '4',
            'nombre' => 'Cerrada'
        ]);
        Mensajes::create([
            'id'    => '23',
            'id_modulo'    => '1',
            'nombre_modulo'    => 'Solicitud Servicio',
            'id_estado'    => '5',
            'nombre' => 'Anulada'
        ]);
        Mensajes::create([
            'id'    => '24',
            'id_modulo'    => '1',
            'nombre_modulo'    => 'Solicitud Servicio',
            'id_estado'    => '6',
            'nombre' => 'En Evaluación'
        ]);
        Mensajes::create([
            'id'    => '25',
            'id_modulo'    => '1',
            'nombre_modulo'    => 'Solicitud Servicio',
            'id_estado'    => '7',
            'nombre' => 'Cotizando'
        ]);

//ARRENDATARIO

Mensajes::create([
            'id_modulo'    => '1',
            'nombre_modulo'    => 'Arrendatario',
            'id_estado'    => '0',
            'nombre' => 'Descartado'
        ]);
          Mensajes::create([
            'id_modulo'    => '1',
            'nombre_modulo'    => 'Arrendatario',
            'id_estado'    => '1',
            'nombre' => 'Sin Gestión(Activo)'
        ]);
           Mensajes::create([
            'id_modulo'    => '1',
            'nombre_modulo'    => 'Arrendatario',
            'id_estado'    => '2',
            'nombre' => 'Activo'
        ]);
           Mensajes::create([
            'id_modulo'    => '1',
            'nombre_modulo'    => 'Arrendatario',
            'id_estado'    => '3',
            'nombre' => 'En Espera'
        ]);
          Mensajes::create([
            'id_modulo'    => '1',
            'nombre_modulo'    => 'Arrendatario',
            'id_estado'    => '4',
            'nombre' => 'Activo - Problema Pago'
        ]);
           Mensajes::create([
            'id_modulo'    => '1',
            'nombre_modulo'    => 'Arrendatario',
            'id_estado'    => '5',
            'nombre' => 'Activo - Daño inmueble'
        ]);
        Mensajes::create([
            'id_modulo'    => '1',
            'nombre_modulo'    => 'Arrendatario',
            'id_estado'    => '6',
            'nombre' => 'Contrato Borrador'
        ]);
           Mensajes::create([
            'id_modulo'    => '1',
            'nombre_modulo'    => 'Arrendatario',
            'id_estado'    => '7',
            'nombre' => 'No Activo - Daño inmueble'
        ]);
           Mensajes::create([
            'id_modulo'    => '1',
            'nombre_modulo'    => 'Arrendatario',
            'id_estado'    => '10',
            'nombre' => 'Contrato Proceso Firma'
        ]);
        Mensajes::create([
            'id_modulo'    => '1',
            'nombre_modulo'    => 'Arrendatario',
            'id_estado'    => '11',
            'nombre' => 'Contrato Firmado'
        ]);
           Mensajes::create([
            'id_modulo'    => '1',
            'nombre_modulo'    => 'Arrendatario',
            'id_estado'    => '12',
            'nombre' => 'No Activo - Problema Pago'
        ]);


//Revision

Mensajes::create([
            'id_modulo'    => '1',
            'nombre_modulo'    => 'Revisión Cuentas',
            'id_estado'    => '0',
            'nombre' => 'Descartado'
        ]);
          Mensajes::create([
            'id_modulo'    => '1',
            'nombre_modulo'    => 'Revisión Cuentas',
            'id_estado'    => '1',
            'nombre' => 'No Pagado'
        ]);
           Mensajes::create([
            'id_modulo'    => '1',
            'nombre_modulo'    => 'Revisión Cuentas',
            'id_estado'    => '2',
            'nombre' => 'Pagado'
        ]);
           Mensajes::create([
            'id_modulo'    => '1',
            'nombre_modulo'    => 'Revisión Cuentas',
            'id_estado'    => '3',
            'nombre' => 'Moroso'
        ]);



//Revision

Mensajes::create([
            'id_modulo'    => '1',
            'nombre_modulo'    => 'Borrador Propietario',
            'id_estado'    => '0',
            'nombre' => 'Rechazado'
        ]);
          Mensajes::create([
            'id_modulo'    => '1',
            'nombre_modulo'    => 'Borrador Propietario',
            'id_estado'    => '1',
            'nombre' => 'Vigente'
        ]);
           Mensajes::create([
            'id_modulo'    => '1',
            'nombre_modulo'    => 'Borrador Propietario',
            'id_estado'    => '2',
            'nombre' => 'Correo Enviado'
        ]);
           Mensajes::create([
            'id_modulo'    => '1',
            'nombre_modulo'    => 'Borrador Propietario',
            'id_estado'    => '3',
            'nombre' => 'Reenvío Correo'
        ]);

Mensajes::create([
            'id_modulo'    => '1',
            'nombre_modulo'    => 'Borrador Arrendatario',
            'id_estado'    => '0',
            'nombre' => 'Rechazado'
        ]);
          Mensajes::create([
            'id_modulo'    => '1',
            'nombre_modulo'    => 'Borrador Arrendatario',
            'id_estado'    => '1',
            'nombre' => 'Vigente'
        ]);
           Mensajes::create([
            'id_modulo'    => '1',
            'nombre_modulo'    => 'Borrador Arrendatario',
            'id_estado'    => '2',
            'nombre' => 'Correo Enviado'
        ]);
           Mensajes::create([
            'id_modulo'    => '1',
            'nombre_modulo'    => 'Borrador Arrendatario',
            'id_estado'    => '3',
            'nombre' => 'Reenvío Correo'
        ]);

Mensajes::create([
            'id_modulo'    => '1',
            'nombre_modulo'    => 'Post Venta',
            'id_estado'    => '0',
            'nombre' => 'Activo'
        ]);
          Mensajes::create([
            'id_modulo'    => '1',
            'nombre_modulo'    => 'Post Venta',
            'id_estado'    => '1',
            'nombre' => 'Asignado'
        ]);
           Mensajes::create([
            'id_modulo'    => '1',
            'nombre_modulo'    => 'Post Venta',
            'id_estado'    => '2',
            'nombre' => 'Cerrado'
        ]);
           Mensajes::create([
            'id_modulo'    => '1',
            'nombre_modulo'    => 'Post Venta',
            'id_estado'    => '3',
            'nombre' => 'Anulado'
        ]);
        Mensajes::create([
            'id_modulo'    => '1',
            'nombre_modulo'    => 'Post Venta',
            'id_estado'    => '4',
            'nombre' => 'En Evaluación'
        ]);
         Mensajes::create([
            'id_modulo'    => '1',
            'nombre_modulo'    => 'Post Venta',
            'id_estado'    => '4',
            'nombre' => 'Pendiente'
        ]);


Mensajes::create([
            'id_modulo'    => '1',
            'nombre_modulo'    => 'Presupuesto',
            'id_estado'    => '0',
            'nombre' => 'Activo'
        ]);
          Mensajes::create([
            'id_modulo'    => '1',
            'nombre_modulo'    => 'Presupuesto',
            'id_estado'    => '1',
            'nombre' => 'Aprobado'
        ]);
           Mensajes::create([
            'id_modulo'    => '1',
            'nombre_modulo'    => 'Presupuesto',
            'id_estado'    => '2',
            'nombre' => 'Rechazado'
        ]);
           Mensajes::create([
            'id_modulo'    => '1',
            'nombre_modulo'    => 'Presupuesto',
            'id_estado'    => '3',
            'nombre' => 'Anulado'
        ]);
        Mensajes::create([
            'id_modulo'    => '1',
            'nombre_modulo'    => 'Presupuesto',
            'id_estado'    => '4',
            'nombre' => 'En Evaluación'
        ]);
         Mensajes::create([
            'id_modulo'    => '1',
            'nombre_modulo'    => 'Presupuesto',
            'id_estado'    => '5',
            'nombre' => 'Pendiente'
        ]);



// CONTRATO FINAL


          Mensajes::create([
            'id_modulo'    => '1',
            'nombre_modulo'    => 'Contrato Final Propietario',
            'id_estado'    => '1',
            'nombre' => 'Proceso de Firma'
        ]);
           Mensajes::create([
            'id_modulo'    => '1',
            'nombre_modulo'    => 'Contrato Final Propietario',
            'id_estado'    => '2',
            'nombre' => 'Contrato Activo'
        ]);
           Mensajes::create([
            'id_modulo'    => '1',
            'nombre_modulo'    => 'Contrato Final Propietario',
            'id_estado'    => '3',
            'nombre' => 'Contrato Vencido'
        ]);
        Mensajes::create([
            'id_modulo'    => '1',
            'nombre_modulo'    => 'Contrato Final Propietario',
            'id_estado'    => '4',
            'nombre' => 'Anexo Contrato'
        ]);
         Mensajes::create([
            'id_modulo'    => '1',
            'nombre_modulo'    => 'Contrato Final Propietario',
            'id_estado'    => '5',
            'nombre' => 'Menor 60 días para vencer'
        ]);
         Mensajes::create([
            'id_modulo'    => '1',
            'nombre_modulo'    => 'Contrato Final Propietario',
            'id_estado'    => '6',
            'nombre' => 'Cerrado por Propietario'
        ]);
         Mensajes::create([
            'id_modulo'    => '1',
            'nombre_modulo'    => 'Contrato Final Propietario',
            'id_estado'    => '13',
            'nombre' => ' Finalizado Propietario'
        ]);
         Mensajes::create([
            'id_modulo'    => '1',
            'nombre_modulo'    => 'Contrato Final Propietario',
            'id_estado'    => '14',
            'nombre' => ' Finalizado Arrendatario'
        ]);
    

//PAGO PROPIETARIO

          Mensajes::create([
            'id_modulo'    => '1',
            'nombre_modulo'    => 'Pago Propietario',
            'id_estado'    => '1',
            'nombre' => 'No Pagado'
        ]);
           Mensajes::create([
            'id_modulo'    => '1',
            'nombre_modulo'    => 'Pago Propietario',
            'id_estado'    => '2',
            'nombre' => 'Pago Parcial'
        ]);
           Mensajes::create([
            'id_modulo'    => '1',
            'nombre_modulo'    => 'Pago Propietario',
            'id_estado'    => '3',
            'nombre' => 'Pagado'
        ]);
        Mensajes::create([
            'id_modulo'    => '1',
            'nombre_modulo'    => 'Pago Propietario',
            'id_estado'    => '4',
            'nombre' => 'Vencido'
        ]);

//TIPOS DE PAGO

          Mensajes::create([
            'id_modulo'    => '1',
            'nombre_modulo'    => 'Tipos de Pago',
            'id_estado'    => '8',
            'nombre' => 'Días Proporcionales'
        ]);
           Mensajes::create([
            'id_modulo'    => '1',
            'nombre_modulo'    => 'Tipos de Pago',
            'id_estado'    => '1',
            'nombre' => 'Canon de Arriendo'
        ]);
           Mensajes::create([
            'id_modulo'    => '1',
            'nombre_modulo'    => 'Tipos de Pago',
            'id_estado'    => '2',
            'nombre' => 'Gasto Común'
        ]);
        Mensajes::create([
            'id_modulo'    => '1',
            'nombre_modulo'    => 'Tipos de Pago',
            'id_estado'    => '3',
            'nombre' => 'Cuota'
        ]);

          Mensajes::create([
            'id_modulo'    => '1',
            'nombre_modulo'    => 'Tipos de Pago',
            'id_estado'    => '4',
            'nombre' => 'IVA'
        ]);
           Mensajes::create([
            'id_modulo'    => '1',
            'nombre_modulo'    => 'Tipos de Pago',
            'id_estado'    => '5',
            'nombre' => 'Notaria'
        ]);
           Mensajes::create([
            'id_modulo'    => '1',
            'nombre_modulo'    => 'Tipos de Pago',
            'id_estado'    => '6',
            'nombre' => 'Pago Personalizado 1'
        ]);
        Mensajes::create([
            'id_modulo'    => '1',
            'nombre_modulo'    => 'Tipos de Pago',
            'id_estado'    => '7',
            'nombre' => 'Pago Personalizado 2'
        ]);

          Mensajes::create([
            'id_modulo'    => '1',
            'nombre_modulo'    => 'Tipos de Pago',
            'id_estado'    => '10',
            'nombre' => 'Reserva'
        ]);
           Mensajes::create([
            'id_modulo'    => '1',
            'nombre_modulo'    => 'Tipos de Pago',
            'id_estado'    => '11',
            'nombre' => 'Garantía'
        ]);
           Mensajes::create([
            'id_modulo'    => '1',
            'nombre_modulo'    => 'Tipos de Pago',
            'id_estado'    => '15',
            'nombre' => 'Pago Pendiente'
        ]);
        Mensajes::create([
            'id_modulo'    => '1',
            'nombre_modulo'    => 'Tipos de Pago',
            'id_estado'    => '20',
            'nombre' => 'Total Costos Propietario'
        ]);

          Mensajes::create([
            'id_modulo'    => '1',
            'nombre_modulo'    => 'Tipos de Pago',
            'id_estado'    => '21',
            'nombre' => 'Saldo a depositar'
        ]);
           Mensajes::create([
            'id_modulo'    => '1',
            'nombre_modulo'    => 'Tipos de Pago',
            'id_estado'    => '34',
            'nombre' => 'Total Costos Arrendatario'
        ]);
           Mensajes::create([
            'id_modulo'    => '1',
            'nombre_modulo'    => 'Tipos de Pago',
            'id_estado'    => '35',
            'nombre' => 'Saldo a depositar'
        ]);
        Mensajes::create([
            'id_modulo'    => '1',
            'nombre_modulo'    => 'Tipos de Pago',
            'id_estado'    => '16',
            'nombre' => 'Otros Cargos'
        ]);

          Mensajes::create([
            'id_modulo'    => '1',
            'nombre_modulo'    => 'Tipos de Pago',
            'id_estado'    => '17',
            'nombre' => 'Otros Abonos'
        ]);

}

}
