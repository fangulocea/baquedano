<?php

namespace App\Http\Controllers;

use App\Persona;
use App\Region;
use App\Cargo;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Database\Query\Builder;
use DB;


class PersonaController extends Controller
{

    public function getPersonas($text){
        $personas=Persona::personas($text);
        return response()->json($personas);
    }

    public function getPersonasEmail($text){
        $personas=Persona::personasEmail($text);
        return response()->json($personas);
    }

    public function getPersonasFono($text){
        $personas=Persona::personasFono($text);
        return response()->json($personas);
    }
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
        return view('persona.index', compact('personas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $regiones=Region::pluck('region_nombre','region_id');
        $cargos=Cargo::pluck('nombre','id');
        $muestra = "display: none;";
        return view('persona.create',compact('regiones','cargos','muestra'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(empty($request->email))
        {   
            $valida = 0;
        }
        else
        {   
            $valida = DB::table('personas')
            ->Where('personas.email','=',$request->email)
            ->count();
        }

        if($valida == 0)
        {
            $persona = Persona::create($request->all());
            $id_user = $persona->id;
            if  ($request->tipo_cargo != 'Empleado')
            {
                array_set($request, 'cargo_id', null);
            } 
            else
            {
                $request = array_add($request, 'name', $request->nombre);
                $request = array_add($request, 'password', '$2y$10$G4rI0Q743N/iWVhdUVtYsOAan.8gNsZkcvvl6w.A60QyluAYVe8eW');
                $request = array_add($request, 'id_persona', $id_user);
                $user = User::create($request->all());    
            }
               return redirect()->route('persona.index', $persona->id)
               ->with('status', 'Persona guardada con éxito');
        }
        else
        {
            return redirect()->route('persona.index')
            ->with('error', 'Persona Ya Existe, no se puede ingresar');  

        }


    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Persona  $persona
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $regiones = Region::pluck('region_nombre','region_id');
        $_persona = Persona::find($id);
        $cargos   = Cargo::pluck('nombre','id');
        if  (isset($_persona->cargo_id))
            { $muestra = "ocultar"; } 
        else 
            { $muestra = "ocultar"; }
        return view('persona.show', compact('_persona','regiones','cargos','muestra'));
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Persona  $persona
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $regiones = Region::pluck('region_nombre','region_id');
        $_persona = Persona::find($id);
        $cargos   = Cargo::pluck('nombre','id');
        if  ($_persona->cargo_id != null)
            { $muestra = "ocultar"; } 
        else 
            { $muestra = "ocultar"; }
        return view('persona.edit', compact('_persona','regiones','cargos','muestra'));
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Persona  $persona
     * @return \Illuminate\Http\Response
     */
     public function update(Request $request, $id)
    {
        if(empty($request->email))
        { 
            $valida = 0;
        }
        else
        {
            $act = DB::table('personas')
            ->Where('personas.id','=',$id)
            ->get();

            if(empty($act->email))
            { 
                $valida = DB::table('personas')
                    ->Where('personas.email','=',$request->email)
                    ->Where('personas.id','<>',$id)
                    ->count();
            }
            else
            {
                if($act->email == $request->email)
                {
                    $valida = 1;
                }
            }
        }

        if($valida == 0)
        {   
            $data = request()->except(['_token']);
            if  ($request->tipo_cargo != 'Empleado')
            { 
                array_set($request, 'cargo_id', null); 
                $data = request()->except(['_token']);
                $usuario = DB::table('users')->where('email', $request->email)->first();
                if($usuario != null)
                {
                    $usuario_ = User::find($usuario->id)->delete();
                }
            } 
            else
            {
                $usuario = DB::table('users')->where('email', $request->email)->first();
                if($usuario == null)
                {
                    $request = array_add($request, 'name', $request->nombre);
                    $request = array_add($request, 'password', '$2y$10$G4rI0Q743N/iWVhdUVtYsOAan.8gNsZkcvvl6w.A60QyluAYVe8eW');
                    $request = array_add($request, 'id_persona',$id);
                    $user = User::create($request->all()); 
                }
            }
            $persona = Persona::whereId($id)->update($data);
            return redirect()->route('persona.index', $id)
            ->with('status', 'Persona guardada con éxito');  
        }
        else
        {   
            return redirect()->route('persona.index')
            ->with('error', 'Persona Ya Existe, no se puede ingresar');  
        }
    }

    public function edithome($id)
    {
        $regiones = Region::pluck('region_nombre','region_id');
        $_persona = Persona::find($id);
        return view('persona.edithome', compact('_persona','regiones'));
    }

    public function updatehome(Request $request, $id)
    {
        $data = request()->except(['_token']);
        $persona = Persona::whereId($id)->update($data);
        return redirect()->route('persona.edithome', $id)
        ->with('status', 'Persona guardada con éxito');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Persona  $persona
     * @return \Illuminate\Http\Response
     */
    public function destroy($id,$cargo)
    {

        $usuario = DB::table('users')->where('id_persona', $id)->first();
        if  ($cargo == 'Empleado')
        { 
            $usuario_ = User::find($usuario->id)->delete();
        }

        Persona::find($id)->update(['id_estado' => 0]);

        return back()->with('status', 'registro No Vigente');
    }
}


