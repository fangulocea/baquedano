<?php

use Illuminate\Database\Seeder;
use Caffeinated\Shinobi\Models\Permission;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Permission::create([
            'id'            =>  1,
            'name'          =>  'contactcenter',
            'slug'          =>  'contactcenter.index',
            'description'   =>  'Acceso a captación Contact Center',
        ]);

    //Captacion
        Permission::create([
             'id'            =>  2,
            'name'          =>  'Listado de captación',
            'slug'          =>  'captacion.index',
            'description'   =>  'Despliega captacion',
        ]);
        Permission::create([
             'id'            =>  3,
            'name'          =>  'Ver detalle de captación',
            'slug'          =>  'captacion.show',
            'description'   =>  'Despliega el detalle del captacion ',
        ]);
        Permission::create([
            'name'          =>  'Crea captación',
             'id'            =>  4,
            'slug'          =>  'captacion.create',
            'description'   =>  'Crear captacion del sistema',
        ]);
        Permission::create([
            'name'          =>  'Edición de captación',
             'id'            =>  5,
            'slug'          =>  'captacion.edit',
            'description'   =>  'Editar captacion del sistema',
        ]);
        Permission::create([
            'name'          =>  'Desactiva captación',
             'id'            =>  6,
            'slug'          =>  'captacion.destroy',
            'description'   =>  'Desactiva captacion del sistema',
        ]);


    	//usuarios
        Permission::create([
        	'name'			=>	'Listado de Usuarios',
        	'slug'			=>	'users.index',
        	'description'	=>	'Despliega los usuarios del sistema',
        ]);
        Permission::create([
        	'name'			=>	'Ver detalle de Usuarios',
        	'slug'			=>	'users.show',
        	'description'	=>	'Despliega el detalle del usuario',
        ]);
        Permission::create([
        	'name'			=>	'Crear Usuarios',
        	'slug'			=>	'users.create',
        	'description'	=>	'Crear los usuarios del sistema',
        ]);
        Permission::create([
        	'name'			=>	'Edición de Usuarios',
        	'slug'			=>	'users.edit',
        	'description'	=>	'Editar los usuarios del sistema',
        ]);
        Permission::create([
        	'name'			=>	'Desactivar Usuarios',
        	'slug'			=>	'users.destroy',
        	'description'	=>	'Desactivar usuarios del sistema',
        ]);
        Permission::create([
            'name'          =>  'Reset Password',
            'slug'          =>  'users.reset',
            'description'   =>  'Reset Password del sistema',
        ]);
        //Roles
        Permission::create([
        	'name'			=>	'Listado de Roles',
        	'slug'			=>	'roles.index',
        	'description'	=>	'Despliega los Roles del sistema',
        ]);
        Permission::create([
        	'name'			=>	'Ver detalle de Roles',
        	'slug'			=>	'roles.show',
        	'description'	=>	'Despliega el detalle del rol',
        ]);
        Permission::create([
        	'name'			=>	'Crear Roles',
        	'slug'			=>	'roles.create',
        	'description'	=>	'Crear los Roles del sistema',
        ]);
        Permission::create([
        	'name'			=>	'Edición de Roles',
        	'slug'			=>	'roles.edit',
        	'description'	=>	'Editar los Roles del sistema',
        ]);
        Permission::create([
        	'name'			=>	'Desactivar Roles',
        	'slug'			=>	'roles.destroy',
        	'description'	=>	'Desactivar Roles del sistema',
        ]);
         //Notarias
        Permission::create([
            'name'          =>  'Listado de Notarias',
            'slug'          =>  'notarias.index',
            'description'   =>  'Despliega las Notarias del sistema',
        ]);
        Permission::create([
            'name'          =>  'Ver detalle de Notarias',
            'slug'          =>  'notarias.show',
            'description'   =>  'Despliega el detalle de la Notaria',
        ]);
        Permission::create([
            'name'          =>  'Crea Notarias',
            'slug'          =>  'notarias.create',
            'description'   =>  'Crear las Notarias del sistema',
        ]);
        Permission::create([
            'name'          =>  'Edición d Notarias',
            'slug'          =>  'notarias.edit',
            'description'   =>  'Editar las Notarias del sistema',
        ]);
        Permission::create([
            'name'          =>  'Desactiva Notarias',
            'slug'          =>  'notarias.destroy',
            'description'   =>  'Desactiva Notarias del sistema',
        ]);
         //Condicion
        Permission::create([
            'name'          =>  'Listado de Condiciones',
            'slug'          =>  'condicion.index',
            'description'   =>  'Despliega lo Condiciones del sistema',
        ]);
        Permission::create([
            'name'          =>  'Ver detalle de Condiciones',
            'slug'          =>  'condicion.show',
            'description'   =>  'Despliega el detalle de la Notaria',
        ]);
        Permission::create([
            'name'          =>  'Crea Condiciones',
            'slug'          =>  'condicion.create',
            'description'   =>  'Crear las Condiciones del sistema',
        ]);
        Permission::create([
            'name'          =>  'Edición d Condiciones',
            'slug'          =>  'condicion.edit',
            'description'   =>  'Editar las Condiciones del sistema',
        ]);
        Permission::create([
            'name'          =>  'Desactiva Condiciones',
            'slug'          =>  'condicion.destroy',
            'description'   =>  'Desactiva Condiciones del sistema',
        ]);
        //Inmueble
        Permission::create([
            'name'          =>  'Listado de Inmuebles',
            'slug'          =>  'inmueble.index',
            'description'   =>  'Despliega los Inmuebles del sistema',
        ]);
        Permission::create([
            'name'          =>  'Ver detalle de Inmuebles',
            'slug'          =>  'inmueble.show',
            'description'   =>  'Despliega el detalle del inmueble',
        ]);
        Permission::create([
            'name'          =>  'Crea Inmuebles',
            'slug'          =>  'inmueble.create',
            'description'   =>  'Crear las Inmuebles del sistema',
        ]);
        Permission::create([
            'name'          =>  'Edición d Inmuebles',
            'slug'          =>  'inmueble.edit',
            'description'   =>  'Editar las Inmuebles del sistema',
        ]);
        Permission::create([
            'name'          =>  'Desactiva Inmuebles',
            'slug'          =>  'inmueble.destroy',
            'description'   =>  'Desactiva Inmuebles del sistema',
        ]);
        //Cargos
        Permission::create([
            'name'          =>  'Listado de Cargos',
            'slug'          =>  'cargo.index',
            'description'   =>  'Despliega los cargos del sistema',
        ]);
        Permission::create([
            'name'          =>  'Ver detalle de Cargos',
            'slug'          =>  'cargo.show',
            'description'   =>  'Despliega el detalle del cargo',
        ]);
        Permission::create([
            'name'          =>  'Crea Cargos',
            'slug'          =>  'cargo.create',
            'description'   =>  'Crear las Cargos del sistema',
        ]);
        Permission::create([
            'name'          =>  'Edición de Cargos',
            'slug'          =>  'cargo.edit',
            'description'   =>  'Editar las Cargos del sistema',
        ]);
        Permission::create([
            'name'          =>  'Desactiva Cargos',
            'slug'          =>  'cargo.destroy',
            'description'   =>  'Desactiva Cargos del sistema',
        ]);
        //Personas
        Permission::create([
            'name'          =>  'Listado de Personas',
            'slug'          =>  'persona.index',
            'description'   =>  'Despliega personas del sistema',
        ]);
        Permission::create([
            'name'          =>  'Ver detalle de Personas',
            'slug'          =>  'persona.show',
            'description'   =>  'Despliega el detalle de la Notaria',
        ]);
        Permission::create([
            'name'          =>  'Crea Personas',
            'slug'          =>  'persona.create',
            'description'   =>  'Crear las Personas del sistema',
        ]);
        Permission::create([
            'name'          =>  'Edición de Personas',
            'slug'          =>  'persona.edit',
            'description'   =>  'Editar las Personas del sistema',
        ]);
        Permission::create([
            'name'          =>  'Desactiva Personas',
            'slug'          =>  'persona.destroy',
            'description'   =>  'Desactiva Personas del sistema',
        ]);
