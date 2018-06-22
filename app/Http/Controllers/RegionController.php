<?php

namespace App\Http\Controllers;

use App\Region;
use App\Provincia;
use Illuminate\Http\Request;

class RegionController extends Controller
{

    public function getProvincias(Request $request, $id){
        if($request->ajax()){
            $provincias=Provincia::provincias($id);
            return response()->json($provincias);
        }
    }


    public function getTodasRegiones(Request $request){
            $regiones=Region::all();
            return response()->json($regiones);
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
     * @param  \App\region  $region
     * @return \Illuminate\Http\Response
     */
    public function show(region $region)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\region  $region
     * @return \Illuminate\Http\Response
     */
    public function edit(region $region)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\region  $region
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, region $region)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\region  $region
     * @return \Illuminate\Http\Response
     */
    public function destroy(region $region)
    {
        //
    }
}
