<?php

namespace App\Http\Controllers;

use App\PagosMensualesPropietarios;
use App\Persona;
use App\Inmueble;
use App\Captacion;
use App\DetallePagosPropietarios;
use App\PropietarioCheques;
use App\PropietarioGarantia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Carbon\Carbon;
use DB;
use Auth;

class PagosMensualesPropietariosController extends Controller {

    public function volver_pago($id) {
        $pago = PagosMensualesPropietarios::find($id);
        return redirect()->route('finalContrato.edit', [$pago->id_publicacion, 0, 0, 5])
                        ->with('status', 'Contrato Final guardado con éxito');
    }

    public function getCheque($id) {
        $cheque = PropietarioCheques::find($id);
        return response()->json($cheque);
    }

    public function getGarantia($id) {
        $garantia = PropietarioGarantia::find($id);
        return response()->json($garantia);
    }

    public function ir_al_pago($id) {
        $meses = array("", "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
        $uf = DB::table('adm_uf')
                ->where("fecha", "=", Carbon::now()->format('Y/m/d'))
                ->first();
        if (count($uf) == 0) {
            return back()->with('error', 'No hay UF registrada para el día de hoy');
        }
        $pago = PagosMensualesPropietarios::find($id);
        $publicacion = Captacion::find($pago->id_publicacion);
        $persona = Persona::find($publicacion->id_propietario);
        $inmueble = DB::table('inmuebles')
                ->join('comunas', 'inmuebles.id_comuna', '=', 'comunas.comuna_id')
                ->where("inmuebles.id", "=", $pago->id_inmueble)
                ->first();
        $mes = $meses[$pago->mes];

        $valor_pagado = DetallePagosPropietarios::where("id_pagomensual", "=", $id)->sum("valor_pagado_moneda");
        $saldo_moneda = ($pago->pago_propietario_moneda - $valor_pagado);

        if ($pago->moneda == 'UF') {
            $saldo_pesos = ($pago->pago_propietario_moneda - $valor_pagado) * $uf->valor;
        } else {
            $saldo_pesos = ($pago->pago_propietario_moneda - $valor_pagado);
        }


        $documentos = DB::table('adm_detallepagospropietarios as dp')
                ->leftjoin('propietario_cheques as c', 'c.id', '=', 'dp.id_cheque')
                ->where("dp.id_pagomensual", "=", $id)
                ->select(DB::raw('dp.*,c.fecha_pago as fc, c.numero'))
                ->get();

        $garantias = PropietarioGarantia::where("id_publicacion", "=", $pago->id_publicacion)
                        ->where("id_estado", "=", null)->get();


        $cheques = PropietarioCheques::where("id_contrato", "=", $pago->id_contratofinal)->get();

        return view('contratoFinal.gestion', compact('pago', 'persona', 'inmueble', 'mes', 'valor_pagado', 'documentos', 'cheques', 'garantias', 'uf', 'saldo_pesos', 'saldo_moneda'));
    }

    public function efectuarpago(Request $request, $id) {

        if (!isset($request->archivo)) {
            return redirect()->route('PagosMensualesPropietarios.ir_al_pago', $id)->with('error', 'Debe seleccionar archivo');
        }

        $destinationPath = 'uploads/docpagospropietarios';
        $archivo = rand() . $request->archivo->getClientOriginalName();
        $file = $request->file('archivo');
        $file->move($destinationPath, $archivo);

        $pago = PagosMensualesPropietarios::find($id);

        $valor_pagado = DetallePagosPropietarios::where("id_pagomensual", "=", $id)->sum("valor_pagado");
        $valor_original = $pago->pago_propietario;
        $saldo_actual = $pago->pago_propietario - $valor_pagado;
        $saldo = $saldo_actual - $request->monto;
        $detalle = "";

        if (isset($request->id_cheque)) {
            $detalle = "Cheque";
        } elseif (isset($request->id_garantia)) {
            $detalle = "Garantía";
            $pagogarantias = DetallePagosPropietarios::where("id_pagomensual", "=", $id)->where("detalle", "=", "Garantía")->sum("valor_pagado");
            $garantia = PropietarioGarantia::find($request->id_garantia);
            if ($garantia->valor <= $pagogarantias || $garantia->valor <= $request->monto) {
                $garantia = PropietarioGarantia::find($request->id_garantia)->update(["id_estado" => 2]);
            } else {
                $garantia = PropietarioGarantia::find($request->id_garantia)->update(["id_estado" => null]);
            }
        } else {
            $detalle = "Pago Normal";
        }

        $detalle = DetallePagosPropietarios::create([
                    "id_pagomensual" => $id,
                    "fecha_pago" => $request->fecha_pago,
                    "id_publicacion" => $pago->id_publicacion,
                    "id_inmueble" => $pago->id_inmueble,
                    "moneda" =>$pago->moneda;
                    "valor_moneda" =>$pago->valor_moneda;
                    "fecha_moneda" =>$pago->fecha_moneda;
                    "valor_original" => $pago->pago_propietario,
                    "valor_pagado" => $request->monto,
                    "saldo_actual" => $saldo_actual,
                    "id_cheque" => $request->id_cheque,
                    "detalle" => $detalle,
                    "saldo" => $saldo,
                    "E_S" => "",
                    "id_modificador" => Auth::user()->id,
                    'tipo' => "Pago Mensual",
                    'nombre' => $archivo,
                    'ruta' => $destinationPath,
                    "id_creador" => Auth::user()->id,
                    "id_estado" => 1
        ]);
        $estado = 1;
        if ($valor_original > $valor_pagado) {
            $estado = 2;
        }

        if ($saldo <= 0) {
            $estado = 3;
        }



        $pago = PagosMensualesPropietarios::find($id)->update([
            "id_estado" => $estado
        ]);


        return redirect()->route('PagosMensualesPropietarios.ir_al_pago', $id)->with('status', 'Pago ingresado con exito');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\PagosMensualesPropietarios  $pagosMensualesPropietarios
     * @return \Illuminate\Http\Response
     */
    public function show(PagosMensualesPropietarios $pagosMensualesPropietarios) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\PagosMensualesPropietarios  $pagosMensualesPropietarios
     * @return \Illuminate\Http\Response
     */
    public function edit(PagosMensualesPropietarios $pagosMensualesPropietarios) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\PagosMensualesPropietarios  $pagosMensualesPropietarios
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PagosMensualesPropietarios $pagosMensualesPropietarios) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\PagosMensualesPropietarios  $pagosMensualesPropietarios
     * @return \Illuminate\Http\Response
     */
    public function destroy(PagosMensualesPropietarios $pagosMensualesPropietarios) {
        //
    }

}
