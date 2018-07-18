<?php

namespace App\Http\Controllers;

use App\SimulaArrendatario;
use App\Arrendatario;
use App\SimulaPagoArrendatario;
use App\SimulaMensualPropietario;
use App\ArrendatarioGarantia;
use Illuminate\Http\Request;
use DB;
use Auth;
use Excel;

class SimulaArrendatarioController extends Controller
{
     public function generarpagos(Request $request, $idp) {

        //general para pago 1 cuota

        $captacion = Arrendatario::find($idp);

        $idinmueble = $captacion->id_inmueble;
        $idpropietario = $captacion->id_arrendatario;
        $cant_meses = $request->cant_meses;
        $meses_contrato = $request->cant_meses;
        $fechafirma = $request->fecha_firmapago;
        $tipomoneda = $request->moneda;
        $valormoneda = $request->valormoneda;
        $iva = $request->iva;
        $nrocuotas = $request->cuotas;
        $cobromensual = $request->cobromensual;
        $tipopropuesta = $request->propuesta;

        //pagos
        $gastocomun = $request->gastocomun_sim;
        $fecha_ini = date('Y-m-j', strtotime(date("Y", strtotime($fechafirma)) . '-' . date("m", strtotime($fechafirma)) . '-' . 1));
        $fecha_ini2 = $fechafirma;
        $dia_original = date("d", strtotime($fechafirma));
        $arriendo = $request->arriendo_sim;
        $comision = $request->comision;
        $pagonotaria = $request->pagonotaria;
        $nombre_otropago1 = $request->nombre_otropago1;
        $nombre_otropago2 = $request->nombre_otropago2;
        $pagootro1 = $request->pagootro1;
        $pagootro2 = $request->pagootro2;
        $pie = $request->pie;
        $descuento = $request->descuento;
        $proporcional = $request->proporcional;

        $id_creador = Auth::user()->id;
        $dia = date("d", strtotime($fecha_ini));
        $mes = date("m", strtotime($fecha_ini));
        $anio = date("Y", strtotime($fecha_ini));

        $simula = SimulaArrendatario::create([
                    'meses_contrato' => $meses_contrato,
                    'id_publicacion' => $idp,
                    'id_inmueble' => $idinmueble,
                    'id_arrendatario' => $idpropietario,
                    'fecha_iniciocontrato' => $fechafirma,
                    'proporcional' => $proporcional,
                    'dia' => $dia,
                    'mes' => $mes,
                    'anio' => $anio,
                    'iva' => $iva,
                    'descuento' => $descuento,
                    'pie' => $pie,
                    'cobromensual' => $cobromensual,
                    'tipopropuesta' => $tipopropuesta,
                    'nrocuotas' => $nrocuotas,
                    'moneda' => $tipomoneda,
                    'gastocomun' => $gastocomun,
                    'notaria' => $pagonotaria,
                    'otro1' => $pagootro1,
                    'otro2' => $pagootro2,
                    'nomotro1' => $nombre_otropago1,
                    'nomotro2' => $nombre_otropago2,
                    'valormoneda' => $valormoneda,
                    'id_creador' => $id_creador,
                    'id_modificador' => $id_creador,
                    'id_estado' => 1,
                    'canondearriendo' => $arriendo
        ]);

        $idsimulacion = $simula->id;
        $primer_mes = 0;

        $fecha_ini = date('Y-m-j', strtotime(date("Y", strtotime($fechafirma)) . '-' . date("m", strtotime($fechafirma)) . '-' . 1));

        //arriendo
        $idtipopago = 1;
        if ($proporcional == 'SI') {
            $dias_mes = cal_days_in_month(CAL_GREGORIAN, date("m", strtotime($fecha_ini)), date("Y", strtotime($fecha_ini)));
            $valor_diario = $arriendo / $dias_mes;
            $dias_proporcionales = cal_days_in_month(CAL_GREGORIAN, date("m", strtotime($fechafirma)), date("Y", strtotime($fechafirma))) - date("d", strtotime($fechafirma)) + 1;
            $precio_proporcional = $dias_proporcionales * $valor_diario;
            $valor_en_pesos = $precio_proporcional * $valormoneda;
            $valor_en_pesos_proporcional = $valor_en_pesos + $arriendo;

            $fecha_ini = date("d-m-Y", strtotime("+1 month", strtotime($fecha_ini)));
            $fecha_ini = date('Y-m-j', strtotime(date("Y", strtotime($fecha_ini)) . '-' . date("m", strtotime($fecha_ini)) . '-' . 1));
            $fechafirma = date('Y-m-j', strtotime(date("Y", strtotime($fecha_ini)) . '-' . date("m", strtotime($fecha_ini)) . '-' . 1));
            $dia = 1;
            $mes = date("m", strtotime($fecha_ini));
            $anio = date("Y", strtotime($fecha_ini));
            $dias_mes = cal_days_in_month(CAL_GREGORIAN, date("m", strtotime($fecha_ini)), date("Y", strtotime($fecha_ini)));
            $pago = SimulaPagoArrendatario::create([
                        'id_simulacion' => $idsimulacion,
                        'id_publicacion' => $idp,
                        'id_inmueble' => $idinmueble,
                        'id_arrendatario' => $idpropietario,
                        'tipo' => 1,
                        'tipopago' => "Valor días proporcionales",
                        'idtipopago' => 8,
                        'meses_contrato' => $meses_contrato,
                        'fecha_iniciocontrato' => $fechafirma,
                        'dia' => $dia,
                        'mes' => $mes,
                        'anio' => $anio,
                        'descuento' => $descuento,
                        'cant_diasmes' => $dias_mes,
                        'cant_diasproporcional' => $dias_proporcionales,
                        'moneda' => $tipomoneda,
                        'valormoneda' => $valormoneda,
                        'valordia' => $valor_diario,
                        'precio_en_moneda' => $precio_proporcional,
                        'precio_en_pesos' => $valor_en_pesos,
                        'id_creador' => $id_creador,
                        'id_modificador' => $id_creador,
                        'id_estado' => 1,
                        'canondearriendo' => $arriendo
            ]);
            $primer_mes += $valor_en_pesos;
        } else {
            
        }


        $dias_mes = cal_days_in_month(CAL_GREGORIAN, date("m", strtotime($fecha_ini)), date("Y", strtotime($fecha_ini)));
        $valor_diario = $arriendo / $dias_mes;
        $dias_proporcionales = cal_days_in_month(CAL_GREGORIAN, date("m", strtotime($fechafirma)), date("Y", strtotime($fechafirma))) - date("d", strtotime($fechafirma)) + 1;
        $precio_proporcional = $dias_proporcionales * $valor_diario;
        $valor_en_pesos = $precio_proporcional * $valormoneda;
        $valor_en_pesos_proporcional = $valor_en_pesos;
        $ini = 0;
        if ($dias_proporcionales > 0) {
            $ini = 1;
            $dia = date("d", strtotime($fecha_ini));
            $mes = date("m", strtotime($fecha_ini));
            $anio = date("Y", strtotime($fecha_ini));
            $dias_mes = cal_days_in_month(CAL_GREGORIAN, date("m", strtotime($fecha_ini)), date("Y", strtotime($fecha_ini)));
            $fecha_ini = date("d-m-Y", strtotime("+1 month", strtotime($fecha_ini)));

            $pago = SimulaPagoArrendatario::create([
                        'id_simulacion' => $idsimulacion,
                        'id_publicacion' => $idp,
                        'id_inmueble' => $idinmueble,
                        'id_arrendatario' => $idpropietario,
                        'tipo' => 1,
                        'tipopago' => "Canon de Arriendo",
                        'idtipopago' => $idtipopago,
                        'meses_contrato' => $meses_contrato,
                        'fecha_iniciocontrato' => $fechafirma,
                        'dia' => $dia,
                        'mes' => $mes,
                        'anio' => $anio,
                        'descuento' => $descuento,
                        'cant_diasmes' => $dias_mes,
                        'cant_diasproporcional' => $dias_proporcionales,
                        'moneda' => $tipomoneda,
                        'valormoneda' => $valormoneda,
                        'valordia' => $valor_diario,
                        'precio_en_moneda' => $precio_proporcional,
                        'precio_en_pesos' => $valor_en_pesos,
                        'id_creador' => $id_creador,
                        'id_modificador' => $id_creador,
                        'id_estado' => 1,
                        'canondearriendo' => $arriendo
            ]);
        }

        $dias_mes = cal_days_in_month(CAL_GREGORIAN, date("m", strtotime($fecha_ini)), date("Y", strtotime($fecha_ini)));
        $valor_diario = $arriendo / $dias_mes;
        for ($i = $ini; $i < $cant_meses; $i++) {

            $dia = date("d", strtotime($fecha_ini));
            $mes = date("m", strtotime($fecha_ini));
            $anio = date("Y", strtotime($fecha_ini));

            $dias_mes = cal_days_in_month(CAL_GREGORIAN, date("m", strtotime($fecha_ini)), date("Y", strtotime($fecha_ini)));
            $dias_proporcionales = cal_days_in_month(CAL_GREGORIAN, date("m", strtotime($fecha_ini)), date("Y", strtotime($fecha_ini)));
            $fecha_ini = date("d-m-Y", strtotime("+1 month", strtotime($fecha_ini)));
            $pago = SimulaPagoArrendatario::create([
                        'id_simulacion' => $idsimulacion,
                        'id_publicacion' => $idp,
                        'id_inmueble' => $idinmueble,
                        'id_arrendatario' => $idpropietario,
                        'tipo' => 1,
                        'tipopago' => "Canon de Arriendo",
                        'idtipopago' => $idtipopago,
                        'meses_contrato' => $meses_contrato,
                        'fecha_iniciocontrato' => $fechafirma,
                        'dia' => $dia,
                        'mes' => $mes,
                        'anio' => $anio,
                        'descuento' => $descuento,
                        'cant_diasmes' => $dias_mes,
                        'cant_diasproporcional' => $dias_proporcionales,
                        'moneda' => $tipomoneda,
                        'valormoneda' => $valormoneda,
                        'valordia' => $valor_diario,
                        'precio_en_moneda' => $arriendo,
                        'precio_en_pesos' => $arriendo * $valormoneda,
                        'id_creador' => $id_creador,
                        'id_modificador' => $id_creador,
                        'id_estado' => 1,
                        'canondearriendo' => $arriendo
            ]);
        }



        if ($gastocomun != 0) {
$fecha_ini = date('Y-m-j', strtotime(date("Y", strtotime($fechafirma)) . '-' . date("m", strtotime($fechafirma)) . '-' . 1));
            $idtipopago = 2;
            $dias_mes = cal_days_in_month(CAL_GREGORIAN, date("m", strtotime($fecha_ini)), date("Y", strtotime($fecha_ini)));
            $valor_diario = $gastocomun / $dias_mes;
            $dias_proporcionales = cal_days_in_month(CAL_GREGORIAN, date("m", strtotime($fecha_ini)), date("Y", strtotime($fecha_ini))) - date("d", strtotime($fecha_ini)) + 1;

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

                $pago = SimulaPagoArrendatario::create([
                            'id_simulacion' => $idsimulacion,
                            'id_publicacion' => $idp,
                            'id_inmueble' => $idinmueble,
                            'id_arrendatario' => $idpropietario,
                            'tipo' => 1,
                            'tipopago' => "Gasto Común",
                            'idtipopago' => $idtipopago,
                            'meses_contrato' => $meses_contrato,
                            'fecha_iniciocontrato' => $fechafirma,
                            'dia' => $dia,
                            'mes' => $mes,
                            'anio' => $anio,
                            'descuento' => $descuento,
                            'cant_diasmes' => $dias_mes,
                            'cant_diasproporcional' => $dias_proporcionales,
                            'moneda' => $tipomoneda,
                            'valormoneda' => $valormoneda,
                            'valordia' => $valor_diario,
                            'precio_en_moneda' => $precio_proporcional,
                            'precio_en_pesos' => $valor_en_pesos,
                            'id_creador' => $id_creador,
                            'id_modificador' => $id_creador,
                            'id_estado' => 1,
                            'canondearriendo' => $arriendo
                ]);
                $primer_mes += $valor_en_pesos;
            }
            for ($i = $ini; $i < $cant_meses; $i++) {
                $dia = date("d", strtotime($fecha_ini));
                $mes = date("m", strtotime($fecha_ini));
                $anio = date("Y", strtotime($fecha_ini));
                $dias_mes = cal_days_in_month(CAL_GREGORIAN, date("m", strtotime($fecha_ini)), date("Y", strtotime($fecha_ini)));
                $fecha_ini = date("d-m-Y", strtotime("+1 month", strtotime($fecha_ini)));

                $pago = SimulaPagoArrendatario::create([
                            'id_simulacion' => $idsimulacion,
                            'id_publicacion' => $idp,
                            'id_inmueble' => $idinmueble,
                            'id_arrendatario' => $idpropietario,
                            'tipopago' => "Gasto Común",
                            'tipo' => 1,
                            'idtipopago' => $idtipopago,
                            'meses_contrato' => $meses_contrato,
                            'fecha_iniciocontrato' => $fechafirma,
                            'dia' => $dia,
                            'mes' => $mes,
                            'anio' => $anio,
                            'descuento' => $descuento,
                            'cant_diasmes' => $dias_mes,
                            'cant_diasproporcional' => $dias_proporcionales,
                            'moneda' => $tipomoneda,
                            'valormoneda' => $valormoneda,
                            'valordia' => $valor_diario,
                            'precio_en_moneda' => $gastocomun,
                            'precio_en_pesos' => $gastocomun * $valormoneda,
                            'id_creador' => $id_creador,
                            'id_modificador' => $id_creador,
                            'id_estado' => 1,
                            'canondearriendo' => $arriendo
                ]);
            }
        }
        if ($tipopropuesta == 1) {
            $fecha_ini = date('Y-m-j', strtotime(date("Y", strtotime($fechafirma)) . '-' . date("m", strtotime($fechafirma)) . '-' . 1));
            //pago 1 cuota

            $idtipopago = 3;
            $dias_mes = cal_days_in_month(CAL_GREGORIAN, date("m", strtotime($fecha_ini)), date("Y", strtotime($fecha_ini)));
            $valor_en_pesos = ($arriendo - ($arriendo * ($descuento / 100)));
            $dia = date("d", strtotime($fecha_ini));
            $mes = date("m", strtotime($fecha_ini));
            $anio = date("Y", strtotime($fecha_ini));
            $dias_mes = cal_days_in_month(CAL_GREGORIAN, date("m", strtotime($fecha_ini)), date("Y", strtotime($fecha_ini)));
            $valor_en_pesos_con_desc = $valor_en_pesos;
            $pago = SimulaPagoArrendatario::create([
                        'id_simulacion' => $idsimulacion,
                        'id_publicacion' => $idp,
                        'id_inmueble' => $idinmueble,
                        'id_arrendatario' => $idpropietario,
                        'tipo' => 1,
                        'tipopago' => "Cuota",
                        'idtipopago' => $idtipopago,
                        'meses_contrato' => $meses_contrato,
                        'fecha_iniciocontrato' => $fechafirma,
                        'dia' => $dia,
                        'mes' => $mes,
                        'anio' => $anio,
                        'descuento' => $descuento,
                        'cant_diasmes' => $dias_mes,
                        'cant_diasproporcional' => $dias_mes,
                        'moneda' => $tipomoneda,
                        'valormoneda' => $valormoneda,
                        'valordia' => 1,
                        'precio_en_moneda' => $valor_en_pesos,
                        'precio_en_pesos' => $valor_en_pesos,
                        'id_creador' => $id_creador,
                        'id_modificador' => $id_creador,
                        'id_estado' => 1,
                        'canondearriendo' => $arriendo
            ]);
            $primer_mes += $valor_en_pesos;
        }

