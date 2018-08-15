<?php

namespace App\Http\Controllers;

use App\PostVenta;
use Illuminate\Http\Request;
use App\Persona;
use App\Inmueble;
use App\Mensajes;
use App\ContratoFinal;
use App\GestionPostVenta;
use App\Captacion;
use App\Region;
use App\DocPostVenta;
use Illuminate\Support\Facades\File;
use DB;
use Auth;

class PostVentaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('postventa.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $empleados = Persona::where('tipo_cargo', '=', 'Corredor - Externo')
                ->Orwhere('tipo_cargo', '=', 'Empleado')
                ->select(DB::raw('id , CONCAT_WS(" ",nombre,apellido_paterno,apellido_materno) as empleado'))
                ->orderby('empleado',"asc")
                ->get();

        $estados = Mensajes::where('nombre_modulo', '=', 'Post Venta')
                 ->select(DB::raw('id_estado , nombre'))
                ->orderby('nombre',"asc")
                ->get();

        return view('postventa.create',compact('empleados','estados'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if($request->modulo=='1'){
            $contrato=ContratoFinal::find($request->id_contrato);
            $publicacion=Captacion::find($contrato->id_publicacion);
            $contratoarr=DB::table('adm_contratofinalarr as cf')
            ->join('arrendatarios as a',"a.id",'cf.id_publicacion')
            ->whereIn("a.id_estado",[10,11])
            ->first();
            $id_propietario=$publicacion->id_propietario;
            if(count($contratoarr)>0){
                $id_arrendatario=$contratoarr->id_arrendatario;
            }else{
                 $id_arrendatario=null;
            }


        }else{
            $contrato=ContratoFinalArr::find($request->id_contrato);
            $publicacion=Arrendatario::find($contrato->id_publicacion);
            $id_arrendatario=$publicacion->id_arrendatario;
            $contratopro=DB::table('adm_contratofinal as cf')
            ->join('cap_publicaciones as a',"a.id",'cf.id_publicacion')
            ->whereIn("a.id_estado",[10,11])
            ->first();
            if(count($contratoarr)>0){
                $id_propietario=$contratoarr->id_propietario;
            }else{
                 $id_propietario=null;
            }
        }

       $postventa=PostVenta::create([
            'id_modulo' => $request->modulo,
            'id_contrato' => $request->id_contrato,
            'id_inmueble' => $publicacion->id_inmueble,
            'id_propietario' => $id_propietario,
            'id_arrendatario' => $id_arrendatario,
            'id_creador' => Auth::user()->id,
            'id_asignacion' => $request->asignado,
            'id_estado' => 1,
            'meses_contrato' => $contrato->meses_contrato,
            'fecha_contrato' => $contrato->fecha_firma,
            'id_aval'=> $contrato->id_aval,
            'fecha_solicitud' => $request->fecha_solicitud
       ]);

       return redirect()->route('postventa.edit', [$postventa->id,1]);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\PostVenta  $postVenta
     * @return \Illuminate\Http\Response
     */
    public function show(PostVenta $postVenta)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\PostVenta  $postVenta
     * @return \Illuminate\Http\Response
     */
    public function edit($id,$tab)
    {
       $regiones = Region::pluck('region_nombre', 'region_id');
        $empleados = Persona::where('tipo_cargo', '=', 'Corredor - Externo')
                ->Orwhere('tipo_cargo', '=', 'Empleado')
                ->select(DB::raw('id , CONCAT_WS(" ",nombre,apellido_paterno,apellido_materno) as empleado'))
                ->orderby('empleado',"asc")
                ->get();

        $estados = Mensajes::where('nombre_modulo', '=', 'Post Venta')
                 ->select(DB::raw('id_estado , nombre'))
                ->orderby('nombre',"asc")
                ->get();

         $postventa=PostVenta::find($id);
         if(isset($postventa->id_propietario)){
            $propietario=Persona::find($postventa->id_propietario);
         }else{
            $propietario=null;
         }
         if(isset($postventa->id_arrendatario)){
            $arrendatario=Persona::find($postventa->id_arrendatario);
         }else{
            $arrendatario=null;
         }

        $inmueble=Inmueble::find($postventa->id_inmueble);
        $docs=DocPostVenta::where("id_postventa","=",$id)->get();
        $gestion=GestionPostVenta::where("id_postventa","=",$id)->get();

        $gestion=DB::table('post_gestion as g')
            ->leftjoin('users as a',"a.id",'g.id_gestionador')
            ->select(DB::raw('g.id , a.name as Gestionador, g.tipo_contacto, g.fecha_gestion, g.hora_gestion, g.contacto_con'))
            ->orderBy("g.id","asc")
            ->get();
        $aval=null;
        if(isset($postventa->id_aval)){
            $aval=Persona::find($postventa->id_aval);
        }
        
       return view('postventa.edit',compact('postventa','propietario','arrendatario','inmueble','empleados','estados','regiones','tab','aval','docs','gestion'));
    }

    public function subir_documentos(Request $request,$id){
        if (!isset($request->foto)) {
                    return redirect()->route('postventa.edit', [$id, 6])->with('error', 'Debe seleccionar un documento');
                }
                $path = 'uploads/postventa';
                $archivo = rand() . $request->foto->getClientOriginalName();
                $file = $request->file('foto');
                $file->move($path, $archivo);

                $imagen = DocPostVenta::create([
                            'id_postventa' => $id,
                            'descripcion' => $request->descripcion,
                            'nombre' => $archivo,
                            'ruta' => $path,
                            'id_creador' => $request->id_creador
                ]);
                return redirect()->route('postventa.edit', [$id, 6])->with('status', 'Documento registrado con éxito');
            }

  public function eliminardoc($id, $ids) {
        $imagen = DocPostVenta::find($id);
        File::delete($imagen->ruta . '/' . $imagen->nombre);
        $foto = DocPostVenta::find($id)->delete();

        return redirect()->route('postventa.edit', [$ids, 6])->with('status', 'Foto eliminada con éxito');
    }


  public function creargestion(Request $request) {
        $postventa = PostVenta::find($request->id_solicitud_gestion);

        $gestion= GestionPostVenta::create([
            "id_gestionador" => $request->gestionador,
            "id_postventa" => $request->id_solicitud_gestion,
            "tipo_contacto" => $request->tipo_contacto,
            "contacto_con" => $request->contacto_con,
            "detalle_contacto"=>$request->detalle_contacto,
            "detalle_gestion"=>$request->detalle_gestion,
            "fecha_gestion"=>$request->fecha_gestion,
            "hora_gestion"=>$request->hora_gestion,
            "id_creador"=>Auth::user()->id,
            "id_modificador"=>Auth::user()->id

        ]);


        return redirect()->route('postventa.edit', [$request->id_solicitud_gestion, 7])->with('status', 'Gestión agregada con éxito');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\PostVenta  $postVenta
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PostVenta $postVenta)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\PostVenta  $postVenta
     * @return \Illuminate\Http\Response
     */
    public function destroy(PostVenta $postVenta)
    {
        //
    }
}
