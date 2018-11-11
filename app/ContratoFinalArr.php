<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class ContratoFinalArr extends Model
{
protected $table='adm_contratofinalarr';
    protected $fillable = ['id','id_notaria','id_publicacion','fecha_firma','observaciones','id_estado','id_creador','id_modificador','id_borrador','id_borradorpdf','meses_contrato','id_simulacion', 'tipo_contrato','tipo','id_aval'];

     public static function contratos_activos_arrendatario($id_arrendatario) {

    	  $direcciones = DB::table('adm_contratofinalarr as c')
                ->leftjoin('arrendatarios as p','p.id','=','c.id_publicacion')
                ->leftjoin('inmuebles as i', 'p.id_inmueble', '=', 'i.id')
                ->leftjoin('comunas as o', 'i.id_comuna', '=', 'o.comuna_id')
                ->leftjoin('notarias as n', 'c.id_notaria', '=', 'n.id')
                ->leftjoin('cap_simulaarrendatario as sp', 'c.id_simulacion', '=', 'sp.id')
            ->leftjoin('mensajes as m', function($join){
                 $join->on('m.nombre_modulo', '=',DB::raw("'Contrato Final Arrendatario'"));
                 $join->on('m.id_estado', '=', 'c.id_estado');
            })
                ->where("p.id_arrendatario", "=", $id_arrendatario)
                ->select(DB::raw("c.id_estado,c.meses_contrato, CASE  WHEN sp.tipopropuesta=1 THEN '1 Cuota' WHEN sp.tipopropuesta=2 THEN '11 Cuotas' WHEN sp.tipopropuesta=3 THEN 'Renovación 1 Cuota' WHEN sp.tipopropuesta=4 THEN 'Renovación 11 Cuotas' END as propuesta, n.razonsocial as notaria, m.nombre as estado, c.fecha_firma, c.id as id_direccion_contrato, c.id as id_contrato, i.id as id_inmueble, CONCAT_WS(' ',i.direccion,'#',i.numero,' Depto. ',i.departamento,o.comuna_nombre) as direccion, c.alias,c.id_estado"))
                ->get();

                return $direcciones;
    }



    public static function id_contratos($id_arrendatario) {

          $direcciones = DB::table('adm_contratofinalarr as c')
                ->leftjoin('arrendatarios as p','p.id','=','c.id_publicacion')
                ->leftjoin('inmuebles as i', 'p.id_inmueble', '=', 'i.id')
                ->leftjoin('comunas as o', 'i.id_comuna', '=', 'o.comuna_id')
                ->leftjoin('notarias as n', 'c.id_notaria', '=', 'n.id')
                ->leftjoin('cap_simulaarrendatario as sp', 'c.id_simulacion', '=', 'sp.id')
            ->leftjoin('mensajes as m', function($join){
                 $join->on('m.nombre_modulo', '=',DB::raw("'Contrato Final Arrendatario'"));
                 $join->on('m.id_estado', '=', 'c.id_estado');
            })
                ->where("p.id_arrendatario", "=", $id_arrendatario)
                ->select(DB::raw("c.id"))
                ->get()->toArray();

                return $direcciones;
    }


    public static function datos_contrato($id) {

          $direcciones = DB::table('adm_contratofinalarr as c')
                ->leftjoin('arrendatarios as p','p.id','=','c.id_publicacion')
                ->leftjoin('inmuebles as i', 'p.id_inmueble', '=', 'i.id')
                ->leftjoin('comunas as o', 'i.id_comuna', '=', 'o.comuna_id')
                ->leftjoin('notarias as n', 'c.id_notaria', '=', 'n.id')
                ->leftjoin('cap_simulaarrendatario as sp', 'c.id_simulacion', '=', 'sp.id')
            ->leftjoin('mensajes as m', function($join){
                 $join->on('m.nombre_modulo', '=',DB::raw("'Contrato Final Arrendatario'"));
                 $join->on('m.id_estado', '=', 'c.id_estado');
            })
                ->where("c.id", "=", $id)
                ->select(DB::raw("c.meses_contrato, CASE  WHEN sp.tipopropuesta=1 THEN '1 Cuota' WHEN sp.tipopropuesta=2 THEN '11 Cuotas' WHEN sp.tipopropuesta=3 THEN 'Renovación 1 Cuota' WHEN sp.tipopropuesta=4 THEN 'Renovación 11 Cuotas' END as propuesta, n.razonsocial as notaria, m.nombre as estado, c.fecha_firma, c.id as id_direccion_contrato, c.id as id_contrato, i.id as id_inmueble, CONCAT_WS(' ',i.direccion,'#',i.numero,' Depto. ',i.departamento,o.comuna_nombre) as direccion, c.alias,c.id_estado"))
                ->first();

                return $direcciones;
    }
}
