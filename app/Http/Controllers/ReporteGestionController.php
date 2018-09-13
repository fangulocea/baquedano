<?php

namespace App\Http\Controllers;

use App\ReporteGestion;
use App\Captacion;
use App\Persona;
use App\Inmueble;
use App\Region;
use App\CaptacionFoto;
use App\CaptacionGestion;
use App\Portales;
use App\CaptacionImport;
use Illuminate\Http\Request;
use DB;
use Image;
use DateTime;
use Excel;
use Yajra\Datatables\Datatables;


class ReporteGestionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($dia)
    {   
        if($dia == 0)
        {
        $publica = DB::select('Select g.id_captacion_gestion as id,CONCAT_WS(", ",i.direccion,i.numero,c.comuna_nombre) as direccion, p.name as creador, g.tipo_contacto as contacto,DATE_FORMAT(g.fecha_gestion, "%d-%m-%Y") as fecha from cap_gestion g left join cap_publicaciones ca on ca.id=g.id_captacion_gestion left join users p on g.id_creador_gestion = p.id left join inmuebles i on i.id=ca.id_inmueble left join comunas c on c.comuna_id=i.id_comuna where g.fecha_gestion = CURDATE()');

        } elseif($dia == 30){
        $publica = DB::select('Select g.id_captacion_gestion as id,CONCAT_WS(", ",i.direccion,i.numero,c.comuna_nombre) as direccion, p.name as creador, g.tipo_contacto as contacto,DATE_FORMAT(g.fecha_gestion, "%d-%m-%Y") as fecha from cap_gestion g left join cap_publicaciones ca on ca.id=g.id_captacion_gestion left join users p on g.id_creador_gestion = p.id left join inmuebles i on i.id=ca.id_inmueble left join comunas c on c.comuna_id=i.id_comuna where g.fecha_gestion > DATE_SUB(CURDATE(), INTERVAL 30 DAY)');            
        } elseif($dia == 365){
        $publica = DB::select('Select g.id_captacion_gestion as id,CONCAT_WS(", ",i.direccion,i.numero,c.comuna_nombre) as direccion, p.name as creador, g.tipo_contacto as contacto,DATE_FORMAT(g.fecha_gestion, "%d-%m-%Y") as fecha from cap_gestion g left join cap_publicaciones ca on ca.id=g.id_captacion_gestion left join users p on g.id_creador_gestion = p.id left join inmuebles i on i.id=ca.id_inmueble left join comunas c on c.comuna_id=i.id_comuna where g.fecha_gestion > DATE_SUB(CURDATE(), INTERVAL 365 DAY)');            
        } else {
                    $publica = DB::select('Select g.id_captacion_gestion as id,CONCAT_WS(", ",i.direccion,i.numero,c.comuna_nombre) as direccion, p.name as creador, g.tipo_contacto as contacto,DATE_FORMAT(g.fecha_gestion, "%d-%m-%Y") as fecha from cap_gestion g left join cap_publicaciones ca on ca.id=g.id_captacion_gestion left join users p on g.id_creador_gestion = p.id left join inmuebles i on i.id=ca.id_inmueble left join comunas c on c.comuna_id=i.id_comuna ');
        }


        return view('reporteGestion.index',compact('publica'));
    }

    public function gestion_hoy(){
        return view('alertas.cap_gestiones');
    }


    public function gestion_hoy_ajax(Request $request)
    {
        $publica = DB::select('Select ca.id as id_publicacion, g.id_captacion_gestion as id,i.departamento,i.direccion,i.numero,c.comuna_nombre, p.name as creador, g.tipo_contacto as contacto,DATE_FORMAT(g.fecha_gestion, "%d-%m-%Y") as fecha from cap_gestion g left join cap_publicaciones ca on ca.id=g.id_captacion_gestion left join users p on g.id_creador_gestion = p.id left join inmuebles i on i.id=ca.id_inmueble left join comunas c on c.comuna_id=i.id_comuna where g.fecha_gestion = CURDATE() order by g.fecha_gestion desc');

     return Datatables::of($publica)
         ->addColumn('action', function ($publica) {
                               return  '<a href="/captacion/'.$publica->id_publicacion.'/2/edit"><span class="btn btn-warning btn-circle btn-sm"><i class="ti-pencil-alt"></i></span></a>
                                    <a href="/captacion/'.$publica->id_publicacion.'/destroy"><span class="btn btn-danger btn-circle btn-sm"><i class="ti-trash"></i></span></a>';
        })
        ->addColumn('id_link', function ($publica) {
                               return  '<a href="/captacion/'.$publica->id_publicacion.'/2/edit"><span class="btn btn-success btn-sm"> '.$publica->id_publicacion.'</span> </a>';
        })
        ->rawColumns(['id_link','action'])
        ->make(true);
    }


    public function gestion_mes(){
        return view('alertas.cap_gestiones_mes');
    }


    public function gestion_mes_ajax(Request $request)
    {
        $publica = DB::select('Select ca.id as id_publicacion, g.id_captacion_gestion as id,i.departamento,i.direccion,i.numero,c.comuna_nombre, p.name as creador, g.tipo_contacto as contacto,DATE_FORMAT(g.fecha_gestion, "%d-%m-%Y") as fecha from cap_gestion g left join cap_publicaciones ca on ca.id=g.id_captacion_gestion left join users p on g.id_creador_gestion = p.id left join inmuebles i on i.id=ca.id_inmueble left join comunas c on c.comuna_id=i.id_comuna where g.fecha_gestion > DATE_SUB(CURDATE(), INTERVAL 30 DAY) order by g.fecha_gestion desc');

     return Datatables::of($publica)
         ->addColumn('action', function ($publica) {
                               return  '<a href="/captacion/'.$publica->id_publicacion.'/2/edit"><span class="btn btn-warning btn-circle btn-sm"><i class="ti-pencil-alt"></i></span></a>
                                    <a href="/captacion/'.$publica->id_publicacion.'/destroy"><span class="btn btn-danger btn-circle btn-sm"><i class="ti-trash"></i></span></a>';
        })
        ->addColumn('id_link', function ($publica) {
                               return  '<a href="/captacion/'.$publica->id_publicacion.'/2/edit"><span class="btn btn-success btn-sm"> '.$publica->id_publicacion.'</span> </a>';
        })
        ->rawColumns(['id_link','action'])
        ->make(true);
    }

