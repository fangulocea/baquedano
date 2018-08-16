<?php

namespace App\Http\Controllers;

use App\PagosMensualesArrendatarios;
use App\Arrendatario;
use App\ArrendatarioGarantia;
use App\PagosArrendatarios;
use App\Persona;
use DB;
use App\DetallePagosArrendatarios;
use App\CargosAbonosArrendatarios;
use Illuminate\Http\Request;
use Auth;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade as PDF;

class PagosMensualesArrendatariosController extends Controller {

    public function volver_pago($id) {
        $pago = PagosMensualesArrendatarios::find($id);
        $origen = "Contrato";
        return redirect()->route('finalContratoArr.edit', [$pago->id_publicacion, 0, 0, 5,$origen])
                        ->with('status', 'Contrato Final guardado con éxito');
    }

    public function getGarantia($id) {
        $garantia = ArrendatarioGarantia::find($id);
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

        $pago = PagosMensualesArrendatarios::find($id);


        $publicacion = Arrendatario::find($pago->id_publicacion);
        $persona = Persona::find($publicacion->id_propietario);
        $inmueble = DB::table('inmuebles')
                ->join('comunas', 'inmuebles.id_comuna', '=', 'comunas.comuna_id')
                ->where("inmuebles.id", "=", $pago->id_inmueble)
                ->first();
        $mes = $meses[$pago->mes];

        $valor_pagado = DetallePagosArrendatarios::where("id_pagomensual", "=", $id)->sum("valor_pagado_moneda");




        if ($pago->moneda == 'UF') {
            $saldo_pesos = (round($pago->pago_a_rentas_moneda, 8) - round($valor_pagado, 8)) * round($uf->valor, 8);

            $saldo_moneda = round($pago->pago_a_rentas_moneda, 8) - round($valor_pagado, 8);
        } else {
            $saldo_pesos = $pago->pago_a_rentas_moneda - $valor_pagado;
            $saldo_moneda = $pago->pago_a_rentas_moneda - $valor_pagado;
        }


        $documentos = DB::table('adm_detallepagosarrendatarios as dp')
                ->where("dp.id_pagomensual", "=", $id)
                ->get();


        $garantias = ArrendatarioGarantia::where("id_publicacion", "=", $pago->id_publicacion)
                        ->where("id_estado", "=", null)->get();

        return view('finalContratoArr.gestion', compact('pago', 'persona', 'inmueble', 'mes', 'valor_pagado', 'documentos', 'garantias', 'uf', 'saldo_pesos', 'saldo_moneda'));
    }

