<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class CuentasArrendatario extends Model
{

    public static function index_ajax(){
        $publica = DB::table('adm_contratofinal as co')
                ->leftjoin('cap_publicaciones as cb', 'co.id_publicacion', '=', 'cb.id')
                ->leftjoin('inmuebles as i', 'cb.id_inmueble', '=', 'i.id')
                ->leftjoin('comunas as o', 'i.id_comuna', '=', 'o.comuna_id')
                ->leftjoin('personas as p1', 'cb.id_propietario', '=', 'p1.id')
                ->leftjoin('users as p2', 'cb.id_creador', '=', 'p2.id')
                ->leftjoin('users as p3', 'cb.id_modificador', '=', 'p3.id')
                ->leftjoin('mensajes as m', function($join){
                 $join->on('m.nombre_modulo', '=',DB::raw("'Captación'"));
                 $join->on('m.id_estado', '=', 'cb.id_estado');
            })
                ->whereIn('co.id_estado', [7])
         ->select(DB::raw('co.id as id_contrato, 
                            DATE_FORMAT(co.created_at, "%d/%m/%Y") as FechaCreacion, 

                            CONCAT_WS(" ",p1.nombre,p1.apellido_paterno,p1.apellido_materno) as Propietario, 
                            p2.name as Creador,
                            p3.name as Modificador,
                            (select name from users where id=(select id_asignado from post_asignarevision where id_contrato=co.id order by 1 desc limit 1)) as Asignado,
                            (select created_at from post_asignarevision where id_contrato=co.id order by 1 desc limit 1) as fecha_revision,
                        (select nombre from mensajes where nombre_modulo="Revisión Cuentas" and id_estado=(select id_estado from post_asignarevision where id_contrato=co.id order by 1 desc limit 1)) as EstadoCuenta,
                            m.nombre as Estado,
                            CONCAT_WS(" ",i.direccion,i.numero," Dpto ",i.departamento) as Direccion,
                            i.direccion as calle,i.numero,i.departamento,
                            o.comuna_nombre as Comuna,
                            p1.email,
                            p1.telefono'))
                ->get();
                return $publica;
            }
}
