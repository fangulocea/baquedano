<?php

namespace App\Http\Controllers;

use App\PostVenta;
use Illuminate\Http\Request;
use App\Persona;
use App\Inmueble;
use App\Mensajes;
use App\ContratoFinal;
use App\Captacion;
use App\Region;
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
        $tab=2;
        $aval=null;
        if(isset($postventa->id_aval)){
            $aval=Persona::find($postventa->id_aval);
        }
        
       return view('postventa.edit',compact('postventa','propietario','arrendatario','inmueble','empleados','estados','regiones','tab','aval'));
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
