<?php

namespace App\Http\Controllers;

use App\SimulaPropietario;
use App\Captacion;
use App\SimulaPagoPropietario;
use Illuminate\Http\Request;
use Auth;

class SimulaPropietarioController extends Controller
{

public function generarpagos(Request $request, $idp) {

        //general

        $captacion=Captacion::find($idp);

        $idinmueble = $captacion->id_inmueble;
        $idpropietario = $captacion->id_propietario;
        $cant_meses = $request->cant_meses;
        $meses_contrato = $request->cant_meses;
        $fechafirma = $request->fecha_firmapago;
        $tipomoneda = $request->moneda;
        $valormoneda = $request->valormoneda;

        //pagos
        $gastocomun = $request->gastocomun;
        $fecha_ini = date('Y-m-j', strtotime(date("Y", strtotime($fechafirma)) . '-' . date("m", strtotime($fechafirma)) . '-' . 1));
        $fecha_ini2 = $fechafirma;
        $dia_original = date("d", strtotime($fechafirma));
        $arriendo = $request->arriendo;
        $comision = $request->comision;
        $pagonotaria = $request->pagonotaria;
        $nombre_otropago1 = $request->nombre_otropago1;
        $nombre_otropago2 = $request->nombre_otropago2;
        $pagootro1 = $request->pagootro1;
        $pagootro2 = $request->pagootro2;
        $garantia = $request->garantia;
        $pie = $request->pie;
        $descuento = $request->descuento;
        
        $id_creador = Auth::user()->id;
                $dia = date("d", strtotime($fecha_ini));
                $mes = date("m", strtotime($fecha_ini));
                $anio = date("Y", strtotime($fecha_ini));

   $simula = SimulaPropietario::create([
                            'meses_contrato' => $meses_contrato,
                            'id_publicacion' => $idp,
                            'id_inmueble' => $idinmueble,
                            'id_propietario' => $idpropietario,
                            'fecha_iniciocontrato' => $fechafirma,
                            'dia' => $dia,
                            'mes' => $mes,
                            'anio' => $anio,
                            'moneda' => $tipomoneda,
                            'valormoneda' => $valormoneda,
                            'id_creador' => $id_creador,
                            'id_modificador' => $id_creador,
                            'id_estado' => 1,
                            'canondearriendo' => $arriendo
                ]);

            $idsimulacion=$simula->id;
            $primer_mes=0;

        $fecha_ini = date('Y-m-j', strtotime(date("Y", strtotime($fechafirma)) . '-' . date("m", strtotime($fechafirma)) . '-' . 1));

        //arriendo
            $idtipopago = 1;
            $dias_mes = cal_days_in_month(CAL_GREGORIAN, date("m", strtotime($fecha_ini)), date("Y", strtotime($fecha_ini)));
            $valor_diario = $arriendo / $dias_mes;
            $dias_proporcionales = cal_days_in_month(CAL_GREGORIAN, date("m", strtotime($fecha_ini2)), date("Y", strtotime($fecha_ini2))) - date("d", strtotime($fecha_ini2)) + 1;
            $precio_proporcional = $dias_proporcionales * $valor_diario;
            $valor_en_pesos = $precio_proporcional * $valormoneda;
            $ini = 0;
            if ($dias_proporcionales > 0) {
                $ini = 1;
                $dia = date("d", strtotime($fecha_ini));
                $mes = date("m", strtotime($fecha_ini));
                $anio = date("Y", strtotime($fecha_ini));
                $dias_mes = cal_days_in_month(CAL_GREGORIAN, date("m", strtotime($fecha_ini)), date("Y", strtotime($fecha_ini)));
                $fecha_ini = date("d-m-Y", strtotime("+1 month", strtotime($fecha_ini)));

                $pago = SimulaPagoPropietario::create([
                            'id_simulacion' => $idsimulacion,
                            'id_publicacion' => $idp,
                            'id_inmueble' => $idinmueble,
                            'id_propietario' => $idpropietario,
                            'tipo' => 1,
                            'tipopago' => "Canon de Arriendo",
                            'idtipopago' => $idtipopago,
                            'meses_contrato' => $meses_contrato,
                            'fecha_iniciocontrato' => $fechafirma,
                            'dia' => $dia,
                            'mes' => $mes,
                            'anio' => $anio,
                            'cant_diasmes' => $dias_mes,
                            'cant_diasproporcional' => $dias_proporcionales,
                            'moneda' => $tipomoneda,
                            'valormoneda' => $valormoneda,
                            'valordia' => $valor_diario,
                            'precio_en_moneda' => $precio_proporcional,
                            'precio_en_pesos' => ceil($valor_en_pesos),
                            'id_creador' => $id_creador,
                            'id_modificador' => $id_creador,
                            'id_estado' => 1,
                            'canondearriendo' => $arriendo
                ]);
                
            }

            for ($i = $ini; $i < $cant_meses; $i++) {

                $dia = date("d", strtotime($fecha_ini));
                $mes = date("m", strtotime($fecha_ini));
                $anio = date("Y", strtotime($fecha_ini));

                $dias_mes = cal_days_in_month(CAL_GREGORIAN, date("m", strtotime($fecha_ini)), date("Y", strtotime($fecha_ini)));
                $dias_proporcionales = cal_days_in_month(CAL_GREGORIAN, date("m", strtotime($fecha_ini)), date("Y", strtotime($fecha_ini)));
                $fecha_ini = date("d-m-Y", strtotime("+1 month", strtotime($fecha_ini)));
                $pago = SimulaPagoPropietario::create([
                            'id_simulacion' => $idsimulacion,
                            'id_publicacion' => $idp,
                            'id_inmueble' => $idinmueble,
                            'id_propietario' => $idpropietario,
                            'tipo' => 1,
                            'tipopago' => "Canon de Arriendo",
                            'idtipopago' => $idtipopago,
                            'meses_contrato' => $meses_contrato,
                            'fecha_iniciocontrato' => $fechafirma,
                            'dia' => $dia,
                            'mes' => $mes,
                            'anio' => $anio,
                            'cant_diasmes' => $dias_mes,
                            'cant_diasproporcional' => $dias_proporcionales,
                            'moneda' => $tipomoneda,
                            'valormoneda' => $valormoneda,
                            'valordia' => $valor_diario,
                            'precio_en_moneda' => $arriendo,
                            'precio_en_pesos' => ceil($arriendo * $valormoneda),
                            'id_creador' => $id_creador,
                            'id_modificador' => $id_creador,
                            'id_estado' => 1,
                            'canondearriendo' => $arriendo
                ]);
            }
        


        if($gastocomun!="" && $gastocomun!=null){

            $idtipopago = 2;
            $dias_mes = cal_days_in_month(CAL_GREGORIAN, date("m", strtotime($fecha_ini2)), date("Y", strtotime($fecha_ini2)));
            $valor_diario = $gastocomun / $dias_mes;
            $dias_proporcionales = cal_days_in_month(CAL_GREGORIAN, date("m", strtotime($fecha_ini2)), date("Y", strtotime($fecha_ini2))) - date("d", strtotime($fecha_ini2)) + 1;

            $precio_proporcional = $dias_proporcionales * $valor_diario;
            $valor_en_pesos = $precio_proporcional * $valormoneda;
            $ini = 0;

            if ($dias_proporcionales > 0) {
                $ini = 1;
                $dia = date("d", strtotime($fecha_ini));
                $mes = date("m", strtotime($fecha_ini));
                $anio = date("Y", strtotime($fecha_ini));
                $dias_mes = cal_days_in_month(CAL_GREGORIAN, date("m", strtotime($fecha_ini)), date("Y", strtotime($fecha_ini)));
                $fecha_ini = date("d-m-Y", strtotime("+1 month", strtotime($fecha_ini)));

             $pago = SimulaPagoPropietario::create([
                            'id_simulacion' => $idsimulacion,
                            'id_publicacion' => $idp,
                            'id_inmueble' => $idinmueble,
                            'id_propietario' => $idpropietario,
                            'tipo' => 1,
                            'tipopago' => "Gasto Común",
                            'idtipopago' => $idtipopago,
                            'meses_contrato' => $meses_contrato,
                            'fecha_iniciocontrato' => $fechafirma,
                            'dia' => $dia,
                            'mes' => $mes,
                            'anio' => $anio,
                            'cant_diasmes' => $dias_mes,
                            'cant_diasproporcional' => $dias_proporcionales,
                            'moneda' => $tipomoneda,
                            'valormoneda' => $valormoneda,
                            'valordia' => $valor_diario,
                            'precio_en_moneda' => $precio_proporcional,
                            'precio_en_pesos' => ceil($valor_en_pesos),
                            'id_creador' => $id_creador,
                            'id_modificador' => $id_creador,
                            'id_estado' => 1,
                            'canondearriendo' => $arriendo
                ]);
             $primer_mes+=ceil($valor_en_pesos);
            }
            for ($i = $ini; $i < $cant_meses; $i++) {
                $dia = date("d", strtotime($fecha_ini));
                $mes = date("m", strtotime($fecha_ini));
                $anio = date("Y", strtotime($fecha_ini));
                $dias_mes = cal_days_in_month(CAL_GREGORIAN, date("m", strtotime($fecha_ini)), date("Y", strtotime($fecha_ini)));
                $fecha_ini = date("d-m-Y", strtotime("+1 month", strtotime($fecha_ini)));
            
            $pago = SimulaPagoPropietario::create([
                            'id_simulacion' => $idsimulacion,
                            'id_publicacion' => $idp,
                            'id_inmueble' => $idinmueble,
                            'id_propietario' => $idpropietario,
                            'tipopago' => "Gasto Común",
                            'tipo' => 1,
                            'idtipopago' => $idtipopago,
                            'meses_contrato' => $meses_contrato,
                            'fecha_iniciocontrato' => $fechafirma,
                            'dia' => $dia,
                            'mes' => $mes,
                            'anio' => $anio,
                            'cant_diasmes' => $dias_mes,
                            'cant_diasproporcional' => $dias_proporcionales,
                            'moneda' => $tipomoneda,
                            'valormoneda' => $valormoneda,
                            'valordia' => $valor_diario,
                            'precio_en_moneda' => $gastocomun,
                            'precio_en_pesos' => ceil($gastocomun * $valormoneda),
                            'id_creador' => $id_creador,
                            'id_modificador' => $id_creador,
                            'id_estado' => 1,
                            'canondearriendo' => $arriendo
                ]);
            }
        }

        $fecha_ini = date('Y-m-j', strtotime(date("Y", strtotime($fechafirma)) . '-' . date("m", strtotime($fechafirma)) . '-' . 1));
        //pago 1 cuota

            $idtipopago = 3;
            $dias_mes = cal_days_in_month(CAL_GREGORIAN, date("m", strtotime($fecha_ini)), date("Y", strtotime($fecha_ini)));
            $valor_en_pesos = ($arriendo-($arriendo*($descuento/100)));
            $dia = date("d", strtotime($fecha_ini));
            $mes = date("m", strtotime($fecha_ini));
            $anio = date("Y", strtotime($fecha_ini));
            $dias_mes = cal_days_in_month(CAL_GREGORIAN, date("m", strtotime($fecha_ini)), date("Y", strtotime($fecha_ini)));

             $pago = SimulaPagoPropietario::create([
                            'id_simulacion' => $idsimulacion,
                            'id_publicacion' => $idp,
                            'id_inmueble' => $idinmueble,
                            'id_propietario' => $idpropietario,
                            'tipo' => 1,
                            'tipopago' => "Cuota",
                            'idtipopago' => $idtipopago,
                            'meses_contrato' => $meses_contrato,
                            'fecha_iniciocontrato' => $fechafirma,
                            'dia' => $dia,
                            'mes' => $mes,
                            'anio' => $anio,
                            'cant_diasmes' => $dias_mes,
                            'cant_diasproporcional' => $dias_mes,
                            'moneda' => $tipomoneda,
                            'valormoneda' => $valormoneda,
                            'valordia' => 1,
                            'precio_en_moneda' => $valor_en_pesos,
                            'precio_en_pesos' => ceil($valor_en_pesos),
                            'id_creador' => $id_creador,
                            'id_modificador' => $id_creador,
                            'id_estado' => 1,
                            'canondearriendo' => $arriendo
                ]);
        $primer_mes+=ceil($valor_en_pesos);


        
        //pago iva

            $idtipopago = 4;
 
             $pago = SimulaPagoPropietario::create([
                            'id_simulacion' => $idsimulacion,
                            'id_publicacion' => $idp,
                            'id_inmueble' => $idinmueble,
                            'id_propietario' => $idpropietario,
                            'tipo' => 1,
                            'tipopago' => "Iva",
                            'idtipopago' => $idtipopago,
                            'meses_contrato' => $meses_contrato,
                            'fecha_iniciocontrato' => $fechafirma,
                            'dia' => $dia,
                            'mes' => $mes,
                            'anio' => $anio,
                            'cant_diasmes' => $dias_mes,
                            'cant_diasproporcional' => $dias_mes,
                            'moneda' => $tipomoneda,
                            'valormoneda' => $valormoneda,
                            'valordia' => 1,
                            'precio_en_moneda' => $valor_en_pesos*0.19,
                            'precio_en_pesos' => ceil($valor_en_pesos*0.19),
                            'id_creador' => $id_creador,
                            'id_modificador' => $id_creador,
                            'id_estado' => 1,
                            'canondearriendo' => $arriendo
                ]);
            $primer_mes+=ceil($valor_en_pesos*0.19);

       if($pagonotaria!="" && $pagonotaria!=null){
        //Notaria
            $idtipopago = 5;
            $precio_proporcional = $pagonotaria;
            $valor_en_pesos = $pagonotaria;
 
             $pago = SimulaPagoPropietario::create([
                            'id_simulacion' => $idsimulacion,
                            'id_publicacion' => $idp,
                            'id_inmueble' => $idinmueble,
                            'id_propietario' => $idpropietario,
                            'tipo' => 1,
                            'tipopago' => "Notaria",
                            'idtipopago' => $idtipopago,
                            'meses_contrato' => $meses_contrato,
                            'fecha_iniciocontrato' => $fechafirma,
                            'dia' => $dia,
                            'mes' => $mes,
                            'anio' => $anio,
                            'cant_diasmes' => $dias_mes,
                            'cant_diasproporcional' => $dias_mes,
                            'moneda' => $tipomoneda,
                            'valormoneda' => $valormoneda,
                            'valordia' => 1,
                            'precio_en_moneda' => $valor_en_pesos,
                            'precio_en_pesos' => ceil($valor_en_pesos),
                            'id_creador' => $id_creador,
                            'id_modificador' => $id_creador,
                            'id_estado' => 1,
                            'canondearriendo' => $arriendo
                ]);

             $primer_mes+=ceil($valor_en_pesos);
         }
         
             if($nombre_otropago1!=null && $nombre_otropago1!="" ){
        //Otro Pago 1
            $idtipopago = 6;
            $precio_proporcional = $pagootro1;
            $valor_en_pesos = $pagootro1;
 
             $pago = SimulaPagoPropietario::create([
                            'id_simulacion' => $idsimulacion,
                            'id_publicacion' => $idp,
                            'id_inmueble' => $idinmueble,
                            'id_propietario' => $idpropietario,
                            'tipo' => 1,
                            'tipopago' => $nombre_otropago1,
                            'idtipopago' => $idtipopago,
                            'meses_contrato' => $meses_contrato,
                            'fecha_iniciocontrato' => $fechafirma,
                            'dia' => $dia,
                            'mes' => $mes,
                            'anio' => $anio,
                            'cant_diasmes' => $dias_mes,
                            'cant_diasproporcional' => $dias_mes,
                            'moneda' => $tipomoneda,
                            'valormoneda' => $valormoneda,
                            'valordia' => 1,
                            'precio_en_moneda' => $valor_en_pesos,
                            'precio_en_pesos' => ceil($valor_en_pesos),
                            'id_creador' => $id_creador,
                            'id_modificador' => $id_creador,
                            'id_estado' => 1,
                            'canondearriendo' => $arriendo
                ]);
             $primer_mes+=ceil($valor_en_pesos);
         }
         if($nombre_otropago1!=null && $nombre_otropago1!="" ){
        //Otro Pago 2
            $idtipopago = 7;
            $precio_proporcional = $pagootro2;
            $valor_en_pesos = $pagootro2;
 
             $pago = SimulaPagoPropietario::create([
                            'id_simulacion' => $idsimulacion,
                            'id_publicacion' => $idp,
                            'id_inmueble' => $idinmueble,
                            'id_propietario' => $idpropietario,
                            'tipo' => 1,
                            'tipopago' => $nombre_otropago2,
                            'idtipopago' => $idtipopago,
                            'meses_contrato' => $meses_contrato,
                            'fecha_iniciocontrato' => $fechafirma,
                            'dia' => $dia,
                            'mes' => $mes,
                            'anio' => $anio,
                            'cant_diasmes' => $dias_mes,
                            'cant_diasproporcional' => $dias_mes,
                            'moneda' => $tipomoneda,
                            'valormoneda' => $valormoneda,
                            'valordia' => 1,
                            'precio_en_moneda' => $valor_en_pesos,
                            'precio_en_pesos' => ceil($valor_en_pesos),
                            'id_creador' => $id_creador,
                            'id_modificador' => $id_creador,
                            'id_estado' => 1,
                            'canondearriendo' => $arriendo
                ]);

            $primer_mes+=ceil($valor_en_pesos);
             }
             //Pendiente Mes Anterior
              $fecha_ini = date('Y-m-j', strtotime(date("Y", strtotime($fechafirma)) . '-' . date("m", strtotime($fechafirma)) . '-' . 1));
            $idtipopago = 8;


            $pendiente=$arriendo-$primer_mes;

            if(($arriendo-$primer_mes)<0){
               $pendiente= ($arriendo-$primer_mes)*-1;
               $fecha_ini = date("d-m-Y", strtotime("+1 month", strtotime($fecha_ini)));
                $dias_mes = cal_days_in_month(CAL_GREGORIAN, date("m", strtotime($fecha_ini)), date("Y", strtotime($fecha_ini)));
                            $dia = date("d", strtotime($fecha_ini));
            $mes = date("m", strtotime($fecha_ini));
            $anio = date("Y", strtotime($fecha_ini));
               $pago = SimulaPagoPropietario::create([
                            'id_simulacion' => $idsimulacion,
                            'id_publicacion' => $idp,
                            'id_inmueble' => $idinmueble,
                            'id_propietario' => $idpropietario,
                            'tipo' => 1,
                            'tipopago' => "Pago Pendiente",
                            'idtipopago' => $idtipopago,
                            'meses_contrato' => $meses_contrato,
                            'fecha_iniciocontrato' => $fechafirma,
                            'dia' => $dia,
                            'mes' => $mes,
                            'anio' => $anio,
                            'cant_diasmes' => $dias_mes,
                            'cant_diasproporcional' => $dias_mes,
                            'moneda' => $tipomoneda,
                            'valormoneda' => $valormoneda,
                            'valordia' => 1,
                            'precio_en_moneda' => $pendiente,
                            'precio_en_pesos' => ceil($pendiente),
                            'id_creador' => $id_creador,
                            'id_modificador' => $id_creador,
                            'id_estado' => 1,
                            'canondearriendo' => $arriendo
                ]);
            }

             

/*
        $fecha_ini = date('Y-m-j', strtotime(date("Y", strtotime($fechafirma)) . '-' . date("m", strtotime($fechafirma)) . '-' . 1));
        for ($i = 0; $i < $meses_contrato; $i++) {
            $mes = date("m", strtotime($fecha_ini));
            $anio = date("Y", strtotime($fecha_ini));
            $fecha_ini = date("d-m-Y", strtotime("+1 month", strtotime($fecha_ini)));
            $pagos_mensuales_e = DB::table('adm_pagospropietarios')
                    ->where("id_publicacion", "=", $idp)
                    ->where("E_S", "=", "e")
                    ->where("id_inmueble", "=", $idinmueble)
                    ->where("mes", "=", $mes)
                    ->where("anio", "=", $anio)
                    ->sum('precio_en_pesos');
            $pagos_mensuales_s = DB::table('adm_pagospropietarios')
                    ->where("id_publicacion", "=", $idp)
                    ->where("E_S", "=", "s")
                    ->where("id_inmueble", "=", $idinmueble)
                    ->where("mes", "=", $mes)
                    ->where("anio", "=", $anio)
                    ->sum('precio_en_pesos');

            $pagar_a_propietario=$pagos_mensuales_s-$pagos_mensuales_e;
            $pagar_a_baquedano=$pagos_mensuales_e-$pagos_mensuales_s;

            if($pagar_a_propietario<0)
                $pagar_a_propietario=0;

            if($pagar_a_baquedano<0)
                $pagar_a_baquedano=0;
//dd($pagar_a_propietario."    ".$pagar_a_baquedano."       e:".$pagos_mensuales_e."        s:".$pagos_mensuales_s );
            $delete=PagosMensualesPropietarios::where("id_contratofinal","=",$idcontrato)
                    ->where("id_publicacion","=",$idp)
                    ->where("id_inmueble","=",$idinmueble)
                    ->where("E_S","=",'e')
                    ->where("mes","=",$mes)
                    ->where("anio","=",$anio)
                    ->delete();

            $pago_mensual = PagosMensualesPropietarios::create([
                        'id_contratofinal' => $idcontrato,
                        'id_publicacion' => $idp,
                        'id_inmueble' => $idinmueble,
                        'E_S' => 'e',
                        'fecha_iniciocontrato' => $fechafirma,
                        'mes' => $mes,
                        'anio' => $anio,
                        'subtotal_entrada' => $pagos_mensuales_e,
                        'subtotal_salida' => $pagos_mensuales_s,
                        'pago_propietario' => $pagar_a_propietario,
                        'pago_rentas' => $pagar_a_baquedano,
                        'id_creador' => Auth::user()->id,
                        'id_modificador' => Auth::user()->id,
                        'id_estado' => 1
            ]);

           
        }
        if($texto=="Pero no fue posible generar nuevamente los siguientes items, ya que deben ser borrados primero : "){
            $texto="";
        }
        return redirect()->route('finalContrato.edit', [$idp, 0, 0, 4])
                        ->with('status', 'Pagos Generados con éxito '.$texto);
           */            
    }

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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\SimulaPropietario  $simulaPropietario
     * @return \Illuminate\Http\Response
     */
    public function show(SimulaPropietario $simulaPropietario)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\SimulaPropietario  $simulaPropietario
     * @return \Illuminate\Http\Response
     */
    public function edit(SimulaPropietario $simulaPropietario)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\SimulaPropietario  $simulaPropietario
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SimulaPropietario $simulaPropietario)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\SimulaPropietario  $simulaPropietario
     * @return \Illuminate\Http\Response
     */
    public function destroy(SimulaPropietario $simulaPropietario)
    {
        //
    }
}