        //pago iva
        if ($tipopropuesta == 1) {
            $idtipopago = 4;

            $pago = SimulaPagoArrendatario::create([
                        'id_simulacion' => $idsimulacion,
                        'id_publicacion' => $idp,
                        'id_inmueble' => $idinmueble,
                        'id_arrendatario' => $idpropietario,
                        'tipo' => 1,
                        'tipopago' => "Iva",
                        'idtipopago' => $idtipopago,
                        'meses_contrato' => $meses_contrato,
                        'fecha_iniciocontrato' => $fechafirma,
                        'dia' => $dia,
                        'mes' => $mes,
                        'anio' => $anio,
                        'descuento' => $descuento,
                        'cant_diasmes' => $dias_mes,
                        'cant_diasproporcional' => $dias_mes,
                        'moneda' => $tipomoneda,
                        'valormoneda' => $valormoneda,
                        'valordia' => 1,
                        'precio_en_moneda' => $valor_en_pesos_con_desc * ($iva / 100),
                        'precio_en_pesos' => $valor_en_pesos_con_desc * ($iva / 100),
                        'id_creador' => $id_creador,
                        'id_modificador' => $id_creador,
                        'id_estado' => 1,
                        'canondearriendo' => $arriendo
            ]);
            $primer_mes += $valor_en_pesos_con_desc * ($iva / 100);
        }

