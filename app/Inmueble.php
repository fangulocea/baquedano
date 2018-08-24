<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;

class Inmueble extends Model
{
	use SoftDeletes;
    protected $table='inmuebles';
    protected $fillable = ['direccion','numero','departamento','dormitorio','bano','estacionamiento','bodega','piscina','precio','gastosComunes','estado','id_comuna','id_region','id_provincia','referencia','condicion','rol','nro_bodega','observaciones','anio_antiguedad','nro_estacionamiento','edificio','nom_administrador','tel_administrador','email_administrador'];
    protected $dates = ['deleted_at'];

public static function inmuebles($text){

       return DB::select(DB::raw('Select i.id , i.direccion, i.numero, i.departamento, c.comuna_nombre from inmuebles as i left join comunas c on c.comuna_id=i.id_comuna where concat_ws(" ",i.direccion,i.numero) like "%'.$text.'%"'));
    }

public static function inmuebles_modulo($text,$modulo){
    	// return Inmueble::where('direccion','like','%'.$text.'%')->get();

	if($modulo==1){

        return DB::select(DB::raw('Select cf.id , i.direccion, i.numero, i.departamento, c.comuna_nombre 
            from adm_contratofinal as cf
            left join cap_publicaciones as p on cf.id_publicacion = p.id 
            left join inmuebles as i on i.id=p.id_inmueble
            left join comunas c on c.comuna_id=i.id_comuna
            where concat_ws(" ",i.direccion,i.numero) like "%'.$text.'%"
            and cf.id_estado in (7,10,6)'));


    	
	}else{
       return DB::select(DB::raw('Select cf.id , i.direccion, i.numero, i.departamento, c.comuna_nombre 
            from adm_contratofinalarr as cf
            left join arrendatarios as p on cf.id_publicacion = p.id 
            left join inmuebles as i on i.id=p.id_inmueble
            left join comunas c on c.comuna_id=i.id_comuna
            where concat_ws(" ",i.direccion,i.numero) like "%'.$text.'%"
            and cf.id_estado in (7,10,6)'));


	}
    }

}