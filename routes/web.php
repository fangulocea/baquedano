<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
	if(Auth::check()){
	return view('home');
	   }else{
	return view('auth.login');
	}
    
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

// SERVICIOS DE COMUNA/REGION

Route::get('inmuebles/{text}','InmuebleController@getInmuebles');

Route::get('personas/{text}','PersonaController@getPersonas');

Route::get('personas/email/{text}','PersonaController@getPersonasEmail');

Route::get('personas/fono/{text}','PersonaController@getPersonasFono');

Route::get('persona/contratoborrador/{id}','PersonaController@getPersonaContratoBorrador');

Route::get('inmueble/contratoborrador/{id}','InmuebleController@getInmuebleContratoBorrador');

Route::get('provincias/{id}','RegionController@getProvincias');

Route::get('regiones/todas','RegionController@getTodasRegiones');

Route::get('captaciones/correo/{id}','CaptacionController@getCaptacionesCorreo');

Route::get('captaciones/gestion/{id}','CaptacionController@getCaptacionesGestiones');

Route::get('comunas/{id}','ProvinciaController@getComunas');

//RUTAS
Route::middleware(['auth'])->group(function(){
	
	//Roles
	Route::post('roles/store','RoleController@store')->name('roles.store')
		->middleware('permission:roles.create');

	Route::get('roles','RoleController@index')->name('roles.index')
		->middleware('permission:roles.index');

	Route::get('roles/create','RoleController@create')->name('roles.create')
		->middleware('permission:roles.create');

	Route::put('roles/{role}','RoleController@update')->name('roles.update')
		->middleware('permission:roles.edit');

	Route::get('roles/{role}','RoleController@show')->name('roles.show')
		->middleware('permission:roles.show');

	Route::delete('roles/{role}','RoleController@destroy')->name('roles.destroy')
		->middleware('permission:roles.destroy');

	Route::get('roles/{role}/edit','RoleController@edit')->name('roles.edit')
		->middleware('permission:roles.edit');

	//Notaria
	Route::post('notarias/store','NotariaController@store')->name('notarias.store')
		->middleware('permission:notarias.create');

	Route::get('notarias','NotariaController@index')->name('notarias.index')
		->middleware('permission:notarias.index');

	Route::get('notarias/create','NotariaController@create')->name('notarias.create')
		->middleware('permission:notarias.create');

	Route::post('notarias/{notaria}','NotariaController@update')->name('notarias.update')
		->middleware('permission:notarias.edit');

	Route::get('notarias/{notaria}','NotariaController@show')->name('notarias.show')
		->middleware('permission:notaria.show');

	Route::delete('notarias/{notaria}','NotariaController@destroy')->name('notarias.destroy')
		->middleware('permission:notarias.destroy');

	Route::get('notarias/{notaria}/edit','NotariaController@edit')->name('notarias.edit')
		->middleware('permission:notarias.edit');


//Usuario
	Route::post('users/store','UsersController@store')->name('users.store')
		->middleware('permission:users.create');

	Route::get('users','UsersController@index')->name('users.index')
		->middleware('permission:users.index');

	Route::get('users/create','UsersController@create')->name('users.create')
		->middleware('permission:users.create');

	Route::put('users/{user}','UsersController@update')->name('users.update')
		->middleware('permission:users.edit');

	Route::get('users/{user}','UsersController@show')->name('users.show')
		->middleware('permission:users.show');

	Route::delete('users/{user}','UsersController@destroy')->name('users.destroy')
		->middleware('permission:users.destroy');

	Route::get('users/{user}/edit','UsersController@edit')->name('users.edit')
		->middleware('permission:users.edit');



	//Condicion
	Route::post('condicion/store','CondicionController@store')->name('condicion.store')
		->middleware('permission:condicion.create');

	Route::get('condicion','CondicionController@index')->name('condicion.index')
		->middleware('permission:condicion.index');

	Route::get('condicion/create','CondicionController@create')->name('condicion.create')
		->middleware('permission:condicion.create');

	Route::post('condicion/{condicion}','CondicionController@update')->name('condicion.update')
		->middleware('permission:condicion.edit');

	Route::get('condicion/{condicion}','CondicionController@show')->name('condicion.show')
		->middleware('permission:condicion.show');

	Route::delete('condicion/{condicion}','CondicionController@destroy')->name('condicion.destroy')
		->middleware('permission:condicion.destroy');

	Route::get('condicion/{notaria}/edit','CondicionController@edit')->name('condicion.edit')
		->middleware('permission:condicion.edit');


	//Inmueble
	Route::post('inmueble/store','InmuebleController@store')->name('inmueble.store')
		->middleware('permission:inmueble.create');

	Route::get('inmueble','InmuebleController@index')->name('inmueble.index')
		->middleware('permission:inmueble.index');

	Route::get('inmueble/create','InmuebleController@create')->name('inmueble.create')
		->middleware('permission:inmueble.create');

	Route::post('inmueble/{inmueble}','InmuebleController@update')->name('inmueble.update')
		->middleware('permission:inmueble.edit');

	Route::get('inmueble/{inmueble}','InmuebleController@show')->name('inmueble.show')
		->middleware('permission:inmueble.show');

	Route::delete('inmueble/{inmueble}','InmuebleController@destroy')->name('inmueble.destroy')
		->middleware('permission:inmueble.destroy');

	Route::get('inmueble/{inmueble}/edit','InmuebleController@edit')->name('inmueble.edit')
		->middleware('permission:inmueble.edit');


//Persona
	Route::post('persona/store','PersonaController@store')->name('persona.store')
		->middleware('permission:persona.create');

	Route::get('persona','PersonaController@index')->name('persona.index')
		->middleware('permission:persona.index');

	Route::get('persona/create','PersonaController@create')->name('persona.create')
		->middleware('permission:persona.create');

	Route::post('persona/{persona}','PersonaController@update')->name('persona.update')
		->middleware('permission:persona.edit');

	Route::post('persona/{persona}/updatehome','PersonaController@updatehome')->name('persona.updatehome');
		
	Route::get('persona/{persona}/edithome','PersonaController@edithome')->name('persona.edithome');

	Route::get('persona/{persona}','PersonaController@show')->name('persona.show')
		->middleware('permission:persona.show');

	Route::delete('persona/{persona},{cargo}','PersonaController@destroy')->name('persona.destroy')
		->middleware('permission:persona.destroy');

	Route::get('persona/{persona}/edit','PersonaController@edit')->name('persona.edit')
		->middleware('permission:persona.edit');


//Cargo
	Route::post('cargo/store','CargoController@store')->name('cargo.store')
		->middleware('permission:cargo.create');

	Route::get('cargo','CargoController@index')->name('cargo.index')
		->middleware('permission:cargo.index');

	Route::get('cargo/create','CargoController@create')->name('cargo.create')
		->middleware('permission:cargo.create');

	Route::post('cargo/{cargo}','CargoController@update')->name('cargo.update')
		->middleware('permission:cargo.edit');

	Route::get('cargo/{cargo}','CargoController@show')->name('cargo.show')
		->middleware('permission:cargo.show');

	Route::delete('cargo/{cargo}','CargoController@destroy')->name('cargo.destroy')
		->middleware('permission:cargo.destroy');

	Route::get('cargo/{cargo}/edit','CargoController@edit')->name('cargo.edit')
		->middleware('permission:cargo.edit');


//Servicios
	Route::post('servicio/store','ServicioController@store')->name('servicio.store')
		->middleware('permission:servicio.create');

	Route::get('servicio','ServicioController@index')->name('servicio.index')
		->middleware('permission:servicio.index');

	Route::get('servicio/create','ServicioController@create')->name('servicio.create')
		->middleware('permission:servicio.create');

	Route::post('servicio/{servicio}','ServicioController@update')->name('servicio.update')
		->middleware('permission:servicio.edit');

	Route::get('servicio/{servicio}','ServicioController@show')->name('servicio.show')
		->middleware('permission:servicio.show');

	Route::delete('servicio/{servicio}','ServicioController@destroy')->name('servicio.destroy')
		->middleware('permission:servicio.destroy');

	Route::get('servicio/{servicio}/edit','ServicioController@edit')->name('servicio.edit')
		->middleware('permission:servicio.edit');


//Multa
	Route::post('multa/store','MultaController@store')->name('multa.store')
		->middleware('permission:multa.create');

	Route::get('multa','MultaController@index')->name('multa.index')
		->middleware('permission:multa.index');

	Route::get('multa/create','MultaController@create')->name('multa.create')
		->middleware('permission:multa.create');

	Route::post('multa/{multa}','MultaController@update')->name('multa.update')
		->middleware('permission:multa.edit');

	Route::get('multa/{multa}','MultaController@show')->name('multa.show')
		->middleware('permission:multa.show');

	Route::delete('multa/{multa}','MultaController@destroy')->name('multa.destroy')
		->middleware('permission:multa.destroy');

	Route::get('multa/{multa}/edit','MultaController@edit')->name('multa.edit')
		->middleware('permission:multa.edit');


//Captacion Propietario

	Route::get('importExportcap', 'CaptacionController@importExportcap')->name('captacion.importExportcap')
		->middleware('permission:captacion.edit');

	Route::get('importExportcontact', 'CaptacionController@importExportcontact')->name('captacion.importExportcontact')
		->middleware('permission:captacion.edit');

	Route::get('downloadExcel/{type}', 'CaptacionController@downloadExcel')->name('captacion.downloadExcel')
		->middleware('permission:captacion.edit');

	Route::post('importExcel', 'CaptacionController@importExcel')->name('captacion.importExcel')
		->middleware('permission:captacion.edit');

	Route::get('procesarxls/{id}', 'CaptacionController@procesarxls')->name('captacion.procesarxls')
		->middleware('permission:captacion.edit');

	Route::get('limpiarxls/{id}', 'CaptacionController@limpiarxls')->name('captacion.limpiarxls')
		->middleware('permission:captacion.edit');

	Route::post('captacion/store','CaptacionController@store')->name('captacion.store')
		->middleware('permission:captacion.create');

	Route::get('captacion','CaptacionController@index')->name('captacion.index')
		->middleware('permission:captacion.index');

	Route::get('captacion/create','CaptacionController@create')->name('captacion.create')
		->middleware('permission:captacion.create');

	Route::post('captacion/update/{id}','CaptacionController@update')->name('captacion.update')
		->middleware('permission:captacion.edit');

	Route::post('captacion/foto/{captacion}','CaptacionController@savefotos')->name('captacion.savefotos')
		->middleware('permission:captacion.edit');


	Route::get('captacion/borrador/create/{id}','CaptacionController@crearBorrador')->name('captacion.crearBorrador')
		->middleware('permission:captacion.edit');

	Route::post('captacion/gestion/create','CaptacionController@crearGestion')->name('captacion.crearGestion')
		->middleware('permission:captacion.edit');

	Route::post('captacion/gestion/update','CaptacionController@editarGestion')->name('captacion.editarGestion')
		->middleware('permission:captacion.edit');

	Route::post('captacion/gestion/proceso/create','CaptacionController@crearGestion_proceso')->name('captacion.crearGestion_proceso')
		->middleware('permission:captacion.edit');

	Route::post('captacion/gestion/proceso/update','CaptacionController@editarGestion_proceso')->name('captacion.editarGestion_proceso')
		->middleware('permission:captacion.edit');

	Route::get('captacion/gestion/{idg}','CaptacionController@mostrarGestion');
	
		Route::get('procesoCaptacion/{id}', 'PrimeraGestionController@volver_proceso')->name('captacion.volver_proceso')
		->middleware('permission:captacion.edit');

    Route::post('procesoCaptacion/store','PrimeraGestionController@storeCaptacion')->name('primeraGestion.storeCaptacion')
		->middleware('permission:captacion.create');

	Route::get('captacion/reportes','CaptacionController@reportes')->name('captacion.reportes')
		->middleware('permission:captacion.edit');

	Route::get('captacion/{captacion}','CaptacionController@show')->name('captacion.show')
		->middleware('permission:captacion.show');

	Route::delete('captacion/{captacion}','CaptacionController@destroy')->name('captacion.destroy')
		->middleware('permission:captacion.destroy');

	Route::get('captacion/{captacion}/edit','CaptacionController@edit')->name('captacion.edit')
		->middleware('permission:captacion.edit');

	Route::get('captacion/agregarinmueble/{idc}/{idi}','CaptacionController@agregarInmueble')->name('captacion.agregarinmueble')
		->middleware('permission:captacion.edit');

	Route::get('captacion/agregarpersona/{idc}/{idp}','CaptacionController@agregarPropietario')->name('captacion.agregarpersona')
		->middleware('permission:captacion.edit');

	Route::get('captacion/eliminarfoto/{idf}/{idc}','CaptacionController@eliminarfoto')->name('captacion.eliminarfoto')
		->middleware('permission:captacion.edit');

		Route::get('importar/gestion/{idc}','CaptacionController@importarGestion')->name('captacion.importarGestion')
		->middleware('permission:captacion.edit');



//Formas de Pago
	Route::post('formasDePago/store','FormasDePagoController@store')->name('formasDePago.store')
		->middleware('permission:formasDePago.create');

	Route::get('formasDePago','FormasDePagoController@index')->name('formasDePago.index')
		->middleware('permission:formasDePago.index');

	Route::get('formasDePago/create','FormasDePagoController@create')->name('formasDePago.create')
		->middleware('permission:formasDePago.create');

	Route::post('formasDePago/{formasDePago}','FormasDePagoController@update')->name('formasDePago.update')
		->middleware('permission:formasDePago.edit');

	Route::get('formasDePago/{formasDePago}','FormasDePagoController@show')->name('formasDePago.show')
		->middleware('permission:formasDePago.show');

	Route::delete('formasDePago/{formasDePago}','FormasDePagoController@destroy')->name('formasDePago.destroy')
		->middleware('permission:formasDePago.destroy');

	Route::get('formasDePago/{formasDePago}/edit','FormasDePagoController@edit')->name('formasDePago.edit')
		->middleware('permission:formasDePago.edit');
	

//Comisiones
	Route::post('comision/store','ComisionController@store')->name('comision.store')
		->middleware('permission:comision.create');

	Route::get('comision','ComisionController@index')->name('comision.index')
		->middleware('permission:comision.index');

	Route::get('comision/create','ComisionController@create')->name('comision.create')
		->middleware('permission:comision.create');

	Route::post('comision/{comision}','ComisionController@update')->name('comision.update')
		->middleware('permission:comision.edit');

	Route::get('comision/{comision}','ComisionController@show')->name('comision.show')
		->middleware('permission:comision.show');

	Route::delete('comision/{comision}','ComisionController@destroy')->name('comision.destroy')
		->middleware('permission:comision.destroy');

	Route::get('comision/{comision}/edit','ComisionController@edit')->name('comision.edit')
		->middleware('permission:comision.edit');



//Flexibilidad
	Route::post('flexibilidad/store','FlexibilidadController@store')->name('flexibilidad.store')
		->middleware('permission:flexibilidad.create');

	Route::get('flexibilidad','FlexibilidadController@index')->name('flexibilidad.index')
		->middleware('permission:flexibilidad.index');

	Route::get('flexibilidad/create','FlexibilidadController@create')->name('flexibilidad.create')
		->middleware('permission:flexibilidad.create');

	Route::post('flexibilidad/{flexibilidad}','FlexibilidadController@update')->name('flexibilidad.update')
		->middleware('permission:flexibilidad.edit');

	Route::get('flexibilidad/{flexibilidad}','FlexibilidadController@show')->name('flexibilidad.show')
		->middleware('permission:flexibilidad.show');

	Route::delete('flexibilidad/{flexibilidad}','FlexibilidadController@destroy')->name('flexibilidad.destroy')
		->middleware('permission:flexibilidad.destroy');

	Route::get('flexibilidad/{flexibilidad}/edit','FlexibilidadController@edit')->name('flexibilidad.edit')
		->middleware('permission:flexibilidad.edit');


//Persona Inmueble
	Route::post('personaInmueble/store','PersonaInmuebleController@store')->name('personaInmueble.store')
		->middleware('permission:personaInmueble.create');

	Route::get('personaInmueble','PersonaInmuebleController@index')->name('personaInmueble.index')
		->middleware('permission:personaInmueble.index');

	Route::get('personaInmueble/create','PersonaInmuebleController@create')->name('personaInmueble.create')
		->middleware('permission:personaInmueble.create');

	Route::post('personaInmueble/{personaInmueble}','PersonaInmuebleController@update')->name('personaInmueble.update')
		->middleware('permission:personaInmueble.edit');

	Route::get('personaInmueble/{personaInmueble}','PersonaInmuebleController@show')->name('personaInmueble.show')
		->middleware('permission:personaInmueble.show');

	Route::delete('personaInmueble/{personaInmueble}','PersonaInmuebleController@destroy')->name('personaInmueble.destroy')
		->middleware('permission:personaInmueble.destroy');

	Route::get('personaInmueble/{personaInmueble}/edit','PersonaInmuebleController@edit')->name('personaInmueble.edit')
		->middleware('permission:personaInmueble.edit');

//Correo Tipo
	Route::post('correo/store','CorreoController@store')->name('correo.store')
		->middleware('permission:correo.create');

	Route::get('correo','CorreoController@index')->name('correo.index')
		->middleware('permission:correo.index');

	Route::get('correo/create','CorreoController@create')->name('correo.create')
		->middleware('permission:correo.create');

	Route::post('correo/{correo}','CorreoController@update')->name('correo.update')
		->middleware('permission:correo.edit');

	Route::get('correo/{correo}','CorreoController@show')->name('correo.show')
		->middleware('permission:correo.show');

	Route::delete('correo/{correo}','CorreoController@destroy')->name('correo.destroy')
		->middleware('permission:correo.destroy');

	Route::get('correo/{correo}/edit','CorreoController@edit')->name('correo.edit')
		->middleware('permission:correo.edit');


//Primera Gestion
    Route::post('primeraGestion/store','PrimeraGestionController@store')->name('primeraGestion.store')
		->middleware('permission:primeraGestion.create');


	Route::get('primeraGestion/{tipo}','PrimeraGestionController@index')->name('primeraGestion.index')
		->middleware('permission:primeraGestion.index');

	Route::get('primeraGestion/create','PrimeraGestionController@create')->name('primeraGestion.create')
		->middleware('permission:primeraGestion.create');

	Route::post('primeraGestion/{primeraGestion}','PrimeraGestionController@update')->name('primeraGestion.update')
		->middleware('permission:primeraGestion.edit');

	Route::get('primeraGestion/{primeraGestion}','PrimeraGestionController@show')->name('primeraGestion.show')
		->middleware('permission:primeraGestion.show');

	Route::delete('primeraGestion/{primeraGestion}','PrimeraGestionController@destroy')->name('primeraGestion.destroy')
		->middleware('permission:primeraGestion.destroy');

	Route::get('primeraGestion/{primeraGestion}/edit','PrimeraGestionController@edit')->name('primeraGestion.edit')
		->middleware('permission:primeraGestion.edit');


//Portales
    Route::post('portal/store','PortalesController@store')->name('portal.store')
		->middleware('permission:portal.create');

	Route::get('portal','PortalesController@index')->name('portal.index')
		->middleware('permission:portal.index');

	Route::get('portal/create','PortalesController@create')->name('portal.create')
		->middleware('permission:portal.create');

	Route::post('portal/{portal}','PortalesController@update')->name('portal.update')
		->middleware('permission:portal.edit');

	Route::get('portal/{portal}','PortalesController@show')->name('portal.show')
		->middleware('permission:portal.show');

	Route::delete('portal/{portal}','PortalesController@destroy')->name('portal.destroy')
		->middleware('permission:portal.destroy');

	Route::get('portal/{portal}/edit','PortalesController@edit')->name('portal.edit')
		->middleware('permission:portal.edit');

	//Reporte Gestion
	Route::get('reporteGestion/{reporteGestion}','ReporteGestionController@index')->name('reporteGestion.index')
		->middleware('permission:primeraGestion.index');

	//Reporte Captaciones
	Route::get('reporteCaptaciones/{reporteCaptaciones}','ReporteCaptacionesController@index')->name('reporteCaptaciones.index')
		->middleware('permission:primeraGestion.index');


//Captacion Arrendatario

	Route::post('arrendatario/store','ArrendatarioController@store')->name('arrendatario.store')
		->middleware('permission:arrendatario.create');

	Route::get('arrendatario','ArrendatarioController@index')->name('arrendatario.index')
		->middleware('permission:arrendatario.index');

	Route::get('arrendatario/create','ArrendatarioController@create')->name('arrendatario.create')
		->middleware('permission:arrendatario.create');

	Route::get('arrendatario/edit/{id}','ArrendatarioController@edit')->name('arrendatario.edit')
		->middleware('permission:arrendatario.edit');

	Route::get('arrendatario/destroy/{id}','ArrendatarioController@destroy')->name('arrendatario.destroy')
		->middleware('permission:arrendatario.destroy');

	Route::post('arrendatario/{captacionArrendador}','ArrendatarioController@update')->name('arrendatario.update')
		->middleware('permission:arrendatario.edit');

	Route::post('arrendatario/foto/{captacion}','ArrendatarioController@savefotos')->name('arrendatario.savefotos')
		->middleware('permission:arrendatario.edit');

	Route::get('arrendatario/eliminarfoto/{idf}/{idc}','ArrendatarioController@eliminarfoto')->name('arrendatario.eliminarfoto')
		->middleware('permission:arrendatario.edit');

	Route::post('arrendatario/gestion/create','ArrendatarioController@crearGestion')->name('arrendatario.crearGestion')
		->middleware('permission:arrendatario.edit');

	Route::post('arrendatario/gestion/update','ArrendatarioController@editarGestion')->name('arrendatario.editarGestion')
		->middleware('permission:arrendatario.edit');

	Route::get('arrendatario/gestion/{idg}','ArrendatarioController@mostrarGestion');

	

//Captacion Corredor


	Route::post('corredor/store','CaptacionCorredorController@store')->name('corredor.store')
		->middleware('permission:captacion.create');

	Route::get('corredor','CaptacionCorredorController@index')->name('corredor.index')
		->middleware('permission:captacion.index');

	Route::get('corredor/create','CaptacionCorredorController@create')->name('corredor.create')
		->middleware('permission:captacion.create');

	Route::post('corredor/{captacion}','CaptacionCorredorController@update')->name('corredor.update')
		->middleware('permission:captacion.edit');

	Route::post('corredor/foto/{captacion}','CaptacionCorredorController@savefotos')->name('corredor.savefotos')
		->middleware('permission:captacion.edit');

	Route::post('corredor/gestion/create','CaptacionCorredorController@crearGestion')->name('corredor.crearGestion')
		->middleware('permission:captacion.edit');

	Route::post('corredor/gestion/update','CaptacionCorredorController@editarGestion')->name('corredor.editarGestion')
		->middleware('permission:captacion.edit');

	Route::get('corredor/gestion/{idg}','CaptacionCorredorController@mostrarGestion');

	Route::delete('corredor/{captacion}','CaptacionCorredorController@destroy')->name('corredor.destroy')
		->middleware('permission:captacion.destroy');

	Route::get('corredor/{captacion}/edit','CaptacionCorredorController@edit')->name('corredor.edit')
		->middleware('permission:captacion.edit');

	Route::get('corredor/agregarinmueble/{idc}/{idi}','CaptacionCorredorController@agregarInmueble')->name('corredor.agregarinmueble')
		->middleware('permission:captacion.edit');

	Route::get('corredor/agregarpersona/{idc}/{idp}','CaptacionCorredorController@agregarPropietario')->name('corredor.agregarpersona')
		->middleware('permission:captacion.edit');

	Route::get('corredor/eliminarfoto/{idf}/{idc}','CaptacionCorredorController@eliminarfoto')->name('corredor.eliminarfoto')
		->middleware('permission:captacion.edit');


//Revisión comercial persona


	Route::post('revisionpersona/store','RevisionPersonaController@store')->name('revisionpersona.store')
		->middleware('permission:revisioncomercial.create');

	Route::get('revisionpersona','RevisionPersonaController@index')->name('revisionpersona.index')
		->middleware('permission:revisioncomercial.index');

	Route::get('revisionpersona/create/{id}','RevisionPersonaController@create')->name('revisionpersona.create')
		->middleware('permission:revisioncomercial.create');

	Route::post('revisionpersona/{rev}','RevisionPersonaController@update')->name('revisionpersona.update')
		->middleware('permission:revisioncomercial.edit');

	Route::get('revisionpersona/edit/{id}','RevisionPersonaController@edit')->name('revisionpersona.edit')
		->middleware('permission:revisioncomercial.edit');

		Route::post('revisionpersona/foto/{captacion}','RevisionPersonaController@savefotos')->name('revisionpersona.savefotos')
		->middleware('permission:revisioncomercial.edit');


	Route::get('revisionpersona/eliminarfoto/{idf}/{idc}','RevisionPersonaController@eliminarfoto')->name('revisionpersona.eliminarfoto')
		->middleware('permission:captacion.edit');

Route::get('revisionpersona/eliminarfoto/{idf}/{idc}','RevisionPersonaController@eliminarfoto')->name('revisionpersona.eliminarfoto')
		->middleware('permission:revisioncomercial.edit');


	Route::post('revisionpersona/gestion/create','RevisionPersonaController@crearGestion')->name('revisionpersona.crearGestion')
		->middleware('permission:revisioncomercial.edit');

	Route::post('revisionpersona/gestion/update','RevisionPersonaController@editarGestion')->name('revisionpersona.editarGestion')
		->middleware('permission:revisioncomercial.edit');

	Route::get('revisionpersona/gestion/{idg}','RevisionPersonaController@mostrarGestion');

//Revisión comercial inmueble


	Route::post('revisioninmueble/store','RevisionInmuebleController@store')->name('revisioninmueble.store')
		->middleware('permission:revisioncomercial.create');

	Route::get('revisioninmueble','RevisionInmuebleController@index')->name('revisioninmueble.index')
		->middleware('permission:revisioncomercial.index');

	Route::get('revisioninmueble/create/{id}','RevisionInmuebleController@create')->name('revisioninmueble.create')
		->middleware('permission:revisioncomercial.create');

	Route::get('revisioninmueble/edit/{id}','RevisionInmuebleController@edit')->name('revisioninmueble.edit')
		->middleware('permission:revisioncomercial.edit');

	Route::post('revisioninmueble/{rev}','RevisionInmuebleController@update')->name('revisioninmueble.update')
		->middleware('permission:revisioncomercial.edit');

		Route::post('revisioninmueble/foto/{captacion}','RevisionInmuebleController@savefotos')->name('revisioninmueble.savefotos')
		->middleware('permission:revisioncomercial.edit');

		Route::get('revisioninmueble/eliminarfoto/{idf}/{idc}','RevisionInmuebleController@eliminarfoto')->name('revisioninmueble.eliminarfoto')
		->middleware('permission:captacion.edit');

		Route::post('revisioninmueble/gestion/create','RevisionInmuebleController@crearGestion')->name('revisioninmueble.crearGestion')
		->middleware('permission:captacion.edit');

		Route::post('revisioninmueble/gestion/update','RevisionInmuebleController@editarGestion')->name('revisioninmueble.editarGestion')
		->middleware('permission:captacion.edit');

		Route::get('revisioninmueble/gestion/{idg}','RevisionInmuebleController@mostrarGestion');


		// COntratos Borrador
		Route::post('borradorContrato/updatepersona','PersonaController@updatePersonaContratoBorrador')->name('borradorContrato.updatepersona')
		->middleware('permission:borradorContrato.edit');

		Route::get('borradorContrato/edit/{id}','ContratoBorradorController@edit')->name('borradorContrato.edit')
		->middleware('permission:borradorContrato.edit');

		Route::post('borradorContrato/updateinmueble','InmuebleController@updateInmuebleContratoBorrador')->name('borradorContrato.updateinmueble')
		->middleware('permission:borradorContrato.edit');

		Route::post('borradorContrato/store','ContratoBorradorController@store')->name('borradorContrato.store')
		->middleware('permission:borradorContrato.create');

		Route::get('borradorContrato','ContratoBorradorController@index')->name('borradorContrato.index')
		->middleware('permission:borradorContrato.index');

		Route::get('borradorContrato/create','ContratoBorradorController@create')->name('borradorContrato.create')
		->middleware('permission:borradorContrato.create');

		Route::get('borradorContrato/destroy/{id}','ContratoBorradorController@destroy')->name('borradorContrato.destroy')
		->middleware('permission:borradorContrato.destroy');

		Route::post('borradorContrato/crearBorrador','ContratoBorradorController@crearBorrador')->name('borradorContrato.crearBorrador')
		->middleware('permission:borradorContrato.edit');

		Route::get('borradorContrato/borradorC/{idg}','ContratoBorradorController@mostrarGestion');

		Route::post('borradorContrato/{captacionArrendador}','ContratoBorradorController@update')->name('borradorContrato.update')
		->middleware('permission:borradorContrato.edit');

		Route::post('borradorContrato/borrador/update','ContratoBorradorController@editarGestion')->name('borradorContrato.editarGestion')
		->middleware('permission:borradorContrato.edit');

		Route::get('borradorContrato/mail/{id}','ContratoBorradorController@enviaMail')->name('borradorContrato.mail');		
		Route::get('pdf/{data}', 'PdfController@index');


//contrato
	Route::post('contrato/store','ContratoMantenedorController@store')->name('contrato.store')
		->middleware('permission:servicio.create');

	Route::get('contrato','ContratoMantenedorController@index')->name('contrato.index')
		->middleware('permission:contrato.index');

	Route::get('contrato/create','ContratoMantenedorController@create')->name('contrato.create')
		->middleware('permission:contrato.create');

	Route::post('contrato/{contrato}','ContratoMantenedorController@update')->name('contrato.update')
		->middleware('permission:contrato.edit');

	Route::get('contrato/{contrato}','ContratoMantenedorController@show')->name('contrato.show')
		->middleware('permission:contrato.show');

	Route::delete('contrato/{contrato}','ContratoMantenedorController@destroy')->name('contrato.destroy')
		->middleware('permission:servicio.destroy');

	Route::get('contrato/{contrato}/edit','ContratoMantenedorController@edit')->name('contrato.edit')
		->middleware('permission:contrato.edit');


// COntratos final
		Route::post('finalContrato/updatepersona','PersonaController@updatePersonaContratoBorrador')->name('finalContrato.updatepersona')
		->middleware('permission:finalContrato.edit');

		Route::post('finalContrato/updateinmueble','InmuebleController@updateInmuebleContratoBorrador')->name('finalContrato.updateinmueble')
		->middleware('permission:finalContrato.edit');

		Route::post('finalContrato/store','ContratoFinalController@store')->name('finalContrato.store')
		->middleware('permission:finalContrato.create');

		Route::get('finalContrato','ContratoFinalController@index')->name('finalContrato.index')
		->middleware('permission:finalContrato.index');

		Route::get('finalContrato/create','ContratoFinalController@create')->name('finalContrato.create')
		->middleware('permission:finalContrato.create');

		Route::get('finalContrato/edit/{id}','ContratoFinalController@edit')->name('finalContrato.edit')
		->middleware('permission:finalContrato.edit');

		Route::get('finalContrato/destroy/{id}','ContratoFinalController@destroy')->name('finalContrato.destroy')
		->middleware('permission:finalContrato.destroy');

		Route::post('finalContrato/crearBorrador','ContratoFinalController@crearBorrador')->name('finalContrato.crearBorrador')
		->middleware('permission:finalContrato.edit');

		Route::get('finalContrato/borradorC/{idg}','ContratoFinalController@mostrarGestion');

		Route::post('finalContrato/{captacionArrendador}','ContratoFinalController@update')->name('finalContrato.update')
		->middleware('permission:finalContrato.edit');

		Route::post('finalContrato/borrador/update','ContratoFinalController@editarGestion')->name('finalContrato.editarGestion')
		->middleware('permission:finalContrato.edit');

		Route::get('finalContrato/mail/{id}','ContratoFinalController@enviaMail')->name('finalContrato.mail');		
		Route::get('pdf/{data}', 'PdfController@index');



		// COntratos Arrendatario Borrador
		Route::get('cbararrendatario','ContratoBorradorArrendatarioController@index')->name('cbararrendatario.index')
		->middleware('permission:cbararrendatario.index');

		Route::get('cbararrendatario/edit/{id}','ContratoBorradorArrendatarioController@edit')->name('cbararrendatario.edit')
		->middleware('permission:cbararrendatario.edit');

		Route::post('cbararrendatario/updatepersona','PersonaController@updatePersonaArrendatarioBorrador')->name('cbararrendatario.updatepersona')
		->middleware('permission:cbararrendatario.edit');

		Route::post('cbararrendatario/updateinmueble','InmuebleController@updateInmuebleArrendatarioBorrador')->name('cbararrendatario.updateinmueble')
		->middleware('permission:cbararrendatario.edit');		


		Route::post('cbararrendatario/crearBorrador','ContratoBorradorArrendatarioController@crearBorrador')->name('cbararrendatario.crearBorrador')
		->middleware('permission:cbararrendatario.edit');


		Route::post('cbararrendatario/store','ContratoBorradorArrendatarioController@store')->name('cbararrendatario.store')
		->middleware('permission:cbararrendatario.create');

		Route::get('cbararrendatario/create','ContratoBorradorArrendatarioController@create')->name('cbararrendatario.create')
		->middleware('permission:contratoborradorarrendatario.create');

		Route::get('cbararrendatario/destroy/{id}','ContratoBorradorArrendatarioController@destroy')->name('cbararrendatario.destroy')
		->middleware('permission:contratoborradorarrendatario.destroy');

		Route::get('cbararrendatario/borradorC/{idg}','ContratoBorradorArrendatarioController@mostrarGestion');

		Route::post('cbararrendatario/{captacionArrendador}','ContratoBorradorArrendatarioController@update')->name('cbararrendatario.update')
		->middleware('permission:cbararrendatario.edit');

		Route::post('cbararrendatario/borrador/update','ContratoBorradorArrendatarioController@editarGestion')->name('cbararrendatario.editarGestion')
		->middleware('permission:cbararrendatario.edit');

		Route::get('cbararrendatario/mail/{id}','ContratoBorradorArrendatarioController@enviaMail')->name('cbararrendatario.mail');		
		Route::get('pdf/{data}', 'PdfController@index');


});