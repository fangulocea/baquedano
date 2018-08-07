<?php

namespace App\Http\Controllers;

use App\SolicitudServicioARR;
use App\ContratoFinalArr;
use App\CatalogoServicios;
use App\DetalleSolicitudServiciosARR;
use App\ContratoBorradorArrendatario;
use App\Arrendatario;
use App\Inmueble;
use App\Persona;
use Barryvdh\DomPDF\Facade as PDF;
use Carbon\Carbon;
use Auth;
use Illuminate\Http\Request;
use DB;
use Yajra\Datatables\Datatables;

class SolicitudServiciosARRController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         return view('solservicios_arr.index');
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
   public function index_ajax()
    {
        $sol = DB::table('post_solicitudserviciosARR as ss')
         ->leftjoin('adm_contratofinalarr as cf',"ss.id_contrato","=","cf.id")
         ->leftjoin('personas as p1', 'ss.id_arrendatario', '=', 'p1.id')
         ->leftjoin('inmuebles as i', 'ss.id_inmueble', '=', 'i.id')
         ->leftjoin('users as p2', 'ss.id_creador', '=', 'p2.id')
         ->leftjoin('users as p3', 'ss.id_modificador', '=', 'p3.id')
         ->leftjoin('users as p4', 'ss.id_autorizador', '=', 'p4.id')
         ->leftjoin('users as p5', 'ss.id_asignacion', '=', 'p4.id')
         ->leftjoin('comunas as o', 'i.id_comuna', '=', 'o.comuna_id')
        ->leftjoin('mensajes as m', function($join){
                 $join->on('m.nombre_modulo', '=',DB::raw("'Solicitud Servicio'"));
                 $join->on('m.id_estado', '=', 'ss.id_estado');
            })
         ->select(DB::raw('ss.id as id_solicitud, 
                            DATE_FORMAT(ss.created_at, "%d/%m/%Y") as FechaCreacion, 
                            m.nombre as Estado,
                            CONCAT_WS(" ",p1.nombre,p1.apellido_paterno,p1.apellido_materno) as Arrendatario, 
                            p2.name as Creador,
                            p3.name as Modificador,
                            p4.name as Autorizador,
                            p5.name as Asignado,
                            CONCAT_WS(" ",i.direccion,i.numero," Dpto ",i.departamento) as Direccion,
                            o.comuna_nombre as Comuna,
                            ss.fecha_autorizacion,
                            p1.email,
                            p1.telefono,
                            ss.fecha_uf,
                            ss.valor_uf,
                            (select sum(subtotal_uf) from post_detallesolservicios as ds where ds.id_solicitud=ss.id) as valor_en_uf,
                            (select sum(subtotal_pesos) from post_detallesolservicios as ds where ds.id_solicitud=ss.id) as valor_en_pesos'))
         ->get();

          return Datatables::of($sol)
         ->addColumn('action', function ($sol) {
                               return  '<a href="/arrsolservicio/'.$sol->id_solicitud.'/edit"><span class="btn btn-warning btn-circle btn-sm">E</span></a>
                               <a href="/arrsolservicio/'.$sol->id_solicitud.'/comprobante"><span class="btn btn-success btn-circle btn-sm">C</span></a>
                                    <a href="/arrsolservicio/'.$sol->id_solicitud.'/destroy"><span class="btn btn-danger btn-circle btn-sm">B</span></a>';
        })
        ->addColumn('id_link', function ($sol) {
                               return  '<a href="/arrsolservicio/'.$sol->id_solicitud.'/edit"><span class="btn btn-success btn-sm"> '.$sol->id_solicitud.'</span> </a>';
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
       
         return view('solservicios_arr.create');
    }

        /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function create_ajax(){
        $publica = DB::table('adm_contratofinalarr as co')
                ->leftjoin('contratoborradorarrendatarios as cb', 'co.id_borrador', '=', 'cb.id')
                ->leftjoin('inmuebles as i', 'cb.id_inmueble', '=', 'i.id')
                ->leftjoin('comunas as o', 'i.id_comuna', '=', 'o.comuna_id')
                ->leftjoin('arrendatarios as c', 'c.id', '=', 'co.id_publicacion')
                ->leftjoin('personas as p1', 'c.id_arrendatario', '=', 'p1.id')
                ->leftjoin('users as p2', 'c.id_creador', '=', 'p2.id')
                ->leftjoin('users as p3', 'c.id_modificador', '=', 'p3.id')
                ->leftjoin('mensajes as m', function($join){
                 $join->on('m.nombre_modulo', '=',DB::raw("'Captación'"));
                 $join->on('m.id_estado', '=', 'c.id_estado');
            })
                ->whereIn('c.id_estado', [7, 10, 11])
         ->select(DB::raw('co.id as id_contrato, 
                            DATE_FORMAT(co.created_at, "%d/%m/%Y") as FechaCreacion, 
                            m.nombre as Estado,
                            CONCAT_WS(" ",p1.nombre,p1.apellido_paterno,p1.apellido_materno) as Arrendatario, 
                            p2.name as Creador,
                            p3.name as Modificador,
                            CONCAT_WS(" ",i.direccion,i.numero," Dpto ",i.departamento) as Direccion,
                            o.comuna_nombre as Comuna,
                            p1.email,
                            p1.telefono'))
                ->get();

          return Datatables::of($publica)
         ->addColumn('action', function ($publica) {
                               return  '<a href="/arrsolservicio/'.$publica->id_contrato.'/create"><span class="btn btn-success  btn-sm">Crear Solicitud</span></a>
                                    ';
        })
        ->addColumn('id_link', function ($publica) {
                               return  '<a href="/arrsolservicio/'.$publica->id_contrato.'/create"><span class="btn btn-success btn-sm"> '.$publica->id_contrato.'</span> </a>';
        })
        ->rawColumns(['id_link','action'])
        ->make(true);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create_solicitud($idcontrato)
    {
           $uf = DB::table('adm_uf')
                ->where("fecha", "=", Carbon::now()->format('Y/m/d'))
                ->first();
        $servicio = CatalogoServicios::all()->where('id_estado','<>','0');
        $contratofinal=ContratoFinalArr::find($idcontrato);
        $borrador=ContratoBorradorArrendatario::find($contratofinal->id_borrador);
        $captacion=Arrendatario::find($borrador->id_cap_arr);
        $nuevo_servicio=SolicitudServicioARR::create([
            "id_contrato"=>$idcontrato,
            "id_inmueble"=>$captacion->id_inmueble,
            "id_arrendatario"=>$captacion->id_arrendatario,
            "id_creador"=>Auth::user()->id,
            "id_modificador"=>Auth::user()->id,
            "fecha_uf"=>Carbon::now()->format('Y/m/d'),
            "valor_uf"=>$uf->valor,
            "valor_en_uf"=>0,
            "valor_en_pesos"=>0,
            "id_estado"=>1
        ]);
        $totaluf=0;
        $totalpesos=0;
         return view('solservicios_arr.create_servicio',compact('servicio','idcontrato','nuevo_servicio','uf','totaluf','totalpesos'));
    }


    public function datos_servicio($id){
        $servicio = CatalogoServicios::find($id);
        return response()->json($servicio);
    }

    public function detalle_servicio_ajax($id){

        $servicio =  DB::table('post_detallesolserviciosarr as ds')
                ->leftjoin('post_catalogoservicios as cs', 'ds.id_servicio', '=', 'cs.id')
                ->where("ds.id_solicitud","=",$id)
                ->select(DB::raw('ds.id,
                    ds.valor_en_uf,
                    ds.valor_en_pesos,
                    ds.cantidad,
                    ds.subtotal_uf,
                    ds.subtotal_pesos,
                    cs.nombre_servicio,
                    cs.detalle,
                ds.ruta,ds.nombre'))
                ->get();

       

        return Datatables::of($servicio)
         ->addColumn('action', function ($servicio) {
            $boton="";
            if(isset($servicio->ruta)){
                $boton='<a href="/'.$servicio->ruta.'/'.$servicio->nombre.'" target="_blank"> <span class="btn btn-success btn-circle btn-sm">D</span></a>';
            }
                               return  $boton.' <a href="/arrsolservicio/borrar/'.$servicio->id.'"><span class="btn btn-danger btn-circle btn-sm"><i class="ti-pencil-alt"></i></span></a>
                                    ';
        })
        ->rawColumns(['action'])
        ->make(true);
    }


    public function borrar_detalleservicio($id){

       $detalle= DetalleSolicitudServiciosARR::find($id);
       $borrar= DetalleSolicitudServiciosARR::find($id)->delete();

        return redirect()->route('arrsolservicio.edit',$detalle->id_solicitud )
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
                   $destinationPath = 'uploads/detallesolservicioarr';
                    $archivo = rand() . $request->foto->getClientOriginalName();
                    $file = $request->file('foto');
                    $file->move($destinationPath, $archivo);
        }
        $uf = DB::table('adm_uf')
                ->where("fecha", "=", Carbon::now()->format('Y/m/d'))
                ->first();

        if($request->moneda=="UF"){
            $subtotaluf=$request->valor_en_moneda*$request->cantidad;
             $subtotalpesos=($uf->valor*$request->valor_en_moneda)*$request->cantidad;
             $valorenuf=$request->valor_en_moneda;
             $valorenpesos=$request->valor_en_moneda*$uf->valor;
        }else{
            $subtotaluf=($request->valor_en_moneda/$uf->valor)*$request->cantidad;
            $subtotalpesos=$request->valor_en_moneda*$request->cantidad;
             $valorenuf=$request->valor_en_moneda/$uf->valor;
             $valorenpesos=$request->valor_en_moneda;
        }
        $detalle=DetalleSolicitudServiciosARR::create([
            "id_solicitud"  => $request->id_solicitud ,
            "id_contrato"  =>  $request->id_contrato,
            "id_inmueble"  =>  $request->id_inmueble,
            "id_arrendatario"  =>  $request->id_arrendatario,
            "id_creador"  =>  Auth::user()->id,
            "id_servicio"  =>  $request->servicio,
            "fecha_uf"  =>  Carbon::now()->format('Y/m/d'),
            "valor_uf"  =>  $uf->valor,
            "valor_en_uf"  => $valorenuf ,
            "valor_en_pesos"  =>  $valorenpesos,
            "cantidad"  =>  $request->cantidad,
            "subtotal_uf"  =>  $subtotaluf,
            "subtotal_pesos"  =>  $subtotalpesos,
            "nombre"  =>  $archivo,
            "ruta"  =>  $destinationPath,
            "id_estado"  => 1 
        ]);

        $edit=SolicitudServicioARR::find($request->id_solicitud)->update(["id_estado"=>2]);

        return redirect()->route('arrsolservicio.edit',$request->id_solicitud )
            ->with('status', 'Detalle ingresado con éxito');  

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
    public function edit($idsolicitud)
    {
          $uf = DB::table('adm_uf')
                ->where("fecha", "=", Carbon::now()->format('Y/m/d'))
                ->first();
        $nuevo_servicio=SolicitudServicioArr::find($idsolicitud);
        $servicio = CatalogoServicios::all()->where('id_estado','<>','0');
        $contratofinal=ContratoFinalARR::find($nuevo_servicio->id_contrato);
        $borrador=ContratoBorradorArrendatario::find($contratofinal->id_borrador);
        $captacion=Arrendatario::find($borrador->id_cap_arr);
        $idcontrato=$nuevo_servicio->id_contrato;

        $totaluf= DetalleSolicitudServiciosARR::where("id_solicitud","=",$idsolicitud)->sum('subtotal_uf');
        $totalpesos=DetalleSolicitudServiciosARR::where("id_solicitud","=",$idsolicitud)->sum('subtotal_pesos');
         return view('solservicios_arr.create_servicio',compact('servicio','idcontrato','nuevo_servicio','uf','totaluf','totalpesos'));
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
        $edit=DetalleSolicitudServiciosARR::where("id_solicitud","=",$id)->count();

        if($edit<1){
            $edit=SolicitudServicioArr::find($id)->delete();
            return redirect()->route('arrsolservicio.index' )
            ->with('status', 'Solicitud eliminada con éxito');  
        }else{
            return redirect()->route('arrsolservicio.edit',$id )
            ->with('error', 'No es posible eliminar solicitud, ya que tiene detalles ingresados');  
         }
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

        $servicio=SolicitudServicioArr::find($id);
        $contratofinal=ContratoFinalARR::find($servicio->id_contrato);
        $borrador=ContratoBorradorArrendatario::find($contratofinal->id_borrador);
        $publicacion=Arrendatario::find($borrador->id_cap_arr);
        $idcontrato=$servicio->id_contrato;
        $inmueble=Inmueble::find($publicacion->id_inmueble);
        $persona=Persona::find($publicacion->id_arrendatario);

        $totaluf= DetalleSolicitudServiciosARR::where("id_solicitud","=",$id)->sum('subtotal_uf');
        $totalpesos=DetalleSolicitudServiciosARR::where("id_solicitud","=",$id)->sum('subtotal_pesos');

 $detalle =  DB::table('post_detallesolserviciosARR as ds')
                ->leftjoin('post_catalogoservicios as cs', 'ds.id_servicio', '=', 'cs.id')
                ->where("ds.id_solicitud","=",$id)
                ->select(DB::raw('ds.id,
                    ds.valor_en_uf,
                    ds.valor_en_pesos,
                    ds.cantidad,
                    ds.subtotal_uf,
                    ds.subtotal_pesos,
                    cs.nombre_servicio,
                    cs.detalle'))
                ->get();
$firma="ARRENDATARIO";

        $pdf = PDF::loadView('formatospdf.solicitudpropietario', compact('servicio', 'persona', 'inmueble', 'uf','totaluf','totalpesos','detalle','firma'));

        return $pdf->download($inmueble->direccion . ' Nro.' . $inmueble->numero . ' Dpto.' . $inmueble->departamento . ', ' . $inmueble->comuna_nombre . ' - Solicitud ' .$servicio->id. ' - Comprobante Solicitud de Servicios.pdf');
    }
}