        $garantias=ArrendatarioGarantia::where("id_publicacion","=",$idp)->get();

        if (count($garantias) > 0) {
                foreach ($garantias as $g) {
                        $mes = $g->mes;
                        $anio = $g->ano;
                        $dias_mes = cal_days_in_month(CAL_GREGORIAN, $mes, $anio);
                        $idtipopago = 10;
                        $precio_proporcional = $g->valor;
                        $valor_en_pesos = $g->valor;
                        $pago = SimulaPagoArrendatario::create([
                        'id_simulacion' => $idsimulacion,
                        'id_publicacion' => $idp,
                        'id_inmueble' => $idinmueble,
                        'id_arrendatario' => $idpropietario,
                        'tipo' => 1,
                        'tipopago' => "Garantía",
                        'idtipopago' => $idtipopago,
                        'meses_contrato' => $meses_contrato,
                        'fecha_iniciocontrato' => $fechafirma,
                        'dia' => $dia,
                        'mes' => $mes,
                        'anio' => $anio,
                        'descuento' => $descuento,
                        'cant_diasmes' => $dias_mes,
                        'cant_diasproporcional' => $dias_mes,
                        'moneda' => $tipomoneda,
                        'valormoneda' => $valormoneda,
                        'valordia' => 1,
                        'precio_en_moneda' => $valor_en_pesos,
                        'precio_en_pesos' => $valor_en_pesos,
                        'id_creador' => $id_creador,
                        'id_modificador' => $id_creador,
                        'id_estado' => 1,
                        'canondearriendo' => $arriendo
            ]);
                        $primer_mes += $valor_en_pesos;
                }
            
        }
        