public function gestion_anual(){
        return view('alertas.cap_gestiones_anual');
    }


    public function gestion_anual_ajax(Request $request)
    {
        $publica = DB::select('Select ca.id as id_publicacion, g.id_captacion_gestion as id,i.departamento,i.direccion,i.numero,c.comuna_nombre, p.name as creador, g.tipo_contacto as contacto,DATE_FORMAT(g.fecha_gestion, "%d-%m-%Y") as fecha from cap_gestion g left join cap_publicaciones ca on ca.id=g.id_captacion_gestion left join users p on g.id_creador_gestion = p.id left join inmuebles i on i.id=ca.id_inmueble left join comunas c on c.comuna_id=i.id_comuna where g.fecha_gestion > DATE_SUB(CURDATE(), INTERVAL 365 DAY) order by g.fecha_gestion desc');

     return Datatables::of($publica)
         ->addColumn('action', function ($publica) {
                               return  '<a href="/captacion/'.$publica->id_publicacion.'/2/edit"><span class="btn btn-warning btn-circle btn-sm"><i class="ti-pencil-alt"></i></span></a>
                                    <a href="/captacion/'.$publica->id_publicacion.'/destroy"><span class="btn btn-danger btn-circle btn-sm"><i class="ti-trash"></i></span></a>';
        })
        ->addColumn('id_link', function ($publica) {
                               return  '<a href="/captacion/'.$publica->id_publicacion.'/2/edit"><span class="btn btn-success btn-sm"> '.$publica->id_publicacion.'</span> </a>';
        })
        ->rawColumns(['id_link','action'])
        ->make(true);
    }



