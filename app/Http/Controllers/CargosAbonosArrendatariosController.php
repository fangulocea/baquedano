<?php

namespace App\Http\Controllers;

use App\CargosAbonosArrendatarios;
use App\PagosArrendatarios;
use App\PagosMensualesArrendatarios;
use Illuminate\Http\Request;
use DB;
use Carbon\Carbon;
use Auth;

class CargosAbonosArrendatariosController extends Controller {

    public function cargos() {

        $publica = DB::table('adm_contratofinalarr as co')
                ->leftjoin('contratoborradorarrendatarios as cb', 'co.id_borrador', '=', 'cb.id')
                ->leftjoin('multas as m', 'cb.id_multa', '=', 'm.id')
                ->leftjoin('arrendatarios as c', 'c.id', '=', 'co.id_publicacion')
                ->Orwhere('c.id_estado', '=', "11")
                ->select(DB::raw('cb.dia_pago, co.id as id_contratofinal, co.fecha_firma, co.meses_contrato, m.valor as valormulta, cb.valorarriendo'))
                ->get();

        $fecha_ini = date("d-m-Y", strtotime(Carbon::now()->format('d-m-Y')));
        $dia = date("d", strtotime($fecha_ini));
        $mes = date("m", strtotime($fecha_ini));
        $anio = date("Y", strtotime($fecha_ini));
        $dias_mes = cal_days_in_month(CAL_GREGORIAN, date("m", strtotime($fecha_ini)), date("Y", strtotime($fecha_ini)));
        $uf = DB::table('adm_uf')
                ->where("fecha", "=", Carbon::now()->format('Y/m/d'))
                ->first();



        foreach ($publica as $c) {

            $valordiamora = ($c->valorarriendo * $c->valormulta) / 100;

            $contrato = DB::table('adm_pagosmensualesarrendatarios as c')
                    ->leftjoin('adm_contratofinalarr as cp', 'c.id_contratofinal', '=', 'cp.id')
                    ->leftjoin('contratoborradorarrendatarios as cb', 'cp.id_borrador', '=', 'cb.id')
                    ->where('c.id_contratofinal', '=', $c->id_contratofinal)
                    ->where('c.mes', '=', $mes)
                    ->where('c.anio', '=', $anio)
                    ->select(DB::raw(' c.id, cp.id_publicacion, c.fecha_iniciocontrato, c.mes, c.anio, c.valor_a_pagar, cp.meses_contrato,c.subtotal_entrada, c.subtotal_entrada_moneda, c.subtotal_salida, c.subtotal_salida_moneda, c.pago_a_arrendatario, c.pago_a_arrendatario_moneda, c.pago_a_rentas, c.pago_a_rentas_moneda, c.id_estado ,cb.dia_pago, c.moneda , cb.id_inmueble, cp.id_simulacion'))
                    ->orderBy('c.id', 'asc')
                    ->first();

            if ($contrato->id_estado == 1) {
                $mora = $dia - $contrato->dia_pago;
                if ($contrato->moneda == 'UF') {
                    $valormoneda = $uf->valor;
                } else {
                    $valormoneda = 1;
                }

                if ($mora > 0) {
                    $valor_en_moneda = $mora * $valordiamora;
                    $valor_en_pesos = ($mora * $valordiamora) / $valormoneda;

                    $pago = PagosMensualesArrendatarios::find($contrato->id);

                    $cargosabonos = CargosAbonosArrendatarios::create([
                                "id_pagomensual" => $pago->id,
                                "id_publicacion" => $pago->id_publicacion,
                                "id_inmueble" => $pago->id_inmueble,
                                "tipooperacion" => 16,
                                "nombreoperacion" => 'Cargo Multas por ' . $mora . ' Días',
                                "moneda" => $contrato->moneda,
                                "fecha_moneda" => Carbon::now()->format('Y/m/d'),
                                "valor_moneda" => $valormoneda,
                                "monto_moneda" => $valor_en_moneda,
                                "monto_pesos" => round($valor_en_pesos * $valormoneda),
                                "tipo" => 16,
                                "nombre" => null,
                                "ruta" => null,
                                "id_creador" => 1,
                                "id_modificador" => 1,
                                "id_estado" => 1
                    ]);

                    $actualizapago = PagosArrendatarios::where('id_contratofinal',"=",$c->id_contratofinal)
                        ->where("id_publicacion","=", $contrato->id_publicacion)
                        ->where("id_inmueble","=",$contrato->id_inmueble)
                        ->where("mes","=",$mes)
                        ->where("anio","=",$anio)
                        ->where("idtipopago","=",18)
                        ->update([
                                "fecha_moneda" => Carbon::now()->format('Y/m/d'),
                                'moneda' => $contrato->moneda,
                                'valormoneda' => $valormoneda,
                                'valordia' => $valordiamora,
                                'precio_en_moneda' => $valor_en_moneda,
                                'precio_en_pesos' => $valor_en_pesos,
                                'id_modificador' => 1,
                                'id_estado' => 1
                        ]);

                   

                    $tipopropuesta = PagosArrendatarios::where("mes", '=', $mes)
                        ->where("anio", '=', $anio)
                        ->where("id_contratofinal", '=', $pago->id_contratofinal)
                        ->where("id_inmueble", '=', $pago->id_inmueble)
                        ->first();

                    $idcontrato = $pago->id_contratofinal;
                    $idinmueble = $pago->id_inmueble;

                    if ($tipopropuesta->tipopropuesta == 1 || $tipopropuesta->tipopropuesta == 3) {

                        $saldo_a_favor = PagosArrendatarios::where("mes", '=', $mes)
                                ->where("anio", '=', $anio)
                                ->whereIn("idtipopago", [17,10])
                                ->where("id_contratofinal", '=', $idcontrato)
                                ->where("id_inmueble", '=', $idinmueble)
                                ->sum('precio_en_pesos');



                        $pago_a_rentas = PagosArrendatarios::where("mes", '=', $mes)
                                ->where("anio", '=', $anio)
                                ->whereIn("idtipopago", [1, 2, 3, 4, 5, 6, 7, 8, 11, 15, 18, 16])
                                ->where("id_contratofinal", '=', $idcontrato)
                                ->where("id_inmueble", '=', $idinmueble)
                                ->sum('precio_en_pesos');


  
                        $saldo_a_depositar = $pago_a_rentas - $saldo_a_favor;

                        $saldo = PagosArrendatarios::where("mes", '=', $mes)
                                ->where("anio", '=', $anio)
                                ->where("idtipopago", '=', 21)
                                ->where("id_contratofinal", '=', $idcontrato)
                                ->where("id_inmueble", '=', $idinmueble)
                                ->update([
                            'precio_en_moneda' => $saldo_a_depositar / $valormoneda,
                            'precio_en_pesos' => $saldo_a_depositar,
                        ]);

                        $pagomensual = PagosArrendatarios::where("mes", '=', $mes)
                                ->where("anio", '=', $anio)
                                ->whereIn("idtipopago", [1, 2, 3, 4, 5, 6, 7, 8, 11, 15, 16, 18])
                                ->where("id_contratofinal", '=', $idcontrato)
                                ->where("id_inmueble", '=', $idinmueble)
                                ->sum('precio_en_pesos');
       
                        $saldo = PagosArrendatarios::where("mes", '=', $mes)
                                ->where("anio", '=', $anio)
                                ->where("idtipopago", '=', 20)
                                ->where("id_contratofinal", '=', $idcontrato)
                                ->where("id_inmueble", '=', $idinmueble)
                                ->update([
                            'precio_en_moneda' => $pagomensual / $valormoneda,
                            'precio_en_pesos' => $pagomensual,
                        ]);


                    } else {
                        $saldo_a_favor = PagosArrendatarios::where("mes", '=', $mes)
                                ->where("anio", '=', $anio)
                                ->whereIn("idtipopago", [17,10])
                                ->where("id_contratofinal", '=', $pago->id_contratofinal)
                                ->where("id_inmueble", '=', $pago->id_inmueble)
                                ->sum('precio_en_pesos');

                        $pago_a_rentas = PagosArrendatarios::where("mes", '=', $mes)
                                ->where("anio", '=', $anio)
                                ->whereIn("idtipopago", [1, 2, 5, 6, 7, 8, 11, 15, 31, 32, 33, 18, 16])
                                ->where("id_contratofinal", '=', $pago->id_contratofinal)
                                ->where("id_inmueble", '=', $pago->id_inmueble)
                                ->sum('precio_en_pesos');

                        $saldo_a_depositar = $pago_a_rentas - $saldo_a_favor;

                        $saldo = PagosArrendatarios::where("mes", '=', $mes)
                                ->where("anio", '=', $anio)
                                ->where("idtipopago", '=', 35)
                                ->where("id_contratofinal", '=', $idcontrato)
                                ->where("id_inmueble", '=', $idinmueble)
                                ->update([
                            'precio_en_moneda' => $saldo_a_depositar / $valormoneda,
                            'precio_en_pesos' => $saldo_a_depositar,
                        ]);

                        $pagomensual = PagosArrendatarios::where("mes", '=', $mes)
                                ->where("anio", '=', $anio)
                                ->whereIn("idtipopago", [1, 2, 5, 6, 7, 8, 11, 15, 31, 32, 33, 16, 18])
                                ->where("id_contratofinal", '=', $idcontrato)
                                ->sum('precio_en_pesos');


                        $saldo = PagosArrendatarios::where("mes", '=', $mes)
                                ->where("anio", '=', $anio)
                                ->where("idtipopago", '=', 34)
                                ->where("id_contratofinal", '=', $idcontrato)
                                ->where("id_inmueble", '=', $idinmueble)
                                ->update([
                            'precio_en_moneda' => $pagomensual / $valormoneda,
                            'precio_en_pesos' => $pagomensual,
                        ]);
                    }



            $pago_propietario=($pago->pago_a_rentas_moneda + $valor_en_pesos)/$valormoneda;
            $pago_propietario_moneda=$pago->pago_a_rentas_moneda + $valor_en_moneda;


                    $pago = PagosMensualesArrendatarios::find($contrato->id)->update([
                        "pago_a_rentas" => $pago_propietario,
                        "pago_a_rentas_moneda" => $pago_propietario_moneda
                    ]);
                }
            }
        }
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
     * @param  \App\CargosAbonosArrendatarios  $cargosAbonosArrendatarios
     * @return \Illuminate\Http\Response
     */
    public function show(CargosAbonosArrendatarios $cargosAbonosArrendatarios) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\CargosAbonosArrendatarios  $cargosAbonosArrendatarios
     * @return \Illuminate\Http\Response
     */
    public function edit(CargosAbonosArrendatarios $cargosAbonosArrendatarios) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\CargosAbonosArrendatarios  $cargosAbonosArrendatarios
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CargosAbonosArrendatarios $cargosAbonosArrendatarios) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\CargosAbonosArrendatarios  $cargosAbonosArrendatarios
     * @return \Illuminate\Http\Response
     */
    public function destroy(CargosAbonosArrendatarios $cargosAbonosArrendatarios) {
        //
    }

}