//Multas
        Permission::create([
            'name'          =>  'Listado de Multa',
            'slug'          =>  'multa.index',
            'description'   =>  'Despliega multa del sistema',
        ]);
        Permission::create([
            'name'          =>  'Ver detalle de Multa',
            'slug'          =>  'multa.show',
            'description'   =>  'Despliega el detalle de la multa',
        ]);
        Permission::create([
            'name'          =>  'Crea Multa',
            'slug'          =>  'multa.create',
            'description'   =>  'Crear las Multa del sistema',
        ]);
        Permission::create([
            'name'          =>  'Edición de Multa',
            'slug'          =>  'multa.edit',
            'description'   =>  'Editar las Multa del sistema',
        ]);
        Permission::create([
            'name'          =>  'Desactiva Multa',
            'slug'          =>  'multa.destroy',
            'description'   =>  'Desactiva Multa del sistema',
        ]);
//Servicio
        Permission::create([
            'name'          =>  'Listado de Servicio',
            'slug'          =>  'servicio.index',
            'description'   =>  'Despliega servicios',
        ]);
        Permission::create([
            'name'          =>  'Ver detalle de Servicio',
            'slug'          =>  'servicio.show',
            'description'   =>  'Despliega el detalle del servicio ',
        ]);
        Permission::create([
            'name'          =>  'Crea Servicio',
            'slug'          =>  'servicio.create',
            'description'   =>  'Crear Servicio del sistema',
        ]);
        Permission::create([
            'name'          =>  'Edición de Servicio',
            'slug'          =>  'servicio.edit',
            'description'   =>  'Editar Servicio del sistema',
        ]);
        Permission::create([
            'name'          =>  'Desactiva Servicio',
            'slug'          =>  'servicio.destroy',
            'description'   =>  'Desactiva Servicio del sistema',
        ]);
    



        //Formas de Pago
        Permission::create([
            'name'          =>  'Listado de forma de pago',
            'slug'          =>  'formasDePago.index',
            'description'   =>  'Despliega forma de pago',
        ]);
        Permission::create([
            'name'          =>  'Ver detalle de forma de pago',
            'slug'          =>  'formasDePago.show',
            'description'   =>  'Despliega el detalle del forma de pago ',
        ]);
        Permission::create([
            'name'          =>  'Crea forma de pago',
            'slug'          =>  'formasDePago.create',
            'description'   =>  'Crear forma de pago del sistema',
        ]);
        Permission::create([
            'name'          =>  'Edición de forma de pago',
            'slug'          =>  'formasDePago.edit',
            'description'   =>  'Editar forma de pago del sistema',
        ]);
        Permission::create([
            'name'          =>  'Desactiva forma de pago',
            'slug'          =>  'formasDePago.destroy',
            'description'   =>  'Desactiva forma de pago del sistema',
        ]);

        //Comision
        Permission::create([
            'name'          =>  'Listado de comision',
            'slug'          =>  'comision.index',
            'description'   =>  'Despliega forma de pago',
        ]);
        Permission::create([
            'name'          =>  'Ver detalle de comision',
            'slug'          =>  'comision.show',
            'description'   =>  'Despliega el detalle de comision ',
        ]);
        Permission::create([
            'name'          =>  'Crea comision',
            'slug'          =>  'comision.create',
            'description'   =>  'Crear comision del sistema',
        ]);
        Permission::create([
            'name'          =>  'Edición de comision',
            'slug'          =>  'comision.edit',
            'description'   =>  'Editar comision del sistema',
        ]);
        Permission::create([
            'name'          =>  'Desactiva  comision',
            'slug'          =>  'comision.destroy',
            'description'   =>  'Desactiva comision del sistema',
        ]);

         //Flexibilidad
        Permission::create([
            'name'          =>  'Listado de flexibilidad',
            'slug'          =>  'flexibilidad.index',
            'description'   =>  'Despliega forma de pago',
        ]);
        Permission::create([
            'name'          =>  'Ver detalle de flexibilidad',
            'slug'          =>  'flexibilidad.show',
            'description'   =>  'Despliega el detalle de flexibilidad ',
        ]);
        Permission::create([
            'name'          =>  'Crea flexibilidad',
            'slug'          =>  'flexibilidad.create',
            'description'   =>  'Crear flexibilidad del sistema',
        ]);
        Permission::create([
            'name'          =>  'Edición de flexibilidad',
            'slug'          =>  'flexibilidad.edit',
            'description'   =>  'Editar flexibilidad del sistema',
        ]);
        Permission::create([
            'name'          =>  'Desactiva  flexibilidad',
            'slug'          =>  'flexibilidad.destroy',
            'description'   =>  'Desactiva flexibilidad del sistema',
        ]);

        //Persona InmueblepersonaInmueble
        Permission::create([
            'name'          =>  'Listado de personaInmueble',
            'slug'          =>  'personaInmueble.index',
            'description'   =>  'Despliega forma de pago',
        ]);
        Permission::create([
            'name'          =>  'Ver detalle de personaInmueble',
            'slug'          =>  'personaInmueble.show',
            'description'   =>  'Despliega el detalle de personaInmueble ',
        ]);
        Permission::create([
            'name'          =>  'Crea personaInmueble',
            'slug'          =>  'personaInmueble.create',
            'description'   =>  'Crear personaInmueble del sistema',
        ]);
        Permission::create([
            'name'          =>  'Edición de personaInmueble',
            'slug'          =>  'personaInmueble.edit',
            'description'   =>  'Editar personaInmueble del sistema',
        ]);
        Permission::create([
            'name'          =>  'Desactiva  personaInmueble',
            'slug'          =>  'personaInmueble.destroy',
            'description'   =>  'Desactiva personaInmueble del sistema',
        ]);
        //Correo Tipo
        Permission::create([
            'name'          =>  'Listado de Correo',
            'slug'          =>  'correo.index',
            'description'   =>  'Despliega Correo',
        ]);
        Permission::create([
            'name'          =>  'Ver detalle de Correo',
            'slug'          =>  'correo.show',
            'description'   =>  'Despliega el detalle de Correo ',
        ]);
        Permission::create([
            'name'          =>  'Crea Correo',
            'slug'          =>  'correo.create',
            'description'   =>  'Crear Correo del sistema',
        ]);
        Permission::create([
            'name'          =>  'Edición de Correo',
            'slug'          =>  'correo.edit',
            'description'   =>  'Editar Correo del sistema',
        ]);
        Permission::create([
            'name'          =>  'Desactiva  correo',
            'slug'          =>  'correo.destroy',
            'description'   =>  'Desactiva correo del sistema',
        ]);
        //primeraGestion
        Permission::create([
            'name'          =>  'Listado de primeraGestion',
            'slug'          =>  'primeraGestion.index',
            'description'   =>  'Despliega primeraGestion',
        ]);
        Permission::create([
            'name'          =>  'Ver detalle de primeraGestion',
            'slug'          =>  'primeraGestion.show',
            'description'   =>  'Despliega el detalle de primeraGestion ',
        ]);
        Permission::create([
            'name'          =>  'Crea primeraGestion',
            'slug'          =>  'primeraGestion.create',
            'description'   =>  'Crear primeraGestion del sistema',
        ]);
        Permission::create([
            'name'          =>  'Edición de primeraGestion',
            'slug'          =>  'primeraGestion.edit',
            'description'   =>  'Editar primeraGestion del sistema',
        ]);
        Permission::create([
            'name'          =>  'Desactiva  primeraGestion',
            'slug'          =>  'primeraGestion.destroy',
            'description'   =>  'Desactiva primeraGestion del sistema',
        ]);
        //Portales
        Permission::create([
            'name'          =>  'Listado de Portales',
            'slug'          =>  'portal.index',
            'description'   =>  'Despliega Portales',
        ]);
        Permission::create([
            'name'          =>  'Ver detalle de Portales',
            'slug'          =>  'portal.show',
            'description'   =>  'Despliega el detalle de Portales ',
        ]);
        Permission::create([
            'name'          =>  'Crea Portales',
            'slug'          =>  'portal.create',
            'description'   =>  'Crear Portales del sistema',
        ]);
        Permission::create([
            'name'          =>  'Edición de Portales',
            'slug'          =>  'portal.edit',
            'description'   =>  'Editar Portales del sistema',
        ]);
        Permission::create([
            'name'          =>  'Desactiva  Portales',
            'slug'          =>  'portal.destroy',
            'description'   =>  'Desactiva Portales del sistema',
        ]);
