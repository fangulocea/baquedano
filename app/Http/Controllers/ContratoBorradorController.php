<?php

namespace App\Http\Controllers;

use App\ContratoBorrador;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use App\Captacion;
use DateTime;

class ContratoBorradorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         $publica = DB::table('cap_publicaciones as c')
         ->leftjoin('personas as p1', 'c.id_propietario', '=', 'p1.id')
         ->leftjoin('inmuebles as i', 'c.id_inmueble', '=', 'i.id')
         ->leftjoin('personas as p2', 'c.id_creador', '=', 'p2.id')
         ->leftjoin('personas as p3', 'c.id_modificador', '=', 'p3.id')
         ->leftjoin('comunas as o', 'i.id_comuna', '=', 'o.comuna_id')
         ->leftjoin('portales as po', 'c.portal', '=', 'po.id')
         ->where('c.id_estado','=',6)
         ->select(DB::raw('c.id as id_publicacion, DATE_FORMAT(c.created_at, "%d/%m/%Y") as fecha_creacion, c.id_estado as id_estado, CONCAT(p1.nombre," ",p1.apellido_paterno," ",p1.apellido_materno) as Propietario, CONCAT(p2.nombre," ",p2.apellido_paterno," ",p2.apellido_materno) as Creador'),'i.id as id_inmueble','i.direccion','i.numero','i.departamento', 'o.comuna_nombre','po.nombre as portal','p1.nombre as nom_p','p1.apellido_paterno as apep_p','p1.apellido_materno as apem_p','p2.nombre as nom_c','p2.apellido_paterno as apep_c','p2.apellido_materno as apem_c','p3.nombre as nom_m','p3.apellido_paterno as apep_m','p3.apellido_materno as apem_m')
         ->get();
         
         return view('contratoBorrador.index',compact('publica'));
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
     * @param  \App\ContratoBorrador  $contratoBorrador
     * @return \Illuminate\Http\Response
     */
    public function show(ContratoBorrador $contratoBorrador)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ContratoBorrador  $contratoBorrador
     * @return \Illuminate\Http\Response
     */
    public function edit(ContratoBorrador $contratoBorrador)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ContratoBorrador  $contratoBorrador
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ContratoBorrador $contratoBorrador)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ContratoBorrador  $contratoBorrador
     * @return \Illuminate\Http\Response
     */
    public function destroy(ContratoBorrador $contratoBorrador)
    {
        //
    }
}
