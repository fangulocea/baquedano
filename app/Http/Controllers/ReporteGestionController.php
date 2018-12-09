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
use Carbon\Carbon;


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
            $publica = DB::table('arrendatarios as c')
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
            $publica = DB::table('arrendatarios as c')
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
            $publica = DB::table('arrendatarios as c')
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
            $publica = DB::table('arrendatarios as c')
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
                  $publica = DB::table('arrendatarios as c')
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



    //VISTAS ALERTAS PRO


   public function adm_contratomespro(){
        return view('alertas.adm_contratomespro');
    }

     public function adm_contratomespro_ajax(Request $request)
    {
                
        $publica = DB::table('adm_contratofinal as co')
                ->leftjoin('borradores as cb', 'co.id_borrador', '=', 'cb.id')
                ->leftjoin('adm_contratodirpropietarios as cd', 'cd.id_contratofinal', '=', 'co.id')
                ->leftjoin('inmuebles as i', 'cd.id_inmueble', '=', 'i.id')
                ->leftjoin('comunas as o', 'i.id_comuna', '=', 'o.comuna_id')
                ->leftjoin('cap_publicaciones as c', 'c.id', '=', 'co.id_publicacion')
                ->leftjoin('personas as p1', 'c.id_propietario', '=', 'p1.id')
                ->leftjoin('users as p2', 'c.id_creador', '=', 'p2.id')
                ->leftjoin('users as p3', 'c.id_modificador', '=', 'p3.id')
                ->leftjoin('mensajes as m', function($join) {
                    $join->on('m.nombre_modulo', '=', DB::raw("'Contrato Final Propietario'"));
                    $join->on('m.id_estado', '=', 'co.id_estado');
                })
                ->whereIn('c.id_estado', [7,10, 6])
                ->select(DB::raw('co.id as id_contrato, co.fecha_firma, m.nombre as estado, cb.dia_pago,c.id as id_publicacion, DATE_FORMAT(c.created_at, "%d/%m/%Y") as fecha_creacion, c.id_estado as id_estado, CONCAT_WS(" ",p1.nombre,p1.apellido_paterno,p1.apellido_materno) as Propietario, p2.name as Creador, p1.rut, p1.email, p1.telefono,
                    CONCAT_WS("/", MONTH(DATE_ADD(now(), INTERVAL 1 MONTH)), YEAR(DATE_ADD(now(), INTERVAL 1 MONTH))) as fechasiguiente,
                    CONCAT_WS("/",MONTH(now()), YEAR(now())) as fechaactual,
                    CONCAT_WS("/",MONTH(DATE_ADD(now(), INTERVAL -1 MONTH)), YEAR(DATE_ADD(now(), INTERVAL -1 MONTH))) as fechaanterior,

                    (select pago_propietario from adm_pagosmensualespropietarios where mes=MONTH(DATE_ADD(now(), INTERVAL -1 MONTH)) and anio=YEAR(DATE_ADD(now(), INTERVAL -1 MONTH)) and id_publicacion=c.id and id_inmueble=i.id and id_contratofinal=co.id) as valoranterior1,

                     (select pago_propietario from adm_pagosmensualespropietarios where mes=MONTH(now()) and anio=YEAR(now()) and id_publicacion=c.id and id_inmueble=i.id and id_contratofinal=co.id) as valoractual,

                      (select pago_propietario from adm_pagosmensualespropietarios where mes=MONTH(DATE_ADD(now(), INTERVAL 1 MONTH)) and anio=YEAR(DATE_ADD(now(), INTERVAL 1 MONTH)) and id_publicacion=c.id and id_inmueble=i.id and id_contratofinal=co.id) as valorsiguiente1

                    '), 'p1.id as id_propietario', 'i.id as id_inmueble', 'i.direccion', 'i.numero', 'i.departamento', 'o.comuna_nombre', 'p1.nombre as nom_p', 'p1.apellido_paterno as apep_p', 'p1.apellido_materno as apem_p', 'p3.name as modifcador')
                ->orderby("co.fecha_firma", "asc")
                ->get();

     return Datatables::of($publica)
         ->addColumn('action', function ($publica) {
                               return  "<a href='/finalContrato/edit/".$publica->id_publicacion."/0/0/1/contrato' >
                                    <span class='btn btn-success btn-sm'>".$publica->id_contrato."</span> </a>
                                    ";
        })
        ->addColumn('id_link', function ($publica) {
                               return  "<a href='/finalContrato/edit/".$publica->id_publicacion."/0/0/1/contrato' >
                                    <span class='btn btn-success btn-sm'>".$publica->id_contrato."</span> </a>
                                    ";
        })
        ->rawColumns(['id_link','action'])
        ->make(true);
    } 


public function adm_morosopro(){
        return view('alertas.adm_morosopro');
    }

     static function adm_morosopro_ajax() {

          $publica = DB::table('adm_contratofinal as co')
                ->leftjoin('borradores as cb', 'co.id_borrador', '=', 'cb.id')
                ->leftjoin('adm_contratodirpropietarios as cd', 'cd.id_contratofinal', '=', 'co.id')
                ->leftjoin('inmuebles as i', 'cd.id_inmueble', '=', 'i.id')
                ->leftjoin('comunas as o', 'i.id_comuna', '=', 'o.comuna_id')
                ->leftjoin('cap_publicaciones as c', 'c.id', '=', 'co.id_publicacion')
                ->leftjoin('personas as p1', 'c.id_propietario', '=', 'p1.id')
                ->leftjoin('users as p2', 'c.id_creador', '=', 'p2.id')
                ->leftjoin('users as p3', 'c.id_modificador', '=', 'p3.id')
                ->leftjoin('mensajes as m', function($join) {
                    $join->on('m.nombre_modulo', '=', DB::raw("'Captación'"));
                    $join->on('m.id_estado', '=', 'c.id_estado');
                })
                ->whereIn('c.id_estado', [7,10,6])
                ->select(DB::raw('co.id as id_contrato, co.fecha_firma, m.nombre as estado, cb.dia_pago,c.id as id_publicacion, DATE_FORMAT(c.created_at, "%d/%m/%Y") as fecha_creacion, c.id_estado as id_estado, CONCAT_WS(" ",p1.nombre,p1.apellido_paterno,p1.apellido_materno) as Propietario, p2.name as Creador, p1.rut, p1.email, p1.telefono,

              CONCAT_WS("/", MONTH(DATE_ADD(now(), INTERVAL 1 MONTH)), YEAR(DATE_ADD(now(), INTERVAL 1 MONTH))) as fechasiguiente,
                    CONCAT_WS("/",MONTH(now()), YEAR(now())) as fechaactual,
                    CONCAT_WS("/",MONTH(DATE_ADD(now(), INTERVAL -1 MONTH)), YEAR(DATE_ADD(now(), INTERVAL -1 MONTH))) as fechaanterior,


                          CASE WHEN  ((select CASE WHEN pago_propietario is null then 0 else pago_propietario end as pago_propietario  from adm_pagosmensualespropietarios where mes=MONTH(DATE_ADD(now(), INTERVAL -1 MONTH)) and anio=YEAR(DATE_ADD(now(), INTERVAL -1 MONTH)) and id_publicacion=c.id and id_inmueble=i.id and id_contratofinal=co.id) - (select CASE WHEN sum(valor_pagado) IS NULL THEN 0 ELSE sum(valor_pagado) END as suma from adm_detallepagospropietarios dt inner join adm_pagosmensualespropietarios pm on dt.id_pagomensual=pm.id where pm.mes=MONTH(DATE_ADD(now(), INTERVAL -1 MONTH)) and pm.anio=YEAR(DATE_ADD(now(), INTERVAL -1 MONTH)) and pm.id_publicacion=c.id and pm.id_inmueble=i.id and pm.id_contratofinal=co.id)) IS NULL THEN 1 

                            WHEN  ((select CASE WHEN pago_propietario is null then 0 else pago_propietario end as pago_propietario  from adm_pagosmensualespropietarios where mes=MONTH(now()) and anio=YEAR(now()) and id_publicacion=c.id and id_inmueble=i.id and id_contratofinal=co.id) - (select CASE WHEN sum(valor_pagado) IS NULL THEN 0 ELSE sum(valor_pagado) END as suma from adm_detallepagospropietarios dt inner join adm_pagosmensualespropietarios pm on dt.id_pagomensual=pm.id where pm.mes=MONTH(now()) and pm.anio=YEAR(now()) and pm.id_publicacion=c.id and pm.id_inmueble=i.id and pm.id_contratofinal=co.id)) IS NULL THEN 2 
                    
                    ELSE 0
                    END as flag,

                  (select pago_propietario from adm_pagosmensualespropietarios where mes=MONTH(DATE_ADD(now(), INTERVAL -1 MONTH)) and anio=YEAR(DATE_ADD(now(), INTERVAL -1 MONTH)) and id_publicacion=c.id and id_inmueble=i.id and id_contratofinal=co.id) as valoranterior1,

                    (select sum(valor_pagado) from adm_detallepagospropietarios dt inner join adm_pagosmensualespropietarios pm on dt.id_pagomensual=pm.id where pm.mes=MONTH(DATE_ADD(now(), INTERVAL -1 MONTH)) and pm.anio=YEAR(DATE_ADD(now(), INTERVAL -1 MONTH)) and pm.id_publicacion=c.id and pm.id_inmueble=i.id and pm.id_contratofinal=co.id) as valorpagadoanterior1,

                         (select pago_propietario from adm_pagosmensualespropietarios where mes=MONTH(now()) and anio=YEAR(now()) and id_publicacion=c.id and id_inmueble=i.id and id_contratofinal=co.id) as valoractual,

                    (select sum(valor_pagado) from adm_detallepagospropietarios dt inner join adm_pagosmensualespropietarios pm on dt.id_pagomensual=pm.id where pm.mes=MONTH(now()) and pm.anio=YEAR(now()) and pm.id_publicacion=c.id and pm.id_inmueble=i.id and pm.id_contratofinal=co.id) as valorpagadoactual,

                         (select pago_propietario from adm_pagosmensualespropietarios where mes=MONTH(DATE_ADD(now(), INTERVAL +1 MONTH)) and anio=YEAR(DATE_ADD(now(), INTERVAL +1 MONTH)) and id_publicacion=c.id and id_inmueble=i.id and id_contratofinal=co.id) as valorsiguiente1,

                    (select sum(valor_pagado) from adm_detallepagospropietarios dt inner join adm_pagosmensualespropietarios pm on dt.id_pagomensual=pm.id where pm.mes=MONTH(DATE_ADD(now(), INTERVAL +1 MONTH)) and pm.anio=YEAR(DATE_ADD(now(), INTERVAL +1 MONTH)) and pm.id_publicacion=c.id and pm.id_inmueble=i.id and pm.id_contratofinal=co.id) as valorpagadosiguiente

                    '), 'p1.id as id_propietario', 'i.id as id_inmueble', 'i.direccion', 'i.numero', 'i.departamento', 'o.comuna_nombre', 'p1.nombre as nom_p', 'p1.apellido_paterno as apep_p', 'p1.apellido_materno as apem_p', 'p3.name as modifcador')
                ->orderby("co.fecha_firma", "asc")
                ->get();


$publica=$publica->where("flag","<>",1);

            return Datatables::of($publica)
        ->addColumn('anterior', function ($publica) {
                               return  $publica->valoranterior1 - $publica->valorpagadoanterior1;

 })
                ->addColumn('actual', function ($publica) {
                               return  $publica->valoractual - $publica->valorpagadoactual;

 })
                                ->addColumn('siguiente', function ($publica) {
                               return  $publica->valorsiguiente1 - $publica->valorpagadosiguiente;

 })
         ->addColumn('action', function ($publica) {
                               return  "<a href='/finalContrato/edit/".$publica->id_publicacion."/0/0/1/contrato' >
                                    <span class='btn btn-success btn-sm'>".$publica->id_contrato."</span> </a>
                                    ";
        })
        ->addColumn('id_link', function ($publica) {
                               return  "<a href='/finalContrato/edit/".$publica->id_publicacion."/0/0/1/contrato' >
                                    <span class='btn btn-success btn-sm'>".$publica->id_contrato."</span> </a>
                                    ";
        })
        ->rawColumns(['id_link','action'])
        ->make(true);
    }




    public function adm_pagadospro(){
        return view('alertas.adm_pagadopro');
    }

     static function adm_pagadospro_ajax() {

          $publica = DB::table('adm_contratofinal as co')
                ->leftjoin('borradores as cb', 'co.id_borrador', '=', 'cb.id')
                ->leftjoin('adm_contratodirpropietarios as cd', 'cd.id_contratofinal', '=', 'co.id')
                ->leftjoin('inmuebles as i', 'cd.id_inmueble', '=', 'i.id')
                ->leftjoin('comunas as o', 'i.id_comuna', '=', 'o.comuna_id')
                ->leftjoin('cap_publicaciones as c', 'c.id', '=', 'co.id_publicacion')
                ->leftjoin('personas as p1', 'c.id_propietario', '=', 'p1.id')
                ->leftjoin('users as p2', 'c.id_creador', '=', 'p2.id')
                ->leftjoin('users as p3', 'c.id_modificador', '=', 'p3.id')
                ->leftjoin('mensajes as m', function($join) {
                    $join->on('m.nombre_modulo', '=', DB::raw("'Captación'"));
                    $join->on('m.id_estado', '=', 'c.id_estado');
                })
                ->whereIn('c.id_estado', [7,10,6])
                ->where("cb.dia_pago","=",Carbon::now()->day)
                ->select(DB::raw('co.id as id_contrato, co.fecha_firma, m.nombre as estado, cb.dia_pago,c.id as id_publicacion, DATE_FORMAT(c.created_at, "%d/%m/%Y") as fecha_creacion, c.id_estado as id_estado, CONCAT_WS(" ",p1.nombre,p1.apellido_paterno,p1.apellido_materno) as Propietario, p2.name as Creador, p1.rut, p1.email, p1.telefono,

              CONCAT_WS("/", MONTH(DATE_ADD(now(), INTERVAL 1 MONTH)), YEAR(DATE_ADD(now(), INTERVAL 1 MONTH))) as fechasiguiente,
                    CONCAT_WS("/",MONTH(now()), YEAR(now())) as fechaactual,
                    CONCAT_WS("/",MONTH(DATE_ADD(now(), INTERVAL -1 MONTH)), YEAR(DATE_ADD(now(), INTERVAL -1 MONTH))) as fechaanterior,

                  (select pago_propietario from adm_pagosmensualespropietarios where mes=MONTH(DATE_ADD(now(), INTERVAL -1 MONTH)) and anio=YEAR(DATE_ADD(now(), INTERVAL -1 MONTH)) and id_publicacion=c.id and id_inmueble=i.id and id_contratofinal=co.id) as valoranterior1,

                    (select sum(valor_pagado) from adm_detallepagospropietarios dt inner join adm_pagosmensualespropietarios pm on dt.id_pagomensual=pm.id where pm.mes=MONTH(DATE_ADD(now(), INTERVAL -1 MONTH)) and pm.anio=YEAR(DATE_ADD(now(), INTERVAL -1 MONTH)) and pm.id_publicacion=c.id and pm.id_inmueble=i.id and pm.id_contratofinal=co.id) as valorpagadoanterior1,

                    CASE WHEN  (select sum(valor_pagado) from adm_detallepagospropietarios dt inner join adm_pagosmensualespropietarios pm on dt.id_pagomensual=pm.id where pm.mes=MONTH(DATE_ADD(now(), INTERVAL -1 MONTH)) and pm.anio=YEAR(DATE_ADD(now(), INTERVAL -1 MONTH)) and pm.id_publicacion=c.id and pm.id_inmueble=i.id and pm.id_contratofinal=co.id) IS NOT NULL THEN 1 
                    WHEN (select sum(valor_pagado) from adm_detallepagospropietarios dt inner join adm_pagosmensualespropietarios pm on dt.id_pagomensual=pm.id where pm.mes=MONTH(now()) and pm.anio=YEAR(now()) and pm.id_publicacion=c.id and pm.id_inmueble=i.id and pm.id_contratofinal=co.id)  IS NOT NULL THEN 1
                    WHEN (select sum(valor_pagado) from adm_detallepagospropietarios dt inner join adm_pagosmensualespropietarios pm on dt.id_pagomensual=pm.id where pm.mes=MONTH(DATE_ADD(now(), INTERVAL +1 MONTH)) and pm.anio=YEAR(DATE_ADD(now(), INTERVAL +1 MONTH)) and pm.id_publicacion=c.id and pm.id_inmueble=i.id and pm.id_contratofinal=co.id) IS NOT NULL THEN 1
                    ELSE 0
                    END as flag,

                         (select pago_propietario from adm_pagosmensualespropietarios where mes=MONTH(now()) and anio=YEAR(now()) and id_publicacion=c.id and id_inmueble=i.id and id_contratofinal=co.id) as valoractual,

                    (select sum(valor_pagado) from adm_detallepagospropietarios dt inner join adm_pagosmensualespropietarios pm on dt.id_pagomensual=pm.id where pm.mes=MONTH(now()) and pm.anio=YEAR(now()) and pm.id_publicacion=c.id and pm.id_inmueble=i.id and pm.id_contratofinal=co.id) as valorpagadoactual,

                         (select pago_propietario from adm_pagosmensualespropietarios where mes=MONTH(DATE_ADD(now(), INTERVAL +1 MONTH)) and anio=YEAR(DATE_ADD(now(), INTERVAL +1 MONTH)) and id_publicacion=c.id and id_inmueble=i.id and id_contratofinal=co.id) as valorsiguiente1,

                    (select sum(valor_pagado) from adm_detallepagospropietarios dt inner join adm_pagosmensualespropietarios pm on dt.id_pagomensual=pm.id where pm.mes=MONTH(DATE_ADD(now(), INTERVAL +1 MONTH)) and pm.anio=YEAR(DATE_ADD(now(), INTERVAL +1 MONTH)) and pm.id_publicacion=c.id and pm.id_inmueble=i.id and pm.id_contratofinal=co.id) as valorpagadosiguiente


                    '), 'p1.id as id_propietario', 'i.id as id_inmueble', 'i.direccion', 'i.numero', 'i.departamento', 'o.comuna_nombre', 'p1.nombre as nom_p', 'p1.apellido_paterno as apep_p', 'p1.apellido_materno as apem_p', 'p3.name as modifcador')
                ->orderby("co.fecha_firma", "asc")
                ->get();

               $publica=$publica->where("flag","=",1);


            return Datatables::of($publica)

         ->addColumn('action', function ($publica) {
                               return  "<a href='/finalContrato/edit/".$publica->id_publicacion."/0/0/1/contrato' >
                                    <span class='btn btn-success btn-sm'>".$publica->id_contrato."</span> </a>
                                    ";
        })
        ->addColumn('id_link', function ($publica) {
                               return  "<a href='/finalContrato/edit/".$publica->id_publicacion."/0/0/1/contrato' >
                                    <span class='btn btn-success btn-sm'>".$publica->id_contrato."</span> </a>
                                    ";
        })
        ->rawColumns(['id_link','action'])
        ->make(true);
    }




    public function adm_transfhoypro(){
        return view('alertas.adm_transfpro');
    }

     static function adm_transfhoypro_ajax() {

          
        $publica = DB::table('adm_contratofinal as co')
                ->leftjoin('borradores as cb', 'co.id_borrador', '=', 'cb.id')
                ->leftjoin('adm_contratodirpropietarios as cd', 'cd.id_contratofinal', '=', 'co.id')
                ->leftjoin('inmuebles as i', 'cd.id_inmueble', '=', 'i.id')
                ->leftjoin('comunas as o', 'i.id_comuna', '=', 'o.comuna_id')
                ->leftjoin('cap_publicaciones as c', 'c.id', '=', 'co.id_publicacion')
                ->leftjoin('personas as p1', 'c.id_propietario', '=', 'p1.id')
                ->leftjoin('users as p2', 'c.id_creador', '=', 'p2.id')
                ->leftjoin('users as p3', 'c.id_modificador', '=', 'p3.id')
                ->leftjoin('mensajes as m', function($join) {
                    $join->on('m.nombre_modulo', '=', DB::raw("'Captación'"));
                    $join->on('m.id_estado', '=', 'c.id_estado');
                })
                ->whereIn('c.id_estado', [7, 10, 6])
                ->where("cb.dia_pago","=",Carbon::now()->day)
                ->select(DB::raw('co.id as id_contrato, co.fecha_firma, m.nombre as estado, cb.dia_pago,c.id as id_publicacion, DATE_FORMAT(c.created_at, "%d/%m/%Y") as fecha_creacion, c.id_estado as id_estado, CONCAT_WS(" ",p1.nombre,p1.apellido_paterno,p1.apellido_materno) as Propietario, p2.name as Creador, p1.rut, p1.email, p1.telefono,
CONCAT_WS("/", MONTH(DATE_ADD(now(), INTERVAL 1 MONTH)), YEAR(DATE_ADD(now(), INTERVAL 1 MONTH))) as fechasiguiente,
                    CONCAT_WS("/",MONTH(now()), YEAR(now())) as fechaactual,
                    
                    (select pago_propietario from adm_pagosmensualespropietarios where mes=MONTH(now()) and anio=YEAR(now()) and id_publicacion=c.id and id_inmueble=i.id and id_contratofinal=co.id) as valoractual,

                    (select sum(valor_pagado) from adm_detallepagospropietarios dt inner join adm_pagosmensualespropietarios pm on dt.id_pagomensual=pm.id where pm.mes=MONTH(now()) and pm.anio=YEAR(now()) and pm.id_publicacion=c.id and pm.id_inmueble=i.id and pm.id_contratofinal=co.id) as valorpagadoactual


                    '), 'p1.id as id_propietario', 'i.id as id_inmueble', 'i.direccion', 'i.numero', 'i.departamento', 'o.comuna_nombre', 'p1.nombre as nom_p', 'p1.apellido_paterno as apep_p', 'p1.apellido_materno as apem_p', 'p3.name as modifcador')
                ->orderby("co.fecha_firma", "asc")
                ->get();



            return Datatables::of($publica)


            ->addColumn('valor_restante', function ($publica) {
                               return  $publica->valoractual-$publica->valorpagadoactual;
        })

         ->addColumn('action', function ($publica) {
                               return  "<a href='/finalContrato/edit/".$publica->id_publicacion."/0/0/1/contrato' >
                                    <span class='btn btn-success btn-sm'>".$publica->id_contrato."</span> </a>
                                    ";
        })
        ->addColumn('id_link', function ($publica) {
                               return  "<a href='/finalContrato/edit/".$publica->id_publicacion."/0/0/1/contrato' >
                                    <span class='btn btn-success btn-sm'>".$publica->id_contrato."</span> </a>
                                    ";
        })
        ->rawColumns(['id_link','action'])
        ->make(true);
    }


  public function adm_transfmananapro(){
        return view('alertas.adm_transfmananapro');
    }

    static function adm_transfmananapro_ajax() {

          $publica = DB::table('adm_contratofinal as co')
                ->leftjoin('borradores as cb', 'co.id_borrador', '=', 'cb.id')
                ->leftjoin('adm_contratodirpropietarios as cd', 'cd.id_contratofinal', '=', 'co.id')
                ->leftjoin('inmuebles as i', 'cd.id_inmueble', '=', 'i.id')
                ->leftjoin('comunas as o', 'i.id_comuna', '=', 'o.comuna_id')
                ->leftjoin('cap_publicaciones as c', 'c.id', '=', 'co.id_publicacion')
                ->leftjoin('personas as p1', 'c.id_propietario', '=', 'p1.id')
                ->leftjoin('users as p2', 'c.id_creador', '=', 'p2.id')
                ->leftjoin('users as p3', 'c.id_modificador', '=', 'p3.id')
                ->leftjoin('mensajes as m', function($join) {
                    $join->on('m.nombre_modulo', '=', DB::raw("'Captación'"));
                    $join->on('m.id_estado', '=', 'c.id_estado');
                })
                ->whereIn('c.id_estado', [7, 10, 6])
                ->where("cb.dia_pago","=",Carbon::tomorrow()->day)
                ->select(DB::raw('co.id as id_contrato, co.fecha_firma, m.nombre as estado, cb.dia_pago,c.id as id_publicacion, DATE_FORMAT(c.created_at, "%d/%m/%Y") as fecha_creacion, c.id_estado as id_estado, CONCAT_WS(" ",p1.nombre,p1.apellido_paterno,p1.apellido_materno) as Propietario, p2.name as Creador, p1.rut, p1.email, p1.telefono,
CONCAT_WS("/", MONTH(DATE_ADD(now(), INTERVAL 1 MONTH)), YEAR(DATE_ADD(now(), INTERVAL 1 MONTH))) as fechasiguiente,
                    CONCAT_WS("/",MONTH(now()), YEAR(now())) as fechaactual,
                    
                    (select pago_propietario from adm_pagosmensualespropietarios where mes=MONTH(now()) and anio=YEAR(now()) and id_publicacion=c.id and id_inmueble=i.id and id_contratofinal=co.id) as valoractual,

                    (select sum(valor_pagado) from adm_detallepagospropietarios dt inner join adm_pagosmensualespropietarios pm on dt.id_pagomensual=pm.id where pm.mes=MONTH(now()) and pm.anio=YEAR(now()) and pm.id_publicacion=c.id and pm.id_inmueble=i.id and pm.id_contratofinal=co.id) as valorpagadoactual


                    '), 'p1.id as id_propietario', 'i.id as id_inmueble', 'i.direccion', 'i.numero', 'i.departamento', 'o.comuna_nombre', 'p1.nombre as nom_p', 'p1.apellido_paterno as apep_p', 'p1.apellido_materno as apem_p', 'p3.name as modifcador')
                ->orderby("co.fecha_firma", "asc")
                ->get();


            return Datatables::of($publica)

->addColumn('valor_restante', function ($publica) {
                               return  $publica->valoractual-$publica->valorpagadoactual;
        })
         ->addColumn('action', function ($publica) {
                               return  "<a href='/finalContrato/edit/".$publica->id_publicacion."/0/0/1/contrato' >
                                    <span class='btn btn-success btn-sm'>".$publica->id_contrato."</span> </a>
                                    ";
        })
        ->addColumn('id_link', function ($publica) {
                               return  "<a href='/finalContrato/edit/".$publica->id_publicacion."/0/0/1/contrato' >
                                    <span class='btn btn-success btn-sm'>".$publica->id_contrato."</span> </a>
                                    ";
        })
        ->rawColumns(['id_link','action'])
        ->make(true);
    }


    public function adm_transfsubsgtepro(){
        return view('alertas.adm_transfpasadopro');
    }

    static function adm_transfsubsgtepro_ajax() {

          $publica = DB::table('adm_contratofinal as co')
                ->leftjoin('borradores as cb', 'co.id_borrador', '=', 'cb.id')
                ->leftjoin('adm_contratodirpropietarios as cd', 'cd.id_contratofinal', '=', 'co.id')
                ->leftjoin('inmuebles as i', 'cd.id_inmueble', '=', 'i.id')
                ->leftjoin('comunas as o', 'i.id_comuna', '=', 'o.comuna_id')
                ->leftjoin('cap_publicaciones as c', 'c.id', '=', 'co.id_publicacion')
                ->leftjoin('personas as p1', 'c.id_propietario', '=', 'p1.id')
                ->leftjoin('users as p2', 'c.id_creador', '=', 'p2.id')
                ->leftjoin('users as p3', 'c.id_modificador', '=', 'p3.id')
                ->leftjoin('mensajes as m', function($join) {
                    $join->on('m.nombre_modulo', '=', DB::raw("'Captación'"));
                    $join->on('m.id_estado', '=', 'c.id_estado');
                })
                ->whereIn('c.id_estado', [7, 10, 6])
                ->where("cb.dia_pago","=",Carbon::now()->addDays(2)->day)
                ->select(DB::raw('co.id as id_contrato, co.fecha_firma, m.nombre as estado, cb.dia_pago,c.id as id_publicacion, DATE_FORMAT(c.created_at, "%d/%m/%Y") as fecha_creacion, c.id_estado as id_estado, CONCAT_WS(" ",p1.nombre,p1.apellido_paterno,p1.apellido_materno) as Propietario, p2.name as Creador, p1.rut, p1.email, p1.telefono,
CONCAT_WS("/", MONTH(DATE_ADD(now(), INTERVAL 1 MONTH)), YEAR(DATE_ADD(now(), INTERVAL 1 MONTH))) as fechasiguiente,
                    CONCAT_WS("/",MONTH(now()), YEAR(now())) as fechaactual,
                    
                    (select pago_propietario from adm_pagosmensualespropietarios where mes=MONTH(now()) and anio=YEAR(now()) and id_publicacion=c.id and id_inmueble=i.id and id_contratofinal=co.id) as valoractual,

                    (select sum(valor_pagado) from adm_detallepagospropietarios dt inner join adm_pagosmensualespropietarios pm on dt.id_pagomensual=pm.id where pm.mes=MONTH(now()) and pm.anio=YEAR(now()) and pm.id_publicacion=c.id and pm.id_inmueble=i.id and pm.id_contratofinal=co.id) as valorpagadoactual


                    '), 'p1.id as id_propietario', 'i.id as id_inmueble', 'i.direccion', 'i.numero', 'i.departamento', 'o.comuna_nombre', 'p1.nombre as nom_p', 'p1.apellido_paterno as apep_p', 'p1.apellido_materno as apem_p', 'p3.name as modifcador')
                ->orderby("co.fecha_firma", "asc")
                ->get();

 


            return Datatables::of($publica)

            ->addColumn('valor_restante', function ($publica) {
                               return  $publica->valoractual-$publica->valorpagadoactual;
        })

         ->addColumn('action', function ($publica) {
                               return  "<a href='/finalContrato/edit/".$publica->id_publicacion."/0/0/1/contrato' >
                                    <span class='btn btn-success btn-sm'>".$publica->id_contrato."</span> </a>
                                    ";
        })
        ->addColumn('id_link', function ($publica) {
                               return  "<a href='/finalContrato/edit/".$publica->id_publicacion."/0/0/1/contrato' >
                                    <span class='btn btn-success btn-sm'>".$publica->id_contrato."</span> </a>
                                    ";
        })
        ->rawColumns(['id_link','action'])
        ->make(true);
    }

    //PV

        public function solpa_pro(){
        return view('alertas.pv_solpa_pro');
    }

    static function solpa_pro_ajax() {

        $postventa = DB::table('post_venta as p')
        ->leftjoin('inmuebles as i', 'i.id', '=', 'p.id_inmueble')
        ->leftjoin('comunas as c', 'i.id_comuna', '=', 'c.comuna_id')
        ->leftjoin('users as u', 'p.id_asignacion', '=', 'u.id')
        ->leftjoin('mensajes as m', function($join){
                 $join->on('m.nombre_modulo', '=',DB::raw("'Post Venta'"));
                 $join->on('m.id_estado', '=', 'p.id_estado');
            })
        ->where("p.id_modulo","=",1)
        ->where("p.id_estado","<>",2)
        ->where('p.updated_at', '>', date('Y-m-d', strtotime('-30 day', strtotime(date("Y-m-d")))))
            ->select(DB::raw("p.id,CONCAT_WS(' ',i.direccion,i.numero,i.departamento,c.comuna_nombre) as direccion,i.numero,i.departamento,c.comuna_nombre as comuna, i.direccion as calle, m.nombre as estado, u.name as asignacion, p.updated_at as ultima_modificacion, p.created_at as fecha_creacion, 
                CASE p.id_modulo when 1 then 'CONTRATO PROPIETARIO' when 2 then 'CONTRATO ARRENDATARIO' end as tipo_contrato"))
            ->orderby("p.id_estado","asc")
            ->get();

return Datatables::of($postventa)
         ->addColumn('action', function ($postventa) {
                               return  '<a href="/postventa/'.$postventa->id.'/1/edit"><span class="btn btn-warning btn-circle btn-sm"><i class="ti-pencil-alt"></i></span></a>';
        })
        ->addColumn('id_link', function ($postventa) {
                               return  '<a href="/postventa/'.$postventa->id.'/1/edit"><span class="btn btn-success btn-sm"> '.$postventa->id.'</span> </a>';
        })
        ->rawColumns(['id_link','action'])
        ->make(true);
    }

    public function solpa_arr(){
        return view('alertas.pv_solpa_arr');
    }

    static function solpa_arr_ajax() {

        $postventa = DB::table('post_venta as p')
        ->leftjoin('inmuebles as i', 'i.id', '=', 'p.id_inmueble')
        ->leftjoin('comunas as c', 'i.id_comuna', '=', 'c.comuna_id')
        ->leftjoin('users as u', 'p.id_asignacion', '=', 'u.id')
        ->leftjoin('mensajes as m', function($join){
                 $join->on('m.nombre_modulo', '=',DB::raw("'Post Venta'"));
                 $join->on('m.id_estado', '=', 'p.id_estado');
            })
        ->where("p.id_modulo","=",2)
         ->where("p.id_estado","<>",2)
        ->where('p.updated_at', '>', date('Y-m-d', strtotime('-30 day', strtotime(date("Y-m-d")))))
            ->select(DB::raw("p.id,CONCAT_WS(' ',i.direccion,i.numero,i.departamento,c.comuna_nombre) as direccion,i.numero,i.departamento,c.comuna_nombre as comuna, i.direccion as calle, m.nombre as estado, u.name as asignacion, p.updated_at as ultima_modificacion, p.created_at as fecha_creacion, 
                CASE p.id_modulo when 1 then 'CONTRATO PROPIETARIO' when 2 then 'CONTRATO ARRENDATARIO' end as tipo_contrato"))
            ->orderby("p.id_estado","asc")
            ->get();


   return Datatables::of($postventa)
         ->addColumn('action', function ($postventa) {
                               return  '<a href="/postventa/'.$postventa->id.'/1/edit"><span class="btn btn-warning btn-circle btn-sm"><i class="ti-pencil-alt"></i></span></a>';
        })
        ->addColumn('id_link', function ($postventa) {
                               return  '<a href="/postventa/'.$postventa->id.'/1/edit"><span class="btn btn-success btn-sm"> '.$postventa->id.'</span> </a>';
        })
        ->rawColumns(['id_link','action'])
        ->make(true);
    }




     public function solpa_sinrevisar_pro(){
        return view('alertas.pv_solpa_sinrevisar_pro');
    }

    static function solpa_sinrevisar_pro_ajax() {

        $postventa = DB::table('post_venta as p')
        ->leftjoin('inmuebles as i', 'i.id', '=', 'p.id_inmueble')
        ->leftjoin('comunas as c', 'i.id_comuna', '=', 'c.comuna_id')
        ->leftjoin('users as u', 'p.id_asignacion', '=', 'u.id')
        ->leftjoin('mensajes as m', function($join){
                 $join->on('m.nombre_modulo', '=',DB::raw("'Post Venta'"));
                 $join->on('m.id_estado', '=', 'p.id_estado');
            })
        ->where("p.id_modulo","=",1)
        ->where("p.id_estado","<>",2)
        ->where('p.updated_at', '<', date('Y-m-d', strtotime('-30 day', strtotime(date("Y-m-d")))))
            ->select(DB::raw("p.id,CONCAT_WS(' ',i.direccion,i.numero,i.departamento,c.comuna_nombre) as direccion,i.numero,i.departamento,c.comuna_nombre as comuna, i.direccion as calle, m.nombre as estado, u.name as asignacion, p.updated_at as ultima_modificacion, p.created_at as fecha_creacion, 
                CASE p.id_modulo when 1 then 'CONTRATO PROPIETARIO' when 2 then 'CONTRATO ARRENDATARIO' end as tipo_contrato"))
            ->orderby("p.id_estado","asc")
            ->get();

return Datatables::of($postventa)
         ->addColumn('action', function ($postventa) {
                               return  '<a href="/postventa/'.$postventa->id.'/1/edit"><span class="btn btn-warning btn-circle btn-sm"><i class="ti-pencil-alt"></i></span></a>';
        })
        ->addColumn('id_link', function ($postventa) {
                               return  '<a href="/postventa/'.$postventa->id.'/1/edit"><span class="btn btn-success btn-sm"> '.$postventa->id.'</span> </a>';
        })
        ->rawColumns(['id_link','action'])
        ->make(true);
    }

    public function solpa_sinrevisar_arr(){
        return view('alertas.pv_solpa_sinrevisar_arr');
    }

    static function solpa_sinrevisar_arr_ajax() {

        $postventa = DB::table('post_venta as p')
        ->leftjoin('inmuebles as i', 'i.id', '=', 'p.id_inmueble')
        ->leftjoin('comunas as c', 'i.id_comuna', '=', 'c.comuna_id')
        ->leftjoin('users as u', 'p.id_asignacion', '=', 'u.id')
        ->leftjoin('mensajes as m', function($join){
                 $join->on('m.nombre_modulo', '=',DB::raw("'Post Venta'"));
                 $join->on('m.id_estado', '=', 'p.id_estado');
            })
        ->where("p.id_modulo","=",2)
         ->where("p.id_estado","<>",2)
        ->where('p.updated_at', '<', date('Y-m-d', strtotime('-30 day', strtotime(date("Y-m-d")))))
            ->select(DB::raw("p.id,CONCAT_WS(' ',i.direccion,i.numero,i.departamento,c.comuna_nombre) as direccion,i.numero,i.departamento,c.comuna_nombre as comuna, i.direccion as calle, m.nombre as estado, u.name as asignacion, p.updated_at as ultima_modificacion, p.created_at as fecha_creacion, 
                CASE p.id_modulo when 1 then 'CONTRATO PROPIETARIO' when 2 then 'CONTRATO ARRENDATARIO' end as tipo_contrato"))
            ->orderby("p.id_estado","asc")
            ->get();


   return Datatables::of($postventa)
         ->addColumn('action', function ($postventa) {
                               return  '<a href="/postventa/'.$postventa->id.'/1/edit"><span class="btn btn-warning btn-circle btn-sm"><i class="ti-pencil-alt"></i></span></a>';
        })
        ->addColumn('id_link', function ($postventa) {
                               return  '<a href="/postventa/'.$postventa->id.'/1/edit"><span class="btn btn-success btn-sm"> '.$postventa->id.'</span> </a>';
        })
        ->rawColumns(['id_link','action'])
        ->make(true);
    }

    public function cuentas(){
        return view('alertas.pv_revision');
    }

    static function cuentas_ajax() {
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
        $publica = $publica->where('fecha_revision', '<', date('Y-m-d', strtotime('-30 day', strtotime(date("Y-m-d")))));

 return Datatables::of($publica)
         ->addColumn('action', function ($publica) {
                               return  '<a href="/revisioncuentas/'.$publica->id_contrato.'/revisar"><span class="btn btn-success  btn-sm">Revisar Cuentas</span></a>
                                    ';
        })
        ->addColumn('opciones', function ($publica) {
                               return  '<a href="/revisioncuentas/'.$publica->id_contrato.'/pagado"><span class="btn btn-warning btn-circle btn-sm">P</span></a>
                                        <a href="/revisioncuentas/'.$publica->id_contrato.'/moroso"><span class="btn btn-danger btn-circle btn-sm">M</span></a>
                               <a href="/revisioncuentas/'.$publica->id_contrato.'/comprobante"><span class="btn btn-success btn-circle btn-sm">C</span></a>';

        })
        ->addColumn('id_link', function ($publica) {
                               return  '<a href="/revisioncuentas/'.$publica->id_contrato.'/revisar"><span class="btn btn-success btn-sm"> '.$publica->id_contrato.'</span> </a>';
        })
        ->rawColumns(['id_link','action','opciones'])
        ->make(true);
    }


    public function solpv_arr(){
        return view('alertas.pv_solpv_arr');
    }

static function solpv_arr_ajax() {
   $sol = DB::table('post_solicitudserviciosarr as ss')
                ->leftjoin('adm_contratofinalarr as cf', "ss.id_contrato", "=", "cf.id")
                ->leftjoin('personas as p1', 'ss.id_arrendatario', '=', 'p1.id')
                ->leftjoin('inmuebles as i', 'ss.id_inmueble', '=', 'i.id')
                ->leftjoin('users as p2', 'ss.id_creador', '=', 'p2.id')
                ->leftjoin('users as p3', 'ss.id_modificador', '=', 'p3.id')
                ->leftjoin('users as p4', 'ss.id_autorizador', '=', 'p4.id')
                ->leftjoin('users as p5', 'ss.id_asignacion', '=', 'p4.id')
                ->leftjoin('comunas as o', 'i.id_comuna', '=', 'o.comuna_id')
                ->leftjoin('mensajes as m', function($join) {
                    $join->on('m.nombre_modulo', '=', DB::raw("'Solicitud Servicio'"));
                    $join->on('m.id_estado', '=', 'ss.id_estado');
                })
                ->whereNotIn('ss.id_estado', [4,5])
                ->select(DB::raw('ss.id as id_solicitud, 
                            DATE_FORMAT(ss.created_at, "%d/%m/%Y") as FechaCreacion, 
                            m.nombre as Estado,
                            CONCAT_WS(" ",p1.nombre,p1.apellido_paterno,p1.apellido_materno) as Arrendatario, 
                            p2.name as Creador,
                            p3.name as Modificador,
                            p4.name as Autorizador,
                            p5.name as Asignado,
                            CONCAT_WS(" ",i.direccion,i.numero," Dpto ",i.departamento) as Direccion,
                            o.comuna_nombre as Comuna,
                            ss.fecha_autorizacion,
                            p1.email,
                            p1.telefono,
                            ss.fecha_uf,
                            ss.valor_uf,
                            (select sum(subtotal_uf) from post_detallesolserviciosarr as ds where ds.id_solicitud=ss.id) as valor_en_uf,
                            (select sum(subtotal_pesos) from post_detallesolserviciosarr as ds where ds.id_solicitud=ss.id) as valor_en_pesos'))
                ->get();
 

        return Datatables::of($sol)
                        ->addColumn('action', function ($sol) {
                            return '<a href="/solservicio/' . $sol->id_solicitud . '/edit"><span class="btn btn-warning btn-circle btn-sm">E</span></a>
                               <a href="/solservicio/' . $sol->id_solicitud . '/comprobante"><span class="btn btn-success btn-circle btn-sm">C</span></a>
                                    <a href="/solservicio/' . $sol->id_solicitud . '/destroy"><span class="btn btn-danger btn-circle btn-sm">B</span></a>';
                        })
                        ->addColumn('id_link', function ($sol) {
                            return '<a href="/solservicio/' . $sol->id_solicitud . '/edit"><span class="btn btn-success btn-sm"> ' . $sol->id_solicitud . '</span> </a>';
                        })
                        ->rawColumns(['id_link', 'action'])
                        ->make(true);
    }

 public function solpv_pro(){
        return view('alertas.pv_solpv_pro');
    }

    static function solpv_pro_ajax() {
   $sol = DB::table('post_solicitudservicios as ss')
                ->leftjoin('adm_contratofinal as cf', "ss.id_contrato", "=", "cf.id")
                ->leftjoin('personas as p1', 'ss.id_propietario', '=', 'p1.id')
                ->leftjoin('inmuebles as i', 'ss.id_inmueble', '=', 'i.id')
                ->leftjoin('users as p2', 'ss.id_creador', '=', 'p2.id')
                ->leftjoin('users as p3', 'ss.id_modificador', '=', 'p3.id')
                ->leftjoin('users as p4', 'ss.id_autorizador', '=', 'p4.id')
                ->leftjoin('users as p5', 'ss.id_asignacion', '=', 'p4.id')
                ->leftjoin('comunas as o', 'i.id_comuna', '=', 'o.comuna_id')
                ->leftjoin('mensajes as m', function($join) {
                    $join->on('m.nombre_modulo', '=', DB::raw("'Solicitud Servicio'"));
                    $join->on('m.id_estado', '=', 'ss.id_estado');
                })
                ->whereNotIn('ss.id_estado', [4,5])
                ->select(DB::raw('ss.id as id_solicitud, 
                            DATE_FORMAT(ss.created_at, "%d/%m/%Y") as FechaCreacion, 
                            m.nombre as Estado,
                            CONCAT_WS(" ",p1.nombre,p1.apellido_paterno,p1.apellido_materno) as Propietario, 
                            p2.name as Creador,
                            p3.name as Modificador,
                            p4.name as Autorizador,
                            p5.name as Asignado,
                            CONCAT_WS(" ",i.direccion,i.numero," Dpto ",i.departamento) as Direccion,
                            o.comuna_nombre as Comuna,
                            ss.fecha_autorizacion,
                            p1.email,
                            p1.telefono,
                            ss.fecha_uf,
                            ss.valor_uf,
                            (select sum(subtotal_uf) from post_detallesolservicios as ds where ds.id_solicitud=ss.id) as valor_en_uf,
                            (select sum(subtotal_pesos) from post_detallesolservicios as ds where ds.id_solicitud=ss.id) as valor_en_pesos'))
                ->get();

return Datatables::of($sol)
                        ->addColumn('action', function ($sol) {
                            return '<a href="/arrsolservicio/' . $sol->id_solicitud . '/edit"><span class="btn btn-warning btn-circle btn-sm">E</span></a>
                               <a href="/arrsolservicio/' . $sol->id_solicitud . '/comprobante"><span class="btn btn-success btn-circle btn-sm">C</span></a>
                                    <a href="/arrsolservicio/' . $sol->id_solicitud . '/destroy"><span class="btn btn-danger btn-circle btn-sm">B</span></a>';
                        })
                        ->addColumn('id_link', function ($sol) {
                            return '<a href="/arrsolservicio/' . $sol->id_solicitud . '/edit"><span class="btn btn-success btn-sm"> ' . $sol->id_solicitud . '</span> </a>';
                        })
                        ->rawColumns(['id_link', 'action'])
                        ->make(true);
    }
}
