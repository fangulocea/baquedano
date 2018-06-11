<?php

namespace App\Http\Controllers;

use App\Arrendatario;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Persona;
use App\Inmueble;
use App\Region;
use App\CaptacionFoto;
use App\CaptacionGestion;
use App\Portales;
use App\CaptacionImport;
use DB;
use Image;
use DateTime;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\File;

class ArrendatarioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         $arrendador = DB::table('arrendatarios as a')
         ->leftjoin('personas as p1', 'a.id_arrendador', '=', 'p1.id')
         ->leftjoin('personas as p2', 'a.id_creador', '=', 'p2.id')
         ->leftjoin('personas as p3', 'a.id_modificador', '=', 'p3.id')
         ->select(DB::raw('a.id, DATE_FORMAT(a.created_at, "%d/%m/%Y") as fecha_creacion, a.id_estado, CONCAT_WS(" ", p1.nombre, p1.apellido_paterno, p1.apellido_materno) as Arrendador, CONCAT_WS(" ", p2.nombre, p2.apellido_paterno, p2.apellido_materno) as Creador'))->get();
         
         return view('arrendatario.index',compact('arrendador'));
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
     * @param  \App\Arrendatario  $arrendatario
     * @return \Illuminate\Http\Response
     */
    public function show(Arrendatario $arrendatario)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Arrendatario  $arrendatario
     * @return \Illuminate\Http\Response
     */
    public function edit(Arrendatario $arrendatario)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Arrendatario  $arrendatario
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Arrendatario $arrendatario)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Arrendatario  $arrendatario
     * @return \Illuminate\Http\Response
     */
    public function destroy(Arrendatario $arrendatario)
    {
        //
    }
}
