<?php

namespace App\Http\Controllers;

use App\CuentasArrendatario;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade as PDF;
use Yajra\Datatables\Datatables;
use Carbon\Carbon;
use App\EmpresasServicios;
use App\ContratoFinalARR;
use App\ContratoFinal;
use App\ContratoBorradorArrendatario;
use App\DetalleCuentasArrendatario;
use App\Arrendatario;
use App\Captacion;
use App\Inmueble;
use App\AsignaRevision;
use App\Persona;
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
        $publica = DB::table('adm_contratofinal as co')
                ->leftjoin('cap_publicaciones as cb', 'co.id_publicacion', '=', 'cb.id')
                ->leftjoin('inmuebles as i', 'cb.id_inmueble', '=', 'i.id')
                ->leftjoin('comunas as o', 'i.id_comuna', '=', 'o.comuna_id')
                ->leftjoin('personas as p1', 'cb.id_propietario', '=', 'p1.id')
                ->leftjoin('users as p2', 'cb.id_creador', '=', 'p2.id')
                ->leftjoin('users as p3', 'cb.id_modificador', '=', 'p3.id')
                ->leftjoin('mensajes as m', function($join){
                 $join->on('m.nombre_modulo', '=',DB::raw("'Captación'"));
                 $join->on('m.id_estado', '=', 'cb.id_estado');
            })
                ->whereIn('cb.id_estado', [7])
         ->select(DB::raw('co.id as id_contrato, 
                            DATE_FORMAT(co.created_at, "%d/%m/%Y") as FechaCreacion, 

                            CONCAT_WS(" ",p1.nombre,p1.apellido_paterno,p1.apellido_materno) as Propietario, 
                            p2.name as Creador,
                            p3.name as Modificador,
                            (select name from users where id=(select id_asignado from post_asignarevision where id_contrato=co.id order by 1 desc limit 1)) as Asignado,
                            (select created_at from post_asignarevision where id_contrato=co.id order by 1 desc limit 1) as fecha_revision,
                        (select nombre from mensajes where nombre_modulo="Revisión Cuentas" and id_estado=(select id_estado from post_asignarevision where id_contrato=co.id order by 1 desc limit 1)) as EstadoCuenta,
                            m.nombre as Estado,
                            CONCAT_WS(" ",i.direccion,i.numero," Dpto ",i.departamento) as Direccion,
                            o.comuna_nombre as Comuna,
                            p1.email,
                            p1.telefono'))
                ->get();

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

       // $captacionarr=Arrendatario::where("            ");

        $inmueble=Inmueble::find($captacion->id_inmueble);
        $propietario=Persona::find($captacion->id_propietario);
        $idcontrato=$id;
         return view('revisioncuentas.create',compact('servicio','idcontrato','uf','captacion','inmueble','persona'));
    }

    public function datos_servicio($id){
        $servicio = CatalogoServicios::find($id);
        return response()->json($servicio);
    }

    public function detalle_servicio_ajax($id){


        $servicio =  DB::table('post_detallecuentasarr as ds')
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
                ->get();

        return Datatables::of($servicio)
         ->addColumn('action', function ($servicio) {
            $boton="";
            if(isset($servicio->ruta)){
                $boton='<a href="/'.$servicio->ruta.'/'.$servicio->nombre.'" target="_blank"> <span class="btn btn-success btn-circle btn-sm">D</span></a>';
            }
                               return  $boton.' <a href="/revisioncuentas/borrar/'.$servicio->id.'"><span class="btn btn-danger btn-circle btn-sm"><i class="ti-pencil-alt"></i></span></a>
                                    ';
        })
        ->rawColumns(['action'])
        ->make(true);
    }


    public function borrar_detalleservicio($id){

       $detalle= DetalleCuentasArrendatario::find($id);
       $borrar= DetalleCuentasArrendatario::find($id)->delete();

        return redirect()->route('revisioncuentas.edit',$detalle->id_contrato )
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

        
        $detalle=DetalleCuentasArrendatario::create([
            "id_contrato"  =>  $request->id_contrato,
            "id_inmueble"  =>  $request->id_inmueble,
            "id_arrendatario"  =>  $request->id_arrendatario,
            "fecha_vencimiento"  =>  $request->fecha_vencimiento,
            "id_creador"  =>  Auth::user()->id,
            "id_serviciobasico"  =>  $request->servicio,
            "valor_en_pesos"  =>  $request->valor_en_moneda,
            "mes"  =>  $request->mes,
            "anio"  =>  $request->anio,
            "nombre"  =>  $archivo,
            "ruta"  =>  $destinationPath,
            "id_estado"  => 1 
        ]);


  $uf = DB::table('adm_uf')
                ->where("fecha", "=", Carbon::now()->format('Y/m/d'))
                ->first();
        $servicio = EmpresasServicios::all()->where('id_estado','<>','0');
        $contratofinal=ContratoFinalARR::find($request->id_contrato);
        $borrador=ContratoBorradorArrendatario::find($contratofinal->id_borrador);
        $captacion=Arrendatario::find($borrador->id_cap_arr);
        $inmueble=Inmueble::find($captacion->id_inmueble);
        $persona=Persona::find($captacion->id_arrendatario);
        $idcontrato=$request->id_contrato;
        $asigna=AsignaRevision::create([
            "id_estado"=>1,
            "id_contrato" => $request->id_contrato,
            "id_asignado" => Auth::user()->id
        ]);
         return view('revisioncuentas.create',compact('servicio','idcontrato','uf','captacion','inmueble','persona'));

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
        $contratofinal=ContratoFinalARR::find($id);
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

        $contratofinal=ContratoFinalARR::find($id);
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
}
