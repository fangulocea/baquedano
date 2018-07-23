<?php

namespace App\Http\Controllers;

use App\ContratoRenovacionPropietario;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use App\Captacion;
use App\Servicio;
use DateTime;
use App\Contratoborradorpdf;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\File;    
use Illuminate\Support\Facades\Mail;
use URL;
use App\PropietarioGarantia;

class ContratoRenovacionPropietarioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $publica = DB::select("SELECT c.id as id_publicacion, DATE_FORMAT(c.created_at, '%d/%m/%Y') as fecha_creacion, 
                               c.id_estado as id_estado, 
                               CONCAT_WS(' ',p1.nombre,p1.apellido_paterno,p1.apellido_materno) as Propietario, 
                               p2.name as Creador, p1.id as id_propietario, i.id as id_inmueble, i.direccion,
                               i.numero ,i.departamento, o.comuna_nombre, po.nombre as portal, p1.nombre as nom_p ,
                               p1.apellido_paterno as apep_p, p1.apellido_materno as apem_p, p3.nombre as nom_m ,
                               p3.apellido_paterno as apep_m, p3.apellido_materno as apem_m
                               ,DATE_FORMAT(date(DATE_ADD(bo.fecha_gestion, INTERVAL 1 YEAR)), '%d/%m/%Y') as contratofin
                               FROM cap_publicaciones c
                               JOIN personas p1   ON c.id_propietario = p1.id 
                               JOIN inmuebles i   ON c.id_inmueble    = i.id 
                               JOIN users p2      ON c.id_creador     = p2.id 
                               JOIN personas p3   ON c.id_modificador = p3.id 
                               JOIN comunas o     ON i.id_comuna      = o.comuna_id
                               JOIN portales po   ON c.portal         = po.id
                               JOIN borradores bo ON c.id             = bo.id_publicacion
                               where c.id_estado = 7
                               and date_add(DATE_ADD(bo.fecha_gestion, INTERVAL 1 YEAR), INTERVAL -60 DAY) < now()");
         
         return view('contratorenovacionpropietario.index',compact('publica'));
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
     * @param  \App\ContratoRenovacionPropietario  $contratoRenovacionPropietario
     * @return \Illuminate\Http\Response
     */
    public function show(ContratoRenovacionPropietario $contratoRenovacionPropietario)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ContratoRenovacionPropietario  $contratoRenovacionPropietario
     * @return \Illuminate\Http\Response
     */
    public function edit(ContratoRenovacionPropietario $contratoRenovacionPropietario)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ContratoRenovacionPropietario  $contratoRenovacionPropietario
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ContratoRenovacionPropietario $contratoRenovacionPropietario)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ContratoRenovacionPropietario  $contratoRenovacionPropietario
     * @return \Illuminate\Http\Response
     */
    public function destroy(ContratoRenovacionPropietario $contratoRenovacionPropietario)
    {
        //
    }
}