        if ($pagonotaria != 0) {
                    $fecha_ini = date('Y-m-j', strtotime(date("Y", strtotime($fechafirma)) . '-' . date("m", strtotime($fechafirma)) . '-' . 1));
                                    $dia = date("d", strtotime($fecha_ini));
                $mes = date("m", strtotime($fecha_ini));
                $anio = date("Y", strtotime($fecha_ini));
                $dias_mes = cal_days_in_month(CAL_GREGORIAN, date("m", strtotime($fecha_ini)), date("Y", strtotime($fecha_ini)));
            //Notaria
            $idtipopago = 5;
            $precio_proporcional = $pagonotaria;
            $valor_en_pesos = $pagonotaria;

            $pago = SimulaPagoArrendatario::create([
                        'id_simulacion' => $idsimulacion,
                        'id_publicacion' => $idp,
                        'id_inmueble' => $idinmueble,
                        'id_arrendatario' => $idpropietario,
                        'tipo' => 1,
                        'tipopago' => "Notaria",
                        'idtipopago' => $idtipopago,
                        'meses_contrato' => $meses_contrato,
                        'fecha_iniciocontrato' => $fechafirma,
                        'dia' => $dia,
                        'mes' => $mes,
                        'anio' => $anio,
                        'descuento' => $descuento,
                        'cant_diasmes' => $dias_mes,
                        'cant_diasproporcional' => $dias_mes,
                        'moneda' => $tipomoneda,
                        'valormoneda' => $valormoneda,
                        'valordia' => 1,
                        'precio_en_moneda' => $valor_en_pesos,
                        'precio_en_pesos' => $valor_en_pesos,
                        'id_creador' => $id_creador,
                        'id_modificador' => $id_creador,
                        'id_estado' => 1,
                        'canondearriendo' => $arriendo
            ]);

            $primer_mes += $valor_en_pesos;
        }

        if ($nombre_otropago1 != null && $nombre_otropago1 != "" && $pagootro1 != 0) {
            //Otro Pago 1
                        $fecha_ini = date('Y-m-j', strtotime(date("Y", strtotime($fechafirma)) . '-' . date("m", strtotime($fechafirma)) . '-' . 1));
                                    $dia = date("d", strtotime($fecha_ini));
                $mes = date("m", strtotime($fecha_ini));
                $anio = date("Y", strtotime($fecha_ini));
                $dias_mes = cal_days_in_month(CAL_GREGORIAN, date("m", strtotime($fecha_ini)), date("Y", strtotime($fecha_ini)));
            $idtipopago = 6;
            $precio_proporcional = $pagootro1;
            $valor_en_pesos = $pagootro1;

            $pago = SimulaPagoArrendatario::create([
                        'id_simulacion' => $idsimulacion,
                        'id_publicacion' => $idp,
                        'id_inmueble' => $idinmueble,
                        'id_arrendatario' => $idpropietario,
                        'tipo' => 1,
                        'tipopago' => $nombre_otropago1,
                        'idtipopago' => $idtipopago,
                        'meses_contrato' => $meses_contrato,
                        'fecha_iniciocontrato' => $fechafirma,
                        'dia' => $dia,
                        'mes' => $mes,
                        'anio' => $anio,
                        'descuento' => $descuento,
                        'cant_diasmes' => $dias_mes,
                        'cant_diasproporcional' => $dias_mes,
                        'moneda' => $tipomoneda,
                        'valormoneda' => $valormoneda,
                        'valordia' => 1,
                        'precio_en_moneda' => $valor_en_pesos,
                        'precio_en_pesos' => $valor_en_pesos,
                        'id_creador' => $id_creador,
                        'id_modificador' => $id_creador,
                        'id_estado' => 1,
                        'canondearriendo' => $arriendo
            ]);
            $primer_mes += $valor_en_pesos;
        }
        if ($nombre_otropago2 != null && $nombre_otropago2 != "" && $pagootro2 != 0) {
            //Otro Pago 2
                        $fecha_ini = date('Y-m-j', strtotime(date("Y", strtotime($fechafirma)) . '-' . date("m", strtotime($fechafirma)) . '-' . 1));
                                    $dia = date("d", strtotime($fecha_ini));
                $mes = date("m", strtotime($fecha_ini));
                $anio = date("Y", strtotime($fecha_ini));
                $dias_mes = cal_days_in_month(CAL_GREGORIAN, date("m", strtotime($fecha_ini)), date("Y", strtotime($fecha_ini)));
            $idtipopago = 7;
            $precio_proporcional = $pagootro2;
            $valor_en_pesos = $pagootro2;

            $pago = SimulaPagoArrendatario::create([
                        'id_simulacion' => $idsimulacion,
                        'id_publicacion' => $idp,
                        'id_inmueble' => $idinmueble,
                        'id_arrendatario' => $idpropietario,
                        'tipo' => 1,
                        'tipopago' => $nombre_otropago2,
                        'idtipopago' => $idtipopago,
                        'meses_contrato' => $meses_contrato,
                        'fecha_iniciocontrato' => $fechafirma,
                        'dia' => $dia,
                        'mes' => $mes,
                        'anio' => $anio,
                        'descuento' => $descuento,
                        'cant_diasmes' => $dias_mes,
                        'cant_diasproporcional' => $dias_mes,
                        'moneda' => $tipomoneda,
                        'valormoneda' => $valormoneda,
                        'valordia' => 1,
                        'precio_en_moneda' => $valor_en_pesos,
                        'precio_en_pesos' => $valor_en_pesos,
                        'id_creador' => $id_creador,
                        'id_modificador' => $id_creador,
                        'id_estado' => 1,
                        'canondearriendo' => $arriendo
            ]);

            $primer_mes += $valor_en_pesos;
        }