//revisioncomercial
        Permission::create([
            'name'          =>  'Listado de revisiones comerciales',
            'slug'          =>  'revisioncomercial.index',
            'description'   =>  'Despliega revisiones comerciales',
        ]);
        Permission::create([
            'name'          =>  'Ver detalle de revisión comercial',
            'slug'          =>  'revisioncomercial.show',
            'description'   =>  'Despliega el detalle de Portales ',
        ]);
        Permission::create([
            'name'          =>  'Crea revisión comercial',
            'slug'          =>  'revisioncomercial.create',
            'description'   =>  'Crear revisión comercial del sistema',
        ]);
        Permission::create([
            'name'          =>  'Edición de revisión comercial',
            'slug'          =>  'revisioncomercial.edit',
            'description'   =>  'Editar revisión comercial del sistema',
        ]);
        Permission::create([
            'name'          =>  'Desactiva  revisión comercial',
            'slug'          =>  'revisioncomercial.destroy',
            'description'   =>  'Desactiva revisión comercial del sistema',
        ]);

//Contrato Mantenedor
        Permission::create([
            'name'          =>  'Listado de Contrato',
            'slug'          =>  'contrato.index',
            'description'   =>  'Despliega servicios',
        ]);
        Permission::create([
            'name'          =>  'Ver detalle de Contrato',
            'slug'          =>  'contrato.show',
            'description'   =>  'Despliega el detalle del Contrato ',
        ]);
        Permission::create([
            'name'          =>  'Crea Contrato',
            'slug'          =>  'contrato.create',
            'description'   =>  'Crear Contrato del sistema',
        ]);
        Permission::create([
            'name'          =>  'Edición de Contrato',
            'slug'          =>  'contrato.edit',
            'description'   =>  'Editar Contrato del sistema',
        ]);
        Permission::create([
            'name'          =>  'Desactiva Contrato',
            'slug'          =>  'contrato.destroy',
            'description'   =>  'Desactiva Contrato del sistema',
        ]);
    
