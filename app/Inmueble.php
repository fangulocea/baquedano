<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;

class Inmueble extends Model
{
	use SoftDeletes;
    protected $table='inmuebles';
    protected $fillable = ['direccion','numero','departamento','dormitorio','bano','estacionamiento','bodega','piscina','precio','gastosComunes','estado','id_comuna','id_region','id_provincia','referencia','condicion','rol','nro_bodega','observaciones'];
    protected $dates = ['deleted_at'];

public static function inmuebles($text){
    	// return Inmueble::where('direccion','like','%'.$text.'%')->get();
    	return DB::table('inmuebles')->where('direccion','like','%'.$text.'%')->join('comunas', 'inmuebles.id_comuna', '=', 'comunas.comuna_id')->get();
    }


}