        if ($tipopropuesta == 1) {
            //Pendiente Mes Anterior
            $fecha_ini = date('Y-m-j', strtotime(date("Y", strtotime($fechafirma)) . '-' . date("m", strtotime($fechafirma)) . '-' . 1));
            $idtipopago = 15;


            $pendiente = $valor_en_pesos_proporcional - $primer_mes;

            if (($arriendo - $primer_mes) < 0) {
                $dia = date("d", strtotime($fecha_ini));
                $mes = date("m", strtotime($fecha_ini));
                $anio = date("Y", strtotime($fecha_ini));
                $dias_mes = cal_days_in_month(CAL_GREGORIAN, date("m", strtotime($fecha_ini)), date("Y", strtotime($fecha_ini)));
                $pago = SimulaPagoArrendatario::create([
                            'id_simulacion' => $idsimulacion,
                            'id_publicacion' => $idp,
                            'id_inmueble' => $idinmueble,
                            'id_arrendatario' => $idpropietario,
                            'tipo' => 1,
                            'tipopago' => "Pago Pendiente",
                            'idtipopago' => $idtipopago,
                            'meses_contrato' => $meses_contrato,
                            'fecha_iniciocontrato' => $fechafirma,
                            'dia' => $dia,
                            'mes' => $mes,
                            'anio' => $anio,
                            'descuento' => $descuento,
                            'cant_diasmes' => $dias_mes,
                            'cant_diasproporcional' => $dias_mes,
                            'moneda' => $tipomoneda,
                            'valormoneda' => $valormoneda,
                            'valordia' => 1,
                            'precio_en_moneda' => 0,
                            'precio_en_pesos' => 0,
                            'id_creador' => $id_creador,
                            'id_modificador' => $id_creador,
                            'id_estado' => 1,
                            'canondearriendo' => $arriendo
                ]);
                $pendiente = ($valor_en_pesos_proporcional - $primer_mes) * -1;
                $fecha_ini = date("d-m-Y", strtotime("+1 month", strtotime($fecha_ini)));
                $dias_mes = cal_days_in_month(CAL_GREGORIAN, date("m", strtotime($fecha_ini)), date("Y", strtotime($fecha_ini)));
                $dia = date("d", strtotime($fecha_ini));
                $mes = date("m", strtotime($fecha_ini));
                $anio = date("Y", strtotime($fecha_ini));
                $pago = SimulaPagoArrendatario::create([
                            'id_simulacion' => $idsimulacion,
                            'id_publicacion' => $idp,
                            'id_inmueble' => $idinmueble,
                            'id_arrendatario' => $idpropietario,
                            'tipo' => 1,
                            'tipopago' => "Pago Pendiente",
                            'idtipopago' => $idtipopago,
                            'meses_contrato' => $meses_contrato,
                            'fecha_iniciocontrato' => $fechafirma,
                            'dia' => $dia,
                            'mes' => $mes,
                            'anio' => $anio,
                            'descuento' => $descuento,
                            'cant_diasmes' => $dias_mes,
                            'cant_diasproporcional' => $dias_mes,
                            'moneda' => $tipomoneda,
                            'valormoneda' => $valormoneda,
                            'valordia' => 1,
                            'precio_en_moneda' => $pendiente,
                            'precio_en_pesos' => $pendiente,
                            'id_creador' => $id_creador,
                            'id_modificador' => $id_creador,
                            'id_estado' => 1,
                            'canondearriendo' => $arriendo
                ]);
            }


            $fecha_ini = date('Y-m-j', strtotime(date("Y", strtotime($fechafirma)) . '-' . date("m", strtotime($fechafirma)) . '-' . 1));
            $idtipopago = 20;

            for ($i = 0; $i < $cant_meses; $i++) {
                $dia = date("d", strtotime($fecha_ini));
                $mes = date("m", strtotime($fecha_ini));
                $anio = date("Y", strtotime($fecha_ini));
                $dias_mes = cal_days_in_month(CAL_GREGORIAN, date("m", strtotime($fecha_ini)), date("Y", strtotime($fecha_ini)));
                $pagomensual = SimulaPagoArrendatario::where("mes", '=', $mes)
                        ->where("anio", '=', $anio)
                        ->whereIn("idtipopago", [2,3,4,5,6,7,8,10,15])
                        ->where("id_simulacion", '=', $idsimulacion)
                        ->sum('precio_en_pesos');


                $pago = SimulaPagoArrendatario::create([
                            'id_simulacion' => $idsimulacion,
                            'id_publicacion' => $idp,
                            'id_inmueble' => $idinmueble,
                            'id_arrendatario' => $idpropietario,
                            'tipopago' => "Total Costos Propietario",
                            'tipo' => 1,
                            'idtipopago' => $idtipopago,
                            'meses_contrato' => $meses_contrato,
                            'fecha_iniciocontrato' => $fechafirma,
                            'dia' => $dia,
                            'mes' => $mes,
                            'anio' => $anio,
                            'descuento' => $descuento,
                            'cant_diasmes' => $dias_mes,
                            'cant_diasproporcional' => $dias_proporcionales,
                            'moneda' => $tipomoneda,
                            'valormoneda' => $valormoneda,
                            'valordia' => $valor_diario,
                            'precio_en_moneda' => $pagomensual,
                            'precio_en_pesos' => $pagomensual,
                            'id_creador' => $id_creador,
                            'id_modificador' => $id_creador,
                            'id_estado' => 1,
                            'canondearriendo' => $arriendo
                ]);
                $fecha_ini = date("d-m-Y", strtotime("+1 month", strtotime($fecha_ini)));
            }


            $fecha_ini = date('Y-m-j', strtotime(date("Y", strtotime($fechafirma)) . '-' . date("m", strtotime($fechafirma)) . '-' . 1));
            $idtipopago = 21;


            for ($i = 0; $i < $cant_meses; $i++) {
                $dia = date("d", strtotime($fecha_ini));
                $mes = date("m", strtotime($fecha_ini));
                $anio = date("Y", strtotime($fecha_ini));
                $dias_mes = cal_days_in_month(CAL_GREGORIAN, date("m", strtotime($fecha_ini)), date("Y", strtotime($fecha_ini)));
                $pagomensual = SimulaPagoArrendatario::where("mes", '=', $mes)
                        ->where("anio", '=', $anio)
                        ->where("tipo", '=', 1)
                        ->whereIn("idtipopago", [2,3,4,5,6,7,8,10,15])
                        ->where("id_simulacion", '=', $idsimulacion)
                        ->sum('precio_en_pesos');
                if ($i == 0) {
                    $saldo = $valor_en_pesos_proporcional - $pagomensual;
                    // dd("valor_en_pesos_proporcional: ".$valor_en_pesos_proporcional."     pagomensual : ".$pagomensual."    saldo ".$saldo);
                } else {
                    $saldo = $arriendo - $pagomensual;
                }
                $pago = SimulaPagoArrendatario::create([
                            'id_simulacion' => $idsimulacion,
                            'id_publicacion' => $idp,
                            'id_inmueble' => $idinmueble,
                            'id_arrendatario' => $idpropietario,
                            'tipopago' => "Saldo a Depositar",
                            'tipo' => 1,
                            'idtipopago' => $idtipopago,
                            'meses_contrato' => $meses_contrato,
                            'fecha_iniciocontrato' => $fechafirma,
                            'dia' => $dia,
                            'mes' => $mes,
                            'anio' => $anio,
                            'descuento' => $descuento,
                            'cant_diasmes' => $dias_mes,
                            'cant_diasproporcional' => $dias_proporcionales,
                            'moneda' => $tipomoneda,
                            'valormoneda' => $valormoneda,
                            'valordia' => $valor_diario,
                            'precio_en_moneda' => $saldo,
                            'precio_en_pesos' => $saldo,
                            'id_creador' => $id_creador,
                            'id_modificador' => $id_creador,
                            'id_estado' => 1,
                            'canondearriendo' => $arriendo
                ]);
                $fecha_ini = date("d-m-Y", strtotime("+1 month", strtotime($fecha_ini)));
            }
        }