//Contrato Borrador
        Permission::create([
            'name'          =>  'Listado de Contrato Borrador',
            'slug'          =>  'borradorContrato.index',
            'description'   =>  'Despliega servicios',
        ]);
        Permission::create([
            'name'          =>  'Ver detalle de Contrato Borrador',
            'slug'          =>  'borradorContrato.show',
            'description'   =>  'Despliega el detalle del Contrato Borrador ',
        ]);
        Permission::create([
            'name'          =>  'Crea Contrato Borrador',
            'slug'          =>  'borradorContrato.create',
            'description'   =>  'Crear Contrato Borrador del sistema',
        ]);
        Permission::create([
            'name'          =>  'Edición de Contrato Borrador',
            'slug'          =>  'borradorContrato.edit',
            'description'   =>  'Editar Contrato Borrador del sistema',
        ]);
        Permission::create([
            'name'          =>  'Desactiva Contrato Borrador',
            'slug'          =>  'borradorContrato.destroy',
            'description'   =>  'Desactiva Contrato Borrador del sistema',
        ]);


//Contrato final
        Permission::create([
            'name'          =>  'Listado de Contrato final',
            'slug'          =>  'finalContrato.index',
            'description'   =>  'Despliega servicios',
        ]);
        Permission::create([
            'name'          =>  'Ver detalle de Contrato final',
            'slug'          =>  'finalContrato.show',
            'description'   =>  'Despliega el detalle del Contrato final ',
        ]);
        Permission::create([
            'name'          =>  'Crea Contrato final',
            'slug'          =>  'finalContrato.create',
            'description'   =>  'Crear Contrato final del sistema',
        ]);
        Permission::create([
            'name'          =>  'Edición de Contrato final',
            'slug'          =>  'finalContrato.edit',
            'description'   =>  'Editar Contrato final del sistema',
        ]);
        Permission::create([
            'name'          =>  'Desactiva Contrato final',
            'slug'          =>  'finalContrato.destroy',
            'description'   =>  'Desactiva Contrato final del sistema',
        ]);



