<?php

namespace App\Http\Controllers;

use App\PresupuestoPostVenta;
use App\FamiliaMateriales;
use App\Proveedores;
use Illuminate\Http\Request;
use Auth;
use DB;
use Yajra\Datatables\Datatables;
use App\DetallePresupuestoPostVenta;
use Excel;


class PresupuestoPostVentaController extends Controller 
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }


    public function detalle_presupuesto_ajax($id) {

        $detalle = DB::table('post_detallepresupuesto as dp')
                ->leftjoin('post_itemmateriales as pi', 'dp.id_item', '=', 'pi.id')
                ->leftjoin('post_familiamateriales as pf', 'dp.id_familia', '=', 'pf.id')
                ->leftjoin('post_proveedores as p', 'dp.id_proveedor', '=', 'p.id')
                ->where("dp.id_presupuesto", "=", $id)
                ->select(DB::raw('dp.id,
                    pf.familia,
                    pi.item,
                    p.nombre as proveedor,
                    dp.valor_proveedor as valor_unitario_proveedor,
                    dp.valor_unitario_baquedano,
                    dp.cantidad,
                    dp.monto_baquedano,
                    dp.monto_proveedor,
                    dp.subtotal,
                    dp.created_at'))
                ->get();



        return Datatables::of($detalle)
                        ->addColumn('action', function ($detalle) {
                            return ' 
                            <a href="/presupuestodetalle/borrar/' . $detalle->id . '"><span class="btn btn-danger btn-circle btn-sm"><i class="ti-pencil-alt"></i></span></a>
                                    ';
                        })
                        ->rawColumns(['action'])
                        ->make(true);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if($request->id_cobro==1){
            $responsable="Propietario";
        }elseif($request->id_cobro==2)
        {
             $responsable="Arrendatario";
        }else{
            $responsable="Baquedano";
        }
        $presupuesto=PresupuestoPostVenta::create([
            "id_postventa" => $request->id_postventa_presupuesto,
            "id_inmueble" => $request->id_inmueble_presupuesto,
            "id_propietario" => $request->id_propietario_presupuesto,
            "id_arrendatario" => $request->id_arrendatario_presupuesto,
            "id_creador" => Auth::user()->id,
            "responsable_pago" => $responsable,
            "id_responsable_pago" => $request->id_cobro,
            "id_estado" => 0
        ]);

        $familia=FamiliaMateriales::all();
        $proveedores=Proveedores::all();

        return view('postventa.create_presupuesto',compact('presupuesto','familia','proveedores'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\PresupuestoPostVenta  $presupuestoPostVenta
     * @return \Illuminate\Http\Response
     */
    public function agregar(Request $request)
    {
        $detalle=DetallePresupuestoPostVenta::create([
            "id_presupuesto" => $request->id_presupuesto,
            "id_proveedor" => $request->proveedor,
            "id_familia" => $request->familia,
            "id_item" => $request->item,
            "id_creador" => Auth::user()->id,
            "valor_proveedor" => $request->valorproveedor,
            "valor_unitario_baquedano" => $request->valorbaquedano,
            "recargo" => $request->por_recargo,
            "cantidad" => $request->cantidad,
            "monto_baquedano" => $request->monto_baquedano,
            "monto_proveedor" => $request->monto_proveedor,
            "subtotal" => $request->subtotal
        ]);
$totalpesos=DetallePresupuestoPostVenta::where("id_presupuesto","=",$request->id_presupuesto)->sum("subtotal");
        $presu=PresupuestoPostVenta::find($request->id_presupuesto)->update([
            "total"=>$totalpesos,
            "id_estado"=>0
        ]);

        return redirect()->route('presupuesto.edit', $request->id_presupuesto)->with("status","Itema agregado con exito");

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\PresupuestoPostVenta  $presupuestoPostVenta
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $presupuesto=PresupuestoPostVenta::find($id);

        $familia=FamiliaMateriales::all();
        $proveedores=Proveedores::all();

         $totalpesos=DetallePresupuestoPostVenta::where("id_presupuesto","=",$id)->sum("subtotal");

        return view('postventa.create_presupuesto',compact('presupuesto','familia','proveedores','totalpesos'));
    }


    public function exportarexcel($id)
    {
        $header=DB::table('post_presupuesto as p')
        ->leftjoin("post_venta as pv","pv.id","p.id_postventa")
        ->leftjoin('users as p2', 'p.id_creador', '=', 'p2.id')
        ->leftjoin('inmuebles as i', 'p.id_inmueble', '=', 'i.id')
        ->leftjoin('personas as p1', 'p.id_arrendatario', '=', 'p1.id')
        ->leftjoin('personas as p3', 'p.id_propietario', '=', 'p3.id')
        ->leftjoin('comunas as o', 'i.id_comuna', '=', 'o.comuna_id')
        ->leftjoin('mensajes as m', function($join){
                 $join->on('m.nombre_modulo', '=',DB::raw("'Presupuesto'"));
                 $join->on('m.id_estado', '=', 'p.id_estado');
            })
        ->where("p.id", '=', $id)
        ->select(DB::raw('
        p.id, 
            DATE_FORMAT(p.created_at, "%d/%m/%Y") as fecha_creacion, 
            CONCAT_WS(" ",p1.nombre,p1.apellido_paterno,p1.apellido_materno) as arrendatario,
            p2.name as creador,
            CONCAT_WS(" ",i.direccion,i.numero,i.departamento,o.comuna_nombre) as propiedad,
            CONCAT_WS(" ",p3.nombre,p3.apellido_paterno,p3.apellido_materno) as propietario,
            p.responsable_pago as responsable,
            p.total,
            m.nombre as estado,
            pv.meses_contrato as meses,
            pv.fecha_contrato'))
            ->first();

        $detalle = DB::table('post_detallepresupuesto as dp')
                ->leftjoin('post_itemmateriales as pi', 'dp.id_item', '=', 'pi.id')
                ->leftjoin('post_familiamateriales as pf', 'dp.id_familia', '=', 'pf.id')
                ->leftjoin('post_proveedores as p', 'dp.id_proveedor', '=', 'p.id')
                ->where("dp.id_presupuesto", "=", $id)
                ->select(DB::raw('dp.id,
                    pf.familia,
                    pi.item,
                    p.nombre as proveedor,
                    dp.valor_proveedor as valor_unitario_proveedor,
                    dp.valor_unitario_baquedano,
                    dp.cantidad,
                    dp.monto_baquedano,
                    dp.monto_proveedor,
                    dp.subtotal'))
                ->get();

        $totalpesos=DetallePresupuestoPostVenta::where("id_presupuesto","=",$id)->sum("subtotal");

          return Excel::create('Presupuesto', function ($excel) use ($header, $detalle,$totalpesos) {
                        $excel->sheet('Presupuesto', function ($sheet) use ($header, $detalle,$totalpesos) {
                            $sheet->setBorder('A1:B10', 'thin');
                            $sheet->setBorder('A16:I30', 'thin');
                               $sheet->loadView('formatosexcel.presupuesto', compact('header', 'detalle','totalpesos'));
                        });
                    })->download('xlsx');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\PresupuestoPostVenta  $presupuestoPostVenta
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PresupuestoPostVenta $presupuestoPostVenta)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\PresupuestoPostVenta  $presupuestoPostVenta
     * @return \Illuminate\Http\Response
     */
    public function eliminarpresupuesto($id)
    {
       $presupuesto=PresupuestoPostVenta::find($id);
       $detalle=DetallePresupuestoPostVenta::where("id_presupuesto","=",$id)->delete();
       $borrar=PresupuestoPostVenta::find($id)->delete();
       return redirect()->route('postventa.edit', [$presupuesto->id_postventa,8])->with("status","Presupuesto eliminado con exito");
    }

        public function eliminardetalle($id)
    {
       $detalle=DetallePresupuestoPostVenta::find($id);
       $borrar=DetallePresupuestoPostVenta::find($id)->delete();
       return redirect()->route('presupuesto.edit', $detalle->id_presupuesto)->with("status","Itema agregado con exito");
    }
}
