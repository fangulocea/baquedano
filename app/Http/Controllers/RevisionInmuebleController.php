<?php

namespace App\Http\Controllers;

use App\RevisionInmueble;
use Illuminate\Http\Request;
use App\Inmueble;
use App\Region;
use DB;

class RevisionInmuebleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
                   $inm = DB::table('inmuebles')->join('comunas', 'inmuebles.id_comuna', '=', 'comunas.comuna_id')->get();

            return view('revisioninmueble.index',compact('inm'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

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
     * @param  \App\RevisionInmueble  $revisionInmueble
     * @return \Illuminate\Http\Response
     */
    public function show(RevisionInmueble $revisionInmueble)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\RevisionInmueble  $revisionInmueble
     * @return \Illuminate\Http\Response
     */
    public function edit(RevisionInmueble $revisionInmueble)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\RevisionInmueble  $revisionInmueble
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, RevisionInmueble $revisionInmueble)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\RevisionInmueble  $revisionInmueble
     * @return \Illuminate\Http\Response
     */
    public function destroy(RevisionInmueble $revisionInmueble)
    {
        //
    }
}