    public function comprobantedepago($id) {
        $meses = array("", "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
        $uf = DB::table('adm_uf')
                ->where("fecha", "=", Carbon::now()->format('Y/m/d'))
                ->first();
        if (count($uf) == 0) {
            return back()->with('error', 'No hay UF registrada para el día de hoy');
        }

        $pago = PagosMensualesArrendatarios::find($id);


        $publicacion = Arrendatario::find($pago->id_publicacion);
        $persona = Persona::find($publicacion->id_propietario);
        $inmueble = DB::table('inmuebles')
                ->join('comunas', 'inmuebles.id_comuna', '=', 'comunas.comuna_id')
                ->where("inmuebles.id", "=", $pago->id_inmueble)
                ->first();
        $mes = $meses[$pago->mes];

        $valor_pagado = DetallePagosArrendatarios::where("id_pagomensual", "=", $id)->sum("valor_pagado_moneda");
        $pagospropietarios=PagosArrendatarios::where("id_contratofinal","=",$pago->id_contratofinal)
        ->where("id_inmueble","=",$pago->id_inmueble)
        ->where("id_publicacion","=",$pago->id_publicacion)
        ->where("mes","=",$pago->mes)
        ->where("anio","=",$pago->anio)
        ->get();

        if ($pago->moneda == 'UF') {
            $saldo_pesos = (round($pago->pago_a_rentas_moneda, 8) - round($valor_pagado, 8)) * round($uf->valor, 8);

            $saldo_moneda = round($pago->pago_a_rentas_moneda, 8) - round($valor_pagado, 8);
        } else {
            $saldo_pesos = $pago->pago_a_rentas_moneda - $valor_pagado;
            $saldo_moneda = $pago->pago_a_rentas_moneda - $valor_pagado;
        }


        $documentos = DB::table('adm_detallepagosarrendatarios as dp')
                ->where("dp.id_pagomensual", "=", $id)
                ->get();
        $valor_original=$pago->pago_a_rentas_moneda;
        $pdf = PDF::loadView('formatospdf.recibopagoarrendatario', compact('pago', 'persona', 'inmueble', 'mes', 'valor_pagado', 'documentos', 'uf', 'saldo_pesos', 'saldo_moneda', 'pagospropietarios','valor_original'));

        return $pdf->download($inmueble->direccion . ' Nro.' . $inmueble->numero . ' Dpto.' . $inmueble->departamento . ', ' . $inmueble->comuna_nombre . ' - ' . $mes . '-' . $pago->anio . ' - Comprobante de Pago a Propietario.pdf');
    }

    public function efectuarpago(Request $request, $id) {

        if (!isset($request->archivo)) {
            return redirect()->route('pagosarrendatario.ir_al_pago', $id)->with('error', 'Debe seleccionar archivo');
        }

        $uf = DB::table('adm_uf')
                ->where("fecha", "=", Carbon::now()->format('Y/m/d'))
                ->first();

        $destinationPath = 'uploads/docpagosarrendatarios';
        $archivo = rand() . $request->archivo->getClientOriginalName();
        $file = $request->file('archivo');
        $file->move($destinationPath, $archivo);

        $pago = PagosMensualesArrendatarios::find($id);


       $valor_pagado = DetallePagosArrendatarios::where("id_pagomensual", "=", $id)->sum("valor_pagado");
        $valor_original = $pago->pago_a_rentas;
        $saldo_actual = $pago->pago_a_rentas - $valor_pagado;
        $saldo = $saldo_actual - $request->monto;



        $valor_pagado_moneda = DetallePagosArrendatarios::where("id_pagomensual", "=", $id)->sum("valor_pagado_moneda");
                if ($pago->moneda == 'UF') {
                $pago_realizado_moneda = $request->monto / $uf->valor;
            } else {
               $pago_realizado_moneda = $request->monto ;
            }

         $valor_original_moneda = $pago->pago_propietario_moneda - $pago_realizado_moneda;
            $saldo_actual_moneda = $pago->pago_propietario_moneda - $valor_pagado_moneda;

            $saldo_moneda = $saldo_actual_moneda - $pago_realizado_moneda;

        $detalle = "";

        if (isset($request->id_garantia)) {
            $detalle = "Garantía";
            $pagogarantias = DetallePagosArrendatarios::where("id_pagomensual", "=", $id)->where("detalle", "=", "Garantía")->sum("valor_pagado");
            $garantia = ArrendatarioGarantia::find($request->id_garantia);
            if ($garantia->valor <= $pagogarantias || $garantia->valor <= $request->monto) {
                $garantia = ArrendatarioGarantia::find($request->id_garantia)->update(["id_estado" => 2]);
            } else {
                $garantia = ArrendatarioGarantia::find($request->id_garantia)->update(["id_estado" => null]);
            }
        } else {
            $detalle = "Pago Normal";
        }
        $detalle = DetallePagosArrendatarios::create([
                    "id_pagomensual" => $id,
                    "fecha_pago" => $request->fecha_pago,
                    "id_publicacion" => $pago->id_publicacion,
                    "id_inmueble" => $pago->id_inmueble,
                    "moneda" =>$pago->moneda,
                    "valor_moneda" =>$pago->valor_moneda,
                    "fecha_moneda" =>$pago->fecha_moneda,
                    "valor_original_moneda" => $pago->pago_a_rentas_moneda,
                    "valor_pagado_moneda" => $pago_realizado_moneda,
                    "saldo_actual_moneda" => $saldo_actual_moneda,
                    "saldo_moneda" => $saldo_moneda,
                    "valor_original" => $pago->pago_a_rentas,
                    "valor_pagado" => $request->monto,
                    "saldo_actual" => $saldo_actual,
                    "saldo" => $saldo,
                    "detalle" => $detalle,
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



        $pago = PagosMensualesArrendatarios::find($id)->update([
            "id_estado" => $estado
        ]);


        return redirect()->route('pagosarrendatario.ir_al_pago', $id)->with('status', 'Pago ingresado con exito');
    }


public function cargosabonos($id) {
        $meses = array("", "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
        $uf = DB::table('adm_uf')
                ->where("fecha", "=", Carbon::now()->format('Y/m/d'))
                ->first();
        if (count($uf) == 0) {
            return back()->with('error', 'No hay UF registrada para el día de hoy');
        }

        $pago = PagosMensualesArrendatarios::find($id);


        $publicacion = Arrendatario::find($pago->id_publicacion);
        $persona = Persona::find($publicacion->id_propietario);
        $inmueble = DB::table('inmuebles')
                ->join('comunas', 'inmuebles.id_comuna', '=', 'comunas.comuna_id')
                ->where("inmuebles.id", "=", $pago->id_inmueble)
                ->first();
        $mes = $meses[$pago->mes];

        $valor_pagado = DetallePagosArrendatarios::where("id_pagomensual", "=", $id)->sum("valor_pagado_moneda");




        if ($pago->moneda == 'UF') {
            $saldo_pesos = (round($pago->pago_a_rentas_moneda, 8) - round($valor_pagado, 8)) * round($uf->valor, 8);
            $saldo_moneda = round($pago->pago_a_rentas_moneda, 8) - round($valor_pagado, 8);
        } else {
            $saldo_pesos = $pago->pago_a_rentas_moneda - $valor_pagado;
            $saldo_moneda = $pago->pago_a_rentas_moneda - $valor_pagado;
        }


        $documentos = DB::table('adm_pagosarrendatarios as pp')
                ->where("pp.id_contratofinal", "=", $pago->id_contratofinal)
                 ->where("pp.id_publicacion", "=", $pago->id_publicacion)
                 ->where("pp.id_inmueble", "=", $pago->id_inmueble)
                 ->where("pp.mes", "=", $pago->mes)
                 ->where("pp.anio", "=", $pago->anio)
                ->get();


        return view('finalContratoArr.cargos', compact('pago', 'persona', 'inmueble', 'mes', 'valor_pagado', 'documentos', 'uf', 'saldo_pesos', 'saldo_moneda'));
    }


    public function agregarcargo(Request $request, $id) {

        if (!isset($request->archivo)) {
            return redirect()->route('PagosMensualesArrendatarios.cargosabonos', $id)->with('error', 'Debe seleccionar archivo');
        }


        $uf = DB::table('adm_uf')
                ->where("fecha", "=", Carbon::now()->format('Y/m/d'))
                ->first();


        $destinationPath = 'uploads/cargosabonosarrendatarios';
        $archivo = rand() . $request->archivo->getClientOriginalName();
        $file = $request->file('archivo');
        $file->move($destinationPath, $archivo);

        $pago = PagosMensualesArrendatarios::find($id);
        if($request->moneda=="UF"){
            $moneda=$request->moneda;
            $valor_moneda=$uf->valor;
        }else{
            $moneda=$request->moneda;
            $valor_moneda=1;
        }

        $cargosabonos=CargosAbonosArrendatarios::create([
            "id_pagomensual"    =>  $pago->id,
            "id_publicacion"    =>  $pago->id_publicacion,
            "id_inmueble"       =>  $pago->id_inmueble,
            "tipooperacion"     =>  $request->tipo,
            "nombreoperacion"   =>  $request->nombreoperacion,
            "moneda"            =>  $request->moneda,
            "fecha_moneda"      =>  Carbon::now()->format('Y/m/d') ,
            "valor_moneda"      =>  $valor_moneda,
            "monto_moneda"      =>  $request->monto,
            "monto_pesos"       =>  round($request->monto * $valor_moneda),
            "tipo"              =>  $request->tipo,
            "nombre"            =>  $archivo,
            "ruta"              =>  $destinationPath,
            "id_creador"        =>  Auth::user()->id,
            "id_modificador"    =>  Auth::user()->id,
            "id_estado"         =>  1

        ]);

        $valor=0;
       
        if($request->tipo==17){
            $es='s';
            $tipoop="Otros Abonos";
            $pago_propietario=($pago->pago_a_rentas_moneda - $request->monto)/$valor_moneda;
            $pago_propietario_moneda=$pago->pago_a_rentas_moneda - $request->monto;
        }else{
            $es='e';
            $tipoop="Otros Cargos";
            $pago_propietario=($pago->pago_a_rentas_moneda + $request->monto)/$valor_moneda;
            $pago_propietario_moneda=$pago->pago_a_rentas_moneda + $request->monto;
        }

        $fechafirma=$pago->fecha_iniciocontrato;

         $fecha_ini = date('Y-m-j', strtotime($pago->anio . '-' . $pago->mes . '-' . 1));
            $dia = date("d", strtotime($fecha_ini));
            $mes = date("m", strtotime($fecha_ini));
            $anio = date("Y", strtotime($fecha_ini));
            $dias_mes = cal_days_in_month(CAL_GREGORIAN, date("m", strtotime($fecha_ini)), date("Y", strtotime($fecha_ini)));

           $tipopropuesta = PagosArrendatarios::where("mes", '=', $mes)
                        ->where("anio", '=', $anio)
                        ->where("id_contratofinal", '=', $pago->id_contratofinal)
                        ->where("id_inmueble", '=', $pago->id_inmueble)
                        ->first();


        $pago = PagosArrendatarios::create([
                        'id_contratofinal' => $pago->id_contratofinal,
                        'gastocomun' => 0,
                         "id_publicacion"    =>  $pago->id_publicacion,
                         "id_inmueble"       =>  $pago->id_inmueble,
                        'E_S' => $es,
                        'tipopago' => $request->nombreoperacion,
                        'idtipopago' => $request->tipo,
                        'tipopropuesta' => $tipopropuesta->tipopropuesta,
                        'meses_contrato' => 0,
                        'fecha_iniciocontrato' => $fechafirma,
                        "fecha_moneda"      =>  Carbon::now()->format('Y/m/d') ,
                        'dia' => $dia,
                        'mes' => $mes,
                        'anio' => $anio,
                        'descuento' => 0,
                        'cant_diasmes' => $dias_mes,
                        'cant_diasproporcional' => $dias_mes,
                        'moneda' => $request->moneda,
                        'valormoneda' => $valor_moneda,
                        'valordia' => 1,
                        'precio_en_moneda' => $request->monto,
                        'precio_en_pesos' => round($request->monto * $valor_moneda),
                        'id_creador' => Auth::user()->id,
                        'id_modificador' => Auth::user()->id,
                        'id_estado' => 1,
                        'gastocomun' =>0,
                        'canondearriendo' => 0
            ]);

        $idcontrato=$pago->id_contratofinal;
        $idinmueble=$pago->id_inmueble;

if($tipopropuesta->tipopropuesta==1 || $tipopropuesta->tipopropuesta==3 ){

         $saldo_a_favor = PagosArrendatarios::where("mes", '=', $mes)
                        ->where("anio", '=', $anio)
                        ->whereIn("idtipopago", [17,10])
                        ->where("id_contratofinal", '=', $idcontrato)
                        ->where("id_inmueble", '=', $idinmueble)
                        ->sum('precio_en_pesos');

                $pago_a_rentas = PagosArrendatarios::where("mes", '=', $mes)
                        ->where("anio", '=', $anio)
                        ->whereIn("idtipopago", [1,2,3, 4, 5, 6, 7,8,9,10,11, 15,16,18])
                        ->where("id_contratofinal", '=', $idcontrato)
                        ->where("id_inmueble", '=', $idinmueble)
                        ->sum('precio_en_pesos');

                $saldo_a_depositar =  $pago_a_rentas-$saldo_a_favor;

                $saldo=PagosArrendatarios::where("mes", '=', $mes)
                        ->where("anio", '=', $anio)
                        ->where("idtipopago", '=', 21)
                        ->where("id_contratofinal", '=', $idcontrato)
                        ->where("id_inmueble", '=', $idinmueble)
                        ->update([
                            'precio_en_moneda' => $saldo_a_depositar / $valor_moneda,
                            'precio_en_pesos' => $saldo_a_depositar,
                        ]);

                  $pagomensual = PagosArrendatarios::where("mes", '=', $mes)
                        ->where("anio", '=', $anio)
                        ->whereIn("idtipopago", [1,2,3, 4, 5, 6, 7,8,10,11, 15,16,18])
                        ->where("id_contratofinal", '=', $idcontrato)
                        ->where("id_inmueble", '=', $idinmueble)
                        ->sum('precio_en_pesos');

                $saldo=PagosArrendatarios::where("mes", '=', $mes)
                        ->where("anio", '=', $anio)
                        ->where("idtipopago", '=', 20)
                        ->where("id_contratofinal", '=', $idcontrato)
                        ->where("id_inmueble", '=', $idinmueble)
                        ->update([
                            'precio_en_moneda' => $pagomensual / $valor_moneda,
                            'precio_en_pesos' => $pagomensual,
                        ]);

}else{
         $saldo_a_favor = PagosArrendatarios::where("mes", '=', $mes)
                        ->where("anio", '=', $anio)
                        ->whereIn("idtipopago", [17,10])
                        ->where("id_contratofinal", '=', $pago->id_contratofinal)
                        ->where("id_inmueble", '=', $pago->id_inmueble)
                        ->sum('precio_en_pesos');

                $pago_a_rentas = PagosArrendatarios::where("mes", '=', $mes)
                        ->where("anio", '=', $anio)
                        ->whereIn("idtipopago", [1,2,5, 6, 7,8,10,11,15, 31, 32, 33,16,18])
                        ->where("id_contratofinal", '=', $pago->id_contratofinal)
                        ->where("id_inmueble", '=', $pago->id_inmueble)
                        ->sum('precio_en_pesos');

                $saldo_a_depositar =$pago_a_rentas- $saldo_a_favor  ;

                $saldo=PagosArrendatarios::where("mes", '=', $mes)
                        ->where("anio", '=', $anio)
                        ->where("idtipopago", '=', 35)
                        ->where("id_contratofinal", '=', $idcontrato)
                        ->where("id_inmueble", '=', $idinmueble)
                        ->update([
                            'precio_en_moneda' => $saldo_a_depositar / $valor_moneda,
                            'precio_en_pesos' => $saldo_a_depositar,
                        ]);

                $pagomensual = PagosArrendatarios::where("mes", '=', $mes)
                        ->where("anio", '=', $anio)
                        ->whereIn("idtipopago", [1,2,5, 6, 7,8,9,10,11,15, 31, 32, 33,16,18])
                        ->where("id_contratofinal", '=', $idcontrato)
                        ->sum('precio_en_pesos');


                $saldo=PagosArrendatarios::where("mes", '=', $mes)
                        ->where("anio", '=', $anio)
                        ->where("idtipopago", '=', 34)
                        ->where("id_contratofinal", '=', $idcontrato)
                        ->where("id_inmueble", '=', $idinmueble)
                        ->update([
                            'precio_en_moneda' => $pagomensual / $valor_moneda,
                            'precio_en_pesos' => $pagomensual,
                        ]);

}
 


        $pago = PagosMensualesArrendatarios::find($id)->update([
            "pago_a_rentas" => $pago_propietario,
            "pago_a_rentas_moneda" => $pago_propietario_moneda
        ]);

        return redirect()->route('PagosMensualesArrendatarios.cargosabonos', $id)->with('status', 'Pago ingresado con exito');

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
     * @param  \App\PagosMensualesArrendatarios  $pagosMensualesArrendatarios
     * @return \Illuminate\Http\Response
     */
    public function show(PagosMensualesArrendatarios $pagosMensualesArrendatarios) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\PagosMensualesArrendatarios  $pagosMensualesArrendatarios
     * @return \Illuminate\Http\Response
     */
    public function edit(PagosMensualesArrendatarios $pagosMensualesArrendatarios) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\PagosMensualesArrendatarios  $pagosMensualesArrendatarios
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PagosMensualesArrendatarios $pagosMensualesArrendatarios) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\PagosMensualesArrendatarios  $pagosMensualesArrendatarios
     * @return \Illuminate\Http\Response
     */
    public function destroy(PagosMensualesArrendatarios $pagosMensualesArrendatarios) {
        //
    }

}
