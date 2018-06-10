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
    
    //Captacion
        Permission::create([
            'name'          =>  'Listado de captación',
            'slug'          =>  'captacion.index',
            'description'   =>  'Despliega captacion',
        ]);
        Permission::create([
            'name'          =>  'Ver detalle de captación',
            'slug'          =>  'captacion.show',
            'description'   =>  'Despliega el detalle del captacion ',
        ]);
        Permission::create([
            'name'          =>  'Crea captación',
            'slug'          =>  'captacion.create',
            'description'   =>  'Crear captacion del sistema',
        ]);
        Permission::create([
            'name'          =>  'Edición de captación',
            'slug'          =>  'captacion.edit',
            'description'   =>  'Editar captacion del sistema',
        ]);
        Permission::create([
            'name'          =>  'Desactiva captación',
            'slug'          =>  'captacion.destroy',
            'description'   =>  'Desactiva captacion del sistema',
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
    }
}
