<?php

namespace App\Http\Controllers;

use App\RevisionInmueble;
use App\FotoRevisionInmueble;
use App\CaptacionImageCorredor;
use Illuminate\Http\Request;
use App\Inmueble;
use App\Region;
use DB;
use Image;
use DateTime;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\File;

class RevisionInmuebleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
            $inm = DB::select("SELECT i.id, i.direccion, i.condicion, i.numero, i.departamento, i.observaciones, i.dormitorio, i.bano, i.estacionamiento, i.bodega, i.piscina, i.precio, i.gastosComunes, i.id_comuna, i.id_region, i.id_provincia, i.created_at, i.updated_at, i.estado, i.deleted_at, (select count(*) from adm_revisioninmueble as a where a.id_inmueble= i.id) as cant_revisiones, (select count(*) from adm_fotorevinmueble as a where a.id_inmueble= i.id) as cant_fotos, c.comuna_nombre FROM inmuebles as i left join comunas c on i.id_comuna=c.comuna_id");

           // $inm = DB::table('inmuebles')->join('comunas', 'inmuebles.id_comuna', '=', 'comunas.comuna_id')->get();

            return view('revisioninmueble.index',compact('inm'));
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
        $inmueble = DB::table('inmuebles')
        ->where("id","=",$id)
        ->join('comunas', 'inmuebles.id_comuna', '=', 'comunas.comuna_id')->get()->first();
        
        $gestion = DB::table('adm_revisioninmueble as g')
         ->leftjoin('personas as p2', 'g.id_creador', '=', 'p2.id')
         ->where("g.id_inmueble","=",$id)
         ->select(DB::raw('g.id, DATE_FORMAT(g.fecha_gestion, "%d/%m/%Y") as fecha_gestion,  CONCAT(p2.nombre," ",p2.apellido_paterno," ",p2.apellido_materno) as Creador'),'g.tipo_revision','g.hora_gestion')
         ->get();

        $imagenes=FotoRevisionInmueble::where('id_inmueble','=',$id)->get();

        return view('revisioninmueble.edit',compact('inmueble','gestion','imagenes'));
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
        $revisioninmueble = RevisionInmueble::create($request->all());
        return redirect()->route('revisioninmueble.edit', $request->id_inmueble)

            ->with('status', 'Gestión guardada con éxito');
    }

  public function editarGestion(Request $request)
    {
        $fecha_gestion = DateTime::createFromFormat('d-m-Y', $request->fecha_gestion);
        array_set($request, 'fecha_gestion', $fecha_gestion);
        $revisiones = RevisionInmueble::where('id','=',$request->id_revisioninmueble)
        ->update([
            'detalle_revision' => $request->detalle_revision,
            'id_modificador' => $request->id_modificador,
            'fecha_gestion' => $request->fecha_gestion,
            'hora_gestion' => $request->hora_gestion
        ]);
        return redirect()->route('revisioninmueble.edit', $request->id_inmueble)

            ->with('status', 'Gestión guardada con éxito');
    }

      public function mostrarGestion(Request $request, $idg){
            $gestion=RevisionInmueble::where('id','=',$idg)->get();
            return response()->json($gestion);  
    }


public function savefotos(Request $request, $id){

         if(!isset($request->foto)){
            return redirect()->route('revisioninmueble.edit', $id)->with('error', 'Debe seleccionar archivo');
         }

        $destinationPath='uploads/adm_revisioninmueble';
        $archivo=rand().$request->foto->getClientOriginalName();
        $file = $request->file('foto');
        $file->move($destinationPath,$archivo);

                $imagen=FotoRevisionInmueble::create([
                            'id_inmueble'         => $id,
                            'descripcion'          => '',
                            'nombre'               => $archivo,
                            'ruta'                 => $destinationPath,
                            'id_creador'           => $request->id_creador
                        ]);


        return redirect()->route('revisioninmueble.edit', $id)->with('status', 'Archivo guardada con éxito');
    }


/**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\captacion  $captacion
     * @return \Illuminate\Http\Response
     */
    public function eliminarfoto($idf,$idc){
        $imagen=FotoRevisionInmueble::find($idf);
        File::delete($imagen->ruta.'/'.$imagen->nombre);
        $foto = FotoRevisionInmueble::find($idf)->delete();

        return redirect()->route('revisioninmueble.edit', $idc)->with('status', 'Archivo eliminada con éxito');
    }
}