//Contrato Borrador Arrendatario
        Permission::create([
            'name'          =>  'Listado de Contrato borrador arrendatario',
            'slug'          =>  'contratoborradorarrendatario.index',
            'description'   =>  'Despliega borrador arrendatario',
        ]);
        Permission::create([
            'name'          =>  'Ver detalle de Contrato borrador arrendatario',
            'slug'          =>  'contratoborradorarrendatario.show',
            'description'   =>  'Despliega el detalle del Contrato borrador arrendatario ',
        ]);
        Permission::create([
            'name'          =>  'Crea Contrato borrador arrendatario',
            'slug'          =>  'contratoborradorarrendatario.create',
            'description'   =>  'Crear Contrato borrador arrendatario del sistema',
        ]);
        Permission::create([
            'name'          =>  'Edición de Contrato borrador arrendatario',
            'slug'          =>  'contratoborradorarrendatario.edit',
            'description'   =>  'Editar Contrato borrador arrendatario del sistema',
        ]);
        Permission::create([
            'name'          =>  'Desactiva Contrato borrador arrendatario',
            'slug'          =>  'contratoborradorarrendatario.destroy',
            'description'   =>  'Desactiva Contrato borrador arrendatario del sistema',
        ]);


//Contrato Final Arrendatario
        Permission::create([
            'name'          =>  'Listado de Contrato final arrendatario',
            'slug'          =>  'finalContratoArr.index',
            'description'   =>  'Despliega final arrendatario',
        ]);
        Permission::create([
            'name'          =>  'Ver detalle de Contrato final arrendatario',
            'slug'          =>  'finalContratoArr.show',
            'description'   =>  'Despliega el detalle del Contrato final arrendatario ',
        ]);
        Permission::create([
            'name'          =>  'Crea Contrato final arrendatario',
            'slug'          =>  'finalContratoArr.create',
            'description'   =>  'Crear Contrato final arrendatario del sistema',
        ]);
        Permission::create([
            'name'          =>  'Edición de Contrato final arrendatario',
            'slug'          =>  'finalContratoArr.edit',
            'description'   =>  'Editar Contrato final arrendatario del sistema',
        ]);
        Permission::create([
            'name'          =>  'Desactiva Contrato final arrendatario',
            'slug'          =>  'finalContratoArr.destroy',
            'description'   =>  'Desactiva Contrato final arrendatario del sistema',
        ]);


