<?php

namespace App\Http\Controllers;

use App\CuentasArrendatario;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade as PDF;
use Yajra\Datatables\Datatables;
use Carbon\Carbon;
use App\EmpresasServicios;
use App\ContratoFinalArr;
use App\ContratoFinal;
use App\ContratoBorradorArrendatario;
use App\DetalleCuentasArrendatario;
use App\Arrendatario;
use App\Captacion;
use App\Inmueble;
use App\AsignaRevision;
use App\Persona;
use App\Comuna;
use App\IDClienteInmueble;
use App\DetalleCuentas;
use App\ContratoBorrador;
use App\SolicitudServicio;
use App\DetalleSolicitudServicio;
use App\SolicitudServicioArr;
use App\DetalleSolicitudServiciosARR;
use DB;
use Auth;


class CuentasArrendatarioController extends Controller
{
    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       
         return view('revisioncuentas.index');
    }

        /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index_ajax(){
        $publica = CuentasArrendatario::index_ajax();

          return Datatables::of($publica)
         ->addColumn('action', function ($publica) {
                               return  '<a href="/revisioncuentas/'.$publica->id_contrato.'/revisar"><span class="btn btn-success  btn-sm">Revisar Cuentas</span></a>
                                    ';
        })
        ->addColumn('opciones', function ($publica) {
                               return  '<a href="/revisioncuentas/'.$publica->id_contrato.'/pagado"><span class="btn btn-warning btn-circle btn-sm">P</span></a>
                                        <a href="/revisioncuentas/'.$publica->id_contrato.'/moroso"><span class="btn btn-danger btn-circle btn-sm">M</span></a>
                               <a href="/revisioncuentas/'.$publica->id_contrato.'/comprobante"><span class="btn btn-success btn-circle btn-sm">C</span></a>';

        })
        ->addColumn('id_link', function ($publica) {
                               return  '<a href="/revisioncuentas/'.$publica->id_contrato.'/revisar"><span class="btn btn-success btn-sm"> '.$publica->id_contrato.'</span> </a>';
        })
        ->rawColumns(['id_link','action','opciones'])
        ->make(true);
    }


  public function create($id){
        $uf = DB::table('adm_uf')
                ->where("fecha", "=", Carbon::now()->format('Y/m/d'))
                ->first();
        $servicio = EmpresasServicios::all()->where('id_estado','<>','0');

        $contratofinal=ContratoFinal::find($id);

        $captacion=Captacion::find($contratofinal->id_publicacion);
        $captacionarr=Arrendatario::where("id_inmueble","=",$captacion->id_inmueble)
        ->whereIn("id_estado",[6,10,11])->get();


        $cap_arr=null;
        $contratofinalarr=null;
        foreach ($captacionarr as $k) {
            $contratofinalarr=ContratoFinalArr::where("id_publicacion","=",$k->id)->wherein("id_estado",[7])->get();
            if(count($contratofinalarr)>0){
                $cap_arr=$k;
                break;
            }
        }
                
        $proc_propietario=DetalleCuentas::where("solicitudpago","=","SI")
        ->where("procesado","=",0)
        ->where("id_contrato","=",$id)
        ->where("responsable","=","Propietario")->sum("monto_responsable");

        $proc_arrendatario=DetalleCuentas::where("solicitudpago","=","SI")
        ->where("id_contrato","=",$id)
        ->where("procesado","=",0)->where("responsable","=","Arrendatario")->sum("monto_responsable");
        
        $inmueble=Inmueble::find($captacion->id_inmueble);
        $comuna=Comuna::where("comuna_id","=",$inmueble->id_comuna);
        $propietario=Persona::find($captacion->id_propietario);
        $arrendatario=null;
        if(count($contratofinalarr)>0){
            $arrendatario=Persona::find($cap_arr->id_arrendatario);
        }
        
        $idcontrato=$id;
         return view('revisioncuentas.create',compact('servicio','idcontrato','uf','captacion','inmueble','propietario','arrendatario','comuna','contratofinal','proc_propietario','proc_arrendatario'));
    }

    public function datos_servicio($id){
        $servicio = CatalogoServicios::find($id);
        return response()->json($servicio);
    }

    public function detalle_servicio_ajax($id){


        $servicio =  DB::table('post_detallecuentas as ds')
                ->leftjoin('post_empresasservicios as cs', 'ds.id_serviciobasico', '=', 'cs.id')
                 ->leftjoin('mensajes as m', function($join){
                 $join->on('m.nombre_modulo', '=',DB::raw("'Revisión Cuentas'"));
                 $join->on('m.id_estado', '=', 'ds.id_estado');
            })
                ->where("ds.id_contrato","=",$id)
                ->select(DB::raw('ds.id,
                    ds.monto_boleta,
                    ds.monto_responsable,
                    ds.responsable,
                    ds.solicitudpago,
                    CASE WHEN ds.solicitudpago = "SI" AND procesado = 0 THEN "NO" WHEN ds.solicitudpago = "SI" AND procesado = 1 THEN "NO" ELSE "N/A" end procesado,
                    ds.mes,
                    ds.anio,
                    cs.nombre as nombreempresa,
                    ds.fecha_vencimiento,
                    cs.descripcion as detalle,
                    ds.ruta,
                    ds.nombre'))
                ->get();

        return Datatables::of($servicio)
         ->addColumn('action', function ($servicio) {
            $boton="";
            if(isset($servicio->ruta)){
                $boton='<a href="/'.$servicio->ruta.'/'.$servicio->nombre.'" target="_blank"> <span class="btn btn-success btn-circle btn-sm">DOC</span></a>';
            }
                               return  $boton.' <a href="/revisioncuentas/borrar/'.$servicio->id.'"><span class="btn btn-danger btn-circle btn-sm"><i class="ti-trash"></i></span></a>
                                    ';
        })
        ->rawColumns(['action'])
        ->make(true);
    }


    public function borrar_detalleservicio($id){

       $detalle= DetalleCuentas::find($id);
       $borrar= DetalleCuentas::find($id)->delete();

        return redirect()->route('revisioncuentas.create',$detalle->id_contrato )
            ->with('status', 'Detalle borrado con éxito');  

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $destinationPath="";
        $archivo="";
        if (isset($request->foto)) {
                   $destinationPath = 'uploads/revisioncuentas';
                    $archivo = rand() . $request->foto->getClientOriginalName();
                    $file = $request->file('foto');
                    $file->move($destinationPath, $archivo);
        }
        $uf = DB::table('adm_uf')
                ->where("fecha", "=", Carbon::now()->format('Y/m/d'))
                ->first();

        $item=IDClienteInmueble::where("id_inmueble","=",$request->id_inmueble)
        ->where("id_empresaservicio","=",$request->servicio)
        ->first();
        if(count($item)==0){
            $item=IDClienteInmueble::create([
                "id_inmueble"=>$request->id_inmueble,
                "id_empresaservicio"=>$request->servicio,
                "idcliente"=>$request->idcliente,
                "id_creador" =>Auth::user()->id,
                "id_modificador" =>Auth::user()->id
            ])->first();
        }else{
             $update=IDClienteInmueble::where("id_inmueble","=",$request->id_inmueble)
             ->where("id_empresaservicio","=",$request->servicio)
                ->update([
                    "idcliente"=>$request->idcliente
                ]);
        }


        $detalle=DetalleCuentas::create([
            "id_contrato"  =>  $request->id_contrato,
            "id_inmueble"  =>  $request->id_inmueble,
            "id_arrendatario"  =>  $request->id_arrendatario,
            "id_propietario"  =>  $request->id_propietario,
            "fecha_vencimiento"  =>  $request->fecha_vencimiento,
            "fecha_contrato"  =>  $request->fecha_contrato,
            "fecha_iniciolectura"  =>  $request->inicio_lectura,
            "fecha_finlectura"  =>  $request->fin_lectura,
            "id_creador"  =>  Auth::user()->id,
            "id_serviciobasico"  =>  $request->servicio,
            "id_idcliente" => $item->id,
            "idcliente" => $request->idcliente,
            "monto_boleta"  =>  $request->monto_boleta,
            "monto_responsable"  =>  $request->monto_responsable,
            "valor_medicion" => $request->valor_medicion,
            "solicitudpago"=>$request->itempago,
            "responsable"=>$request->responsable,
            "mes"  =>  $request->mes,
            "anio"  =>  $request->anio,
            "diasproporcionales" => $request->dias_proporcionales,
            "nombre"  =>  $archivo,
            "ruta"  =>  $destinationPath,
            "procesado"  =>  0 ,
            "id_estado"  => 1 
        ]);



 return redirect()->route('revisioncuentas.create',$request->id_contrato)
            ->with('status', 'Revisión Guardada con Exito');  

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\SolicitudServicio  $solicitudServicio
     * @return \Illuminate\Http\Response
     */
    public function show(SolicitudServicio $solicitudServicio)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\SolicitudServicio  $solicitudServicio
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
  $uf = DB::table('adm_uf')
                ->where("fecha", "=", Carbon::now()->format('Y/m/d'))
                ->first();
        $servicio = EmpresasServicios::all()->where('id_estado','<>','0');
        $contratofinal=ContratoFinalArr::find($id);
        $borrador=ContratoBorradorArrendatario::find($contratofinal->id_borrador);
        $captacion=Arrendatario::find($borrador->id_cap_arr);
        $inmueble=Inmueble::find($captacion->id_inmueble);
        $persona=Persona::find($captacion->id_arrendatario);
        $idcontrato=$id;

          return view('revisioncuentas.create',compact('servicio','idcontrato','uf','captacion','inmueble','persona'));
    }



    public function pagado($id)
    {

        $asigna=AsignaRevision::create([
            "id_contrato" => $id,
            "id_asignado" => Auth::user()->id,
            "id_estado" => 2
        ]);

        return view('revisioncuentas.index');
    }


    public function moroso($id)
    {
 
        $asigna=AsignaRevision::create([
            "id_contrato" => $id,
            "id_asignado" => Auth::user()->id,
            "id_estado" => 3
        ]);

          return view('revisioncuentas.index');
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\SolicitudServicio  $solicitudServicio
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SolicitudServicio $solicitudServicio)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\SolicitudServicio  $solicitudServicio
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
       
    }

     public function comprobantesolicitud($id) {
        $meses = array("", "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
        $uf = DB::table('adm_uf')
                ->where("fecha", "=", Carbon::now()->format('Y/m/d'))
                ->first();
        if (count($uf) == 0) {
            return back()->with('error', 'No hay UF registrada para el día de hoy');
        }


          $uf = DB::table('adm_uf')
                ->where("fecha", "=", Carbon::now()->format('Y/m/d'))
                ->first();

        $contratofinal=ContratoFinalArr::find($id);
        $borrador=ContratoBorradorArrendatario::find($contratofinal->id_borrador);
        $publicacion=Arrendatario::find($borrador->id_cap_arr);
        $idcontrato=$id;
        $inmueble=Inmueble::find($publicacion->id_inmueble);
        $persona=Persona::find($publicacion->id_arrendatario);


     $detalle =  DB::table('post_detallecuentasarr as ds')
                ->leftjoin('post_empresasservicios as cs', 'ds.id_serviciobasico', '=', 'cs.id')
                 ->leftjoin('mensajes as m', function($join){
                 $join->on('m.nombre_modulo', '=',DB::raw("'Revisión Cuentas'"));
                 $join->on('m.id_estado', '=', 'ds.id_estado');
            })
                ->where("ds.id_contrato","=",$id)
                ->select(DB::raw('ds.id,
                    ds.valor_en_pesos,
                    ds.mes,
                    ds.anio,
                    m.nombre as estado,
                    cs.nombre as nombreempresa,
                    ds.fecha_vencimiento,
                    cs.descripcion as detalle,
                    ds.ruta,
                    ds.nombre'))
                ->orderby("ds.mes","asc")
                ->orderby("ds.anio","asc")
                ->get();
$firma="ARRENDATARIO";

        $pdf = PDF::loadView('formatospdf.revisioncuentas', compact('servicio', 'persona', 'inmueble', 'uf','totaluf','totalpesos','detalle','firma'));

        return $pdf->download($inmueble->direccion . ' Nro.' . $inmueble->numero . ' Dpto.' . $inmueble->departamento . ', ' . $inmueble->comuna_nombre . ' - Comprobante de Revisiones de Pagos de Gastos Básicos.pdf');
    }

    public function generarsolp($id) {
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
                      "detalle" => "Pago proporcional por concepto de servicios Básicos",
                      "valor_uf" => $uf->valor,
                      "valor_en_uf" => 0,
                      "valor_en_pesos" => 0,
                      "id_estado" => 1
          ]);
          $totaluf = 0;
          $totalpesos = 0;

            $proc_propietario=DetalleCuentas::where("solicitudpago","=","SI")
        ->where("procesado","=",0)
        ->where("id_contrato","=",$id)
        ->where("responsable","=","Propietario")->sum("monto_responsable");



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
                    "id_servicio" => 1,
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

        $edit = SolicitudServicio::find($nuevo_servicio->id)->update(["id_estado" => 2]);

        return redirect()->route('solservicio.edit', $nuevo_servicio->id)
                        ->with('status', 'Solicitud ingresado con éxito');
    }

    public function generarsola($id) {
      $uf = DB::table('adm_uf')
                  ->where("fecha", "=", Carbon::now()->format('Y/m/d'))
                  ->first();
        if (count($uf) == 0) {
            return back()->with('error', 'No hay UF registrada para el día de hoy');
        }

          $contratofinalpro = ContratoFinal::find($id);
          $borradorpro = ContratoBorrador::find($contratofinalpro->id_borrador);
          $captacionpro = Captacion::find($borradorpro->id_publicacion);

        $captacionarr=Arrendatario::where("id_inmueble","=",$captacionpro->id_inmueble)
        ->whereIn("id_estado",[6,10,11])->get();

        $cap_arr=null;
        $contratofinalarr=null;
        foreach ($captacionarr as $k) {
            $contratofinalarr=ContratoFinalArr::where("id_publicacion","=",$k->id)->wherein("id_estado",[7])->first();
            if(count($contratofinalarr)>0){
                $cap_arr=$k;
                break;
            }
        }
       
  if (count($contratofinalarr) == 0) {
            return back()->with('error', 'No hay contrato arrendatario vigente');
        }

          $borrador = ContratoBorradorArrendatario::find($contratofinalarr->id_borrador);
          $captacion = Arrendatario::find($cap_arr->id);
          $nuevo_servicio = SolicitudServicioArr::create([
                      "id_contrato" => $contratofinalarr->id,
                      "id_inmueble" => $captacion->id_inmueble,
                      "id_arrendatario" => $captacion->id_arrendatario,
                      "id_creador" => Auth::user()->id,
                      "id_modificador" => Auth::user()->id,
                      "fecha_uf" => Carbon::now()->format('Y/m/d'),
                      "valor_uf" => $uf->valor,
                      "detalle" => "Pago proporcional por concepto de servicios Básicos",
                      "valor_en_uf" => 0,
                      "valor_en_pesos" => 0,
                      "id_estado" => 1
          ]);
          $totaluf = 0;
          $totalpesos = 0;

            $proc_arrendatario=DetalleCuentas::where("solicitudpago","=","SI")
        ->where("procesado","=",0)
        ->where("id_contrato","=",$id)
        ->where("responsable","=","Arrendatario")->sum("monto_responsable");



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
                    "id_servicio" => 2,
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

        $edit = SolicitudServicioArr::find($nuevo_servicio->id)->update(["id_estado" => 2]);

        return redirect()->route('arrsolservicio.edit', $nuevo_servicio->id)
                        ->with('status', 'Solicitud ingresado con éxito');
    }
}
