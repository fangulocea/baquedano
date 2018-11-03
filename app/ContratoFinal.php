<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;



class ContratoFinal extends Model
{

    protected $table='adm_contratofinal';
    protected $fillable = ['id','id_notaria','id_publicacion','fecha_firma','observaciones','id_estado','id_creador','id_modificador'
    ,'id_borrador','id_borradorpdf','meses_contrato','id_inmueble','id_propuesta','tipo_contrato','tipo','id_aval'];

    public static function contratos_activos_propietarios($id_propietario) {

    	  $direcciones = DB::table('adm_contratodirpropietarios as c')
    	  		->leftjoin('cap_publicaciones as p','p.id','=','c.id_publicacion')
                ->leftjoin('inmuebles as i', 'c.id_inmueble', '=', 'i.id')
                ->leftjoin('comunas as o', 'i.id_comuna', '=', 'o.comuna_id')
                ->leftjoin('adm_contratofinal as cf', 'c.id_contratofinal', '=', 'cf.id')
                ->leftjoin('notarias as n', 'cf.id_notaria', '=', 'n.id')
                 ->leftjoin('cap_simulapropietario as sp', 'cf.id_propuesta', '=', 'sp.id')
            ->leftjoin('mensajes as m', function($join){
                 $join->on('m.nombre_modulo', '=',DB::raw("'Contrato Final Propietario'"));
                 $join->on('m.id_estado', '=', 'cf.id_estado');
            })
                ->where("p.id_propietario", "=", $id_propietario)
                ->select(DB::raw("cf.meses_contrato, CASE  WHEN sp.tipopropuesta=1 THEN '1 Cuota' WHEN sp.tipopropuesta=2 THEN '11 Cuotas' WHEN sp.tipopropuesta=3 THEN 'Renovación 1 Cuota' WHEN sp.tipopropuesta=4 THEN 'Renovación 11 Cuotas' END as propuesta, n.razonsocial as notaria, m.nombre as estado, cf.fecha_firma, c.id as id_direccion_contrato, cf.id as id_contrato, i.id as id_inmueble, CONCAT_WS(' ',i.direccion,'#',i.numero,' Depto. ',i.departamento,o.comuna_nombre) as direccion, cf.alias,cf.id_estado"))
                ->get();

                return $direcciones;
    }


}