//UF
        Permission::create([
            'name'          =>  'Listado de UFs',
            'slug'          =>  'uf.index',
            'description'   =>  'Despliega UF',
        ]);
        Permission::create([
            'name'          =>  'Ver detalle de UF',
            'slug'          =>  'uf.show',
            'description'   =>  'Despliega el detalle del UF ',
        ]);
        Permission::create([
            'name'          =>  'Crea UF',
            'slug'          =>  'uf.create',
            'description'   =>  'Crear UF del sistema',
        ]);
        Permission::create([
            'name'          =>  'Edición de UF',
            'slug'          =>  'uf.edit',
            'description'   =>  'Editar UF del sistema',
        ]);
        Permission::create([
            'name'          =>  'Desactiva UF',
            'slug'          =>  'uf.destroy',
            'description'   =>  'Desactiva UF del sistema',
        ]);

//Catalogo de Servicios
        Permission::create([
            'name'          =>  'Listado de Servicios',
            'slug'          =>  'catalogo.index',
            'description'   =>  'Despliega Servicios',
        ]);
        Permission::create([
            'name'          =>  'Ver detalle de Servicios',
            'slug'          =>  'catalogo.show',
            'description'   =>  'Despliega el detalle del Servicios ',
        ]);
        Permission::create([
            'name'          =>  'Crea Servicios',
            'slug'          =>  'catalogo.create',
            'description'   =>  'Crear Servicios del sistema',
        ]);
        Permission::create([
            'name'          =>  'Edición de Servicios',
            'slug'          =>  'catalogo.edit',
            'description'   =>  'Editar Servicios del sistema',
        ]);
        Permission::create([
            'name'          =>  'Desactiva Servicios',
            'slug'          =>  'catalogo.destroy',
            'description'   =>  'Desactiva Servicios del sistema',
        ]);

//Solicitud de Servicios
        Permission::create([
            'name'          =>  'Listado de Solicitud de Servicios',
            'slug'          =>  'solservicio.index',
            'description'   =>  'Despliega  Solicitud de Servicios',
        ]);
        Permission::create([
            'name'          =>  'Ver detalle de  Solicitud de Servicios',
            'slug'          =>  'solservicio.show',
            'description'   =>  'Despliega el detalle del Servicios ',
        ]);
        Permission::create([
            'name'          =>  'Crea Servicios',
            'slug'          =>  'solservicio.create',
            'description'   =>  'Crear  Solicitud de Servicios del sistema',
        ]);
        Permission::create([
            'name'          =>  'Edición de  Solicitud de Servicios',
            'slug'          =>  'solservicio.edit',
            'description'   =>  'Editar  Solicitud de  Servicios del sistema',
        ]);
        Permission::create([
            'name'          =>  'Desactiva  Solicitud de  Servicios',
            'slug'          =>  'solservicio.destroy',
            'description'   =>  'Desactiva  Solicitud de Servicios del sistema',
        ]);


//Alertas
        Permission::create([
            'name'          =>  'Alertas de Captaciones',
            'slug'          =>  'alerta.captaciones',
            'description'   =>  'Alertas de Captaciones',
        ]);
//Reportes
        Permission::create([
            'name'          =>  'Reportes de Captación',
            'slug'          =>  'reportes.captaciones',
            'description'   =>  'Reportes de Captaciones',
        ]);
        Permission::create([
            'name'          =>  'Reportes de Administración',
            'slug'          =>  'reportes.administracion',
            'description'   =>  'Reportes de Administración',
        ]);
        Permission::create([
            'name'          =>  'Reportes de Post Venta',
            'slug'          =>  'reportes.postventa',
            'description'   =>  'Reportes de Post Venta',
        ]);

