<?php

namespace App\Http\Controllers;

use App\RevisionPersona;
use App\FotoRevisionPersona;
use Illuminate\Http\Request;
use App\Region;
use App\Persona;
use DB;
use Image;
use DateTime;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\File;

class RevisionPersonaController extends Controller
{
   /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

              $personas = DB::select("SELECT p.*, (select count(*) from adm_revisionpersona as a where a.id_persona= p.id) as cant_revisiones, (select count(*) from adm_fotorevpersona as a where a.id_persona= p.id) as cant_fotos, c.comuna_nombre FROM personas as p left join comunas c on p.id_comuna=c.comuna_id where p.id <> 1 and p.tipo_cargo<>'Empleado'");

           // $inm = DB::table('inmuebles')->join('comunas', 'inmuebles.id_comuna', '=', 'comunas.comuna_id')->get();

            return view('revisionpersona.index',compact('personas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
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
    public function edit($id)
    {
        $persona = DB::table('personas')
        ->where("id","=",$id)
        ->leftjoin('comunas', 'personas.id_comuna', '=', 'comunas.comuna_id')->get()->first();
        
        $gestion = DB::table('adm_revisionpersona as g')
         ->leftjoin('personas as p2', 'g.id_creador', '=', 'p2.id')
         ->where("g.id_persona","=",$id)
         ->select(DB::raw('g.id, DATE_FORMAT(g.fecha_gestion, "%d/%m/%Y") as fecha_gestion,  CONCAT(p2.nombre," ",p2.apellido_paterno," ",p2.apellido_materno) as Creador'),'g.tipo_revision','g.hora_gestion')
         ->get();

        $imagenes=FotoRevisionPersona::where('id_persona','=',$id)->get();

        return view('revisionpersona.edit',compact('persona','gestion','imagenes'));
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


    public function crearGestion(Request $request)
    {
        $fecha_gestion = DateTime::createFromFormat('d-m-Y', $request->fecha_gestion);
        array_set($request, 'fecha_gestion', $fecha_gestion);
        $revisionpersona = RevisionPersona::create($request->all());
        return redirect()->route('revisionpersona.edit', $request->id_persona)

            ->with('status', 'Gestión guardada con éxito');
    }

  public function editarGestion(Request $request)
    {
        $fecha_gestion = DateTime::createFromFormat('d-m-Y', $request->fecha_gestion);
        array_set($request, 'fecha_gestion', $fecha_gestion);
        $revisiones = RevisionPersona::where('id','=',$request->id_revisionpersona)
        ->update([
            'detalle_revision' => $request->detalle_revision,
            'id_modificador' => $request->id_modificador,
            'fecha_gestion' => $request->fecha_gestion,
            'hora_gestion' => $request->hora_gestion
        ]);
        return redirect()->route('revisionpersona.edit', $request->id_persona)

            ->with('status', 'Gestión guardada con éxito');
    }

      public function mostrarGestion(Request $request, $idg){
            $gestion=RevisionPersona::where('id','=',$idg)->get();
            return response()->json($gestion);  
    }


public function savefotos(Request $request, $id){

         if(!isset($request->foto)){
            return redirect()->route('revisionpersona.edit', $id)->with('error', 'Debe seleccionar archivo');
         }

        $destinationPath='uploads/adm_revisionpersona';
        $archivo=rand().$request->foto->getClientOriginalName();
        $file = $request->file('foto');
        $file->move($destinationPath,$archivo);

                $imagen=FotoRevisionPersona::create([
                            'id_persona'         => $id,
                            'descripcion'          => '',
                            'nombre'               => $archivo,
                            'ruta'                 => $destinationPath,
                            'id_creador'           => $request->id_creador
                        ]);


        return redirect()->route('revisionpersona.edit', $id)->with('status', 'Archivo guardada con éxito');
    }


/**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\captacion  $captacion
     * @return \Illuminate\Http\Response
     */
    public function eliminarfoto($idf,$idc){
        $imagen=FotoRevisionPersona::find($idf);
        File::delete($imagen->ruta.'/'.$imagen->nombre);
        $foto = FotoRevisionPersona::find($idf)->delete();

        return redirect()->route('revisionpersona.edit', $idc)->with('status', 'Archivo eliminada con éxito');
    }
}