        //general para pago 11 cuotas

        if ($tipopropuesta == 2) {
            $primer_mes = 0;

            $fecha_ini = date('Y-m-j', strtotime(date("Y", strtotime($fechafirma)) . '-' . date("m", strtotime($fechafirma)) . '-' . 1));
            //pago pie

            $idtipopago = 31;
            $dias_mes = cal_days_in_month(CAL_GREGORIAN, date("m", strtotime($fecha_ini)), date("Y", strtotime($fecha_ini)));
            $valor_en_pesos = ($arriendo - ($arriendo * ($descuento / 100)));
            $pie_valor = $valor_en_pesos * ($pie / 100);
            $dia = date("d", strtotime($fecha_ini));
            $mes = date("m", strtotime($fecha_ini));
            $anio = date("Y", strtotime($fecha_ini));
            $dias_mes = cal_days_in_month(CAL_GREGORIAN, date("m", strtotime($fecha_ini)), date("Y", strtotime($fecha_ini)));
            $valor_en_pesos_con_desc = $valor_en_pesos;
            $pago = SimulaPagoArrendatario::create([
                        'id_simulacion' => $idsimulacion,
                        'id_publicacion' => $idp,
                        'id_inmueble' => $idinmueble,
                        'id_arrendatario' => $idpropietario,
                        'tipo' => 2,
                        'tipopago' => "Pie",
                        'idtipopago' => $idtipopago,
                        'meses_contrato' => $meses_contrato,
                        'fecha_iniciocontrato' => $fechafirma,
                        'dia' => $dia,
                        'mes' => $mes,
                        'anio' => $anio,
                        'descuento' => $descuento,
                        'cant_diasmes' => $dias_mes,
                        'cant_diasproporcional' => $dias_mes,
                        'moneda' => $tipomoneda,
                        'valormoneda' => $valormoneda,
                        'valordia' => 1,
                        'precio_en_moneda' => $pie_valor,
                        'precio_en_pesos' => $pie_valor,
                        'id_creador' => $id_creador,
                        'id_modificador' => $id_creador,
                        'id_estado' => 1,
                        'canondearriendo' => $arriendo
            ]);
            $primer_mes += $pie_valor;

            $idtipopago = 32;

            $dia = date("d", strtotime($fecha_ini));
            $mes = date("m", strtotime($fecha_ini));
            $anio = date("Y", strtotime($fecha_ini));
            $dias_mes = cal_days_in_month(CAL_GREGORIAN, date("m", strtotime($fecha_ini)), date("Y", strtotime($fecha_ini)));
            $valor_cuota = $arriendo * ($cobromensual / 100);

            $pago = SimulaPagoArrendatario::create([
                        'id_simulacion' => $idsimulacion,
                        'id_publicacion' => $idp,
                        'id_inmueble' => $idinmueble,
                        'id_arrendatario' => $idpropietario,
                        'tipopago' => $nrocuotas . " Cuotas " . $cobromensual . "%",
                        'tipo' => 2,
                        'idtipopago' => $idtipopago,
                        'meses_contrato' => $meses_contrato,
                        'fecha_iniciocontrato' => $fechafirma,
                        'dia' => $dia,
                        'mes' => $mes,
                        'anio' => $anio,
                        'descuento' => $descuento,
                        'cant_diasmes' => $dias_mes,
                        'cant_diasproporcional' => $dias_proporcionales,
                        'moneda' => $tipomoneda,
                        'valormoneda' => $valormoneda,
                        'valordia' => $valor_diario,
                        'precio_en_moneda' => 0,
                        'precio_en_pesos' => 0,
                        'id_creador' => $id_creador,
                        'id_modificador' => $id_creador,
                        'id_estado' => 1,
                        'canondearriendo' => $arriendo
            ]);
            for ($i = 0; $i < $nrocuotas; $i++) {
                $fecha_ini = date("d-m-Y", strtotime("+1 month", strtotime($fecha_ini)));
                $dia = date("d", strtotime($fecha_ini));
                $mes = date("m", strtotime($fecha_ini));
                $anio = date("Y", strtotime($fecha_ini));
                $dias_mes = cal_days_in_month(CAL_GREGORIAN, date("m", strtotime($fecha_ini)), date("Y", strtotime($fecha_ini)));
                $valor_cuota = $arriendo * ($cobromensual / 100);
                $pago = SimulaPagoArrendatario::create([
                            'id_simulacion' => $idsimulacion,
                            'id_publicacion' => $idp,
                            'id_inmueble' => $idinmueble,
                            'id_arrendatario' => $idpropietario,
                            'tipopago' => $nrocuotas . " Cuotas " . $cobromensual . "%",
                            'tipo' => 2,
                            'idtipopago' => $idtipopago,
                            'meses_contrato' => $meses_contrato,
                            'fecha_iniciocontrato' => $fechafirma,
                            'dia' => $dia,
                            'mes' => $mes,
                            'anio' => $anio,
                            'descuento' => $descuento,
                            'cant_diasmes' => $dias_mes,
                            'cant_diasproporcional' => $dias_proporcionales,
                            'moneda' => $tipomoneda,
                            'valormoneda' => $valormoneda,
                            'valordia' => $valor_diario,
                            'precio_en_moneda' => $valor_cuota,
                            'precio_en_pesos' => $valor_cuota,
                            'id_creador' => $id_creador,
                            'id_modificador' => $id_creador,
                            'id_estado' => 1,
                            'canondearriendo' => $arriendo
                ]);
            }




            //Pendiente Mes Anterior
                $fecha_ini = date('Y-m-j', strtotime(date("Y", strtotime($fechafirma)) . '-' . date("m", strtotime($fechafirma)) . '-' . 1));
                $idtipopago = 33;
                $dia = date("d", strtotime($fecha_ini));
                $mes = date("m", strtotime($fecha_ini));
                $anio = date("Y", strtotime($fecha_ini));

                $primer_mes=  SimulaPagoArrendatario::where("mes", '=', $mes)
                        ->where("anio", '=', $anio)
                        ->whereIn("idtipopago", [2,3,4,5,6,7,8,10,31,32])
                        ->where("id_simulacion", '=', $idsimulacion)
                        ->sum('precio_en_pesos');
                $valor_en_pesos_proporcional=  SimulaPagoArrendatario::where("mes", '=', $mes)
                        ->where("anio", '=', $anio)
                        ->whereIn("idtipopago", [1])
                        ->where("id_simulacion", '=', $idsimulacion)
                        ->sum('precio_en_pesos');

            $pendiente = $valor_en_pesos_proporcional - $primer_mes;
//dd(" pendiente : $pendiente valor_en_pesos_proporcional : $valor_en_pesos_proporcional primer_mes : $primer_mes");
            if (($valor_en_pesos_proporcional - $primer_mes) < 0) {
                $dia = date("d", strtotime($fecha_ini));
                $mes = date("m", strtotime($fecha_ini));
                $anio = date("Y", strtotime($fecha_ini));
                $dias_mes = cal_days_in_month(CAL_GREGORIAN, date("m", strtotime($fecha_ini)), date("Y", strtotime($fecha_ini)));
                $pago = SimulaPagoArrendatario::create([
                            'id_simulacion' => $idsimulacion,
                            'id_publicacion' => $idp,
                            'id_inmueble' => $idinmueble,
                            'id_arrendatario' => $idpropietario,
                            'tipo' => 1,
                            'tipopago' => "Pago Pendiente",
                            'idtipopago' => $idtipopago,
                            'meses_contrato' => $meses_contrato,
                            'fecha_iniciocontrato' => $fechafirma,
                            'dia' => $dia,
                            'mes' => $mes,
                            'anio' => $anio,
                            'descuento' => $descuento,
                            'cant_diasmes' => $dias_mes,
                            'cant_diasproporcional' => $dias_mes,
                            'moneda' => $tipomoneda,
                            'valormoneda' => $valormoneda,
                            'valordia' => 1,
                            'precio_en_moneda' => 0,
                            'precio_en_pesos' => 0,
                            'id_creador' => $id_creador,
                            'id_modificador' => $id_creador,
                            'id_estado' => 1,
                            'canondearriendo' => $arriendo
                ]);
                $pendiente = ($valor_en_pesos_proporcional - $primer_mes) * -1;
                $fecha_ini = date("d-m-Y", strtotime("+1 month", strtotime($fecha_ini)));
                $dias_mes = cal_days_in_month(CAL_GREGORIAN, date("m", strtotime($fecha_ini)), date("Y", strtotime($fecha_ini)));
                $dia = date("d", strtotime($fecha_ini));
                $mes = date("m", strtotime($fecha_ini));
                $anio = date("Y", strtotime($fecha_ini));
                $pago = SimulaPagoArrendatario::create([
                            'id_simulacion' => $idsimulacion,
                            'id_publicacion' => $idp,
                            'id_inmueble' => $idinmueble,
                            'id_arrendatario' => $idpropietario,
                            'tipo' => 1,
                            'tipopago' => "Pago Pendiente",
                            'idtipopago' => $idtipopago,
                            'meses_contrato' => $meses_contrato,
                            'fecha_iniciocontrato' => $fechafirma,
                            'dia' => $dia,
                            'mes' => $mes,
                            'anio' => $anio,
                            'descuento' => $descuento,
                            'cant_diasmes' => $dias_mes,
                            'cant_diasproporcional' => $dias_mes,
                            'moneda' => $tipomoneda,
                            'valormoneda' => $valormoneda,
                            'valordia' => 1,
                            'precio_en_moneda' => $pendiente,
                            'precio_en_pesos' => $pendiente,
                            'id_creador' => $id_creador,
                            'id_modificador' => $id_creador,
                            'id_estado' => 1,
                            'canondearriendo' => $arriendo
                ]);
            }
        }

        
          $fecha_ini = date('Y-m-j', strtotime(date("Y", strtotime($fechafirma)) . '-' . date("m", strtotime($fechafirma)) . '-' . 1));
          $idtipopago = 34;