public function gestion_total(){
        return view('alertas.cap_gestiones_anual');
    }


    public function gestion_total_ajax(Request $request)
    {
        $publica = DB::select('Select ca.id as id_publicacion, g.id_captacion_gestion as id,i.departamento,i.direccion,i.numero,c.comuna_nombre, p.name as creador, g.tipo_contacto as contacto,DATE_FORMAT(g.fecha_gestion, "%d-%m-%Y") as fecha from cap_gestion g left join cap_publicaciones ca on ca.id=g.id_captacion_gestion left join users p on g.id_creador_gestion = p.id left join inmuebles i on i.id=ca.id_inmueble left join comunas c on c.comuna_id=i.id_comuna  order by g.fecha_gestion desc');

     return Datatables::of($publica)
         ->addColumn('action', function ($publica) {
                               return  '<a href="/captacion/'.$publica->id_publicacion.'/2/edit"><span class="btn btn-warning btn-circle btn-sm"><i class="ti-pencil-alt"></i></span></a>
                                    <a href="/captacion/'.$publica->id_publicacion.'/destroy"><span class="btn btn-danger btn-circle btn-sm"><i class="ti-trash"></i></span></a>';
        })
        ->addColumn('id_link', function ($publica) {
                               return  '<a href="/captacion/'.$publica->id_publicacion.'/2/edit"><span class="btn btn-success btn-sm"> '.$publica->id_publicacion.'</span> </a>';
        })
        ->rawColumns(['id_link','action'])
        ->make(true);
    }



  public function cap_mes(){
        return view('alertas.cap_mes');
    }


    public function cap_mes_ajax(Request $request)
    {
            $publica = DB::table('cap_publicaciones as c')
                ->leftjoin('personas as p1', 'c.id_propietario', '=', 'p1.id')
                ->leftjoin('inmuebles as i', 'c.id_inmueble', '=', 'i.id')
                ->leftjoin('users as p2', 'c.id_creador', '=', 'p2.id')
                ->leftjoin('personas as p3', 'c.id_modificador', '=', 'p3.id')
                ->leftjoin('personas as p4', 'c.id_corredor', '=', 'p4.id')
                ->leftjoin('comunas as o', 'i.id_comuna', '=', 'o.comuna_id')
                ->leftjoin('portales as po', 'c.portal', '=', 'po.id')
               ->leftjoin('mensajes as m', function($join){
                 $join->on('m.nombre_modulo', '=',DB::raw("'Captación'"));
                 $join->on('m.id_estado', '=', 'c.id_estado');
            })
               ->where("c.id_estado","<>",0)
                ->select(DB::raw('c.url, c.id as id_publicacion, DATE_FORMAT(c.created_at, "%d/%m/%Y %T") as fecha_creacion,DATE_FORMAT(c.updated_at, "%d/%m/%Y") as fecha_modificacion, m.nombre as id_estado, CONCAT_WS(" ",p1.nombre,p1.apellido_paterno,p1.apellido_materno) as Propietario, CONCAT_WS(" ",p4.nombre,p4.apellido_paterno,p4.apellido_materno) as Externo,
                    (select tipo_contacto from cap_gestion where id_captacion_gestion=c.id order by created_at asc limit 1) as tipo_contacto, (select (select name from users where id=id_creador_gestion limit 1)  from cap_gestion where id_captacion_gestion=c.id order by created_at asc limit 1) as creador_gestion, 
         c.tipo, p2.name as Creador, CONCAT_WS(" ",p3.nombre,p3.apellido_paterno,p3.apellido_materno) as Modificador,p1.email,p1.telefono,c.fecha_publicacion,i.departamento,i.numero,i.direccion'), 'i.id as id_inmueble', 'o.comuna_nombre', 'po.nombre as portal', 'p1.nombre as nom_p', 'p1.apellido_paterno as apep_p', 'p1.apellido_materno as apem_p', 'p3.nombre as nom_m', 'p3.apellido_paterno as apep_m', 'p3.apellido_materno as apem_m')
                ->orderBy("c.id","Desc")
                ->get();

     return Datatables::of($publica)
         ->addColumn('action', function ($publica) {
                               return  '<a href="/captacion/'.$publica->id_publicacion.'/2/edit"><span class="btn btn-warning btn-circle btn-sm"><i class="ti-pencil-alt"></i></span></a>
                                    <a href="/captacion/'.$publica->id_publicacion.'/destroy"><span class="btn btn-danger btn-circle btn-sm"><i class="ti-trash"></i></span></a>';
        })
        ->addColumn('id_link', function ($publica) {
                               return  '<a href="/captacion/'.$publica->id_publicacion.'/2/edit"><span class="btn btn-success btn-sm"> '.$publica->id_publicacion.'</span> </a>';
        })
        ->rawColumns(['id_link','action'])
        ->make(true);
    }  


    public function cap_anual(){
        return view('alertas.cap_mes');
    }


    public function cap_anual_ajax(Request $request)
    {
            $publica = DB::table('cap_publicaciones as c')
                ->leftjoin('personas as p1', 'c.id_propietario', '=', 'p1.id')
                ->leftjoin('inmuebles as i', 'c.id_inmueble', '=', 'i.id')
                ->leftjoin('users as p2', 'c.id_creador', '=', 'p2.id')
                ->leftjoin('personas as p3', 'c.id_modificador', '=', 'p3.id')
                ->leftjoin('personas as p4', 'c.id_corredor', '=', 'p4.id')
                ->leftjoin('comunas as o', 'i.id_comuna', '=', 'o.comuna_id')
                ->leftjoin('portales as po', 'c.portal', '=', 'po.id')
               ->leftjoin('mensajes as m', function($join){
                 $join->on('m.nombre_modulo', '=',DB::raw("'Captación'"));
                 $join->on('m.id_estado', '=', 'c.id_estado');
            })
               ->where("c.id_estado","<>",0)
                ->select(DB::raw('c.url, c.id as id_publicacion, DATE_FORMAT(c.created_at, "%d/%m/%Y %T") as fecha_creacion,DATE_FORMAT(c.updated_at, "%d/%m/%Y") as fecha_modificacion, m.nombre as id_estado, CONCAT_WS(" ",p1.nombre,p1.apellido_paterno,p1.apellido_materno) as Propietario, CONCAT_WS(" ",p4.nombre,p4.apellido_paterno,p4.apellido_materno) as Externo,
                    (select tipo_contacto from cap_gestion where id_captacion_gestion=c.id order by created_at asc limit 1) as tipo_contacto, (select (select name from users where id=id_creador_gestion limit 1)  from cap_gestion where id_captacion_gestion=c.id order by created_at asc limit 1) as creador_gestion, 
         c.tipo, p2.name as Creador, CONCAT_WS(" ",p3.nombre,p3.apellido_paterno,p3.apellido_materno) as Modificador,p1.email,p1.telefono,c.fecha_publicacion,i.departamento,i.numero,i.direccion'), 'i.id as id_inmueble', 'o.comuna_nombre', 'po.nombre as portal', 'p1.nombre as nom_p', 'p1.apellido_paterno as apep_p', 'p1.apellido_materno as apem_p', 'p3.nombre as nom_m', 'p3.apellido_paterno as apep_m', 'p3.apellido_materno as apem_m')
                ->where('c.created_at','>',date('Y-m-d',strtotime('-365 day', strtotime(date("Y-m-d")))))
                ->orderBy("c.id","Desc")
                ->get();

     return Datatables::of($publica)
         ->addColumn('action', function ($publica) {
                               return  '<a href="/captacion/'.$publica->id_publicacion.'/2/edit"><span class="btn btn-warning btn-circle btn-sm"><i class="ti-pencil-alt"></i></span></a>
                                    <a href="/captacion/'.$publica->id_publicacion.'/destroy"><span class="btn btn-danger btn-circle btn-sm"><i class="ti-trash"></i></span></a>';
        })
        ->addColumn('id_link', function ($publica) {
                               return  '<a href="/captacion/'.$publica->id_publicacion.'/2/edit"><span class="btn btn-success btn-sm"> '.$publica->id_publicacion.'</span> </a>';
        })
        ->rawColumns(['id_link','action'])
        ->make(true);
    }  


     public function cap_descartadas(){
        return view('alertas.cap_descartadas');
    }


    public function cap_descartadas_ajax(Request $request)
    {
            $publica = DB::table('cap_publicaciones as c')
                ->leftjoin('personas as p1', 'c.id_propietario', '=', 'p1.id')
                ->leftjoin('inmuebles as i', 'c.id_inmueble', '=', 'i.id')
                ->leftjoin('users as p2', 'c.id_creador', '=', 'p2.id')
                ->leftjoin('personas as p3', 'c.id_modificador', '=', 'p3.id')
                ->leftjoin('personas as p4', 'c.id_corredor', '=', 'p4.id')
                ->leftjoin('comunas as o', 'i.id_comuna', '=', 'o.comuna_id')
                ->leftjoin('portales as po', 'c.portal', '=', 'po.id')
               ->leftjoin('mensajes as m', function($join){
                 $join->on('m.nombre_modulo', '=',DB::raw("'Captación'"));
                 $join->on('m.id_estado', '=', 'c.id_estado');
            })
               ->where("c.id_estado","=",0)
                ->select(DB::raw('c.url, c.id as id_publicacion, DATE_FORMAT(c.created_at, "%d/%m/%Y %T") as fecha_creacion,DATE_FORMAT(c.updated_at, "%d/%m/%Y") as fecha_modificacion, m.nombre as id_estado, CONCAT_WS(" ",p1.nombre,p1.apellido_paterno,p1.apellido_materno) as Propietario, CONCAT_WS(" ",p4.nombre,p4.apellido_paterno,p4.apellido_materno) as Externo,
                    (select tipo_contacto from cap_gestion where id_captacion_gestion=c.id order by created_at asc limit 1) as tipo_contacto, (select (select name from users where id=id_creador_gestion limit 1)  from cap_gestion where id_captacion_gestion=c.id order by created_at asc limit 1) as creador_gestion, 
         c.tipo, p2.name as Creador, CONCAT_WS(" ",p3.nombre,p3.apellido_paterno,p3.apellido_materno) as Modificador,p1.email,p1.telefono,c.fecha_publicacion,i.departamento,i.numero,i.direccion'), 'i.id as id_inmueble', 'o.comuna_nombre', 'po.nombre as portal', 'p1.nombre as nom_p', 'p1.apellido_paterno as apep_p', 'p1.apellido_materno as apem_p', 'p3.nombre as nom_m', 'p3.apellido_paterno as apep_m', 'p3.apellido_materno as apem_m')
                ->orderBy("c.id","Desc")
                ->get();

     return Datatables::of($publica)
         ->addColumn('action', function ($publica) {
                               return  '<a href="/captacion/'.$publica->id_publicacion.'/2/edit"><span class="btn btn-warning btn-circle btn-sm"><i class="ti-pencil-alt"></i></span></a>
                                    <a href="/captacion/'.$publica->id_publicacion.'/destroy"><span class="btn btn-danger btn-circle btn-sm"><i class="ti-trash"></i></span></a>';
        })
        ->addColumn('id_link', function ($publica) {
                               return  '<a href="/captacion/'.$publica->id_publicacion.'/2/edit"><span class="btn btn-success btn-sm"> '.$publica->id_publicacion.'</span> </a>';
        })
        ->rawColumns(['id_link','action'])
        ->make(true);
    }  


    public function cap_sin_respuesta(){
        return view('alertas.cap_sin_respuesta');
    }


    public function cap_sin_respuesta_ajax(Request $request)
    {
            $publica = DB::table('cap_publicaciones as c')
                ->leftjoin('personas as p1', 'c.id_propietario', '=', 'p1.id')
                ->leftjoin('inmuebles as i', 'c.id_inmueble', '=', 'i.id')
                ->leftjoin('users as p2', 'c.id_creador', '=', 'p2.id')
                ->leftjoin('personas as p3', 'c.id_modificador', '=', 'p3.id')
                ->leftjoin('personas as p4', 'c.id_corredor', '=', 'p4.id')
                ->leftjoin('comunas as o', 'i.id_comuna', '=', 'o.comuna_id')
                ->leftjoin('portales as po', 'c.portal', '=', 'po.id')
               ->leftjoin('mensajes as m', function($join){
                 $join->on('m.nombre_modulo', '=',DB::raw("'Captación'"));
                 $join->on('m.id_estado', '=', 'c.id_estado');
            })
              ->where('c.id_estado','=',2)->Where('c.id_estado', '<>', 0)
                ->select(DB::raw('c.url, c.id as id_publicacion, DATE_FORMAT(c.created_at, "%d/%m/%Y %T") as fecha_creacion,DATE_FORMAT(c.updated_at, "%d/%m/%Y") as fecha_modificacion, m.nombre as id_estado, CONCAT_WS(" ",p1.nombre,p1.apellido_paterno,p1.apellido_materno) as Propietario, CONCAT_WS(" ",p4.nombre,p4.apellido_paterno,p4.apellido_materno) as Externo,
                    (select tipo_contacto from cap_gestion where id_captacion_gestion=c.id order by created_at asc limit 1) as tipo_contacto, (select (select name from users where id=id_creador_gestion limit 1)  from cap_gestion where id_captacion_gestion=c.id order by created_at asc limit 1) as creador_gestion, 
         c.tipo, p2.name as Creador, CONCAT_WS(" ",p3.nombre,p3.apellido_paterno,p3.apellido_materno) as Modificador,p1.email,p1.telefono,c.fecha_publicacion,i.departamento,i.numero,i.direccion'), 'i.id as id_inmueble', 'o.comuna_nombre', 'po.nombre as portal', 'p1.nombre as nom_p', 'p1.apellido_paterno as apep_p', 'p1.apellido_materno as apem_p', 'p3.nombre as nom_m', 'p3.apellido_paterno as apep_m', 'p3.apellido_materno as apem_m')
                ->orderBy("c.id","Desc")
                ->get();

     return Datatables::of($publica)
         ->addColumn('action', function ($publica) {
                               return  '<a href="/captacion/'.$publica->id_publicacion.'/2/edit"><span class="btn btn-warning btn-circle btn-sm"><i class="ti-pencil-alt"></i></span></a>
                                    <a href="/captacion/'.$publica->id_publicacion.'/destroy"><span class="btn btn-danger btn-circle btn-sm"><i class="ti-trash"></i></span></a>';
        })
        ->addColumn('id_link', function ($publica) {
                               return  '<a href="/captacion/'.$publica->id_publicacion.'/2/edit"><span class="btn btn-success btn-sm"> '.$publica->id_publicacion.'</span> </a>';
        })
        ->rawColumns(['id_link','action'])
        ->make(true);
    }  


     public function cap_primera_gestion(){
        return view('alertas.cap_primera_gestion');
    }


    public function cap_primera_gestion_ajax(Request $request)
    {
            $publica = DB::table('cap_publicaciones as c')
                ->leftjoin('personas as p1', 'c.id_propietario', '=', 'p1.id')
                ->leftjoin('inmuebles as i', 'c.id_inmueble', '=', 'i.id')
                ->leftjoin('users as p2', 'c.id_creador', '=', 'p2.id')
                ->leftjoin('personas as p3', 'c.id_modificador', '=', 'p3.id')
                ->leftjoin('personas as p4', 'c.id_corredor', '=', 'p4.id')
                ->leftjoin('comunas as o', 'i.id_comuna', '=', 'o.comuna_id')
                ->leftjoin('portales as po', 'c.portal', '=', 'po.id')
               ->leftjoin('mensajes as m', function($join){
                 $join->on('m.nombre_modulo', '=',DB::raw("'Captación'"));
                 $join->on('m.id_estado', '=', 'c.id_estado');
            })
               ->where('c.id_estado','=',3)->Where('c.id_estado', '<>', 0)
                ->select(DB::raw('c.url, c.id as id_publicacion, DATE_FORMAT(c.created_at, "%d/%m/%Y %T") as fecha_creacion,DATE_FORMAT(c.updated_at, "%d/%m/%Y") as fecha_modificacion, m.nombre as id_estado, CONCAT_WS(" ",p1.nombre,p1.apellido_paterno,p1.apellido_materno) as Propietario, CONCAT_WS(" ",p4.nombre,p4.apellido_paterno,p4.apellido_materno) as Externo,
                    (select tipo_contacto from cap_gestion where id_captacion_gestion=c.id order by created_at asc limit 1) as tipo_contacto, (select (select name from users where id=id_creador_gestion limit 1)  from cap_gestion where id_captacion_gestion=c.id order by created_at asc limit 1) as creador_gestion, 
         c.tipo, p2.name as Creador, CONCAT_WS(" ",p3.nombre,p3.apellido_paterno,p3.apellido_materno) as Modificador,p1.email,p1.telefono,c.fecha_publicacion,i.departamento,i.numero,i.direccion'), 'i.id as id_inmueble', 'o.comuna_nombre', 'po.nombre as portal', 'p1.nombre as nom_p', 'p1.apellido_paterno as apep_p', 'p1.apellido_materno as apem_p', 'p3.nombre as nom_m', 'p3.apellido_paterno as apep_m', 'p3.apellido_materno as apem_m')
                ->orderBy("c.id","Desc")
                ->get();

     return Datatables::of($publica)
         ->addColumn('action', function ($publica) {
                               return  '<a href="/captacion/'.$publica->id_publicacion.'/2/edit"><span class="btn btn-warning btn-circle btn-sm"><i class="ti-pencil-alt"></i></span></a>
                                    <a href="/captacion/'.$publica->id_publicacion.'/destroy"><span class="btn btn-danger btn-circle btn-sm"><i class="ti-trash"></i></span></a>';
        })
        ->addColumn('id_link', function ($publica) {
                               return  '<a href="/captacion/'.$publica->id_publicacion.'/2/edit"><span class="btn btn-success btn-sm"> '.$publica->id_publicacion.'</span> </a>';
        })
        ->rawColumns(['id_link','action'])
        ->make(true);
    }  

 public function cap_sin_gestion(){
        return view('alertas.cap_sin_gestion');
    }


    public function cap_sin_gestion_ajax(Request $request)
    {
            $publica = DB::table('cap_publicaciones as c')
                ->leftjoin('personas as p1', 'c.id_propietario', '=', 'p1.id')
                ->leftjoin('inmuebles as i', 'c.id_inmueble', '=', 'i.id')
                ->leftjoin('users as p2', 'c.id_creador', '=', 'p2.id')
                ->leftjoin('personas as p3', 'c.id_modificador', '=', 'p3.id')
                ->leftjoin('personas as p4', 'c.id_corredor', '=', 'p4.id')
                ->leftjoin('comunas as o', 'i.id_comuna', '=', 'o.comuna_id')
                ->leftjoin('portales as po', 'c.portal', '=', 'po.id')
               ->leftjoin('mensajes as m', function($join){
                 $join->on('m.nombre_modulo', '=',DB::raw("'Captación'"));
                 $join->on('m.id_estado', '=', 'c.id_estado');
            })
               ->where(DB::raw('(select count(*) from cap_gestion g where g.id_captacion_gestion = c.id)'),'=',0)->Where('c.id_estado', '<>', 0)
                ->select(DB::raw('c.url, c.id as id_publicacion, DATE_FORMAT(c.created_at, "%d/%m/%Y %T") as fecha_creacion,DATE_FORMAT(c.updated_at, "%d/%m/%Y") as fecha_modificacion, m.nombre as id_estado, CONCAT_WS(" ",p1.nombre,p1.apellido_paterno,p1.apellido_materno) as Propietario, CONCAT_WS(" ",p4.nombre,p4.apellido_paterno,p4.apellido_materno) as Externo,
                    (select tipo_contacto from cap_gestion where id_captacion_gestion=c.id order by created_at asc limit 1) as tipo_contacto, (select (select name from users where id=id_creador_gestion limit 1)  from cap_gestion where id_captacion_gestion=c.id order by created_at asc limit 1) as creador_gestion, 
         c.tipo, p2.name as Creador, CONCAT_WS(" ",p3.nombre,p3.apellido_paterno,p3.apellido_materno) as Modificador,p1.email,p1.telefono,c.fecha_publicacion,i.departamento,i.numero,i.direccion'), 'i.id as id_inmueble', 'o.comuna_nombre', 'po.nombre as portal', 'p1.nombre as nom_p', 'p1.apellido_paterno as apep_p', 'p1.apellido_materno as apem_p', 'p3.nombre as nom_m', 'p3.apellido_paterno as apep_m', 'p3.apellido_materno as apem_m')
                ->orderBy("c.id","Desc")
                ->get();

     return Datatables::of($publica)
         ->addColumn('action', function ($publica) {
                               return  '<a href="/captacion/'.$publica->id_publicacion.'/2/edit"><span class="btn btn-warning btn-circle btn-sm"><i class="ti-pencil-alt"></i></span></a>
                                    <a href="/captacion/'.$publica->id_publicacion.'/destroy"><span class="btn btn-danger btn-circle btn-sm"><i class="ti-trash"></i></span></a>';
        })
        ->addColumn('id_link', function ($publica) {
                               return  '<a href="/captacion/'.$publica->id_publicacion.'/2/edit"><span class="btn btn-success btn-sm"> '.$publica->id_publicacion.'</span> </a>';
        })
        ->rawColumns(['id_link','action'])
        ->make(true);
    }  


    public function cap_borrador(){
        return view('alertas.cap_borrador');
    }


    public function cap_borrador_ajax(Request $request)
    {
            $publica = DB::table('cap_publicaciones as c')
                ->leftjoin('personas as p1', 'c.id_propietario', '=', 'p1.id')
                ->leftjoin('inmuebles as i', 'c.id_inmueble', '=', 'i.id')
                ->leftjoin('users as p2', 'c.id_creador', '=', 'p2.id')
                ->leftjoin('personas as p3', 'c.id_modificador', '=', 'p3.id')
                ->leftjoin('personas as p4', 'c.id_corredor', '=', 'p4.id')
                ->leftjoin('comunas as o', 'i.id_comuna', '=', 'o.comuna_id')
                ->leftjoin('portales as po', 'c.portal', '=', 'po.id')
               ->leftjoin('mensajes as m', function($join){
                 $join->on('m.nombre_modulo', '=',DB::raw("'Captación'"));
                 $join->on('m.id_estado', '=', 'c.id_estado');
            })
               ->Wherein('c.id_estado',[5,6,7])
                ->select(DB::raw('c.url, c.id as id_publicacion, DATE_FORMAT(c.created_at, "%d/%m/%Y %T") as fecha_creacion,DATE_FORMAT(c.updated_at, "%d/%m/%Y") as fecha_modificacion, m.nombre as id_estado, CONCAT_WS(" ",p1.nombre,p1.apellido_paterno,p1.apellido_materno) as Propietario, CONCAT_WS(" ",p4.nombre,p4.apellido_paterno,p4.apellido_materno) as Externo,
                    (select tipo_contacto from cap_gestion where id_captacion_gestion=c.id order by created_at asc limit 1) as tipo_contacto, (select (select name from users where id=id_creador_gestion limit 1)  from cap_gestion where id_captacion_gestion=c.id order by created_at asc limit 1) as creador_gestion, 
         c.tipo, p2.name as Creador, CONCAT_WS(" ",p3.nombre,p3.apellido_paterno,p3.apellido_materno) as Modificador,p1.email,p1.telefono,c.fecha_publicacion,i.departamento,i.numero,i.direccion'), 'i.id as id_inmueble', 'o.comuna_nombre', 'po.nombre as portal', 'p1.nombre as nom_p', 'p1.apellido_paterno as apep_p', 'p1.apellido_materno as apem_p', 'p3.nombre as nom_m', 'p3.apellido_paterno as apep_m', 'p3.apellido_materno as apem_m')
                ->orderBy("c.id","Desc")
                ->get();

     return Datatables::of($publica)
         ->addColumn('action', function ($publica) {
                               return  '<a href="/captacion/'.$publica->id_publicacion.'/2/edit"><span class="btn btn-warning btn-circle btn-sm"><i class="ti-pencil-alt"></i></span></a>
                                    <a href="/captacion/'.$publica->id_publicacion.'/destroy"><span class="btn btn-danger btn-circle btn-sm"><i class="ti-trash"></i></span></a>';
        })
        ->addColumn('id_link', function ($publica) {
                               return  '<a href="/captacion/'.$publica->id_publicacion.'/2/edit"><span class="btn btn-success btn-sm"> '.$publica->id_publicacion.'</span> </a>';
        })
        ->rawColumns(['id_link','action'])
        ->make(true);
    }  

    public function cap_contrato(){
        return view('alertas.cap_contrato');
    }


    public function cap_contrato_ajax(Request $request)
    {
            $publica = DB::table('cap_publicaciones as c')
                ->leftjoin('personas as p1', 'c.id_propietario', '=', 'p1.id')
                ->leftjoin('inmuebles as i', 'c.id_inmueble', '=', 'i.id')
                ->leftjoin('users as p2', 'c.id_creador', '=', 'p2.id')
                ->leftjoin('personas as p3', 'c.id_modificador', '=', 'p3.id')
                ->leftjoin('personas as p4', 'c.id_corredor', '=', 'p4.id')
                ->leftjoin('comunas as o', 'i.id_comuna', '=', 'o.comuna_id')
                ->leftjoin('portales as po', 'c.portal', '=', 'po.id')
               ->leftjoin('mensajes as m', function($join){
                 $join->on('m.nombre_modulo', '=',DB::raw("'Captación'"));
                 $join->on('m.id_estado', '=', 'c.id_estado');
            })
               ->Wherein('c.id_estado',[10])
                ->select(DB::raw('c.url, c.id as id_publicacion, DATE_FORMAT(c.created_at, "%d/%m/%Y %T") as fecha_creacion,DATE_FORMAT(c.updated_at, "%d/%m/%Y") as fecha_modificacion, m.nombre as id_estado, CONCAT_WS(" ",p1.nombre,p1.apellido_paterno,p1.apellido_materno) as Propietario, CONCAT_WS(" ",p4.nombre,p4.apellido_paterno,p4.apellido_materno) as Externo,
                    (select tipo_contacto from cap_gestion where id_captacion_gestion=c.id order by created_at asc limit 1) as tipo_contacto, (select (select name from users where id=id_creador_gestion limit 1)  from cap_gestion where id_captacion_gestion=c.id order by created_at asc limit 1) as creador_gestion, 
         c.tipo, p2.name as Creador, CONCAT_WS(" ",p3.nombre,p3.apellido_paterno,p3.apellido_materno) as Modificador,p1.email,p1.telefono,c.fecha_publicacion,i.departamento,i.numero,i.direccion'), 'i.id as id_inmueble', 'o.comuna_nombre', 'po.nombre as portal', 'p1.nombre as nom_p', 'p1.apellido_paterno as apep_p', 'p1.apellido_materno as apem_p', 'p3.nombre as nom_m', 'p3.apellido_paterno as apep_m', 'p3.apellido_materno as apem_m')
                ->orderBy("c.id","Desc")
                ->get();

     return Datatables::of($publica)
         ->addColumn('action', function ($publica) {
                               return  '<a href="/captacion/'.$publica->id_publicacion.'/2/edit"><span class="btn btn-warning btn-circle btn-sm"><i class="ti-pencil-alt"></i></span></a>
                                    <a href="/captacion/'.$publica->id_publicacion.'/destroy"><span class="btn btn-danger btn-circle btn-sm"><i class="ti-trash"></i></span></a>';
        })
        ->addColumn('id_link', function ($publica) {
                               return  '<a href="/captacion/'.$publica->id_publicacion.'/2/edit"><span class="btn btn-success btn-sm"> '.$publica->id_publicacion.'</span> </a>';
        })
        ->rawColumns(['id_link','action'])
        ->make(true);
    }  

public function cap_mes_arr(){
        return view('alertas.cap_mes_arr');
    }


    public function cap_mes_arr_ajax(Request $request)
    {
            $publica = DB::table('Arrendatarios as c')
                ->leftjoin('personas as p1', 'c.id_arrendatario', '=', 'p1.id')
                ->leftjoin('inmuebles as i', 'c.id_inmueble', '=', 'i.id')
                ->leftjoin('users as p2', 'c.id_creador', '=', 'p2.id')
                ->leftjoin('personas as p3', 'c.id_modificador', '=', 'p3.id')
                ->leftjoin('comunas as o', 'i.id_comuna', '=', 'o.comuna_id')
               ->leftjoin('mensajes as m', function($join){
                 $join->on('m.nombre_modulo', '=',DB::raw("'Arrendatario'"));
                 $join->on('m.id_estado', '=', 'c.id_estado');
            })
                ->select(DB::raw(' c.id as id_publicacion, DATE_FORMAT(c.created_at, "%d/%m/%Y %T") as fecha_creacion,DATE_FORMAT(c.updated_at, "%d/%m/%Y") as fecha_modificacion, m.nombre as id_estado, CONCAT_WS(" ",p1.nombre,p1.apellido_paterno,p1.apellido_materno) as Arrendatario,
                    p2.name as Creador, CONCAT_WS(" ",p3.nombre,p3.apellido_paterno,p3.apellido_materno) as Modificador,p1.email,p1.telefono,i.departamento,i.numero,i.direccion'), 'i.id as id_inmueble', 'o.comuna_nombre', 'p1.nombre as nom_p', 'p1.apellido_paterno as apep_p', 'p1.apellido_materno as apem_p', 'p3.nombre as nom_m', 'p3.apellido_paterno as apep_m', 'p3.apellido_materno as apem_m')
                ->where('c.created_at','>',date('Y-m-d',strtotime('-30 day', strtotime(date("Y-m-d")))))
                ->orderBy("c.id","Desc")
                ->get();

     return Datatables::of($publica)
         ->addColumn('action', function ($publica) {
                               return  '<a href="/arrendatario/edit/'.$publica->id_publicacion.'/1"><span class="btn btn-warning btn-circle btn-sm"><i class="ti-pencil-alt"></i></span></a>
                                    ';
        })
        ->addColumn('id_link', function ($publica) {
                               return  '<a href="/arrendatario/edit/'.$publica->id_publicacion.'/1"><span class="btn btn-success btn-sm"> '.$publica->id_publicacion.'</span> </a>';
        })
        ->rawColumns(['id_link','action'])
        ->make(true);
    }  


    public function cap_anual_arr(){
        return view('alertas.cap_anual_arr');
    }


    public function cap_anual_arr_ajax(Request $request)
    {
            $publica = DB::table('Arrendatarios as c')
                ->leftjoin('personas as p1', 'c.id_arrendatario', '=', 'p1.id')
                ->leftjoin('inmuebles as i', 'c.id_inmueble', '=', 'i.id')
                ->leftjoin('users as p2', 'c.id_creador', '=', 'p2.id')
                ->leftjoin('personas as p3', 'c.id_modificador', '=', 'p3.id')
                ->leftjoin('comunas as o', 'i.id_comuna', '=', 'o.comuna_id')
               ->leftjoin('mensajes as m', function($join){
                 $join->on('m.nombre_modulo', '=',DB::raw("'Arrendatario'"));
                 $join->on('m.id_estado', '=', 'c.id_estado');
            })
                ->select(DB::raw(' c.id as id_publicacion, DATE_FORMAT(c.created_at, "%d/%m/%Y %T") as fecha_creacion,DATE_FORMAT(c.updated_at, "%d/%m/%Y") as fecha_modificacion, m.nombre as id_estado, CONCAT_WS(" ",p1.nombre,p1.apellido_paterno,p1.apellido_materno) as Arrendatario,
                    p2.name as Creador, CONCAT_WS(" ",p3.nombre,p3.apellido_paterno,p3.apellido_materno) as Modificador,p1.email,p1.telefono,i.departamento,i.numero,i.direccion'), 'i.id as id_inmueble', 'o.comuna_nombre', 'p1.nombre as nom_p', 'p1.apellido_paterno as apep_p', 'p1.apellido_materno as apem_p', 'p3.nombre as nom_m', 'p3.apellido_paterno as apep_m', 'p3.apellido_materno as apem_m')
                ->where('c.created_at','>',date('Y-m-d',strtotime('-365 day', strtotime(date("Y-m-d")))))
                ->orderBy("c.id","Desc")
                ->get();

     return Datatables::of($publica)
         ->addColumn('action', function ($publica) {
                               return  '<a href="/arrendatario/edit/'.$publica->id_publicacion.'/1"><span class="btn btn-warning btn-circle btn-sm"><i class="ti-pencil-alt"></i></span></a>
                                    ';
        })
        ->addColumn('id_link', function ($publica) {
                               return  '<a href="/arrendatario/edit/'.$publica->id_publicacion.'/1"><span class="btn btn-success btn-sm"> '.$publica->id_publicacion.'</span> </a>';
        })
        ->rawColumns(['id_link','action'])
        ->make(true);
    }  


public function cap_descartadas_arr(){
        return view('alertas.cap_descartadas_arr');
    }


    public function cap_descartadas_arr_ajax(Request $request)
    {
            $publica = DB::table('Arrendatarios as c')
                ->leftjoin('personas as p1', 'c.id_arrendatario', '=', 'p1.id')
                ->leftjoin('inmuebles as i', 'c.id_inmueble', '=', 'i.id')
                ->leftjoin('users as p2', 'c.id_creador', '=', 'p2.id')
                ->leftjoin('personas as p3', 'c.id_modificador', '=', 'p3.id')
                ->leftjoin('comunas as o', 'i.id_comuna', '=', 'o.comuna_id')
               ->leftjoin('mensajes as m', function($join){
                 $join->on('m.nombre_modulo', '=',DB::raw("'Arrendatario'"));
                 $join->on('m.id_estado', '=', 'c.id_estado');
            })
               ->where("c.id_estado","=",0)
                ->select(DB::raw(' c.id as id_publicacion, DATE_FORMAT(c.created_at, "%d/%m/%Y %T") as fecha_creacion,DATE_FORMAT(c.updated_at, "%d/%m/%Y") as fecha_modificacion, m.nombre as id_estado, CONCAT_WS(" ",p1.nombre,p1.apellido_paterno,p1.apellido_materno) as Arrendatario,
                    p2.name as Creador, CONCAT_WS(" ",p3.nombre,p3.apellido_paterno,p3.apellido_materno) as Modificador,p1.email,p1.telefono,i.departamento,i.numero,i.direccion'), 'i.id as id_inmueble', 'o.comuna_nombre', 'p1.nombre as nom_p', 'p1.apellido_paterno as apep_p', 'p1.apellido_materno as apem_p', 'p3.nombre as nom_m', 'p3.apellido_paterno as apep_m', 'p3.apellido_materno as apem_m')
                ->orderBy("c.id","Desc")
                ->get();

     return Datatables::of($publica)
         ->addColumn('action', function ($publica) {
                               return  '<a href="/arrendatario/edit/'.$publica->id_publicacion.'/1"><span class="btn btn-warning btn-circle btn-sm"><i class="ti-pencil-alt"></i></span></a>
                                    ';
        })
        ->addColumn('id_link', function ($publica) {
                               return  '<a href="/arrendatario/edit/'.$publica->id_publicacion.'/1"><span class="btn btn-success btn-sm"> '.$publica->id_publicacion.'</span> </a>';
        })
        ->rawColumns(['id_link','action'])
        ->make(true);
    }  

public function cap_borrador_arr(){
        return view('alertas.cap_borrador_arr');
    }


    public function cap_borrador_arr_ajax(Request $request)
    {
            $publica = DB::table('Arrendatarios as c')
                ->leftjoin('personas as p1', 'c.id_arrendatario', '=', 'p1.id')
                ->leftjoin('inmuebles as i', 'c.id_inmueble', '=', 'i.id')
                ->leftjoin('users as p2', 'c.id_creador', '=', 'p2.id')
                ->leftjoin('personas as p3', 'c.id_modificador', '=', 'p3.id')
                ->leftjoin('comunas as o', 'i.id_comuna', '=', 'o.comuna_id')
               ->leftjoin('mensajes as m', function($join){
                 $join->on('m.nombre_modulo', '=',DB::raw("'Arrendatario'"));
                 $join->on('m.id_estado', '=', 'c.id_estado');
            })
               ->Wherein('c.id_estado',[6,10])
                ->select(DB::raw(' c.id as id_publicacion, DATE_FORMAT(c.created_at, "%d/%m/%Y %T") as fecha_creacion,DATE_FORMAT(c.updated_at, "%d/%m/%Y") as fecha_modificacion, m.nombre as id_estado, CONCAT_WS(" ",p1.nombre,p1.apellido_paterno,p1.apellido_materno) as Arrendatario,
                    p2.name as Creador, CONCAT_WS(" ",p3.nombre,p3.apellido_paterno,p3.apellido_materno) as Modificador,p1.email,p1.telefono,i.departamento,i.numero,i.direccion'), 'i.id as id_inmueble', 'o.comuna_nombre', 'p1.nombre as nom_p', 'p1.apellido_paterno as apep_p', 'p1.apellido_materno as apem_p', 'p3.nombre as nom_m', 'p3.apellido_paterno as apep_m', 'p3.apellido_materno as apem_m')
                ->orderBy("c.id","Desc")
                ->get();

     return Datatables::of($publica)
         ->addColumn('action', function ($publica) {
                               return  '<a href="/arrendatario/edit/'.$publica->id_publicacion.'/1"><span class="btn btn-warning btn-circle btn-sm"><i class="ti-pencil-alt"></i></span></a>
                                    ';
        })
        ->addColumn('id_link', function ($publica) {
                               return  '<a href="/arrendatario/edit/'.$publica->id_publicacion.'/1"><span class="btn btn-success btn-sm"> '.$publica->id_publicacion.'</span> </a>';
        })
        ->rawColumns(['id_link','action'])
        ->make(true);
    }  

    public function cap_contrato_arr(){
        return view('alertas.cap_contrato_arr');
    }


    public function cap_contrato_arr_ajax(Request $request)
    {
                  $publica = DB::table('Arrendatarios as c')
                ->leftjoin('personas as p1', 'c.id_arrendatario', '=', 'p1.id')
                ->leftjoin('inmuebles as i', 'c.id_inmueble', '=', 'i.id')
                ->leftjoin('users as p2', 'c.id_creador', '=', 'p2.id')
                ->leftjoin('personas as p3', 'c.id_modificador', '=', 'p3.id')
                ->leftjoin('comunas as o', 'i.id_comuna', '=', 'o.comuna_id')
               ->leftjoin('mensajes as m', function($join){
                 $join->on('m.nombre_modulo', '=',DB::raw("'Arrendatario'"));
                 $join->on('m.id_estado', '=', 'c.id_estado');
            })
               ->Wherein('c.id_estado',[11])
                ->select(DB::raw(' c.id as id_publicacion, DATE_FORMAT(c.created_at, "%d/%m/%Y %T") as fecha_creacion,DATE_FORMAT(c.updated_at, "%d/%m/%Y") as fecha_modificacion, m.nombre as id_estado, CONCAT_WS(" ",p1.nombre,p1.apellido_paterno,p1.apellido_materno) as Arrendatario,
                    p2.name as Creador, CONCAT_WS(" ",p3.nombre,p3.apellido_paterno,p3.apellido_materno) as Modificador,p1.email,p1.telefono,i.departamento,i.numero,i.direccion'), 'i.id as id_inmueble', 'o.comuna_nombre', 'p1.nombre as nom_p', 'p1.apellido_paterno as apep_p', 'p1.apellido_materno as apem_p', 'p3.nombre as nom_m', 'p3.apellido_paterno as apep_m', 'p3.apellido_materno as apem_m')
                ->where('c.created_at','>',date('Y-m-d',strtotime('-365 day', strtotime(date("Y-m-d")))))
                ->orderBy("c.id","Desc")
                ->get();

     return Datatables::of($publica)
         ->addColumn('action', function ($publica) {
                               return  '<a href="/arrendatario/edit/'.$publica->id_publicacion.'/1"><span class="btn btn-warning btn-circle btn-sm"><i class="ti-pencil-alt"></i></span></a>';
        })
        ->addColumn('id_link', function ($publica) {
                               return  '<a href="/arrendatario/edit/'.$publica->id_publicacion.'/1"><span class="btn btn-success btn-sm"> '.$publica->id_publicacion.'</span> </a>';
        })
        ->rawColumns(['id_link','action'])
        ->make(true);
    }  
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ReporteGestion  $reporteGestion
     * @return \Illuminate\Http\Response
     */
    public function show(ReporteGestion $reporteGestion)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ReporteGestion  $reporteGestion
     * @return \Illuminate\Http\Response
     */
    public function edit(ReporteGestion $reporteGestion)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ReporteGestion  $reporteGestion
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ReporteGestion $reporteGestion)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ReporteGestion  $reporteGestion
     * @return \Illuminate\Http\Response
     */
    public function destroy(ReporteGestion $reporteGestion)
    {
        //
    }
}
