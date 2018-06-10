<?php

namespace App\Http\Controllers;

use App\Provincia;
use App\Comuna;
use Illuminate\Http\Request;

class ProvinciaController extends Controller
{

    public function getComunas(Request $request, $id){
        if($request->ajax()){
            $comunas=Comuna::comunas($id);
            return response()->json($comunas);
        }
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
     * @param  \App\provincia  $provincia
     * @return \Illuminate\Http\Response
     */
    public function show(provincia $provincia)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\provincia  $provincia
     * @return \Illuminate\Http\Response
     */
    public function edit(provincia $provincia)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\provincia  $provincia
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, provincia $provincia)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\provincia  $provincia
     * @return \Illuminate\Http\Response
     */
    public function destroy(provincia $provincia)
    {
        //
    }
}