//Presupouesto
        Permission::create([
            'name'          =>  'Crear presupuesto',
            'slug'          =>  'presupuesto.create',
            'description'   =>  'Crear presupuesto',
        ]);
        Permission::create([
            'name'          =>  'Editar Presupuesto',
            'slug'          =>  'presupuesto.edit',
            'description'   =>  'Editar Presupuesto',
        ]);
        Permission::create([
            'name'          =>  'Lista de Presupuestos',
            'slug'          =>  'presupuesto.index',
            'description'   =>  'Lista de Presupuestos',
        ]);

//Proveedores
        Permission::create([
            'name'          =>  'Listado de Proveedores',
            'slug'          =>  'proveedor.index',
            'description'   =>  'Despliega Proveedores',
        ]);
        Permission::create([
            'name'          =>  'Ver detalle Proveedores',
            'slug'          =>  'proveedor.show',
            'description'   =>  'Despliega el detalle Proveedores ',
        ]);
        Permission::create([
            'name'          =>  'Crea Proveedores',
            'slug'          =>  'proveedor.create',
            'description'   =>  'Crear Proveedores',
        ]);
        Permission::create([
            'name'          =>  'Edición de Proveedores',
            'slug'          =>  'proveedor.edit',
            'description'   =>  'Editar Proveedores del sistema',
        ]);
        Permission::create([
            'name'          =>  'Desactiva Proveedores',
            'slug'          =>  'proveedor.destroy',
            'description'   =>  'Desactiva Proveedores del sistema',
        ]);


//ITEM
        Permission::create([
            'name'          =>  'Listado de item',
            'slug'          =>  'item.index',
            'description'   =>  'Despliega item',
        ]);
        Permission::create([
            'name'          =>  'Ver detalle de item',
            'slug'          =>  'item.show',
            'description'   =>  'Despliega el detalle del item ',
        ]);
        Permission::create([
            'name'          =>  'Crea item',
            'slug'          =>  'item.create',
            'description'   =>  'Crear item del sistema',
        ]);
        Permission::create([
            'name'          =>  'Edición de item',
            'slug'          =>  'item.edit',
            'description'   =>  'Editar item del sistema',
        ]);
        Permission::create([
            'name'          =>  'Desactiva item',
            'slug'          =>  'item.destroy',
            'description'   =>  'Desactiva item del sistema',
        ]);


//familia
        Permission::create([
            'name'          =>  'Listado de familia',
            'slug'          =>  'familia.index',
            'description'   =>  'Despliega familia',
        ]);
        Permission::create([
            'name'          =>  'Ver detalle de familia',
            'slug'          =>  'familia.show',
            'description'   =>  'Despliega el detalle del familia ',
        ]);
        Permission::create([
            'name'          =>  'Crea familia',
            'slug'          =>  'familia.create',
            'description'   =>  'Crear familia del sistema',
        ]);
        Permission::create([
            'name'          =>  'Edición de familia',
            'slug'          =>  'familia.edit',
            'description'   =>  'Editar familia del sistema',
        ]);
        Permission::create([
            'name'          =>  'Desactiva familia',
            'slug'          =>  'familia.destroy',
            'description'   =>  'Desactiva familia del sistema',
        ]);


//postventa
        Permission::create([
            'name'          =>  'Listado de postventa',
            'slug'          =>  'postventa.index',
            'description'   =>  'Despliega postventa',
        ]);
        Permission::create([
            'name'          =>  'Ver detalle de postventa',
            'slug'          =>  'postventa.show',
            'description'   =>  'Despliega el detalle del postventa ',
        ]);
        Permission::create([
            'name'          =>  'Crea postventa',
            'slug'          =>  'postventa.create',
            'description'   =>  'Crear postventa del sistema',
        ]);
        Permission::create([
            'name'          =>  'Edición de postventa',
            'slug'          =>  'postventa.edit',
            'description'   =>  'Editar postventa del sistema',
        ]);
        Permission::create([
            'name'          =>  'Desactiva postventa',
            'slug'          =>  'postventa.destroy',
            'description'   =>  'Desactiva postventa del sistema',
        ]);


//empresas
        Permission::create([
            'name'          =>  'Listado de empresas',
            'slug'          =>  'empresas.index',
            'description'   =>  'Despliega empresas',
        ]);
        Permission::create([
            'name'          =>  'Ver detalle de empresas',
            'slug'          =>  'empresas.show',
            'description'   =>  'Despliega el detalle del empresas ',
        ]);
        Permission::create([
            'name'          =>  'Crea empresas',
            'slug'          =>  'empresas.create',
            'description'   =>  'Crear empresas del sistema',
        ]);
        Permission::create([
            'name'          =>  'Edición de empresas',
            'slug'          =>  'empresas.edit',
            'description'   =>  'Editar empresas del sistema',
        ]);
        Permission::create([
            'name'          =>  'Desactiva empresas',
            'slug'          =>  'empresas.destroy',
            'description'   =>  'Desactiva empresas del sistema',
        ]);


