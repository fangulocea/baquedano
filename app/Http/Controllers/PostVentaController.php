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
use App\ContratoFinalArr;
use App\Arrendatario;
use App\FamiliaMateriales;
use App\PresupuestoPostVenta;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\File;
use DB;
use Auth;
use Carbon\Carbon;
use App\ContratoBorrador;
use App\SolicitudServicio;
use App\DetallePresupuestoPostVenta;
use App\DetalleSolicitudServicio;
use App\ContratoBorradorArrendatario;
use App\SolicitudServicioArr;
use App\DetalleSolicitudServiciosARR;

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

    public function index_ajax(Request $request)
    {
        
        $postventa = DB::table('post_venta as p')
        ->leftjoin('inmuebles as i', 'i.id', '=', 'p.id_inmueble')
        ->leftjoin('comunas as c', 'i.id_comuna', '=', 'c.comuna_id')
        ->leftjoin('users as u', 'p.id_asignacion', '=', 'u.id')
        ->leftjoin('mensajes as m', function($join){
                 $join->on('m.nombre_modulo', '=',DB::raw("'Post Venta'"));
                 $join->on('m.id_estado', '=', 'p.id_estado');
            })
            ->select(DB::raw("p.id,CONCAT_WS(' ',i.direccion,i.numero,i.departamento,c.comuna_nombre) as direccion,i.numero,i.departamento,c.comuna_nombre as comuna, i.direccion as calle, m.nombre as estado, u.name as asignacion, p.updated_at as ultima_modificacion, p.created_at as fecha_creacion, 
                CASE p.id_modulo when 1 then 'CONTRATO PROPIETARIO' when 2 then 'CONTRATO ARRENDATARIO' end as tipo_contrato"))
            ->orderby("p.id_estado","asc")
            ->get();

            return Datatables::of($postventa)
         ->addColumn('action', function ($postventa) {
                               return  '<a href="/postventa/'.$postventa->id.'/1/edit"><span class="btn btn-warning btn-circle btn-sm"><i class="ti-pencil-alt"></i></span></a>';
        })
        ->addColumn('id_link', function ($postventa) {
                               return  '<a href="/postventa/'.$postventa->id.'/1/edit"><span class="btn btn-success btn-sm"> '.$postventa->id.'</span> </a>';
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
        $idaval=null;
        if($request->modulo=='1'){
            $contrato=ContratoFinal::find($request->id_contrato);
            $publicacion=Captacion::find($contrato->id_publicacion);
            $contratoarr=DB::table('adm_contratofinalarr as cf')
            ->join('arrendatarios as a',"a.id",'cf.id_publicacion')
            ->where('a.id_inmueble','=',$publicacion->id_inmueble)
            ->whereIn("a.id_estado",[10,11])
            ->first();
            $id_propietario=$publicacion->id_propietario;
            if(count($contratoarr)>0){
                $id_arrendatario=$contratoarr->id_arrendatario;
                $idaval=$contratoarr->id_aval;
            }else{
                 $id_arrendatario=null;
            }


        }else{
            $contrato=ContratoFinalArr::find($request->id_contrato);
            $publicacion=Arrendatario::find($contrato->id_publicacion);
            $id_arrendatario=$publicacion->id_arrendatario;
            $contratopro=DB::table('adm_contratofinal as cf')
            ->join('cap_publicaciones as a',"a.id",'cf.id_publicacion')
            ->where('a.id_inmueble','=',$publicacion->id_inmueble)
            ->whereIn("a.id_estado",[10,11])
            ->first();
             $idaval=$contrato->id_aval;
            if(count($contratopro)>0){
                $id_propietario=$contratopro->id_propietario;
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
            'id_aval'=> $idaval,
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
            ->where("g.id_postventa","=",$id)
            ->select(DB::raw('g.id , a.name as Gestionador, g.tipo_contacto, g.fecha_gestion, g.hora_gestion, g.contacto_con'))
            ->orderBy("g.id","asc")
            ->get();

        $presupuestos=DB::table('post_presupuesto as g')
            ->leftjoin('users as a',"a.id",'g.id_creador')
            ->leftjoin('mensajes as m', function($join){
                 $join->on('m.nombre_modulo', '=',DB::raw("'Presupuesto'"));
                 $join->on('m.id_estado', '=', 'g.id_estado');
            })
           ->where("g.id_postventa","=",$id)
            ->select(DB::raw('g.id , a.name as Creador, g.responsable_pago, g.id_responsable_pago, g.total, g.created_at, m.nombre as estado'))
            ->orderBy("g.id","asc")
            ->get();
        $aval=null;
        if(isset($postventa->id_aval)){
            $aval=Persona::find($postventa->id_aval);
        }

        $idclientes=DB::table('post_idcliente as i')
            ->leftjoin('post_empresasservicios as e',"i.id_empresaservicio",'e.id')
            ->where("i.id_inmueble","=",$postventa->id_inmueble)
            ->select(DB::raw('i.id , e.nombre, e.descripcion, i.idcliente'))->get();
        
       return view('postventa.edit',compact('postventa','propietario','arrendatario','inmueble','empleados','estados','regiones','tab','aval','docs','gestion','presupuestos','idclientes'));
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



  public function updategestion(Request $request) {

        $gestion= GestionPostVenta::find($request->id_gestion)->update([
            "id_gestionador" => $request->gestionador,
            "id_postventa" => $request->id_solicitud_gestion,
            "tipo_contacto" => $request->tipo_contacto,
            "contacto_con" => $request->contacto_con,
            "detalle_contacto"=>$request->detalle_contacto,
            "detalle_gestion"=>$request->detalle_gestion,
            "fecha_gestion"=>$request->fecha_gestion,
            "hora_gestion"=>$request->hora_gestion,
            "id_modificador"=>Auth::user()->id

        ]);


        return redirect()->route('postventa.edit', [$request->id_solicitud_gestion, 7])->with('status', 'Gestión agregada con éxito');
    }

  public function eliminargestion($id) {

        $gestion= GestionPostVenta::find($id);
        $del= GestionPostVenta::find($id)->delete();

        return redirect()->route('postventa.edit', [$gestion->id_postventa, 7])->with('status', 'Gestión agregada con éxito');
    }


      public function mostrargestion($id) {

        $gestion= GestionPostVenta::find($id);

            return response()->json($gestion);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\PostVenta  $postVenta
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
          $postventa=PostVenta::find($id)->update([
            'id_modificador' => Auth::user()->id,
            'id_asignacion' => $request->asignado,
            'id_estado' => $request->estado,
            'fecha_solicitud' => $request->fecha_solicitud,
            'nombre_caso' => $request->nombre_caso,
            'descripcion_del_caso' => $request->descripcion_del_caso,
            'id_cobro' => $request->id_cobro
       ]);
           return redirect()->route('postventa.edit', [$id, 1])->with('status', 'Post Atención actualizada con éxito');

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

 public function generarsolp($id,$idp) {
       $uf = DB::table('adm_uf')
                  ->where("fecha", "=", Carbon::now()->format('Y/m/d'))
                  ->first();
        if (count($uf) == 0) {
            return back()->with('error', 'No hay UF registrada para el día de hoy');
        }

          $contratofinal = ContratoFinal::find($id);
          $borrador = ContratoBorrador::find($contratofinal->id_borrador);
          $captacion = Captacion::find($borrador->id_publicacion);
          $nuevo_servicio = SolicitudServicio::create([
                      "id_contrato" => $id,
                      "id_inmueble" => $captacion->id_inmueble,
                      "id_propietario" => $captacion->id_propietario,
                      "id_creador" => Auth::user()->id,
                      "id_modificador" => Auth::user()->id,
                      "fecha_uf" => Carbon::now()->format('Y/m/d'),
                      "detalle" => "Pago  por concepto de presupuesto Limpieza y Reparaciones",
                      "valor_uf" => $uf->valor,
                      "valor_en_uf" => 0,
                      "valor_en_pesos" => 0,
                      "id_estado" => 1
          ]);
          $totaluf = 0;
          $totalpesos = 0;

            $proc_propietario=DetallePresupuestoPostVenta::where("id_presupuesto","=",$idp)->sum("subtotal");



          $subtotaluf = ($proc_propietario / $uf->valor) * 1;
            $subtotalpesos = $proc_propietario * 1;
            $valorenuf = $proc_propietario / $uf->valor;
            $valorenpesos = $proc_propietario;
        
        $detalle = DetalleSolicitudServicio::create([
                    "id_solicitud" => $nuevo_servicio->id,
                    "id_contrato" => $id,
                    "id_inmueble" => $captacion->id_inmueble,
                    "id_propietario" => $captacion->id_propietario,
                    "id_creador" => Auth::user()->id,
                    "id_servicio" => 3,
                    "fecha_uf" => Carbon::now()->format('Y/m/d'),
                    "valor_uf" => $uf->valor,
                    "valor_en_uf" => $valorenuf,
                    "valor_en_pesos" => $valorenpesos,
                    "cantidad" => 1,
                    "subtotal_uf" => $subtotaluf,
                    "subtotal_pesos" => $subtotalpesos,
                    "nombre" => null,
                    "ruta" => null,
                    "id_estado" => 1
        ]);

        $presu=PresupuestoPostVenta::find($idp);
        $editp = PostVenta::find($presu->id_postventa)->update(["id_solicitud" => $nuevo_servicio->id, "id_estado"  => 6]);
        $edit = SolicitudServicio::find($nuevo_servicio->id)->update(["id_estado" => 2]);
        $editp = PresupuestoPostVenta::find($idp)->update(["id_solicitud" => $nuevo_servicio->id, "id_estado"  => 4]);

        return redirect()->route('solservicio.edit', $nuevo_servicio->id)
                        ->with('status', 'Solicitud ingresado con éxito');
    }



     public function generarsola($id,$idp) {
      $uf = DB::table('adm_uf')
                  ->where("fecha", "=", Carbon::now()->format('Y/m/d'))
                  ->first();
        if (count($uf) == 0) {
            return back()->with('error', 'No hay UF registrada para el día de hoy');
        }

          $contratofinalarr = ContratoFinalARR::find($id);


          $borrador = ContratoBorradorArrendatario::find($contratofinalarr->id_borrador);
          $captacion = Arrendatario::find($contratofinalarr->id_publicacion);
          $nuevo_servicio = SolicitudServicioArr::create([
                      "id_contrato" => $contratofinalarr->id,
                      "id_inmueble" => $captacion->id_inmueble,
                      "id_arrendatario" => $captacion->id_arrendatario,
                      "id_creador" => Auth::user()->id,
                      "id_modificador" => Auth::user()->id,
                      "fecha_uf" => Carbon::now()->format('Y/m/d'),
                      "valor_uf" => $uf->valor,
                      "detalle" => "Pago  por concepto de presupuesto Limpieza y Reparaciones",
                      "valor_en_uf" => 0,
                      "valor_en_pesos" => 0,
                      "id_estado" => 1
          ]);
          $totaluf = 0;
          $totalpesos = 0;

            $proc_arrendatario=DetallePresupuestoPostVenta::where("id_presupuesto","=",$idp)->sum("subtotal");



          $subtotaluf = ($proc_arrendatario / $uf->valor) * 1;
            $subtotalpesos = $proc_arrendatario * 1;
            $valorenuf = $proc_arrendatario / $uf->valor;
            $valorenpesos = $proc_arrendatario;
        
        $detalle = DetalleSolicitudServiciosARR::create([
                    "id_solicitud" => $nuevo_servicio->id,
                    "id_contrato" => $id,
                    "id_inmueble" => $captacion->id_inmueble,
                    "id_arrendatario" => $captacion->id_arrendatario,
                    "id_creador" => Auth::user()->id,
                    "id_servicio" => 4,
                    "fecha_uf" => Carbon::now()->format('Y/m/d'),
                    "valor_uf" => $uf->valor,
                    "valor_en_uf" => $valorenuf,
                    "valor_en_pesos" => $valorenpesos,
                    "cantidad" => 1,
                    "subtotal_uf" => $subtotaluf,
                    "subtotal_pesos" => $subtotalpesos,
                    "nombre" => null,
                    "ruta" => null,
                    "id_estado" => 1
        ]);
        $presu=PresupuestoPostVenta::find($idp);
        $editp = PostVenta::find($presu->id_postventa)->update(["id_solicitud" => $nuevo_servicio->id, "id_estado"  => 6]);
        $edit = SolicitudServicioArr::find($nuevo_servicio->id)->update(["id_estado" => 2]);
        
        $editp = PresupuestoPostVenta::find($idp)->update(["id_solicitud" => $nuevo_servicio->id, "id_estado"  => 4]);

        return redirect()->route('arrsolservicio.edit', $nuevo_servicio->id)
                        ->with('status', 'Solicitud ingresado con éxito');
    }
}
