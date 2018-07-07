<?php

namespace App\Http\Controllers;

use App\ReporteCaptaciones;
use Illuminate\Http\Request;
use DB;

class ReporteCaptacionesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($estados)
    {
        if($estados == 2)
        {
        $publica = DB::select('select cap.id, por.nombre, CONCAT_WS(", ",inm.direccion,inm.numero,com.comuna_nombre) as direccion, per.name as creador, case cap.id_estado when 0 then "Descartado" when 1 then "Sin Gestión" when 2 then "Sin Respuesta" when 3 then "Reenvío" when 4 then "Expirado"  when 5 then "Segunda Gestión"  when 6 then "Contrato Borrador"  when 7 then "Contrato Cerrado"  when 8 then "eguimiento Correo"  when 9 then "Captación Terreno" end as estado, DATE_FORMAT(cap.fecha_publicacion, "%d-%m-%Y") as fecha, cap.created_at as fecha_creacion from cap_publicaciones cap left join portales por on cap.portal=por.id left join inmuebles inm on cap.id_inmueble=inm.id left join users per on cap.id_creador=per.id left join comunas com on inm.id_comuna=com.comuna_id where cap.id_estado = 2');

        } elseif($estados == 0){

        $publica = DB::select('select cap.id, por.nombre, CONCAT_WS(", ",inm.direccion,inm.numero,com.comuna_nombre) as direccion, per.name as creador, case cap.id_estado when 0 then "Descartado" when 1 then "Sin Gestión" when 2 then "Sin Respuesta" when 3 then "Reenvío" when 4 then "Expirado"  when 5 then "Segunda Gestión"  when 6 then "Contrato Borrador"  when 7 then "Contrato Cerrado"  when 8 then "eguimiento Correo"  when 9 then "Captación Terreno" end as estado, DATE_FORMAT(cap.fecha_publicacion, "%d-%m-%Y") as fecha , cap.created_at as fecha_creacion from cap_publicaciones cap left join portales por on cap.portal=por.id left join inmuebles inm on cap.id_inmueble=inm.id left join users per on cap.id_creador=per.id left join comunas com on inm.id_comuna=com.comuna_id where cap.id_estado = 0');          
        } elseif($estados == 3){
        $publica = DB::select('select cap.id, por.nombre, CONCAT_WS(", ",inm.direccion,inm.numero,com.comuna_nombre) as direccion, per.name as creador, case cap.id_estado when 0 then "Descartado" when 1 then "Sin Gestión" when 2 then "Sin Respuesta" when 3 then "Reenvío" when 4 then "Expirado"  when 5 then "Segunda Gestión"  when 6 then "Contrato Borrador"  when 7 then "Contrato Cerrado"  when 8 then "eguimiento Correo"  when 9 then "Captación Terreno" end as estado, DATE_FORMAT(cap.fecha_publicacion, "%d-%m-%Y") as fecha , cap.created_at as fecha_creacion from cap_publicaciones cap left join portales por on cap.portal=por.id left join inmuebles inm on cap.id_inmueble=inm.id left join users per on cap.id_creador=per.id left join comunas com on inm.id_comuna=com.comuna_id where cap.id_estado = 3');             
        } else {

        $publica = DB::select('select cap.id, por.nombre, CONCAT_WS(", ",inm.direccion,inm.numero,com.comuna_nombre) as direccion, per.name as creador, case cap.id_estado when 0 then "Descartado" when 1 then "Sin Gestión" when 2 then "Sin Respuesta" when 3 then "Reenvío" when 4 then "Expirado"  when 5 then "Segunda Gestión"  when 6 then "Contrato Borrador"  when 7 then "Contrato Cerrado"  when 8 then "eguimiento Correo"  when 9 then "Captación Terreno" end as estado, DATE_FORMAT(cap.fecha_publicacion, "%d-%m-%Y") as fecha , cap.created_at as fecha_creacion from cap_publicaciones cap left join portales por on cap.portal=por.id left join inmuebles inm on cap.id_inmueble=inm.id left join users per on cap.id_creador=per.id left join comunas com on inm.id_comuna=com.comuna_id where (select count(*) from cap_gestion g where g.id_captacion_gestion = cap.id) = 0');
                   
        }


        return view('reporteCaptaciones.index',compact('publica'));
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
     * @param  \App\ReporteCaptaciones  $reporteCaptaciones
     * @return \Illuminate\Http\Response
     */
    public function show(ReporteCaptaciones $reporteCaptaciones)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ReporteCaptaciones  $reporteCaptaciones
     * @return \Illuminate\Http\Response
     */
    public function edit(ReporteCaptaciones $reporteCaptaciones)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ReporteCaptaciones  $reporteCaptaciones
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ReporteCaptaciones $reporteCaptaciones)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ReporteCaptaciones  $reporteCaptaciones
     * @return \Illuminate\Http\Response
     */
    public function destroy(ReporteCaptaciones $reporteCaptaciones)
    {
        //
    }
}
