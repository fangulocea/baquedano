<?php

namespace App\Http\Controllers;

use App\SolicitudServicio;
use Illuminate\Http\Request;
use DB;
use Yajra\Datatables\Datatables;
use App\CatalogoServicios;
use Carbon\Carbon;
use App\ContratoFinal;
use App\ContratoBorrador;
USE App\PagosPropietarios;
use App\DetalleSolicitudServicio;
use App\PagosMensualesPropietarios;
use App\Captacion;
use Barryvdh\DomPDF\Facade as PDF;
use App\Inmueble;
use App\Persona;
use Auth;

class SolicitudServicioController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        return view('solservicios_pro.index');
    }

    public function autoriza_prop_index() {
        return view('autorizacion_pro.index');
    }

    public function autoriza_arr_index() {
        return view('autorizacion_arr.index');
    }

    public function autorizar($id) {
        $solicitud = SolicitudServicio::find($id);
        $contrato = ContratoFinal::find($solicitud->id_contrato);
        $montouf = DetalleSolicitudServicio::where("id_solicitud", "=", $id)->sum("subtotal_uf");
        $montopesos = DetalleSolicitudServicio::where("id_solicitud", "=", $id)->sum("subtotal_pesos");

        $mes = date("m");
        $anio = date("Y");
        $dias_mes = cal_days_in_month(CAL_GREGORIAN, $mes, $anio);
        $idtipopago = 12;


        $tipopropuesta = PagosPropietarios::where("mes", '=', $mes)
                ->where("anio", '=', $anio)
                ->where("id_contratofinal", '=', $solicitud->id_contrato)
                ->where("id_inmueble", '=', $solicitud->id_inmueble)
                ->first();


        if (!isset($tipopropuesta)) {
            return back()->with('error', "No se han generado los pagos para este contrato");
        }
        $pago = PagosPropietarios::create([
                    'id_contratofinal' => $solicitud->id_contrato,
                    'id_publicacion' => $contrato->id_publicacion,
                    'id_inmueble' => $solicitud->id_inmueble,
                    'tipopropuesta' => $tipopropuesta->tipopropuesta,
                    'tipopago' => "Solicitud de Servicios Nro" . $id,
                    'idtipopago' => $idtipopago,
                    'meses_contrato' => $contrato->meses_contrato,
                    'fecha_iniciocontrato' => $contrato->fecha_firma,
                    'dia' => 1,
                    'mes' => $mes,
                    'anio' => $anio,
                    'E_S' => 's',
                    'descuento' => 0,
                    'cant_diasmes' => $dias_mes,
                    'cant_diasproporcional' => $dias_mes,
                    'moneda' => 'CLP',
                    'valormoneda' => '1',
                    'valordia' => 1,
                    'precio_en_moneda' => $montopesos,
                    'precio_en_pesos' => $montopesos,
                    'id_creador' => Auth::user()->id,
                    'id_modificador' => Auth::user()->id,
                    'id_estado' => 1,
                    'gastocomun' => 0,
                    'canondearriendo' => 0
        ]);

        $valor_en_pesos = $montopesos;
        $valor_en_moneda = $montopesos;


        $idcontrato = $solicitud->id_contrato;
        $idinmueble = $solicitud->id_inmueble;
        $valormoneda = 1;



        if ($tipopropuesta->tipopropuesta == 1 || $tipopropuesta->tipopropuesta == 3) {

            $saldo_a_favor = PagosPropietarios::where("mes", '=', $mes)
                    ->where("anio", '=', $anio)
                    ->whereIn("idtipopago", [1, 2, 8, 11, 17, 10])
                    ->where("id_contratofinal", '=', $idcontrato)
                    ->where("id_inmueble", '=', $idinmueble)
                    ->sum('precio_en_pesos');



            $pago_a_rentas = PagosPropietarios::where("mes", '=', $mes)
                    ->where("anio", '=', $anio)
                    ->whereIn("idtipopago", [3, 4, 5, 6, 7, 9, 12, 15, 18, 16])
                    ->where("id_contratofinal", '=', $idcontrato)
                    ->where("id_inmueble", '=', $idinmueble)
                    ->sum('precio_en_pesos');



            $saldo_a_depositar = $saldo_a_favor - $pago_a_rentas;

            $saldo = PagosPropietarios::where("mes", '=', $mes)
                    ->where("anio", '=', $anio)
                    ->where("idtipopago", '=', 21)
                    ->where("id_contratofinal", '=', $idcontrato)
                    ->where("id_inmueble", '=', $idinmueble)
                    ->update([
                'precio_en_moneda' => $saldo_a_depositar / $valormoneda,
                'precio_en_pesos' => $saldo_a_depositar,
            ]);

            $pagomensual = PagosPropietarios::where("mes", '=', $mes)
                    ->where("anio", '=', $anio)
                    ->whereIn("idtipopago", [3, 4, 5, 6, 7, 12, 15, 16, 18])
                    ->where("id_contratofinal", '=', $idcontrato)
                    ->where("id_inmueble", '=', $idinmueble)
                    ->sum('precio_en_pesos');

            $saldo = PagosPropietarios::where("mes", '=', $mes)
                    ->where("anio", '=', $anio)
                    ->where("idtipopago", '=', 20)
                    ->where("id_contratofinal", '=', $idcontrato)
                    ->where("id_inmueble", '=', $idinmueble)
                    ->update([
                'precio_en_moneda' => $pagomensual / $valormoneda,
                'precio_en_pesos' => $pagomensual,
            ]);

            if ($saldo_a_depositar < 0) {
                $saldo_a_depositar = $saldo_a_depositar * -1;
                $hoy = Carbon::now()->format('d-m-Y');
                $fecha_ini = date("d-m-Y", strtotime("+1 month", strtotime($hoy)));
                $dias_mes = cal_days_in_month(CAL_GREGORIAN, date("m", strtotime($fecha_ini)), date("Y", strtotime($fecha_ini)));
                $dia = date("d", strtotime($fecha_ini));
                $mes = date("m", strtotime($fecha_ini));
                $anio = date("Y", strtotime($fecha_ini));
                $pendiente = PagosPropietarios::where("mes", '=', $mes)
                        ->where("anio", '=', $anio)
                        ->where("idtipopago", '=', 15)
                        ->where("id_contratofinal", '=', $idcontrato)
                        ->where("id_inmueble", '=', $idinmueble)
                        ->update([
                    'precio_en_moneda' => $saldo_a_depositar / $valormoneda,
                    'precio_en_pesos' => $saldo_a_depositar,
                ]);

                $saldo_a_favor = PagosPropietarios::where("mes", '=', $mes)
                        ->where("anio", '=', $anio)
                        ->whereIn("idtipopago", [1, 2, 8, 11, 17, 10])
                        ->where("id_contratofinal", '=', $idcontrato)
                        ->where("id_inmueble", '=', $idinmueble)
                        ->sum('precio_en_pesos');



                $pago_a_rentas = PagosPropietarios::where("mes", '=', $mes)
                        ->where("anio", '=', $anio)
                        ->whereIn("idtipopago", [3, 4, 5, 6, 7, 9, 12, 15, 18, 16])
                        ->where("id_contratofinal", '=', $idcontrato)
                        ->where("id_inmueble", '=', $idinmueble)
                        ->sum('precio_en_pesos');



                $saldo_a_depositar = $saldo_a_favor - $pago_a_rentas;

                $saldo = PagosPropietarios::where("mes", '=', $mes)
                        ->where("anio", '=', $anio)
                        ->where("idtipopago", '=', 21)
                        ->where("id_contratofinal", '=', $idcontrato)
                        ->where("id_inmueble", '=', $idinmueble)
                        ->update([
                    'precio_en_moneda' => $saldo_a_depositar / $valormoneda,
                    'precio_en_pesos' => $saldo_a_depositar
                ]);

                $pagomensual = PagosPropietarios::where("mes", '=', $mes)
                        ->where("anio", '=', $anio)
                        ->whereIn("idtipopago", [3, 4, 5, 6, 7, 12, 15, 16, 18])
                        ->where("id_contratofinal", '=', $idcontrato)
                        ->where("id_inmueble", '=', $idinmueble)
                        ->sum('precio_en_pesos');

                $saldo = PagosPropietarios::where("mes", '=', $mes)
                        ->where("anio", '=', $anio)
                        ->where("idtipopago", '=', 20)
                        ->where("id_contratofinal", '=', $idcontrato)
                        ->where("id_inmueble", '=', $idinmueble)
                        ->update([
                    'precio_en_moneda' => $pagomensual / $valormoneda,
                    'precio_en_pesos' => $pagomensual
                ]);
            }
        } else {
            $saldo_a_favor = PagosPropietarios::where("mes", '=', $mes)
                    ->where("anio", '=', $anio)
                    ->whereIn("idtipopago", [1, 2, 8, 11, 17, 10])
                    ->where("id_contratofinal", '=', $idcontrato)
                    ->where("id_inmueble", '=', $idinmueble)
                    ->sum('precio_en_pesos');

            $pago_a_rentas = PagosPropietarios::where("mes", '=', $mes)
                    ->where("anio", '=', $anio)
                    ->whereIn("idtipopago", [5, 6, 10, 15, 31, 32, 33, 18, 16, 12])
                    ->where("id_contratofinal", '=', $idcontrato)
                    ->where("id_inmueble", '=', $idinmueble)
                    ->sum('precio_en_pesos');

            $saldo_a_depositar = $pago_a_rentas - $saldo_a_favor;

            $saldo = PagosPropietarios::where("mes", '=', $mes)
                    ->where("anio", '=', $anio)
                    ->where("idtipopago", '=', 35)
                    ->where("id_contratofinal", '=', $idcontrato)
                    ->where("id_inmueble", '=', $idinmueble)
                    ->update([
                'precio_en_moneda' => $saldo_a_depositar / $valormoneda,
                'precio_en_pesos' => $saldo_a_depositar,
            ]);

            $pagomensual = PagosPropietarios::where("mes", '=', $mes)
                    ->where("anio", '=', $anio)
                    ->whereIn("idtipopago", [5, 6, 10, 12, 15, 31, 32, 33, 16, 18])
                    ->where("id_contratofinal", '=', $idcontrato)
                    ->sum('precio_en_pesos');


            $saldo = PagosPropietarios::where("mes", '=', $mes)
                    ->where("anio", '=', $anio)
                    ->where("idtipopago", '=', 34)
                    ->where("id_contratofinal", '=', $idcontrato)
                    ->where("id_inmueble", '=', $idinmueble)
                    ->update([
                'precio_en_moneda' => $pagomensual / $valormoneda,
                'precio_en_pesos' => $pagomensual,
            ]);




            if ($saldo_a_depositar < 0) {
                $saldo_a_depositar = $saldo_a_depositar * -1;
                $hoy = Carbon::now()->format('d-m-Y');
                $fecha_ini = date("d-m-Y", strtotime("+1 month", strtotime($hoy)));
                $dias_mes = cal_days_in_month(CAL_GREGORIAN, date("m", strtotime($fecha_ini)), date("Y", strtotime($fecha_ini)));
                $dia = date("d", strtotime($fecha_ini));
                $mes = date("m", strtotime($fecha_ini));
                $anio = date("Y", strtotime($fecha_ini));
                $pendiente = PagosPropietarios::where("mes", '=', $mes)
                        ->where("anio", '=', $anio)
                        ->where("idtipopago", '=', 15)
                        ->where("id_contratofinal", '=', $idcontrato)
                        ->where("id_inmueble", '=', $idinmueble)
                        ->update([
                    'precio_en_moneda' => $saldo_a_depositar / $valormoneda,
                    'precio_en_pesos' => $saldo_a_depositar,
                ]);

                $saldo_a_favor = PagosPropietarios::where("mes", '=', $mes)
                        ->where("anio", '=', $anio)
                        ->whereIn("idtipopago", [1, 2, 8, 11, 17, 10])
                        ->where("id_contratofinal", '=', $idcontrato)
                        ->where("id_inmueble", '=', $idinmueble)
                        ->sum('precio_en_pesos');



                $pago_a_rentas = PagosPropietarios::where("mes", '=', $mes)
                        ->where("anio", '=', $anio)
                        ->whereIn("idtipopago", [5, 6, 10, 15, 31, 32, 33, 18, 16, 12])
                        ->where("id_contratofinal", '=', $idcontrato)
                        ->where("id_inmueble", '=', $idinmueble)
                        ->sum('precio_en_pesos');



                $saldo_a_depositar = $saldo_a_favor - $pago_a_rentas;

                $saldo = PagosPropietarios::where("mes", '=', $mes)
                        ->where("anio", '=', $anio)
                        ->where("idtipopago", '=', 35)
                        ->where("id_contratofinal", '=', $idcontrato)
                        ->where("id_inmueble", '=', $idinmueble)
                        ->update([
                    'precio_en_moneda' => $saldo_a_depositar / $valormoneda,
                    'precio_en_pesos' => $saldo_a_depositar
                ]);

                $pagomensual = PagosPropietarios::where("mes", '=', $mes)
                        ->where("anio", '=', $anio)
                        ->whereIn("idtipopago", [5, 6, 10, 12, 15, 31, 32, 33, 16, 18])
                        ->where("id_contratofinal", '=', $idcontrato)
                        ->where("id_inmueble", '=', $idinmueble)
                        ->sum('precio_en_pesos');

                $saldo = PagosPropietarios::where("mes", '=', $mes)
                        ->where("anio", '=', $anio)
                        ->where("idtipopago", '=', 34)
                        ->where("id_contratofinal", '=', $idcontrato)
                        ->where("id_inmueble", '=', $idinmueble)
                        ->update([
                    'precio_en_moneda' => $pagomensual / $valormoneda,
                    'precio_en_pesos' => $pagomensual
                ]);
            }
        }



        $pago_propietario = ($pago->pago_a_rentas_moneda + $valor_en_pesos) / $valormoneda;
        $pago_propietario_moneda = $pago->pago_a_rentas_moneda + $valor_en_moneda;

        if ($tipopropuesta->tipopropuesta == 1 || $tipopropuesta->tipopropuesta == 3) {
            $tipos = [1, 2, 3, 4, 5, 6, 7, 8, 10, 11, 15, 12];
        } elseif ($tipopropuesta->tipopropuesta == 2 || $tipopropuesta->tipopropuesta == 4) {
            $tipos = [1, 2, 5, 6, 7, 8, 10, 11, 31, 32, 33, 12];
        } else {
            $tipos = [1, 2, 5, 6, 7, 8, 10, 11, 31, 32, 33, 12];
        }

        $fecha_ini = date('Y-m-j', strtotime(date("Y", strtotime($contrato->fecha_firma)) . '-' . date("m", strtotime($contrato->fecha_firma)) . '-' . 1));

        for ($i = 0; $i < 13; $i++) {
            $mes = date("m", strtotime($fecha_ini));
            $anio = date("Y", strtotime($fecha_ini));
            $fecha_ini = date("d-m-Y", strtotime("+1 month", strtotime($fecha_ini)));
            $pagos_mensuales_e = DB::table('adm_pagospropietarios')
                    ->where("id_publicacion", "=", $contrato->id_publicacion)
                    ->whereIn("idTipoPago", $tipos)
                    ->where("id_contratofinal", '=', $idcontrato)
                    ->where("E_S", "=", "e")
                    ->where("id_inmueble", "=", $idinmueble)
                    ->where("mes", "=", $mes)
                    ->where("anio", "=", $anio)
                    ->sum('precio_en_pesos');
            $pagos_mensuales_s = DB::table('adm_pagospropietarios')
                    ->where("id_publicacion", "=", $contrato->id_publicacion)
                    ->where("id_contratofinal", '=', $idcontrato)
                    ->whereIn("idTipoPago", $tipos)
                    ->where("E_S", "=", "s")
                    ->where("id_inmueble", "=", $idinmueble)
                    ->where("mes", "=", $mes)
                    ->where("anio", "=", $anio)
                    ->sum('precio_en_pesos');

            $pagar_a_propietario = $pagos_mensuales_s - $pagos_mensuales_e;
            $pagar_a_baquedano = $pagos_mensuales_e - $pagos_mensuales_s;

            if ($pagar_a_propietario < 0)
                $pagar_a_propietario = 0;

            if ($pagar_a_baquedano < 0)
                $pagar_a_baquedano = 0;

            $uf = DB::table('adm_uf')
                    ->where("fecha", "=", Carbon::now()->format('Y/m/d'))
                    ->first();

            $pm = PagosMensualesPropietarios::where("id_contratofinal", "=", $idcontrato)
                    ->where("id_publicacion", "=", $contrato->id_publicacion)
                    ->where("id_inmueble", "=", $idinmueble)
                    ->where("E_S", "=", 's')
                    ->where("mes", "=", $mes)
                    ->where("anio", "=", $anio)
                    ->first();
            if ($pm->moneda == "UF") {
                $valormoneda = $uf->valor;
            } else {
                $valormoneda = 1;
            }


            $delete = PagosMensualesPropietarios::where("id_contratofinal", "=", $idcontrato)
                    ->where("id_publicacion", "=", $contrato->id_publicacion)
                    ->where("id_inmueble", "=", $idinmueble)
                    ->where("E_S", "=", 's')
                    ->where("mes", "=", $mes)
                    ->where("anio", "=", $anio)
                    ->update([
                'valor_moneda' => $valormoneda,
                'fecha_moneda' => Carbon::now()->format('Y-m-d'),
                'subtotal_entrada_moneda' => $pagos_mensuales_e / $valormoneda,
                'subtotal_salida_moneda' => $pagos_mensuales_s / $valormoneda,
                'pago_propietario_moneda' => $pagar_a_propietario / $valormoneda,
                'pago_rentas_moneda' => $pagar_a_baquedano / $valormoneda,
                'subtotal_entrada' => $pagos_mensuales_e,
                'subtotal_salida' => $pagos_mensuales_s,
                'pago_propietario' => $pagar_a_propietario,
                'pago_rentas' => $pagar_a_baquedano,
            ]);
        }




        $edit = SolicitudServicio::find($id)->update(["id_estado" => 3]);
        return back()->with("status", "Solicitud Autorizada, se ha generado el item de pago");
    }

    public function rechazar($id) {
        $edit = SolicitudServicio::find($id)->update(["id_estado" => 5]);
        return back()->with("status", "Solicitud Rechazada / Anulada");
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index_ajax(Request $request) {
        $sol = DB::table('post_solicitudservicios as ss')
                ->leftjoin('adm_contratofinal as cf', "ss.id_contrato", "=", "cf.id")
                ->leftjoin('personas as p1', 'ss.id_propietario', '=', 'p1.id')
                ->leftjoin('inmuebles as i', 'ss.id_inmueble', '=', 'i.id')
                ->leftjoin('users as p2', 'ss.id_creador', '=', 'p2.id')
                ->leftjoin('users as p3', 'ss.id_modificador', '=', 'p3.id')
                ->leftjoin('users as p4', 'ss.id_autorizador', '=', 'p4.id')
                ->leftjoin('users as p5', 'ss.id_asignacion', '=', 'p4.id')
                ->leftjoin('comunas as o', 'i.id_comuna', '=', 'o.comuna_id')
                ->leftjoin('mensajes as m', function($join) {
                    $join->on('m.nombre_modulo', '=', DB::raw("'Solicitud Servicio'"));
                    $join->on('m.id_estado', '=', 'ss.id_estado');
                })
                ->select(DB::raw('ss.id as id_solicitud, 
                            DATE_FORMAT(ss.created_at, "%d/%m/%Y") as FechaCreacion, 
                            m.nombre as Estado,
                            CONCAT_WS(" ",p1.nombre,p1.apellido_paterno,p1.apellido_materno) as Propietario, 
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
                            return '<a href="/solservicio/' . $sol->id_solicitud . '/edit"><span class="btn btn-warning btn-circle btn-sm">E</span></a>
                               <a href="/solservicio/' . $sol->id_solicitud . '/comprobante"><span class="btn btn-success btn-circle btn-sm">C</span></a>
                                    <a href="/solservicio/' . $sol->id_solicitud . '/destroy"><span class="btn btn-danger btn-circle btn-sm">B</span></a>';
                        })
                        ->addColumn('id_link', function ($sol) {
                            return '<a href="/solservicio/' . $sol->id_solicitud . '/edit"><span class="btn btn-success btn-sm"> ' . $sol->id_solicitud . '</span> </a>';
                        })
                        ->rawColumns(['id_link', 'action'])
                        ->make(true);
    }

    public function autoriza_index_ajax_pro(Request $request) {
        $sol = DB::table('post_solicitudservicios as ss')
                ->leftjoin('adm_contratofinal as cf', "ss.id_contrato", "=", "cf.id")
                ->leftjoin('personas as p1', 'ss.id_propietario', '=', 'p1.id')
                ->leftjoin('inmuebles as i', 'ss.id_inmueble', '=', 'i.id')
                ->leftjoin('users as p2', 'ss.id_creador', '=', 'p2.id')
                ->leftjoin('users as p3', 'ss.id_modificador', '=', 'p3.id')
                ->leftjoin('users as p4', 'ss.id_autorizador', '=', 'p4.id')
                ->leftjoin('users as p5', 'ss.id_asignacion', '=', 'p4.id')
                ->leftjoin('comunas as o', 'i.id_comuna', '=', 'o.comuna_id')
                ->wherenotin("ss.id_estado", [3,5])
                ->leftjoin('mensajes as m', function($join) {
                    $join->on('m.nombre_modulo', '=', DB::raw("'Solicitud Servicio'"));
                    $join->on('m.id_estado', '=', 'ss.id_estado');
                })
                ->select(DB::raw('ss.id as id_solicitud, 
                            DATE_FORMAT(ss.created_at, "%d/%m/%Y") as FechaCreacion, 
                            m.nombre as Estado,
                            CONCAT_WS(" ",p1.nombre,p1.apellido_paterno,p1.apellido_materno) as Propietario, 
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
                ->orderby("ss.id_estado", "asc")
                ->get();

        return Datatables::of($sol)
                        ->addColumn('action', function ($sol) {
                            return '<a href="/solservicio/' . $sol->id_solicitud . '/autorizar"><span class="btn btn-info btn-circle btn-sm">A</span></a>
                               <a href="/solservicio/' . $sol->id_solicitud . '/comprobante"><span class="btn btn-success btn-circle btn-sm">C</span></a>
                                    <a href="/solservicio/' . $sol->id_solicitud . '/rechazar"><span class="btn btn-danger btn-circle btn-sm">R</span></a>';
                        })
                        ->rawColumns(['action'])
                        ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {

        return view('solservicios_pro.create');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create_ajax() {
        $publica = DB::table('adm_contratofinal as co')
                ->leftjoin('borradores as cb', 'co.id_borrador', '=', 'cb.id')
                ->leftjoin('adm_contratodirpropietarios as cd', 'cd.id_contratofinal', '=', 'co.id')
                ->leftjoin('inmuebles as i', 'cd.id_inmueble', '=', 'i.id')
                ->leftjoin('comunas as o', 'i.id_comuna', '=', 'o.comuna_id')
                ->leftjoin('cap_publicaciones as c', 'c.id', '=', 'co.id_publicacion')
                ->leftjoin('personas as p1', 'c.id_propietario', '=', 'p1.id')
                ->leftjoin('users as p2', 'c.id_creador', '=', 'p2.id')
                ->leftjoin('users as p3', 'c.id_modificador', '=', 'p3.id')
                ->leftjoin('mensajes as m', function($join) {
                    $join->on('m.nombre_modulo', '=', DB::raw("'Captación'"));
                    $join->on('m.id_estado', '=', 'c.id_estado');
                })
                ->whereIn('c.id_estado', [7, 10, 6])
                ->select(DB::raw('co.id as id_contrato, 
                            DATE_FORMAT(co.created_at, "%d/%m/%Y") as FechaCreacion, 
                            m.nombre as Estado,
                            CONCAT_WS(" ",p1.nombre,p1.apellido_paterno,p1.apellido_materno) as Propietario, 
                            p2.name as Creador,
                            p3.name as Modificador,
                            CONCAT_WS(" ",i.direccion,i.numero," Dpto ",i.departamento) as Direccion,
                            o.comuna_nombre as Comuna,
                            p1.email,
                            p1.telefono'))
                ->get();
        return Datatables::of($publica)
                        ->addColumn('action', function ($publica) {
                            return '<a href="/solservicio/' . $publica->id_contrato . '/create"><span class="btn btn-success  btn-sm">Crear Solicitud</span></a>
                                    ';
                        })
                        ->addColumn('id_link', function ($publica) {
                            return '<a href="/solservicio/' . $publica->id_contrato . '/create"><span class="btn btn-success btn-sm"> ' . $publica->id_contrato . '</span> </a>';
                        })
                        ->rawColumns(['id_link', 'action'])
                        ->make(true);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create_solicitud($idcontrato) {
        $uf = DB::table('adm_uf')
                ->where("fecha", "=", Carbon::now()->format('Y/m/d'))
                ->first();
        $servicio = CatalogoServicios::all()->where('id_estado', '<>', '0');
        $contratofinal = ContratoFinal::find($idcontrato);
        $borrador = ContratoBorrador::find($contratofinal->id_borrador);
        $captacion = Captacion::find($borrador->id_publicacion);
        $nuevo_servicio = SolicitudServicio::create([
                    "id_contrato" => $idcontrato,
                    "id_inmueble" => $captacion->id_inmueble,
                    "id_propietario" => $captacion->id_propietario,
                    "id_creador" => Auth::user()->id,
                    "id_modificador" => Auth::user()->id,
                    "fecha_uf" => Carbon::now()->format('Y/m/d'),
                    "valor_uf" => $uf->valor,
                    "valor_en_uf" => 0,
                    "valor_en_pesos" => 0,
                    "id_estado" => 1
        ]);
        $totaluf = 0;
        $totalpesos = 0;
        return view('solservicios_pro.create_servicio', compact('servicio', 'idcontrato', 'nuevo_servicio', 'uf', 'totaluf', 'totalpesos'));
    }

    public function datos_servicio($id) {
        $servicio = CatalogoServicios::find($id);
        return response()->json($servicio);
    }

    public function detalle_servicio_ajax(Request $request, $id) {

        $servicio = DB::table('post_detallesolservicios as ds')
                ->leftjoin('post_catalogoservicios as cs', 'ds.id_servicio', '=', 'cs.id')
                ->where("ds.id_solicitud", "=", $id)
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
                            $boton = "";
                            if (isset($servicio->ruta)) {
                                $boton = '<a href="/' . $servicio->ruta . '/' . $servicio->nombre . '" target="_blank"> <span class="btn btn-success btn-circle btn-sm">D</span></a>';
                            }
                            return $boton . ' <a href="/solservicio/borrar/' . $servicio->id . '"><span class="btn btn-danger btn-circle btn-sm"><i class="ti-pencil-alt"></i></span></a>
                                    ';
                        })
                        ->rawColumns(['action'])
                        ->make(true);
    }

    public function borrar_detalleservicio($id) {

        $detalle = DetalleSolicitudServicio::find($id);
        $borrar = DetalleSolicitudServicio::find($id)->delete();

        return redirect()->route('solservicio.edit', $detalle->id_solicitud)
                        ->with('status', 'Detalle borrado con éxito');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $destinationPath = "";
        $archivo = "";
        if (isset($request->foto)) {
            $destinationPath = 'uploads/detallesolservicio';
            $archivo = rand() . $request->foto->getClientOriginalName();
            $file = $request->file('foto');
            $file->move($destinationPath, $archivo);
        }
        $uf = DB::table('adm_uf')
                ->where("fecha", "=", Carbon::now()->format('Y/m/d'))
                ->first();

        if ($request->moneda == "UF") {
            $subtotaluf = $request->valor_en_moneda * $request->cantidad;
            $subtotalpesos = ($uf->valor * $request->valor_en_moneda) * $request->cantidad;
            $valorenuf = $request->valor_en_moneda;
            $valorenpesos = $request->valor_en_moneda * $uf->valor;
        } else {
            $subtotaluf = ($request->valor_en_moneda / $uf->valor) * $request->cantidad;
            $subtotalpesos = $request->valor_en_moneda * $request->cantidad;
            $valorenuf = $request->valor_en_moneda / $uf->valor;
            $valorenpesos = $request->valor_en_moneda;
        }
        $detalle = DetalleSolicitudServicio::create([
                    "id_solicitud" => $request->id_solicitud,
                    "id_contrato" => $request->id_contrato,
                    "id_inmueble" => $request->id_inmueble,
                    "id_propietario" => $request->id_propietario,
                    "id_creador" => Auth::user()->id,
                    "id_servicio" => $request->servicio,
                    "fecha_uf" => Carbon::now()->format('Y/m/d'),
                    "valor_uf" => $uf->valor,
                    "valor_en_uf" => $valorenuf,
                    "valor_en_pesos" => $valorenpesos,
                    "cantidad" => $request->cantidad,
                    "subtotal_uf" => $subtotaluf,
                    "subtotal_pesos" => $subtotalpesos,
                    "nombre" => $archivo,
                    "ruta" => $destinationPath,
                    "id_estado" => 1
        ]);

        $edit = SolicitudServicio::find($request->id_solicitud)->update(["id_estado" => 2]);

        return redirect()->route('solservicio.edit', $request->id_solicitud)
                        ->with('status', 'Detalle ingresado con éxito');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\SolicitudServicio  $solicitudServicio
     * @return \Illuminate\Http\Response
     */
    public function show(SolicitudServicio $solicitudServicio) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\SolicitudServicio  $solicitudServicio
     * @return \Illuminate\Http\Response
     */
    public function edit($idsolicitud) {
        $uf = DB::table('adm_uf')
                ->where("fecha", "=", Carbon::now()->format('Y/m/d'))
                ->first();
        $nuevo_servicio = SolicitudServicio::find($idsolicitud);
        $servicio = CatalogoServicios::all()->where('id_estado', '<>', '0');
        $contratofinal = ContratoFinal::find($nuevo_servicio->id_contrato);
        $borrador = ContratoBorrador::find($contratofinal->id_borrador);
        $captacion = Captacion::find($borrador->id_publicacion);
        $idcontrato = $nuevo_servicio->id_contrato;

        $totaluf = DetalleSolicitudServicio::where("id_solicitud", "=", $idsolicitud)->sum('subtotal_uf');
        $totalpesos = DetalleSolicitudServicio::where("id_solicitud", "=", $idsolicitud)->sum('subtotal_pesos');
        return view('solservicios_pro.create_servicio', compact('servicio', 'idcontrato', 'nuevo_servicio', 'uf', 'totaluf', 'totalpesos'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\SolicitudServicio  $solicitudServicio
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SolicitudServicio $solicitudServicio) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\SolicitudServicio  $solicitudServicio
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        $edit = DetalleSolicitudServicio::where("id_solicitud", "=", $id)->count();

        if ($edit < 1) {
            $edit = SolicitudServicio::find($id)->delete();
            return redirect()->route('solservicio.index')
                            ->with('status', 'Solicitud eliminada con éxito');
        } else {
            return redirect()->route('solservicio.edit', $id)
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

        $servicio = SolicitudServicio::find($id);
        $contratofinal = ContratoFinal::find($servicio->id_contrato);
        $borrador = ContratoBorrador::find($contratofinal->id_borrador);
        $publicacion = Captacion::find($borrador->id_publicacion);
        $idcontrato = $servicio->id_contrato;
        $inmueble = Inmueble::find($publicacion->id_inmueble);
        $persona = Persona::find($publicacion->id_propietario);

        $totaluf = DetalleSolicitudServicio::where("id_solicitud", "=", $id)->sum('subtotal_uf');
        $totalpesos = DetalleSolicitudServicio::where("id_solicitud", "=", $id)->sum('subtotal_pesos');

        $detalle = DB::table('post_detallesolservicios as ds')
                ->leftjoin('post_catalogoservicios as cs', 'ds.id_servicio', '=', 'cs.id')
                ->where("ds.id_solicitud", "=", $id)
                ->select(DB::raw('ds.id,
                    ds.valor_en_uf,
                    ds.valor_en_pesos,
                    ds.cantidad,
                    ds.subtotal_uf,
                    ds.subtotal_pesos,
                    cs.nombre_servicio,
                    cs.detalle'))
                ->get();
        $firma = "PROPIETARIO";

        $pdf = PDF::loadView('formatospdf.solicitudpropietario', compact('servicio', 'persona', 'inmueble', 'uf', 'totaluf', 'totalpesos', 'detalle', 'firma'));

        return $pdf->download($inmueble->direccion . ' Nro.' . $inmueble->numero . ' Dpto.' . $inmueble->departamento . ', ' . $inmueble->comuna_nombre . ' - Solicitud ' . $servicio->id . ' - Comprobante Solicitud de Servbicios.pdf');
    }

}
