<?php

namespace App\Http\Controllers;

use App\PersonaInmueble;
use App\Inmueble;
use App\Persona;
use App\Comuna;
use Illuminate\Database\Query\Builder;
use DB;
use Illuminate\Http\Request;

class PersonaInmuebleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pi = DB::table('personainmuebles')->join('inmuebles', 'personainmuebles.id_inmueble', '=', 'inmuebles.id')
                                           ->join('personas' , 'personainmuebles.id_persona',  '=', 'personas.id')
                                           ->join('comunas'  , 'inmuebles.id_comuna',          '=', 'comunas.comuna_id')
                                           ->select('personainmuebles.id','inmuebles.direccion','inmuebles.numero','personas.nombre','personas.apellido_paterno','personas.apellido_materno','comunas.comuna_nombre')
                                           ->get();
        return view('personaInmueble.index',compact('pi'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $pers = DB::table('personas as p')
        ->where('p.id_estado',1)
        ->select(DB::raw('p.id, CONCAT(p.nombre," ",p.apellido_paterno," ",p.apellido_materno) as propietario'))
         ->get()->toArray();
        $inmu = DB::table('inmuebles')->join('comunas', 'inmuebles.id_comuna', '=', 'comunas.comuna_id')->get();

        return view('personaInmueble.create',compact('pers','inmu'));

    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $pi = PersonaInmueble::create($request->all());
        return redirect()->route('personaInmueble.index')
        ->with('status', 'Relación Persona/Inmueble guardado con éxito');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\PersonaInmueble  $personaInmueble
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $ip = PersonaInmueble::where('personainmuebles.id', $id)->join('inmuebles', 'personainmuebles.id_inmueble', '=', 'inmuebles.id')
                                               ->join('personas' , 'personainmuebles.id_persona',  '=', 'personas.id')
                                               ->join('comunas'  , 'inmuebles.id_comuna',          '=', 'comunas.comuna_id')
                                               ->first();

        return view('personaInmueble.show', compact('ip', 'id'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\PersonaInmueble  $personaInmueble
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $pi = PersonaInmueble::where('personainmuebles.id', $id)->join('inmuebles', 'personainmuebles.id_inmueble', '=', 'inmuebles.id')
                                               ->join('personas' , 'personainmuebles.id_persona',  '=', 'personas.id')
                                               ->join('comunas'  , 'inmuebles.id_comuna',          '=', 'comunas.comuna_id')
                                               ->select('personainmuebles.id','inmuebles.direccion','inmuebles.numero','personas.nombre','personas.apellido_paterno','personas.apellido_materno','comunas.comuna_nombre')
                                               ->first();
        $pers = Persona::all();
        $inmu = DB::table('inmuebles')->join('comunas', 'inmuebles.id_comuna', '=', 'comunas.comuna_id')->get();

        return view('personaInmueble.edit', compact('pi', 'pers','inmu'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\PersonaInmueble  $personaInmueble
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = request()->except(['_token']);
        $cargo = PersonaInmueble::whereId($id)->update($data);

        return redirect()->route('personaInmueble.index', $id)
            ->with('status', 'Relación Persona/Inmueble guardada con éxito');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\PersonaInmueble  $personaInmueble
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $pi = PersonaInmueble::find($id);
        $pi->delete();

        return back()->with('status', 'Registro Eliminado con éxito');
    }
}
