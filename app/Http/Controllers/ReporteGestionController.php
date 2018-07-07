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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
