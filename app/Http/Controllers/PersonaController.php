<?php

namespace App\Http\Controllers;

use App\Persona;
use App\Region;
use App\Cargo;
use App\User;
use Yajra\Datatables\Datatables;
use App\Arrendatario;
use Illuminate\Http\Request;
use Illuminate\Database\Query\Builder;
use DB;


class PersonaController extends Controller
{


    public function getPersonaContratoBorrador($id){
        $persona=Persona::find($id);
        return response()->json($persona);
    }



    public function updatePersonaContratoBorrador(Request $request)
    {
        $id_persona=$request->id_persona;
        $id_publicacion=$request->id_publicacion;
        $data = request()->except(['_token','id_publicacion','id_persona']);
        $persona = Persona::whereId($id_persona)->update($data);
        return redirect()->route('borradorContrato.edit', [$id_publicacion,3])
        ->with('status', 'Propietario Actualizado con éxito');
    }

    public function updatePersonaArrendatarioBorrador(Request $request)
    {
        $id_persona=$request->id_persona;
        $id_publicacion=$request->id_publicacion;
        $data = request()->except(['_token','id_publicacion','id_persona']);
        $persona = Persona::whereId($id_persona)->update($data);
        return redirect()->route('cbararrendatario.edit', [$request->id_publicacion,3])
        ->with('status', 'Arrendatario Actualizado con éxito');
    }

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
        return view('persona.index');
    }


    public function index_ajax()
    {
        $personas = DB::table('personas as p')
        ->leftjoin('comunas as c', 'p.id_comuna', '=', 'c.comuna_id')
        ->Where('p.id','<>',1)
        ->leftjoin('mensajes as m', function($join){
                 $join->on('m.nombre_modulo', '=',DB::raw("'Vigencia'"));
                 $join->on('m.id_estado', '=', 'p.id_estado');
            })
            ->select(DB::raw("p.id,CONCAT_WS(' ',p.nombre,p.apellido_paterno,p.apellido_materno) as Persona, p.tipo_cargo, m.nombre as estado"))
            ->get();

            return Datatables::of($personas)
         ->addColumn('action', function ($personas) {
                               return  '<a href="/persona/'.$personas->id.'/edit"><span class="btn btn-warning btn-circle btn-sm"><i class="ti-pencil-alt"></i></span></a>';
        })
        ->addColumn('id_link', function ($personas) {
                               return  '<a href="/persona/'.$personas->id.'/edit"><span class="btn btn-success btn-sm"> '.$personas->id.'</span> </a>';
        })
        ->rawColumns(['id_link','action'])
        ->make(true);
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
                $request = array_add($request, 'name', $request->nombre.' '.$request->apellido_paterno.' '.$request->apellido_materno);
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


public function update_postventa_p(Request $request, $id)
    {
          if($id==0){
            return redirect()->route('postventa.edit', [$request->i_postventa_p,3])->with('error', 'No existe contrato propietario para la propiedad, no se puede guardar la información');
        }
 $persona = Persona::whereId($id)->update([
                    'rut' => $request->p_rut,
                    'nombre' => $request->p_nombre,
                    'apellido_paterno' => $request->p_apellido_paterno,
                    'apellido_materno' => $request->p_apellido_materno,
                    'direccion' => $request->p_direccion,
                    'numero' => $request->p_numero,
                    'departamento' => $request->p_departamento,
                    'estado_civil' => $request->p_estado_civil,
                    'profesion' => $request->p_profesion,
                    'telefono' => $request->p_telefono,
                    'email' => $request->p_email,
                    'id_comuna' => $request->p_id_comuna,
                    'id_region' => $request->p_id_region,
                    'id_provincia' => $request->p_id_provincia,
                    'tipo_cargo' => 'Propietario',
                ]);
return redirect()->route('postventa.edit', [$request->i_postventa_p,3])
        ->with('status', 'Propietario guardada con éxito');
    }

public function update_postventa_a(Request $request, $id)
    {
        if($id==0){
            return redirect()->route('postventa.edit', [$request->i_postventa_a,4])->with('error', 'No existe contrato arrendatario para la propiedad, no se puede guardar la información');
        }
 $persona = Persona::whereId($id)->update([
                    'rut' => $request->a_rut,
                    'nombre' => $request->a_nombre,
                    'apellido_paterno' => $request->a_apellido_paterno,
                    'apellido_materno' => $request->a_apellido_materno,
                    'direccion' => $request->a_direccion,
                    'numero' => $request->a_numero,
                    'departamento' => $request->a_departamento,
                    'estado_civil' => $request->a_estado_civil,
                    'profesion' => $request->a_profesion,
                    'telefono' => $request->a_telefono,
                    'email' => $request->a_email,
                    'id_comuna' => $request->a_id_comuna,
                    'id_region' => $request->a_id_region,
                    'id_provincia' => $request->a_id_provincia,
                    'tipo_cargo' => 'Arrendatario',
                ]);
return redirect()->route('postventa.edit', [$request->i_postventa_a,4])
        ->with('status', 'Arrendatario guardada con éxito');
    }


public function update_postventa_v(Request $request, $id)
    {
          if($id==0){
            return redirect()->route('postventa.edit', [$request->i_postventa_v,5])->with('error', 'No existe asignado un aval al contrato arrendatario para la propiedad, no se puede guardar la información');
        }
 $persona = Persona::whereId($id)->update([
                    'rut' => $request->v_rut,
                    'nombre' => $request->v_nombre,
                    'apellido_paterno' => $request->v_apellido_paterno,
                    'apellido_materno' => $request->v_apellido_materno,
                    'direccion' => $request->v_direccion,
                    'numero' => $request->v_numero,
                    'departamento' => $request->v_departamento,
                    'estado_civil' => $request->v_estado_civil,
                    'profesion' => $request->v_profesion,
                    'telefono' => $request->v_telefono,
                    'email' => $request->v_email,
                    'id_comuna' => $request->v_id_comuna,
                    'id_region' => $request->v_id_region,
                    'id_provincia' => $request->v_id_provincia,
                    'tipo_cargo' => 'Aval',
                    'id_estado'=>1
                ]);
 return redirect()->route('postventa.edit', [$request->i_postventa_v,5])
        ->with('status', 'Aval guardada con éxito');
    }



public function update_borrador_v(Request $request, $id)
    {
       
            $captacion = Arrendatario::find($id);

            //Propietario Nuevo
            if ($captacion->id_aval == null) {
                $p = Persona::where('rut', '=', $request->v_rut)->first();
                if ($p != null && isset($request->v_rut)) {
                    return back()->with('error', 'Rut existente en el sistema');
                }
                $persona = Persona::create([
                    'rut' => $request->v_rut,
                    'nombre' => $request->v_nombre,
                    'apellido_paterno' => $request->v_apellido_paterno,
                    'apellido_materno' => $request->v_apellido_materno,
                    'direccion' => $request->v_direccion,
                    'numero' => $request->v_numero,
                    'departamento' => $request->v_departamento,
                    'estado_civil' => $request->v_estado_civil,
                    'profesion' => $request->v_profesion,
                    'telefono' => $request->v_telefono,
                    'email' => $request->v_email,
                    'id_comuna' => $request->v_id_comuna,
                    'id_region' => $request->v_id_region,
                    'id_provincia' => $request->v_id_provincia,
                    'tipo_cargo' => 'Aval',
                    'id_estado'=>1
                ]);
            }
            //Propietario ya ingresado
            else {
                $persona = Persona::whereId($captacion->id_aval)->update([
                      'rut' => $request->v_rut,
                    'nombre' => $request->v_nombre,
                    'apellido_paterno' => $request->v_apellido_paterno,
                    'apellido_materno' => $request->v_apellido_materno,
                    'direccion' => $request->v_direccion,
                    'numero' => $request->v_numero,
                    'departamento' => $request->v_departamento,
                    'estado_civil' => $request->v_estado_civil,
                    'profesion' => $request->v_profesion,
                    'telefono' => $request->v_telefono,
                    'email' => $request->v_email,
                    'id_comuna' => $request->v_id_comuna,
                    'id_region' => $request->v_id_region,
                    'id_provincia' => $request->v_id_provincia,
                    'tipo_cargo' => 'Aval',
                    'id_estado'=>1
                ]);
                 $persona = Persona::find($captacion->id_aval);
            }

            $captacion = Arrendatario::whereId($id)->update([
                'id_aval' => $persona->id
                    ]
            );
         return redirect()->route('cbararrendatario.edit', [$id,2])
        ->with('status', 'Aval guardado con éxito');
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