          for ($i = 0; $i < $cant_meses; $i++) {
          $dia = date("d", strtotime($fecha_ini));
          $mes = date("m", strtotime($fecha_ini));
          $anio = date("Y", strtotime($fecha_ini));
          $dias_mes = cal_days_in_month(CAL_GREGORIAN, date("m", strtotime($fecha_ini)), date("Y", strtotime($fecha_ini)));
          $pagomensual=SimulaPagoArrendatario::where("mes",'=',$mes)
          ->where("anio",'=',$anio)
          ->whereIn("idtipopago", [2,3,4,5,6,7,8,10,31,32,33])
          ->where("id_simulacion",'=',$idsimulacion)
          ->sum('precio_en_pesos');
          $pago = SimulaPagoArrendatario::create([
          'id_simulacion' => $idsimulacion,
          'id_publicacion' => $idp,
          'id_inmueble' => $idinmueble,
          'id_arrendatario' => $idpropietario,
          'tipopago' => "Total Costos Propietario",
          'tipo' => 1,
          'idtipopago' => $idtipopago,
          'meses_contrato' => $meses_contrato,
          'fecha_iniciocontrato' => $fechafirma,
          'dia' => $dia,
          'mes' => $mes,
          'anio' => $anio,
          'descuento' => $descuento,
          'cant_diasmes' => $dias_mes,
          'cant_diasproporcional' => $dias_proporcionales,
          'moneda' => $tipomoneda,
          'valormoneda' => $valormoneda,
          'valordia' => $valor_diario,
          'precio_en_moneda' => $pagomensual,
          'precio_en_pesos' => $pagomensual,
          'id_creador' => $id_creador,
          'id_modificador' => $id_creador,
          'id_estado' => 1,
          'canondearriendo' => $arriendo
          ]);
          $fecha_ini = date("d-m-Y", strtotime("+1 month", strtotime($fecha_ini)));
          }