//revisioncuentas
        Permission::create([
            'name'          =>  'Listado de revision cuentas',
            'slug'          =>  'revisioncuentas.index',
            'description'   =>  'Despliega revision cuentas',
        ]);
        Permission::create([
            'name'          =>  'Ver detalle de revision cuentas',
            'slug'          =>  'revisioncuentas.show',
            'description'   =>  'Despliega el detalle del revision cuentas ',
        ]);
        Permission::create([
            'name'          =>  'Crea revision cuentas',
            'slug'          =>  'revisioncuentas.create',
            'description'   =>  'Crear revisionc uentas del sistema',
        ]);
        Permission::create([
            'name'          =>  'Edición de revision cuentas',
            'slug'          =>  'revisioncuentas.edit',
            'description'   =>  'Editar revision cuentas del sistema',
        ]);
        Permission::create([
            'name'          =>  'Desactiva revision cuentas',
            'slug'          =>  'revisioncuentas.destroy',
            'description'   =>  'Desactiva revision cuentas del sistema',
        ]);

//Check List
        Permission::create([
            'name'          =>  'Listado de checklist checklist',
            'slug'          =>  'checklist.checklist',
            'description'   =>  'Despliega checklist checklist',
        ]);
        Permission::create([
            'name'          =>  'Ver detalle de checklist checklist',
            'slug'          =>  'checklist.show',
            'description'   =>  'Despliega el detalle del checklist checklist ',
        ]);
        Permission::create([
            'name'          =>  'Crea checklist checklist',
            'slug'          =>  'checklist.create',
            'description'   =>  'Crear checklist checklist del sistema',
        ]);
        Permission::create([
            'name'          =>  'Edición de checklist checklist',
            'slug'          =>  'checklist.edit',
            'description'   =>  'Editar checklist checklist del sistema',
        ]);
        Permission::create([
            'name'          =>  'Desactiva checklist checklist',
            'slug'          =>  'checklist.destroy',
            'description'   =>  'Desactiva checklist checklist del sistema',
        ]);

//Mantenedor Check List
        Permission::create([
            'name'          =>  'Listado de mantenedor checklist',
            'slug'          =>  'mantenedorchecklist.index',
            'description'   =>  'Despliega mantenedor checklist',
        ]);
        Permission::create([
            'name'          =>  'Ver detalle de mantenedor checklist',
            'slug'          =>  'mantenedorchecklist.show',
            'description'   =>  'Despliega el detalle del mantenedor checklist ',
        ]);
        Permission::create([
            'name'          =>  'Crea mantenedor checklist',
            'slug'          =>  'mantenedorchecklist.create',
            'description'   =>  'Crear mantenedor checklist del sistema',
        ]);
        Permission::create([
            'name'          =>  'Edición de mantenedor checklist',
            'slug'          =>  'mantenedorchecklist.edit',
            'description'   =>  'Editar mantenedor checklist del sistema',
        ]);
        Permission::create([
            'name'          =>  'Desactiva mantenedor checklist',
            'slug'          =>  'mantenedorchecklist.destroy',
            'description'   =>  'Desactiva mantenedor checklist del sistema',
        ]);

//contratorenovacionarrendatario
        Permission::create([
            'name'          =>  'Listado contrato renovacion arrendatario',
            'slug'          =>  'contratorenovacionarrendatario.index',
            'description'   =>  'Despliega contrato renovacion arrendatario',
        ]);
        Permission::create([
            'name'          =>  'Editar detalle de contrato renovacion arrendatario',
            'slug'          =>  'contratorenovacionarrendatario.edit',
            'description'   =>  'Editar el detalle del contrato renovacion arrendatario ',
        ]);



//HOME
        Permission::create([
            'name'          =>  'HOME PROPIETARIO',
            'slug'          =>  'propietario.home',
            'description'   =>  'HOME PROPIETARIO',
        ]);
        Permission::create([
            'name'          =>  'HOME ARRENDATARIO',
            'slug'          =>  'arrendatario.home',
            'description'   =>  'HOME ARRENDATARIO ',
        ]);
    }
}
