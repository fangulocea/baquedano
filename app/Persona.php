<?php

namespace App;
use DB;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Persona extends Model
{
	use SoftDeletes;
    protected $table='personas';
    protected $fillable=['rut','nombre','apellido_paterno','apellido_materno','direccion','numero','departamento','telefono','email','id_comuna','id_region','id_provincia','tipo_cargo','cargo_id','id_estado','estado_civil','profesion','banco','tipo_cuenta','cuenta','titular','rut_titular'];
	 protected $dates = ['deleted_at'];

public static function personas($text){
    	// return Inmueble::where('direccion','like','%'.$text.'%')->get();
    	return DB::table('personas')->where('direccion','like','%'.$text.'%')->join('comunas', 'personas.id_comuna', '=', 'comunas.comuna_id')->get();
    }


public static function personasEmail($text){
    	// return Inmueble::where('direccion','like','%'.$text.'%')->get();
    	return DB::table('personas')->where('email','like','%'.$text.'%')->get();
    }

public static function personasFono($text){
        // return Inmueble::where('direccion','like','%'.$text.'%')->get();
        return DB::table('personas')->where('telefono','like','%'.$text.'%')->get();
    }
}