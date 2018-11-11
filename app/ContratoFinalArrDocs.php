<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class ContratoFinalArrDocs extends Model
{
    protected $table='adm_contratofinalarrdocs';
    protected $fillable = ['id','id_final','id_publicacion','tipo','ruta','nombre','id_creador'];

      public static function documentos($id_contrato) {

    	$documentos = DB::table('adm_contratofinalarrdocs as n')
    				->leftjoin('arrendatarios as a', 'n.id_publicacion', '=', 'a.id')
	                ->leftjoin('inmuebles as i', 'a.id_inmueble', '=', 'i.id')
	                ->leftjoin('comunas as o', 'i.id_comuna', '=', 'o.comuna_id')
	                ->where("n.id_final", "=", $id_contrato)
	                ->select(DB::raw(' n.id ,n.ruta, n.nombre, n.tipo, CONCAT_WS(" ",i.direccion,"#",i.numero,"Depto.",i.departamento,o.comuna_nombre) as direccion, n.id_final'))
	                ->get();

	      return $documentos;
    }
}
