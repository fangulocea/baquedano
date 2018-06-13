<?php

namespace App\Http\Controllers;

use App\RevisionPersona;
use Illuminate\Http\Request;
use App\Region;
use App\Persona;
use DB;

class RevisionPersonaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
          $personas = DB::table('personas')
        ->leftjoin('comunas', 'personas.id_comuna', '=', 'comunas.comuna_id')
        ->Where('personas.id','<>',1)
        ->get();
        return view('revisionpersona.index', compact('personas'));
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
     * @param  \App\RevisionPersona  $revisionPersona
     * @return \Illuminate\Http\Response
     */
    public function show(RevisionPersona $revisionPersona)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\RevisionPersona  $revisionPersona
     * @return \Illuminate\Http\Response
     */
    public function edit(RevisionPersona $revisionPersona)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\RevisionPersona  $revisionPersona
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, RevisionPersona $revisionPersona)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\RevisionPersona  $revisionPersona
     * @return \Illuminate\Http\Response
     */
    public function destroy(RevisionPersona $revisionPersona)
    {
        //
    }
}
