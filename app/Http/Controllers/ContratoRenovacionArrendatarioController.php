<?php

namespace App\Http\Controllers;

use App\ContratoRenovacionArrendatario;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use DateTime;
use URL;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\File;    
use Illuminate\Support\Facades\Mail;
use App\ContratoBorradorArrendatarioPdf;
use App\ArrendatarioGarantia;

class ContratoRenovacionArrendatarioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $publica = DB::select("SELECT  a.id as id_cap_arr, 
                    CONCAT_WS(' ',pa .nombre,pa.apellido_paterno,pa.apellido_materno) as arrendatario,
                    i.direccion,i.numero,c.comuna_nombre as comuna,a.id_estado, a.id_arrendatario as id_arrendatario
                    ,DATE_FORMAT(date(DATE_ADD(cba.fecha_contrato, INTERVAL 1 YEAR)), '%d/%m/%Y') as contratofin
                    FROM arrendatarios a
                    JOIN users pc ON a.id_creador =  pc.id
                    JOIN personas pm ON a.id_modificador = pm.id
                    JOIN personas pa ON a.id_arrendatario = pa.id
                    JOIN inmuebles i ON a.id_inmueble = i.id
                    JOIN comunas c ON i.id_comuna = c.comuna_id
                    JOIN contratoborradorarrendatarios cba ON a.id = cba.id_cap_arr
                    where a.id_estado = 11
                    and date_add(DATE_ADD(cba.fecha_contrato, INTERVAL 1 YEAR), INTERVAL -60 DAY) < now()");

        return view('contratorenovacionarrendatario.index',compact('publica'));


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
     * @param  \App\ContratoRenovacionArrendatario  $contratoRenovacionArrendatario
     * @return \Illuminate\Http\Response
     */
    public function show(ContratoRenovacionArrendatario $contratoRenovacionArrendatario)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ContratoRenovacionArrendatario  $contratoRenovacionArrendatario
     * @return \Illuminate\Http\Response
     */
    public function edit(ContratoRenovacionArrendatario $contratoRenovacionArrendatario)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ContratoRenovacionArrendatario  $contratoRenovacionArrendatario
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ContratoRenovacionArrendatario $contratoRenovacionArrendatario)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ContratoRenovacionArrendatario  $contratoRenovacionArrendatario
     * @return \Illuminate\Http\Response
     */
    public function destroy(ContratoRenovacionArrendatario $contratoRenovacionArrendatario)
    {
        //
    }
}