         $fecha_ini = date('Y-m-j', strtotime(date("Y", strtotime($fechafirma)) . '-' . date("m", strtotime($fechafirma)) . '-' . 1));
          $idtipopago = 35;

          for ($i = 0; $i < $cant_meses; $i++) {
          $dia = date("d", strtotime($fecha_ini));
          $mes = date("m", strtotime($fecha_ini));
          $anio = date("Y", strtotime($fecha_ini));
          $dias_mes = cal_days_in_month(CAL_GREGORIAN, date("m", strtotime($fecha_ini)), date("Y", strtotime($fecha_ini)));
          $valor_en_pesos_proporcional=  SimulaPagoArrendatario::where("mes", '=', $mes)
                        ->where("anio", '=', $anio)
                        ->whereIn("idtipopago", [1])
                        ->where("id_simulacion", '=', $idsimulacion)
                        ->sum('precio_en_pesos');
          $pagomensual=SimulaPagoArrendatario::where("mes",'=',$mes)
          ->where("anio",'=',$anio)
          ->whereIn("idtipopago", [2,3,4,5,6,7,8,10,31,32,33])
          ->where("id_simulacion",'=',$idsimulacion)
          ->sum('precio_en_pesos');
          $saldo=$valor_en_pesos_proporcional-$pagomensual;
          $pago = SimulaPagoArrendatario::create([
          'id_simulacion' => $idsimulacion,
          'id_publicacion' => $idp,
          'id_inmueble' => $idinmueble,
          'id_arrendatario' => $idpropietario,
          'tipopago' => "Saldo a Depositar",
          'tipo' => 1,
          'idtipopago' => $idtipopago,
          'meses_contrato' => $meses_contrato,
          'fecha_iniciocontrato' => $fechafirma,
          'dia' => $dia,
          'mes' => $mes,
          'anio' => $anio,
          'descuento' => $descuento,
          'cant_diasmes' => $dias_mes,
          'cant_diasproporcional' => $dias_proporcionales,
          'moneda' => $tipomoneda,
          'valormoneda' => $valormoneda,
          'valordia' => $valor_diario,
          'precio_en_moneda' => $saldo,
          'precio_en_pesos' => $saldo,
          'id_creador' => $id_creador,
          'id_modificador' => $id_creador,
          'id_estado' => 1,
          'canondearriendo' => $arriendo
          ]);
          $fecha_ini = date("d-m-Y", strtotime("+1 month", strtotime($fecha_ini)));
          }
    
        return redirect()->route('cbararrendatario.edit', [$idp,2])
         ->with('status', 'Simulación generada con éxito');
        
    }

    public function downloadExcel($id) {
        $meses = array("", "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
        $header = DB::table('cap_simulaarrendatario as c')
                        ->leftjoin('users as p2', 'c.id_creador', '=', 'p2.id')
                        ->leftjoin('inmuebles as i', 'c.id_inmueble', '=', 'i.id')
                        ->leftjoin('personas as p1', 'c.id_arrendatario', '=', 'p1.id')
                        ->leftjoin('comunas as o', 'i.id_comuna', '=', 'o.comuna_id')
                        ->where("c.id", "=", $id)
                        ->select(DB::raw(' DATE_FORMAT(c.created_at, "%d/%m/%Y") as fecha_creacion, CONCAT_WS(" ",p1.nombre,p1.apellido_paterno,p1.apellido_materno) as Arrendatario,
         p2.name as Creador,CONCAT_WS(" ",i.direccion,i.numero,i.departamento,o.comuna_nombre) as propiedad,c.meses_contrato,c.fecha_iniciocontrato, c.iva, c.descuento, c.pie, c.cobromensual, c.tipopropuesta, c.nrocuotas'))
                        ->get()->toArray();
        $header = $header[0];


        if ($header->tipopropuesta == 1) {
            $propuesta1 = DB::table('cap_simulapagoarrendatarios as c')
                            ->where("id_simulacion", '=', $id)
                            ->whereIn("idtipopago", [1, 2, 3, 4, 5, 6, 7, 8, 15, 10, 20, 21])->get();
            return Excel::create('Propuesta de Pago', function ($excel) use ($header, $propuesta1, $meses) {
                        $excel->sheet('Propuesta', function ($sheet) use ($header, $propuesta1, $meses) {
                            $sheet->setBorder('A8:M20', 'thin');
                            $sheet->setBorder('A5:G6', 'thin');
                            $sheet->loadView('formatosexcel.propuesta1_arr', compact('header', 'meses', 'propuesta1'));
                        });
                    })->download('xlsx');
        } else {
            $propuesta2 = DB::table('cap_simulapagoarrendatarios as c')
                            ->where("id_simulacion", '=', $id)
                            ->whereIn("idtipopago", [1, 2, 5, 6, 7, 10, 31, 32, 33, 34, 35])->get();
            return Excel::create('Propuesta de Pago', function ($excel) use ($header, $propuesta2, $meses) {
                        $excel->sheet('Propuesta', function ($sheet) use ($header, $propuesta2, $meses) {
                            $sheet->loadView('formatosexcel.propuesta2_arr', compact('header', 'meses', 'propuesta2'));
                            $sheet->setBorder('A8:M20', 'thin');
                            $sheet->setBorder('A5:G6', 'thin');
                        });
                    })->download('xlsx');
        }
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
     * @param  \App\SimulaArrendatario  $simulaArrendatario
     * @return \Illuminate\Http\Response
     */
    public function show(SimulaArrendatario $simulaArrendatario)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\SimulaArrendatario  $simulaArrendatario
     * @return \Illuminate\Http\Response
     */
    public function edit(SimulaArrendatario $simulaArrendatario)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\SimulaArrendatario  $simulaArrendatario
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SimulaArrendatario $simulaArrendatario)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\SimulaArrendatario  $simulaArrendatario
     * @return \Illuminate\Http\Response
     */
    public function destroy(SimulaArrendatario $simulaArrendatario)
    {
        //
    }
}
