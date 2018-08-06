<?php

namespace App\Http\Controllers;

use App\SolicitudServicio;
use Illuminate\Http\Request;
use DB;
use Yajra\Datatables\Datatables;

class SolicitudServicioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
              
         return view('solservicios_pro.index');
    }

   public function index_ajax()
    {
        $sol = DB::table('post_solicitudservicios as ss')
         ->leftjoin('adm_contratofinal as cf',"ss.id_contrato","=","cf.id")
         ->leftjoin('personas as p1', 'ss.id_propietario', '=', 'p1.id')
         ->leftjoin('inmuebles as i', 'ss.id_inmueble', '=', 'i.id')
         ->leftjoin('users as p2', 'ss.id_creador', '=', 'p2.id')
         ->leftjoin('users as p3', 'ss.id_modificador', '=', 'p3.id')
         ->leftjoin('users as p4', 'ss.id_autorizador', '=', 'p4.id')
         ->leftjoin('users as p5', 'ss.id_asignacion', '=', 'p4.id')
         ->leftjoin('comunas as o', 'i.id_comuna', '=', 'o.comuna_id')
        ->leftjoin('mensajes as m', function($join){
                 $join->on('m.nombre_modulo', '=',DB::raw("'Solicitud Servicio'"));
                 $join->on('m.id_estado', '=', 'ss.id_estado');
            })
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
                            ss.valor_en_uf,
                            ss.valor_en_pesos'))
         ->get();
         
          return Datatables::of($sol)
         ->addColumn('action', function ($sol) {
                               return  '<a href="/solservicio/'.$sol->id_solicitud.'/2/edit"><span class="btn btn-warning btn-circle btn-sm"><i class="ti-pencil-alt"></i></span></a>
                                    <a href="/captacion/'.$sol->id_solicitud.'/destroy"><span class="btn btn-danger btn-circle btn-sm"><i class="ti-pencil-alt"></i></span></a>';
        })
        ->addColumn('id_link', function ($sol) {
                               return  '<a href="/solservicio/'.$sol->id_solicitud.'/2/edit"><span class="btn btn-success btn-sm"> '.$sol->id.'</span> </a>';
        })
        ->rawColumns(['id_link','action'])
        ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
         return view('solservicios_pro.create');
    }

    public function create_ajax(){
        $publica = DB::table('adm_contratofinal as co')
                ->leftjoin('borradores as cb', 'co.id_borrador', '=', 'cb.id')
                ->leftjoin('adm_contratodirpropietarios as cd', 'cd.id_contratofinal', '=', 'co.id')
                ->leftjoin('inmuebles as i', 'cd.id_inmueble', '=', 'i.id')
                ->leftjoin('comunas as o', 'i.id_comuna', '=', 'o.comuna_id')
                ->leftjoin('cap_publicaciones as c', 'c.id', '=', 'co.id_publicacion')
                ->leftjoin('personas as p1', 'c.id_propietario', '=', 'p1.id')
                ->leftjoin('users as p2', 'c.id_creador', '=', 'p2.id')
                ->leftjoin('users as p3', 'c.id_modificador', '=', 'p3.id')
                ->leftjoin('mensajes as m', function($join){
                 $join->on('m.nombre_modulo', '=',DB::raw("'Captación'"));
                 $join->on('m.id_estado', '=', 'c.id_estado');
            })
                ->whereIn('c.id_estado', [7, 10, 6])
         ->select(DB::raw('co.id as id_contrato, 
                            DATE_FORMAT(co.created_at, "%d/%m/%Y") as FechaCreacion, 
                            m.nombre as Estado,
                            CONCAT_WS(" ",p1.nombre,p1.apellido_paterno,p1.apellido_materno) as Propietario, 
                            p2.name as Creador,
                            p3.name as Modificador,
                            CONCAT_WS(" ",i.direccion,i.numero," Dpto ",i.departamento) as Direccion,
                            o.comuna_nombre as Comuna,
                            p1.email,
                            p1.telefono'))
                ->get();
          return Datatables::of($publica)
         ->addColumn('action', function ($publica) {
                               return  '<a href="/solservicio/'.$publica->id_contrato.'/create"><span class="btn btn-success  btn-sm">Crear Solicitud</span></a>
                                    ';
        })
        ->addColumn('id_link', function ($publica) {
                               return  '<a href="/solservicio/'.$publica->id_contrato.'/create"><span class="btn btn-success btn-sm"> '.$publica->id_contrato.'</span> </a>';
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
     * @param  \App\SolicitudServicio  $solicitudServicio
     * @return \Illuminate\Http\Response
     */
    public function show(SolicitudServicio $solicitudServicio)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\SolicitudServicio  $solicitudServicio
     * @return \Illuminate\Http\Response
     */
    public function edit(SolicitudServicio $solicitudServicio)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\SolicitudServicio  $solicitudServicio
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SolicitudServicio $solicitudServicio)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\SolicitudServicio  $solicitudServicio
     * @return \Illuminate\Http\Response
     */
    public function destroy(SolicitudServicio $solicitudServicio)
    {
        //
    }
}
