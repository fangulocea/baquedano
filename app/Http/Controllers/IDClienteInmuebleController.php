<?php

namespace App\Http\Controllers;

use App\IDClienteInmueble;
use Illuminate\Http\Request;

class IDClienteInmuebleController extends Controller
{


    public function getid($id_empresaservicio,$idinmueble){
        $id=IDClienteInmueble::where("id_inmueble","=",$idinmueble)->where("id_empresaservicio","=",$id_empresaservicio)->first();
        return response()->json($id);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @param  \App\IDClienteInmueble  $iDClienteInmueble
     * @return \Illuminate\Http\Response
     */
    public function show(IDClienteInmueble $iDClienteInmueble)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\IDClienteInmueble  $iDClienteInmueble
     * @return \Illuminate\Http\Response
     */
    public function edit(IDClienteInmueble $iDClienteInmueble)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\IDClienteInmueble  $iDClienteInmueble
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, IDClienteInmueble $iDClienteInmueble)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\IDClienteInmueble  $iDClienteInmueble
     * @return \Illuminate\Http\Response
     */
    public function destroy(IDClienteInmueble $iDClienteInmueble)
    {
        //
    }
}
