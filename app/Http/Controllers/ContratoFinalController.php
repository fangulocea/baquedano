<?php

namespace App\Http\Controllers;

use App\ContratoFinal;
use App\ContratoBorrador;
use App\ContratoFinalPdf;
use App\ContratoFinalDocs;
use App\Captacion;
use App\PagosPropietarios;
use App\PagosMensualesPropietarios;
use App\ContratoInmueblesPropietarios;
use App\Contratoborradorpdf;
use App\GenerarPagoPropietario;
use App\SimulaPropietario;
use App\PropietarioGarantia;
use App\DetallePagosPropietarios;
use Illuminate\Http\Request;
use Carbon\Carbon;
use DB;
use Illuminate\Support\Facades\File;
use Auth;
use App\PropietarioCheques;

class ContratoFinalController extends Controller {

    public function getContrato($id) {
        $contrato = DB::table('adm_contratofinal  as b')
                        ->leftjoin('cap_publicaciones as cp', 'b.id_publicacion', '=', 'cp.id')
                        ->leftjoin('adm_contratofinalpdf as bp', 'b.id', '=', 'bp.id_final')
                        ->leftjoin('borradores as br', 'b.id_borrador', '=', 'br.id')
                        ->leftjoin('comisiones as co', 'br.id_comisiones', '=', 'co.id')
                        ->leftjoin('flexibilidads as f', 'br.id_flexibilidad', '=', 'f.id')
                        ->where('b.id', '=', $id)
                        ->select(DB::raw(' co.comision,b.fecha_firma'))
                        ->get()->first();
        return response()->json($contrato);
    }

    public function getPagos($id, $idi) {

        $contratofinal = DB::table('adm_contratofinal as cf')
                ->leftjoin('cap_simulapropietario as s', 's.id', '=', 'cf.id_propuesta')
                ->where("cf.id", "=", $id)
                ->first();



        $contrato = DB::table('adm_pagospropietarios')
                ->where('id_contratofinal', '=', $id)
                ->where('id_inmueble', '=', $idi)
                ->where('tipopropuesta', '=', $contratofinal->tipopropuesta)
                ->orderBy('id', 'asc')
                ->get();
        return response()->json($contrato);
    }

    public function getpagosmensuales($id, $idi) {
        $contrato = DB::table('adm_pagosmensualespropietarios as c')
                ->leftjoin('adm_contratofinal as cp', 'c.id_contratofinal', '=', 'cp.id')
                ->where('c.id_contratofinal', '=', $id)
                ->where('c.id_inmueble', '=', $idi)
                ->select(DB::raw(' c.id, c.E_S, c.fecha_iniciocontrato, c.mes, c.anio, c.valor_a_pagar, cp.meses_contrato,c.subtotal_entrada, c.subtotal_salida, c.pago_propietario, c.pago_rentas,c.subtotal_entrada_moneda, c.subtotal_salida_moneda, c.pago_propietario_moneda, c.pago_rentas_moneda, c.id_estado'))
                ->orderBy('c.id', 'asc')
                ->get();
        return response()->json($contrato);
    }

    public function crearContrato(Request $request) {


        $ContratoBorrador = ContratoBorrador::find($request->id_borradorfinal);
        $ContratoBorradorPDF = Contratoborradorpdf::where("id_borrador", "=", $request->id_borradorfinal)->first();
        $captacion = Captacion::find($ContratoBorrador->id_publicacion)->update([
            "id_estado" => 10
        ]);

        $tipo_simulacion = DB::table('cap_simulapropietario')
                        ->where("id", "=", $ContratoBorrador->id_simulacion)->first();
        if ($tipo_simulacion->tipopropuesta == 1 || $tipo_simulacion->tipopropuesta == 2) {
            $tContrato = "N";
        } elseif ($tipo_simulacion->tipopropuesta == 3 || $tipo_simulacion->tipopropuesta == 4) {
            $tContrato = "R";
        } else {
            $tContrato = "X";
        }
        array_set($request, 'tipo_contrato', $tContrato);

        $contratoFinal = ContratoFinal::create([
                    "id_publicacion" => $ContratoBorrador->id_publicacion,
                    "id_propuesta" => $request->id_propuesta,
                    "id_estado" => 1,
                    "id_creador" => $request->id_creadorfinal,
                    "id_borrador" => $request->id_borradorfinal,
                    "id_borradorpdf" => $ContratoBorradorPDF->id,
                    "tipo_contrato" => $request->tipo_contrato
        ]);

        //PARA PDF
        $borradorPDF = DB::table('borradores as b')
                        ->leftjoin('notarias as n', 'b.id_notaria', '=', 'n.id')
                        ->leftjoin('servicios as s', 'b.id_servicios', '=', 's.id')
                        ->leftjoin('comisiones as c', 'b.id_comisiones', '=', 'c.id')
                        ->leftjoin('flexibilidads as f', 'b.id_flexibilidad', '=', 'f.id')
                        ->leftjoin('cap_publicaciones as cp', 'b.id_publicacion', '=', 'cp.id')
                        ->leftjoin('personas as p1', 'cp.id_propietario', '=', 'p1.id')
                        ->leftjoin('comunas as c1', 'p1.id_comuna', '=', 'c1.comuna_id')
                        ->leftjoin('inmuebles as i', 'cp.id_inmueble', '=', 'i.id')
                        ->leftjoin('comunas as c2', 'i.id_comuna', '=', 'c2.comuna_id')
                        ->leftjoin('regions as reg', 'p1.id_region', '=', 'reg.region_id')
                        ->leftjoin('contratos as con', 'b.id_contrato', '=', 'con.id')
                        ->where('b.id', '=', $request->id_borradorfinal)
                        ->select(DB::raw(' b.id as id, n.razonsocial as n_n, s.nombre as n_s, c.nombre as n_c, f.nombre as n_f , cp.id as id_publicacion,DATE_FORMAT(b.fecha_gestion, "%d/%m/%Y") as fecha,
             CONCAT_WS(" ",p1.nombre,p1.apellido_paterno,p1.apellido_materno) as propietario,
             p1.rut as rut_p, CONCAT(p1.direccion," ", p1.numero) as direccion_p , c1.comuna_nombre as comuna_p, reg.region_nombre as region_p,
             CONCAT(i.direccion," ",i.numero) as direccion_i, i.departamento as depto_i, c2.comuna_nombre as comuna_i,
             i.dormitorio as dormitorio, i.bano as bano, i.bodega, i.piscina, i.precio, i.gastosComunes, 
             con.nombre, con.nombre as contrato, con.descripcion as deta_contrato,
             p1.profesion as profesion_p, p1.telefono as telefono_p, p1.departamento as depto_p,
             i.rol as rol, b.detalle_revision as bodyContrato, CONCAT(c.descripcion, " ", c.comision, " %") as comision,f.descripcion as Flexibilidad, CONCAT(s.descripcion, "  $",s.valor) as Servicio'))->first();


        $capSimulacion = DB::table('cap_simulapropietario as s')
                        ->where('s.id', '=', $request->id_propuesta)->first();

        if ($capSimulacion->tipopropuesta == 1 || $capSimulacion->tipopropuesta == 3) {
            $idTipoPago = 21;
        } elseif ($capSimulacion->tipopropuesta == 2 || $capSimulacion->tipopropuesta == 4) {
            $idTipoPago = 35;
        }

        $simulacion = DB::table('cap_simulapagopropietarios as b')
                ->where('b.id_simulacion', '=', $request->id_propuesta)
                ->where('b.idtipopago', '=', $idTipoPago)
                ->get();

        $textoContrato = DB::table('borradores as c')
                ->where('c.id', '=', $request->id_borradorfinal)
                ->first();

        $cadenaAbuscar = '{Cheques}';
        $posicion_coincidencia = strrpos($textoContrato->detalle_revision, $cadenaAbuscar);

        $correlativo = 1;
        if ($posicion_coincidencia != false) {
            foreach ($simulacion as $s) {
                $contratoCh = PropietarioCheques::create([
                            'id_contrato' => $contratoFinal->id,
                            'monto' => $s->precio_en_pesos,
                            'id_estado' => 1,
                            'correlativo' => $correlativo,
                            'mes_arriendo' => $s->mes . '/' . $s->anio
                ]);
                $correlativo++;
            }
        }

        $simulacion = DB::table('propietario_cheques as b')
                ->where('b.id_contrato', '=', $contratoFinal->id)
                ->get();






        $pdf = new PdfController();
        $numero = rand();
        $pdf->crontratoFinalPdf($borradorPDF, $numero, $simulacion);
        // FIN PARA PDFsss

        $finalpdf = ContratoFinalPdf::create([
                    "id_final" => $contratoFinal->id,
                    "nombre" => $numero . $borradorPDF->id . $borradorPDF->direccion_i . '-FINAL.pdf',
                    "ruta" => "uploads/pdf_final/",
                    "id_creador" => $request->id_creadorfinal,
                ])->toArray();
        return redirect()->route('finalContrato.edit', [$ContratoBorrador->id_publicacion, $request->id_borradorfinal, $ContratoBorradorPDF->id, 1])
                        ->with('status', 'Contrato Final guardado con éxito');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $meses = DB::select(DB::raw('Select CONCAT(MONTH(DATE_ADD(now(), INTERVAL -6 MONTH)),"/",YEAR(DATE_ADD(now(), INTERVAL -6 MONTH))) as mesanterior6,
                    CONCAT(MONTH(DATE_ADD(now(), INTERVAL -5 MONTH)),"/",YEAR(DATE_ADD(now(), INTERVAL -5 MONTH))) as mesanterior5,
                    CONCAT(MONTH(DATE_ADD(now(), INTERVAL -4 MONTH)),"/",YEAR(DATE_ADD(now(), INTERVAL -4 MONTH))) as mesanterior4,
                    CONCAT(MONTH(DATE_ADD(now(), INTERVAL -3 MONTH)),"/",YEAR(DATE_ADD(now(), INTERVAL -3 MONTH))) as mesanterior3,
                    CONCAT(MONTH(DATE_ADD(now(), INTERVAL -2 MONTH)),"/",YEAR(DATE_ADD(now(), INTERVAL -2 MONTH))) as mesanterior2,
                    CONCAT(MONTH(DATE_ADD(now(), INTERVAL -1 MONTH)),"/",YEAR(DATE_ADD(now(), INTERVAL -1 MONTH))) as mesanterior1,
                    CONCAT(MONTH(now()),"/",YEAR(now())) as mesactual,
                    CONCAT(MONTH(DATE_ADD(now(), INTERVAL +1 MONTH)),"/",YEAR(DATE_ADD(now(), INTERVAL +1 MONTH))) as messiguiente1,
                    CONCAT(MONTH(DATE_ADD(now(), INTERVAL +2 MONTH)),"/",YEAR(DATE_ADD(now(), INTERVAL +2 MONTH))) as messiguiente2,
                    CONCAT(MONTH(DATE_ADD(now(), INTERVAL +3 MONTH)),"/",YEAR(DATE_ADD(now(), INTERVAL +3 MONTH))) as messiguiente3,
                    CONCAT(MONTH(DATE_ADD(now(), INTERVAL +4 MONTH)),"/",YEAR(DATE_ADD(now(), INTERVAL +4 MONTH))) as messiguiente4,
                    CONCAT(MONTH(DATE_ADD(now(), INTERVAL +5 MONTH)),"/",YEAR(DATE_ADD(now(), INTERVAL +5 MONTH))) as messiguiente5,
                    CONCAT(MONTH(DATE_ADD(now(), INTERVAL +6 MONTH)),"/",YEAR(DATE_ADD(now(), INTERVAL +6 MONTH))) as messiguiente6;'));
        $meses = $meses[0];

        $publica = DB::table('adm_contratofinal as co')
                ->leftjoin('borradores as cb', 'co.id_borrador', '=', 'cb.id')
                ->leftjoin('adm_contratodirpropietarios as cd', 'cd.id_contratofinal', '=', 'co.id')
                ->leftjoin('inmuebles as i', 'cd.id_inmueble', '=', 'i.id')
                ->leftjoin('comunas as o', 'i.id_comuna', '=', 'o.comuna_id')
                ->leftjoin('cap_publicaciones as c', 'c.id', '=', 'co.id_publicacion')
                ->leftjoin('personas as p1', 'c.id_propietario', '=', 'p1.id')
                ->leftjoin('users as p2', 'c.id_creador', '=', 'p2.id')
                ->leftjoin('users as p3', 'c.id_modificador', '=', 'p3.id')
                ->whereIn('c.id_estado', [7, 10, 6])
                ->select(DB::raw('cb.dia_pago,c.id as id_publicacion, DATE_FORMAT(c.created_at, "%d/%m/%Y") as fecha_creacion, c.id_estado as id_estado, CONCAT_WS(" ",p1.nombre,p1.apellido_paterno,p1.apellido_materno) as Propietario, p2.name as Creador,

                  (select pago_propietario from adm_pagosmensualespropietarios where mes=MONTH(DATE_ADD(now(), INTERVAL -6 MONTH)) and anio=YEAR(DATE_ADD(now(), INTERVAL -6 MONTH)) and id_publicacion=c.id and id_inmueble=i.id and id_contratofinal=co.id ) as valoranterior6,

                    (select sum(valor_pagado) from adm_detallepagospropietarios dt inner join adm_pagosmensualespropietarios pm on dt.id_pagomensual=pm.id where pm.mes=MONTH(DATE_ADD(now(), INTERVAL -6 MONTH)) and pm.anio=YEAR(DATE_ADD(now(), INTERVAL -6 MONTH)) and pm.id_publicacion=c.id and pm.id_inmueble=i.id and pm.id_contratofinal=co.id ) as valorpagadoanterior6,

                  (select pago_propietario from adm_pagosmensualespropietarios where mes=MONTH(DATE_ADD(now(), INTERVAL -5 MONTH)) and anio=YEAR(DATE_ADD(now(), INTERVAL -5 MONTH)) and id_publicacion=c.id and id_inmueble=i.id and id_contratofinal=co.id) as valoranterior5,

                    (select sum(valor_pagado) from adm_detallepagospropietarios dt inner join adm_pagosmensualespropietarios pm on dt.id_pagomensual=pm.id where pm.mes=MONTH(DATE_ADD(now(), INTERVAL -5 MONTH)) and pm.anio=YEAR(DATE_ADD(now(), INTERVAL -5 MONTH)) and pm.id_publicacion=c.id and pm.id_inmueble=i.id and pm.id_contratofinal=co.id) as valorpagadoanterior5,

                  (select pago_propietario from adm_pagosmensualespropietarios where mes=MONTH(DATE_ADD(now(), INTERVAL -4 MONTH)) and anio=YEAR(DATE_ADD(now(), INTERVAL -4 MONTH)) and id_publicacion=c.id and id_inmueble=i.id and id_contratofinal=co.id) as valoranterior4,

                    (select sum(valor_pagado) from adm_detallepagospropietarios dt inner join adm_pagosmensualespropietarios pm on dt.id_pagomensual=pm.id where pm.mes=MONTH(DATE_ADD(now(), INTERVAL -4 MONTH)) and pm.anio=YEAR(DATE_ADD(now(), INTERVAL -4 MONTH)) and pm.id_publicacion=c.id and pm.id_inmueble=i.id and pm.id_contratofinal=co.id) as valorpagadoanterior4,

                  (select pago_propietario from adm_pagosmensualespropietarios where mes=MONTH(DATE_ADD(now(), INTERVAL -3 MONTH)) and anio=YEAR(DATE_ADD(now(), INTERVAL -3 MONTH)) and id_publicacion=c.id and id_inmueble=i.id and id_contratofinal=co.id) as valoranterior3,

                    (select sum(valor_pagado) from adm_detallepagospropietarios dt inner join adm_pagosmensualespropietarios pm on dt.id_pagomensual=pm.id where pm.mes=MONTH(DATE_ADD(now(), INTERVAL -3 MONTH)) and pm.anio=YEAR(DATE_ADD(now(), INTERVAL -3 MONTH)) and pm.id_publicacion=c.id and pm.id_inmueble=i.id and pm.id_contratofinal=co.id) as valorpagadoanterior3,

                  (select pago_propietario from adm_pagosmensualespropietarios where mes=MONTH(DATE_ADD(now(), INTERVAL -2 MONTH)) and anio=YEAR(DATE_ADD(now(), INTERVAL -2 MONTH)) and id_publicacion=c.id and id_inmueble=i.id and id_contratofinal=co.id) as valoranterior2,

                    (select sum(valor_pagado) from adm_detallepagospropietarios dt inner join adm_pagosmensualespropietarios pm on dt.id_pagomensual=pm.id where pm.mes=MONTH(DATE_ADD(now(), INTERVAL -2 MONTH)) and pm.anio=YEAR(DATE_ADD(now(), INTERVAL -2 MONTH)) and pm.id_publicacion=c.id and pm.id_inmueble=i.id and pm.id_contratofinal=co.id) as valorpagadoanterior2,


                  (select pago_propietario from adm_pagosmensualespropietarios where mes=MONTH(DATE_ADD(now(), INTERVAL -1 MONTH)) and anio=YEAR(DATE_ADD(now(), INTERVAL -1 MONTH)) and id_publicacion=c.id and id_inmueble=i.id and id_contratofinal=co.id) as valoranterior1,

                    (select sum(valor_pagado) from adm_detallepagospropietarios dt inner join adm_pagosmensualespropietarios pm on dt.id_pagomensual=pm.id where pm.mes=MONTH(DATE_ADD(now(), INTERVAL -1 MONTH)) and pm.anio=YEAR(DATE_ADD(now(), INTERVAL -1 MONTH)) and pm.id_publicacion=c.id and pm.id_inmueble=i.id and pm.id_contratofinal=co.id) as valorpagadoanterior1,

                    
                    (select pago_propietario from adm_pagosmensualespropietarios where mes=MONTH(now()) and anio=YEAR(now()) and id_publicacion=c.id and id_inmueble=i.id and id_contratofinal=co.id) as valoractual,

                    (select sum(valor_pagado) from adm_detallepagospropietarios dt inner join adm_pagosmensualespropietarios pm on dt.id_pagomensual=pm.id where pm.mes=MONTH(now()) and pm.anio=YEAR(now()) and pm.id_publicacion=c.id and pm.id_inmueble=i.id and pm.id_contratofinal=co.id) as valorpagadoactual,


                      (select pago_propietario from adm_pagosmensualespropietarios where mes=MONTH(DATE_ADD(now(), INTERVAL 1 MONTH)) and anio=YEAR(DATE_ADD(now(), INTERVAL 1 MONTH)) and id_publicacion=c.id and id_inmueble=i.id and id_contratofinal=co.id) as valorsiguiente1,

                    (select sum(valor_pagado) from adm_detallepagospropietarios dt inner join adm_pagosmensualespropietarios pm on dt.id_pagomensual=pm.id where pm.mes=MONTH(DATE_ADD(now(), INTERVAL 1 MONTH)) and pm.anio=YEAR(DATE_ADD(now(), INTERVAL 1 MONTH)) and pm.id_publicacion=c.id and pm.id_inmueble=i.id and pm.id_contratofinal=co.id) as valorpagadosiguiente1,

                    (select pago_propietario from adm_pagosmensualespropietarios where mes=MONTH(DATE_ADD(now(), INTERVAL 2 MONTH)) and anio=YEAR(DATE_ADD(now(), INTERVAL 2 MONTH)) and id_publicacion=c.id and id_inmueble=i.id and id_contratofinal=co.id) as valorsiguiente2,

                    (select sum(valor_pagado) from adm_detallepagospropietarios dt inner join adm_pagosmensualespropietarios pm on dt.id_pagomensual=pm.id where pm.mes=MONTH(DATE_ADD(now(), INTERVAL 2 MONTH)) and pm.anio=YEAR(DATE_ADD(now(), INTERVAL 2 MONTH)) and pm.id_publicacion=c.id and pm.id_inmueble=i.id and pm.id_contratofinal=co.id) as valorpagadosiguiente2,

                     (select pago_propietario from adm_pagosmensualespropietarios where mes=MONTH(DATE_ADD(now(), INTERVAL 3 MONTH)) and anio=YEAR(DATE_ADD(now(), INTERVAL 3 MONTH)) and id_publicacion=c.id and id_inmueble=i.id and id_contratofinal=co.id) as valorsiguiente3,

                    (select sum(valor_pagado) from adm_detallepagospropietarios dt inner join adm_pagosmensualespropietarios pm on dt.id_pagomensual=pm.id where pm.mes=MONTH(DATE_ADD(now(), INTERVAL 3 MONTH)) and pm.anio=YEAR(DATE_ADD(now(), INTERVAL 3 MONTH)) and pm.id_publicacion=c.id and pm.id_inmueble=i.id and pm.id_contratofinal=co.id) as valorpagadosiguiente3,

                     (select pago_propietario from adm_pagosmensualespropietarios where mes=MONTH(DATE_ADD(now(), INTERVAL 4 MONTH)) and anio=YEAR(DATE_ADD(now(), INTERVAL 4 MONTH)) and id_publicacion=c.id and id_inmueble=i.id and id_contratofinal=co.id) as valorsiguiente4,

                    (select sum(valor_pagado) from adm_detallepagospropietarios dt inner join adm_pagosmensualespropietarios pm on dt.id_pagomensual=pm.id where pm.mes=MONTH(DATE_ADD(now(), INTERVAL 4 MONTH)) and pm.anio=YEAR(DATE_ADD(now(), INTERVAL 4 MONTH)) and pm.id_publicacion=c.id and pm.id_inmueble=i.id and pm.id_contratofinal=co.id) as valorpagadosiguiente4,

                    (select pago_propietario from adm_pagosmensualespropietarios where mes=MONTH(DATE_ADD(now(), INTERVAL 5 MONTH)) and anio=YEAR(DATE_ADD(now(), INTERVAL 5 MONTH)) and id_publicacion=c.id and id_inmueble=i.id and id_contratofinal=co.id ) as valorsiguiente5,

                    (select sum(valor_pagado) from adm_detallepagospropietarios dt inner join adm_pagosmensualespropietarios pm on dt.id_pagomensual=pm.id where pm.mes=MONTH(DATE_ADD(now(), INTERVAL 5 MONTH)) and pm.anio=YEAR(DATE_ADD(now(), INTERVAL 5 MONTH)) and pm.id_publicacion=c.id and pm.id_inmueble=i.id and pm.id_contratofinal=co.id) as valorpagadosiguiente5,

                     (select pago_propietario from adm_pagosmensualespropietarios where mes=MONTH(DATE_ADD(now(), INTERVAL 6 MONTH)) and anio=YEAR(DATE_ADD(now(), INTERVAL 6 MONTH)) and id_publicacion=c.id and id_inmueble=i.id and id_contratofinal=co.id) as valorsiguiente6,

                    (select sum(valor_pagado) from adm_detallepagospropietarios dt inner join adm_pagosmensualespropietarios pm on dt.id_pagomensual=pm.id where pm.mes=MONTH(DATE_ADD(now(), INTERVAL 6 MONTH)) and pm.anio=YEAR(DATE_ADD(now(), INTERVAL 6 MONTH)) and pm.id_publicacion=c.id and pm.id_inmueble=i.id and pm.id_contratofinal=co.id) as valorpagadosiguiente6

                    '), 'p1.id as id_propietario', 'i.id as id_inmueble', 'i.direccion', 'i.numero', 'i.departamento', 'o.comuna_nombre', 'p1.nombre as nom_p', 'p1.apellido_paterno as apep_p', 'p1.apellido_materno as apem_p', 'p3.name as modifcador')
                ->get();

        return view('contratoFinal.index', compact('publica', 'meses'));
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
     * @param  \App\ContratoFinal  $contratoFinal
     * @return \Illuminate\Http\Response
     */
    public function show(ContratoFinal $contratoFinal) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ContratoFinal  $contratoFinal
     * @return \Illuminate\Http-\Response
     */
    public function edit($idc, $idcb, $idpdf, $tab) {
        $borrador = DB::table('cap_publicaciones as c')
                ->leftjoin('personas as p1', 'c.id_propietario', '=', 'p1.id')
                ->leftjoin('inmuebles as i', 'c.id_inmueble', '=', 'i.id')
                ->leftjoin('users as p2', 'c.id_creador', '=', 'p2.id')
                ->leftjoin('users as p3', 'c.id_modificador', '=', 'p3.id')
                ->leftjoin('comunas as o', 'i.id_comuna', '=', 'o.comuna_id')
                ->leftjoin('portales as po', 'c.portal', '=', 'po.id')
                ->where('c.id', '=', $idc)
                ->select(DB::raw('c.id as id_publicacion, p1.id as id_propietario, i.id as id_inmueble, CONCAT_WS(" ",i.direccion,"#",i.numero,"Depto.",i.departamento,o.comuna_nombre) as direccion, CONCAT_WS(" ",p1.nombre , p1.apellido_paterno, " Fono: " ,p1.telefono, " Email: " ,p1.email ) as propietario, i.precio, i.gastosComunes'))
                ->first();

        $finalIndex = DB::table('adm_contratofinal  as b')
                ->leftjoin('cap_publicaciones as cp', 'b.id_publicacion', '=', 'cp.id')
                ->leftjoin('adm_contratofinalpdf as bp', 'b.id', '=', 'bp.id_final')
                ->leftjoin('borradores as cb', 'b.id_borrador', '=', 'cb.id')
                ->where('b.id_publicacion', '=', $idc)
                ->select(DB::raw(' b.id ,b.id_borrador, cp.id as id_publicacion,b.fecha_firma as fecha,b.id_estado,bp.nombre, bp.id as id_pdf,b.id_notaria,b.alias, cb.dia_pago'))
                ->get();

        $notaria = DB::table('notarias as n')
                ->where("n.estado", "<>", 0)
                ->select(DB::raw('n.id as id,n.razonsocial as nombre'))
                ->get();

        $documentos = DB::table('adm_contratofinaldocs as n')
                ->leftjoin('inmuebles as i', 'n.id_inmueble', '=', 'i.id')
                ->leftjoin('comunas as o', 'i.id_comuna', '=', 'o.comuna_id')
                ->where("n.id_publicacion", "=", $idc)
                ->select(DB::raw(' n.id ,n.ruta, n.nombre, n.tipo, CONCAT_WS(" ",i.direccion,"#",i.numero,"Depto.",i.departamento,o.comuna_nombre) as direccion'))
                ->get();

        $direcciones = DB::table('adm_contratodirpropietarios as c')
                ->leftjoin('inmuebles as i', 'c.id_inmueble', '=', 'i.id')
                ->leftjoin('comunas as o', 'i.id_comuna', '=', 'o.comuna_id')
                ->leftjoin('adm_contratofinal as cf', 'c.id_contratofinal', '=', 'cf.id')
                ->where("c.id_publicacion", "=", $idc)
                ->select(DB::raw('c.id, i.id as id_inmueble, CONCAT_WS(" ",i.direccion,"#",i.numero,"Depto.",i.departamento,o.comuna_nombre) as direccion, cf.alias'))
                ->get();

        $uf = DB::table('adm_uf')
                ->where("fecha", "=", Carbon::now()->format('Y/m/d'))
                ->first();

        $flag = 0;

        $propuestas = DB::table('cap_simulapropietario as s')
                ->join("adm_contratofinal as cf", "cf.id_propuesta", "s.id")
                ->where("s.id_publicacion", "=", $idc)
                ->select(DB::raw(" s.id, (CASE  WHEN s.tipopropuesta=1 THEN '1 Cuota' WHEN s.tipopropuesta=2 THEN'Pie + Cuota' ELSE 'Renovación' END) as tipopropuesta, s.proporcional, s.fecha_iniciocontrato, s.meses_contrato, s.iva,descuento, s.pie, cobromensual, s.nrocuotas,s.canondearriendo"))
                ->get();

        return view('contratoFinal.edit', compact('borrador', 'finalIndex', 'notaria', 'documentos', 'flag', 'tab', 'direcciones', 'propuestas', 'uf'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ContratoFinal  $contratoFinal
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ContratoFinal $contratoFinal) {
        //
    }

    public function mostrarsimulacion($id) {
        $simulacion = SimulaPropietario::find($id);
        return response()->json($simulacion);
    }

    public function asignarNotaria(Request $request, $id) {
        $now = new \DateTime();
        $fecha_creacion = $now->format('Y-m-d H:i:s');
        $contrato = ContratoFinal::where('id', '=', $id)->update([
            "id_notaria" => $request->id_notaria,
            "fecha_firma" => $request->fecha_firma,
            "id_modificador" => $request->id_modificador,
            "updated_at" => $fecha_creacion,
            "alias" => $request->alias,
            "id_estado" => 7
        ]);

        $captacion = Captacion::find($request->id_publicacion)->update([
            "id_estado" => 7
        ]);

        $captacion = Captacion::find($request->id_publicacion);
        $cont_inmueble = ContratoInmueblesPropietarios::create([
                    "id_publicacion" => $request->id_publicacion,
                    "id_contratofinal" => $id,
                    "id_inmueble" => $captacion->id_inmueble,
                    "id_creador" => Auth::user()->id
        ]);

        return redirect()->route('finalContrato.edit', [$request->id_publicacion, $request->id_borrador, $request->id_pdf, 1])
                        ->with('status', 'Contrato actualizado con éxito');
    }

    public function asignarinmueble($idc, $idi, $idp) {

        $cont_inmueble = ContratoInmueblesPropietarios::where("id_inmueble", "=", $idi)
                ->where("id_contratofinal", "=", $idc)
                ->where("id_publicacion", "=", $idp)
                ->get();
        if (count($cont_inmueble) > 0) {
            return redirect()->route('finalContrato.edit', [$idp, 0, 0, 6])
                            ->with('error', 'Inmueble ya se encuentra asignado a contrato');
        }

        $cont_inmueble = ContratoInmueblesPropietarios::create([
                    "id_publicacion" => $idp,
                    "id_contratofinal" => $idc,
                    "id_inmueble" => $idi,
                    "id_creador" => Auth::user()->id
        ]);

        return redirect()->route('finalContrato.edit', [$idp, 0, 0, 6])
                        ->with('status', 'Contrato actualizado con éxito');
    }

    public function savedocs(Request $request, $id) {
        if (!isset($request->foto)) {
            return redirect()->route('finalContrato.edit', $id)->with('error', 'Debe seleccionar archivo');
        }

        $destinationPath = 'uploads/contratofinaldocs';
        $archivo = rand() . $request->foto->getClientOriginalName();
        $file = $request->file('foto');
        $file->move($destinationPath, $archivo);

        $imagen = ContratoFinalDocs::create([
                    'id_final' => $request->id_final,
                    'id_publicacion' => $request->id_publicacion,
                    'id_inmueble' => $request->id_inmueble_pdf,
                    'tipo' => $request->tipo,
                    'nombre' => $archivo,
                    'ruta' => $destinationPath,
                    'id_creador' => $request->id_creador
        ]);


        return redirect()->route('finalContrato.edit', [$request->id_publicacion, 0, 0, 2])->with('status', 'Documento guardada con éxito');
    }

    public function eliminarfoto($idf) {

        $imagen = ContratoFinalDocs::find($idf);

        File::delete($imagen->ruta . '/' . $imagen->nombre);
        $foto = ContratoFinalDocs::find($idf)->delete();

        return redirect()->route('finalContrato.edit', [$imagen->id_publicacion, 0, 0, 2])->with('status', 'Documento eliminado con éxito');
    }

    public function eliminartipopago(Request $request) {
        $eliminamensual = DetallePagosPropietarios::where("id_publicacion", "=", $request->id_pub_borrar)
                ->where("id_inmueble", "=", $request->id_inmueble_mensual)
                ->delete();
        $eliminamensual = PagosMensualesPropietarios::where("id_contratofinal", "=", $request->id_final_detalle)
                ->where("id_inmueble", "=", $request->id_inmueble_mensual)
                ->delete();
        $eliminapagos = PagosPropietarios::where("id_contratofinal", "=", $request->id_final_detalle)
                ->where("id_inmueble", "=", $request->id_inmueble_mensual)
                ->delete();
        return redirect()->route('finalContrato.edit', [$request->id_pub_borrar, 0, 0, 4])->with('status', 'Pagos Eliminados con éxito');
    }

    public function updatepago(Request $request) {
        $idcontrato = $request->id_contrato_update;
        ;
        $pp = PagosPropietarios::find($request->id_pago_update)->update([
            "precio_en_pesos" => $request->pago_update
        ]);
        $idp = $request->id_publicacion_update;
        $p = PagosPropietarios::find($request->id_pago_update);

        $fecha_ini = date('Y-m-j', strtotime(date("Y", strtotime($p->fecha_iniciocontrato)) . '-' . date("m", strtotime($p->fecha_iniciocontrato)) . '-' . 1));
        for ($i = 0; $i < $p->meses_contrato; $i++) {
            $mes = date("m", strtotime($fecha_ini));
            $anio = date("Y", strtotime($fecha_ini));
            $fecha_ini = date("d-m-Y", strtotime("+1 month", strtotime($fecha_ini)));
            $pagos_mensuales_e = DB::table('adm_pagospropietarios')
                    ->where("id_publicacion", "=", $idp)
                    ->where("id_contratofinal", '=', $idcontrato)
                    ->where("E_S", "=", "e")
                    ->where("id_inmueble", "=", $request->id_inmueble_update)
                    ->where("mes", "=", $mes)
                    ->where("anio", "=", $anio)
                    ->sum('precio_en_pesos');
            $pagos_mensuales_s = DB::table('adm_pagospropietarios')
                    ->where("id_contratofinal", '=', $idcontrato)
                    ->where("id_publicacion", "=", $idp)
                    ->where("E_S", "=", "s")
                    ->where("id_inmueble", "=", $request->id_inmueble_update)
                    ->where("mes", "=", $mes)
                    ->where("anio", "=", $anio)
                    ->sum('precio_en_pesos');

            $pagar_a_propietario = $pagos_mensuales_s - $pagos_mensuales_e;
            $pagar_a_baquedano = $pagos_mensuales_e - $pagos_mensuales_s;

            if ($pagar_a_propietario < 0)
                $pagar_a_propietario = 0;

            if ($pagar_a_baquedano < 0)
                $pagar_a_baquedano = 0;

            $pago_mensual = PagosMensualesPropietarios::
                    where("id_contratofinal", "=", $idp)
                    ->where("id_inmueble", "=", $request->id_inmueble_update)
                    ->where("mes", "=", $mes)
                    ->where("anio", "=", $anio)
                    ->update([
                'valor_a_pagar' => $pagos_mensuales_e,
                'id_modificador' => Auth::user()->id,
                'subtotal_entrada' => $pagos_mensuales_e,
                'subtotal_salida' => $pagos_mensuales_s,
                'pago_propietario' => $pagar_a_propietario,
                'pago_rentas' => $pagar_a_baquedano
            ]);
        }
        return redirect()->route('finalContrato.edit', [$p->id_publicacion, 0, 0, 4])->with('status', 'Pago actualizado con éxito');
    }

    public function mostrar_un_pago($id) {
        $pago = PagosPropietarios::find($id);
        return response()->json($pago);
    }

    public function mostrardirecciones($id) {
        $direcciones = DB::table('adm_contratodirpropietarios as c')
                ->leftjoin('inmuebles as i', 'c.id_inmueble', '=', 'i.id')
                ->leftjoin('comunas as o', 'i.id_comuna', '=', 'o.comuna_id')
                ->leftjoin('adm_contratofinal as cf', 'c.id_contratofinal', '=', 'cf.id')
                ->where("cf.id", "=", $id)
                ->select(DB::raw('c.id, i.id as id_inmueble, CONCAT_WS(" ",i.direccion,"#",i.numero,"Depto.",i.departamento,o.comuna_nombre) as direccion, cf.alias'))
                ->get();
        return response()->json($direcciones);
    }

    public function generarpagos(Request $request, $idp) {

        $canMPagos = PagosMensualesPropietarios::where("id_contratofinal", "=", $request->id_final_pagos)
                        ->where("id_inmueble", "=", $request->id_inmueble_pago)->get();
        $canPagos = PagosPropietarios::where("id_contratofinal", "=", $request->id_final_pagos)
                        ->where("id_inmueble", "=", $request->id_inmueble_pago)->get();


        if (count($canMPagos) > 0 || count($canPagos) > 0) {
            return redirect()->route('finalContrato.edit', [$idp, 0, 0, 4])->with('error', 'Debe eliminar pagos antes de volver a crear');
        }


        $captacion = Captacion::find($idp);
        $idcontrato = $request->id_final_pagos;
        $idinmueble = $request->id_inmueble_pago;
        $idpropietario = $captacion->id_propietario;
        $cant_meses = $request->cant_meses;
        $meses_contrato = $request->cant_meses;
        $fechafirma = $request->fecha_firmapago;
        $tipomoneda = $request->moneda;
        $valormoneda = $request->valormoneda;
        $iva = $request->iva;
        $nrocuotas = $request->cuotas;
        $cobromensual = $request->cobromensual;
        $id_propuesta = $request->id_propuesta;
        $tipopropuesta = $request->tipopropuesta;

        //pagos
        $gastocomun = $request->gastocomun;
        $fecha_ini = date('Y-m-j', strtotime(date("Y", strtotime($fechafirma)) . '-' . date("m", strtotime($fechafirma)) . '-' . 1));
        $fecha_ini2 = $fechafirma;
        $dia_original = date("d", strtotime($fechafirma));
        $arriendo = $request->precio;
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

        $simula = GenerarPagoPropietario::create([
                    'meses_contrato' => $meses_contrato,
                    'id_publicacion' => $idp,
                    'id_propuesta' => $id_propuesta,
                    'id_inmueble' => $idinmueble,
                    'id_propietario' => $idpropietario,
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
                    'fecha_moneda' => Carbon::now()->format('Y/m/d'),
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
                    'gastocomun' => $gastocomun,
                    'canondearriendo' => $arriendo
// agregar ipc
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
            $pago = PagosPropietarios::create([
                        'id_contratofinal' => $idcontrato,
                        'gastocomun' => $gastocomun,
                        'E_S' => 's',
                        'id_publicacion' => $idp,
                        'id_inmueble' => $idinmueble,
                        'tipopago' => "Valor días proporcionales",
                        'idtipopago' => 8,
                        'meses_contrato' => $meses_contrato,
                        'tipopropuesta' => $tipopropuesta,
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
                        'gastocomun' => $gastocomun,
                        'canondearriendo' => $arriendo
            ]);
            $dias_mes = cal_days_in_month(CAL_GREGORIAN, date("m", strtotime($fecha_ini)), date("Y", strtotime($fecha_ini)));
            $valor_diario = $arriendo / $dias_mes;
            $dias_proporcionales = cal_days_in_month(CAL_GREGORIAN, date("m", strtotime($fechafirma)), date("Y", strtotime($fechafirma))) - date("d", strtotime($fechafirma)) + 1;
            $precio_proporcional = $dias_proporcionales * $valor_diario;
            $valor_en_pesos = $precio_proporcional * $valormoneda;
        } else {
            $dias_mes = cal_days_in_month(CAL_GREGORIAN, date("m", strtotime($fecha_ini)), date("Y", strtotime($fecha_ini)));
            $valor_diario = $arriendo / $dias_mes;
            $dias_proporcionales = cal_days_in_month(CAL_GREGORIAN, date("m", strtotime($fechafirma)), date("Y", strtotime($fechafirma))) - date("d", strtotime($fechafirma)) + 1;
            $precio_proporcional = $dias_proporcionales * $valor_diario;
            $valor_en_pesos = $precio_proporcional * $valormoneda;
            $valor_en_pesos_proporcional = $valor_en_pesos;
        }



        $ini = 0;
        if ($dias_proporcionales > 0) {
            $ini = 1;
            $dia = date("d", strtotime($fecha_ini));
            $mes = date("m", strtotime($fecha_ini));
            $anio = date("Y", strtotime($fecha_ini));
            $dias_mes = cal_days_in_month(CAL_GREGORIAN, date("m", strtotime($fecha_ini)), date("Y", strtotime($fecha_ini)));
            $fecha_ini = date("d-m-Y", strtotime("+1 month", strtotime($fecha_ini)));

            $pago = PagosPropietarios::create([
                        'id_contratofinal' => $idcontrato,
                        'id_publicacion' => $idp,
                        'id_inmueble' => $idinmueble,
                        'tipopago' => "Canon de Arriendo",
                        'idtipopago' => $idtipopago,
                        'meses_contrato' => $meses_contrato,
                        'fecha_iniciocontrato' => $fechafirma,
                        'E_S' => 's',
                        'dia' => $dia,
                        'mes' => $mes,
                        'anio' => $anio,
                        'descuento' => $descuento,
                        'tipopropuesta' => $tipopropuesta,
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
                        'gastocomun' => $gastocomun,
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
            $pago = PagosPropietarios::create([
                        'id_contratofinal' => $idcontrato,
                        'gastocomun' => $gastocomun,
                        'id_publicacion' => $idp,
                        'id_inmueble' => $idinmueble,
                        'tipopropuesta' => $tipopropuesta,
                        'E_S' => 's',
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
        $fecha_ini = date("d-m-Y", strtotime("+12 month", strtotime($fechafirma)));
        $dia = date("d", strtotime($fecha_ini));
        $mes = date("m", strtotime($fecha_ini));
        $anio = date("Y", strtotime($fecha_ini));
        $dias_mes = cal_days_in_month(CAL_GREGORIAN, date("m", strtotime($fecha_ini)), date("Y", strtotime($fecha_ini)));
        $dias_proporcionales = $dias_mes - (cal_days_in_month(CAL_GREGORIAN, date("m", strtotime($fecha_ini)), date("Y", strtotime($fecha_ini))) - date("d", strtotime($fecha_ini))) - 1;
        $precio_proporcional = $dias_proporcionales * $valor_diario;
        $valor_en_pesos = $precio_proporcional * $valormoneda;
        $pago = PagosPropietarios::create([
                    'id_contratofinal' => $idcontrato,
                    'gastocomun' => $gastocomun,
                    'id_publicacion' => $idp,
                    'id_inmueble' => $idinmueble,
                    'tipopropuesta' => $tipopropuesta,
                    'E_S' => 's',
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
                    'precio_en_pesos' => round($valor_en_pesos),
                    'id_creador' => $id_creador,
                    'id_modificador' => $id_creador,
                    'id_estado' => 1,
                    'canondearriendo' => $arriendo
        ]);

        //GASTO COMUN


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

                $pago = PagosPropietarios::create([
                            'id_contratofinal' => $idcontrato,
                            'gastocomun' => $gastocomun,
                            'id_publicacion' => $idp,
                            'id_inmueble' => $idinmueble,
                            'tipopago' => "Gasto Común",
                            'E_S' => 's',
                            'idtipopago' => $idtipopago,
                            'tipopropuesta' => $tipopropuesta,
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
                            'precio_en_pesos' => round($valor_en_pesos),
                            'id_creador' => $id_creador,
                            'id_modificador' => $id_creador,
                            'gastocomun' => $gastocomun,
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

                $pago = PagosPropietarios::create([
                            'id_contratofinal' => $idcontrato,
                            'gastocomun' => $gastocomun,
                            'id_publicacion' => $idp,
                            'id_inmueble' => $idinmueble,
                            'E_S' => 's',
                            'tipopago' => "Gasto Común",
                            'tipopropuesta' => $tipopropuesta,
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
                            'precio_en_pesos' => round($gastocomun * $valormoneda),
                            'id_creador' => $id_creador,
                            'id_modificador' => $id_creador,
                            'gastocomun' => $gastocomun,
                            'id_estado' => 1,
                            'canondearriendo' => $arriendo
                ]);
            }
            $fecha_ini = date("d-m-Y", strtotime("+12 month", strtotime($fechafirma)));
            $dia = date("d", strtotime($fecha_ini));
            $mes = date("m", strtotime($fecha_ini));
            $anio = date("Y", strtotime($fecha_ini));
            $dias_mes = cal_days_in_month(CAL_GREGORIAN, date("m", strtotime($fecha_ini)), date("Y", strtotime($fecha_ini)));
            $dias_proporcionales = $dias_mes - (cal_days_in_month(CAL_GREGORIAN, date("m", strtotime($fecha_ini)), date("Y", strtotime($fecha_ini))) - date("d", strtotime($fecha_ini))) - 1;
            $precio_proporcional = $dias_proporcionales * $valor_diario;
            $valor_en_pesos = $precio_proporcional * $valormoneda;
            $pago = PagosPropietarios::create([
                        'id_contratofinal' => $idcontrato,
                        'gastocomun' => $gastocomun,
                        'id_publicacion' => $idp,
                        'id_inmueble' => $idinmueble,
                        'tipopago' => "Gasto Común",
                        'idtipopago' => $idtipopago,
                        'tipopropuesta' => $tipopropuesta,
                        'meses_contrato' => $meses_contrato,
                        'fecha_iniciocontrato' => $fechafirma,
                        'dia' => $dia,
                        'mes' => $mes,
                        'anio' => $anio,
                        'E_S' => 's',
                        'descuento' => $descuento,
                        'cant_diasmes' => $dias_mes,
                        'cant_diasproporcional' => $dias_proporcionales,
                        'moneda' => $tipomoneda,
                        'valormoneda' => $valormoneda,
                        'valordia' => $valor_diario,
                        'precio_en_moneda' => $precio_proporcional,
                        'precio_en_pesos' => round($valor_en_pesos),
                        'id_creador' => $id_creador,
                        'id_modificador' => $id_creador,
                        'id_estado' => 1,
                        'canondearriendo' => $arriendo
            ]);
        }
        if ($tipopropuesta == 1 || $tipopropuesta == 3) {
            $fecha_ini = date('Y-m-j', strtotime(date("Y", strtotime($fechafirma)) . '-' . date("m", strtotime($fechafirma)) . '-' . 1));
            //pago 1 cuota

            $idtipopago = 3;
            $dias_mes = cal_days_in_month(CAL_GREGORIAN, date("m", strtotime($fecha_ini)), date("Y", strtotime($fecha_ini)));
            $valor_en_moneda = ($arriendo - ($arriendo * ($descuento / 100)));
            $valor_en_pesos = $valor_en_moneda * $valormoneda;
            $dia = date("d", strtotime($fecha_ini));
            $mes = date("m", strtotime($fecha_ini));
            $anio = date("Y", strtotime($fecha_ini));
            $dias_mes = cal_days_in_month(CAL_GREGORIAN, date("m", strtotime($fecha_ini)), date("Y", strtotime($fecha_ini)));
            $valor_en_pesos_con_desc = $valor_en_pesos;
            $pago = PagosPropietarios::create([
                        'id_contratofinal' => $idcontrato,
                        'gastocomun' => $gastocomun,
                        'id_publicacion' => $idp,
                        'id_inmueble' => $idinmueble,
                        'E_S' => 'e',
                        'tipopago' => "Cuota",
                        'idtipopago' => $idtipopago,
                        'tipopropuesta' => $tipopropuesta,
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
                        'precio_en_moneda' => $valor_en_moneda,
                        'precio_en_pesos' => round($valor_en_pesos),
                        'id_creador' => $id_creador,
                        'id_modificador' => $id_creador,
                        'id_estado' => 1,
                        'gastocomun' => $gastocomun,
                        'canondearriendo' => $arriendo
            ]);
            $primer_mes += $valor_en_pesos;
        }

        //pago iva
        if ($tipopropuesta == 1 || $tipopropuesta == 3) {
            $idtipopago = 4;

            $pago = PagosPropietarios::create([
                        'id_contratofinal' => $idcontrato,
                        'gastocomun' => $gastocomun,
                        'id_publicacion' => $idp,
                        'id_inmueble' => $idinmueble,
                        'E_S' => 'e',
                        'tipopago' => "Iva",
                        'idtipopago' => $idtipopago,
                        'tipopropuesta' => $tipopropuesta,
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
                        'precio_en_moneda' => $valor_en_moneda * ($iva / 100),
                        'precio_en_pesos' => $valor_en_pesos * ($iva / 100),
                        'id_creador' => $id_creador,
                        'id_modificador' => $id_creador,
                        'id_estado' => 1,
                        'gastocomun' => $gastocomun,
                        'canondearriendo' => $arriendo
            ]);
            $primer_mes += $valor_en_pesos_con_desc * ($iva / 100);
        }

        $garantias = PropietarioGarantia::where("id_publicacion", "=", $idp)->get();

        if (count($garantias) > 0) {
            foreach ($garantias as $g) {
                $mes = $g->mes;
                $anio = $g->ano;
                $dias_mes = cal_days_in_month(CAL_GREGORIAN, $mes, $anio);
                $idtipopago = 11;
                $precio_proporcional = $g->valor;
                $valor_en_pesos = $g->valor;
                $pago = PagosPropietarios::create([
                            'id_contratofinal' => $idcontrato,
                            'id_publicacion' => $idp,
                            'id_inmueble' => $idinmueble,
                            'tipopropuesta' => $tipopropuesta,
                            'tipopago' => "Garantía",
                            'idtipopago' => $idtipopago,
                            'meses_contrato' => $meses_contrato,
                            'fecha_iniciocontrato' => $fechafirma,
                            'dia' => $dia,
                            'mes' => $mes,
                            'anio' => $anio,
                            'E_S' => 's',
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
                            'gastocomun' => $gastocomun,
                            'canondearriendo' => $arriendo
                ]);
                // $primer_mes += $valor_en_pesos;
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

            $pago = PagosPropietarios::create([
                        'id_contratofinal' => $idcontrato,
                        'gastocomun' => $gastocomun,
                        'id_publicacion' => $idp,
                        'id_inmueble' => $idinmueble,
                        'tipopago' => "Notaria",
                        'E_S' => $request->no_radio,
                        'tipopropuesta' => $tipopropuesta,
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
                        'precio_en_moneda' => $valor_en_pesos / $valormoneda,
                        'precio_en_pesos' => $valor_en_pesos,
                        'id_creador' => $id_creador,
                        'id_modificador' => $id_creador,
                        'id_estado' => 1,
                        'gastocomun' => $gastocomun,
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

            $pago = PagosPropietarios::create([
                        'id_contratofinal' => $idcontrato,
                        'gastocomun' => $gastocomun,
                        'id_publicacion' => $idp,
                        'id_inmueble' => $idinmueble,
                        'tipopago' => $nombre_otropago1,
                        'idtipopago' => $idtipopago,
                        'meses_contrato' => $meses_contrato,
                        'tipopropuesta' => $tipopropuesta,
                        'fecha_iniciocontrato' => $fechafirma,
                        'dia' => $dia,
                        'mes' => $mes,
                        'anio' => $anio,
                        'E_S' => $request->o1_radio,
                        'descuento' => $descuento,
                        'cant_diasmes' => $dias_mes,
                        'cant_diasproporcional' => $dias_mes,
                        'moneda' => $tipomoneda,
                        'valormoneda' => $valormoneda,
                        'valordia' => 1,
                        'precio_en_moneda' => $valor_en_pesos / $valormoneda,
                        'precio_en_pesos' => $valor_en_pesos,
                        'id_creador' => $id_creador,
                        'id_modificador' => $id_creador,
                        'id_estado' => 1,
                        'gastocomun' => $gastocomun,
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

            $pago = PagosPropietarios::create([
                        'id_contratofinal' => $idcontrato,
                        'gastocomun' => $gastocomun,
                        'id_publicacion' => $idp,
                        'id_inmueble' => $idinmueble,
                        'tipopago' => $nombre_otropago2,
                        'idtipopago' => $idtipopago,
                        'E_S' => $request->o2_radio,
                        'meses_contrato' => $meses_contrato,
                        'tipopropuesta' => $tipopropuesta,
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
                        'precio_en_moneda' => $valor_en_pesos / $valormoneda,
                        'precio_en_pesos' => $valor_en_pesos,
                        'id_creador' => $id_creador,
                        'id_modificador' => $id_creador,
                        'id_estado' => 1,
                        'gastocomun' => $gastocomun,
                        'canondearriendo' => $arriendo
            ]);

            $primer_mes += $valor_en_pesos;
        }

        if ($tipopropuesta == 1 || $tipopropuesta == 3) {
            //Pendiente Mes Anterior
            $fecha_ini = date('Y-m-j', strtotime(date("Y", strtotime($fechafirma)) . '-' . date("m", strtotime($fechafirma)) . '-' . 1));
            $idtipopago = 15;

            $saldo_a_favor = PagosPropietarios::where("mes", '=', $mes)
                    ->where("anio", '=', $anio)
                    ->whereIn("idtipopago", [1, 2, 8, 11])
                    ->where("id_contratofinal", '=', $idcontrato)
                    ->where("id_inmueble", '=', $idinmueble)
                    ->sum('precio_en_pesos');

            $pago_a_rentas = PagosPropietarios::where("mes", '=', $mes)
                    ->where("anio", '=', $anio)
                    ->whereIn("idtipopago", [3, 4, 5, 6, 7])
                    ->where("id_contratofinal", '=', $idcontrato)
                    ->where("id_inmueble", '=', $idinmueble)
                    ->sum('precio_en_pesos');

            $pendiente = $saldo_a_favor - $pago_a_rentas;

            if ($pendiente < 0) {
                $dia = date("d", strtotime($fecha_ini));
                $mes = date("m", strtotime($fecha_ini));
                $anio = date("Y", strtotime($fecha_ini));
                $dias_mes = cal_days_in_month(CAL_GREGORIAN, date("m", strtotime($fecha_ini)), date("Y", strtotime($fecha_ini)));
                $pago = PagosPropietarios::create([
                            'id_contratofinal' => $idcontrato,
                            'gastocomun' => $gastocomun,
                            'id_publicacion' => $idp,
                            'id_inmueble' => $idinmueble,
                            'tipopago' => "Pago Pendiente",
                            'E_S' => 'e',
                            'idtipopago' => $idtipopago,
                            'meses_contrato' => $meses_contrato,
                            'tipopropuesta' => $tipopropuesta,
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
                            'gastocomun' => $gastocomun,
                            'canondearriendo' => $arriendo
                ]);
                $pendiente = $pendiente * -1;
                $fecha_ini = date("d-m-Y", strtotime("+1 month", strtotime($fecha_ini)));
                $dias_mes = cal_days_in_month(CAL_GREGORIAN, date("m", strtotime($fecha_ini)), date("Y", strtotime($fecha_ini)));
                $dia = date("d", strtotime($fecha_ini));
                $mes = date("m", strtotime($fecha_ini));
                $anio = date("Y", strtotime($fecha_ini));
                $pago = PagosPropietarios::create([
                            'id_contratofinal' => $idcontrato,
                            'gastocomun' => $gastocomun,
                            'id_publicacion' => $idp,
                            'id_inmueble' => $idinmueble,
                            'tipopago' => "Pago Pendiente",
                            'idtipopago' => $idtipopago,
                            'meses_contrato' => $meses_contrato,
                            'fecha_iniciocontrato' => $fechafirma,
                            'dia' => $dia,
                            'mes' => $mes,
                            'anio' => $anio,
                            'E_S' => 'e',
                            'descuento' => $descuento,
                            'tipopropuesta' => $tipopropuesta,
                            'cant_diasmes' => $dias_mes,
                            'cant_diasproporcional' => $dias_mes,
                            'moneda' => $tipomoneda,
                            'valormoneda' => $valormoneda,
                            'valordia' => 1,
                            'precio_en_moneda' => $pendiente / $valormoneda,
                            'precio_en_pesos' => $pendiente,
                            'id_creador' => $id_creador,
                            'id_modificador' => $id_creador,
                            'id_estado' => 1,
                            'gastocomun' => $gastocomun,
                            'canondearriendo' => $arriendo
                ]);
            }


            $fecha_ini = date('Y-m-j', strtotime(date("Y", strtotime($fechafirma)) . '-' . date("m", strtotime($fechafirma)) . '-' . 1));
            $idtipopago = 20;

            for ($i = 0; $i < $cant_meses + 1; $i++) {
                $dia = date("d", strtotime($fecha_ini));
                $mes = date("m", strtotime($fecha_ini));
                $anio = date("Y", strtotime($fecha_ini));
                $dias_mes = cal_days_in_month(CAL_GREGORIAN, date("m", strtotime($fecha_ini)), date("Y", strtotime($fecha_ini)));
                $pagomensual = PagosPropietarios::where("mes", '=', $mes)
                        ->where("anio", '=', $anio)
                        ->whereIn("idtipopago", [3, 4, 5, 6, 7, 10, 15])
                        ->where("id_contratofinal", '=', $idcontrato)
                        ->where("id_inmueble", '=', $idinmueble)
                        ->sum('precio_en_pesos');

                $pago = PagosPropietarios::create([
                            'id_contratofinal' => $idcontrato,
                            'gastocomun' => $gastocomun,
                            'id_publicacion' => $idp,
                            'id_inmueble' => $idinmueble,
                            'tipopago' => "Total Costos Propietario",
                            'E_S' => 's',
                            'idtipopago' => $idtipopago,
                            'tipopropuesta' => $tipopropuesta,
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
                            'precio_en_moneda' => $pagomensual / $valormoneda,
                            'precio_en_pesos' => $pagomensual,
                            'id_creador' => $id_creador,
                            'id_modificador' => $id_creador,
                            'id_estado' => 1,
                            'gastocomun' => $gastocomun,
                            'canondearriendo' => $arriendo
                ]);
                $fecha_ini = date("d-m-Y", strtotime("+1 month", strtotime($fecha_ini)));
            }


            $fecha_ini = date('Y-m-j', strtotime(date("Y", strtotime($fechafirma)) . '-' . date("m", strtotime($fechafirma)) . '-' . 1));
            $idtipopago = 21;


            for ($i = 0; $i < $cant_meses + 1; $i++) {
                $dia = date("d", strtotime($fecha_ini));
                $mes = date("m", strtotime($fecha_ini));
                $anio = date("Y", strtotime($fecha_ini));
                $dias_mes = cal_days_in_month(CAL_GREGORIAN, date("m", strtotime($fecha_ini)), date("Y", strtotime($fecha_ini)));
                $saldo_a_favor = PagosPropietarios::where("mes", '=', $mes)
                        ->where("anio", '=', $anio)
                        ->whereIn("idtipopago", [1, 2, 8, 11])
                        ->where("id_contratofinal", '=', $idcontrato)
                        ->where("id_inmueble", '=', $idinmueble)
                        ->sum('precio_en_pesos');

                $pago_a_rentas = PagosPropietarios::where("mes", '=', $mes)
                        ->where("anio", '=', $anio)
                        ->whereIn("idtipopago", [3, 4, 5, 6, 7, 15])
                        ->where("id_contratofinal", '=', $idcontrato)
                        ->where("id_inmueble", '=', $idinmueble)
                        ->sum('precio_en_pesos');

                $saldo_a_depositar = $saldo_a_favor - $pago_a_rentas;

                $pago = PagosPropietarios::create([
                            'id_contratofinal' => $idcontrato,
                            'gastocomun' => $gastocomun,
                            'id_publicacion' => $idp,
                            'id_inmueble' => $idinmueble,
                            'tipopago' => "Saldo a Depositar",
                            'idtipopago' => $idtipopago,
                            'tipopropuesta' => $tipopropuesta,
                            'meses_contrato' => $meses_contrato,
                            'fecha_iniciocontrato' => $fechafirma,
                            'dia' => $dia,
                            'mes' => $mes,
                            'anio' => $anio,
                            'E_S' => 's',
                            'descuento' => $descuento,
                            'cant_diasmes' => $dias_mes,
                            'cant_diasproporcional' => $dias_proporcionales,
                            'moneda' => $tipomoneda,
                            'valormoneda' => $valormoneda,
                            'valordia' => $valor_diario,
                            'precio_en_moneda' => $saldo_a_depositar / $valormoneda,
                            'precio_en_pesos' => $saldo_a_depositar,
                            'id_creador' => $id_creador,
                            'id_modificador' => $id_creador,
                            'id_estado' => 1,
                            'gastocomun' => $gastocomun,
                            'canondearriendo' => $arriendo
                ]);
                $fecha_ini = date("d-m-Y", strtotime("+1 month", strtotime($fecha_ini)));
            }
        }


        //general para pago 11 cuotas

        if ($tipopropuesta == 2 || $tipopropuesta == 4) {
            $primer_mes = 0;

            $fecha_ini = date('Y-m-j', strtotime(date("Y", strtotime($fechafirma)) . '-' . date("m", strtotime($fechafirma)) . '-' . 1));
            //pago pie

            $idtipopago = 31;
            $dias_mes = cal_days_in_month(CAL_GREGORIAN, date("m", strtotime($fecha_ini)), date("Y", strtotime($fecha_ini)));
            $valor_en_moneda = ($arriendo - ($arriendo * ($descuento / 100)));
            $pie_valor_en_moneda = $valor_en_moneda * ($pie / 100);
            $pie_valor_en_pesos = $pie_valor_en_moneda * $valormoneda;
            $pie_valor = $valor_en_pesos * ($pie / 100);
            $dia = date("d", strtotime($fecha_ini));
            $mes = date("m", strtotime($fecha_ini));
            $anio = date("Y", strtotime($fecha_ini));
            $dias_mes = cal_days_in_month(CAL_GREGORIAN, date("m", strtotime($fecha_ini)), date("Y", strtotime($fecha_ini)));
            $valor_en_pesos_con_desc = $valor_en_pesos;
            $pago = PagosPropietarios::create([
                        'id_contratofinal' => $idcontrato,
                        'gastocomun' => $gastocomun,
                        'id_publicacion' => $idp,
                        'id_inmueble' => $idinmueble,
                        'tipopago' => "Pie",
                        'E_S' => 'e',
                        'idtipopago' => $idtipopago,
                        'meses_contrato' => $meses_contrato,
                        'fecha_iniciocontrato' => $fechafirma,
                        'dia' => $dia,
                        'mes' => $mes,
                        'tipopropuesta' => $tipopropuesta,
                        'anio' => $anio,
                        'descuento' => $descuento,
                        'cant_diasmes' => $dias_mes,
                        'cant_diasproporcional' => $dias_mes,
                        'moneda' => $tipomoneda,
                        'valormoneda' => $valormoneda,
                        'valordia' => 1,
                        'precio_en_moneda' => $pie_valor_en_moneda,
                        'precio_en_pesos' => round($pie_valor_en_pesos),
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
            $valor_cuota_en_moneda = $arriendo * ($cobromensual / 100);
            $valor_cuota_en_pesos = $valor_cuota_en_moneda * $valormoneda;

            $pago = PagosPropietarios::create([
                        'id_contratofinal' => $idcontrato,
                        'gastocomun' => $gastocomun,
                        'id_publicacion' => $idp,
                        'id_inmueble' => $idinmueble,
                        'tipopago' => $nrocuotas . " Cuotas " . $cobromensual . "%",
                        'idtipopago' => $idtipopago,
                        'meses_contrato' => $meses_contrato,
                        'fecha_iniciocontrato' => $fechafirma,
                        'dia' => $dia,
                        'mes' => $mes,
                        'anio' => $anio,
                        'tipopropuesta' => $tipopropuesta,
                        'E_S' => 'e',
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
                $valor_cuota_en_moneda = $arriendo * ($cobromensual / 100);
                $valor_cuota_en_pesos = $valor_cuota_en_moneda * $valormoneda;
                $pago = PagosPropietarios::create([
                            'id_contratofinal' => $idcontrato,
                            'gastocomun' => $gastocomun,
                            'id_publicacion' => $idp,
                            'id_inmueble' => $idinmueble,
                            'tipopago' => $nrocuotas . " Cuotas " . $cobromensual . "%",
                            'idtipopago' => $idtipopago,
                            'meses_contrato' => $meses_contrato,
                            'fecha_iniciocontrato' => $fechafirma,
                            'dia' => $dia,
                            'mes' => $mes,
                            'tipopropuesta' => $tipopropuesta,
                            'anio' => $anio,
                            'E_S' => 'e',
                            'descuento' => $descuento,
                            'cant_diasmes' => $dias_mes,
                            'cant_diasproporcional' => $dias_proporcionales,
                            'moneda' => $tipomoneda,
                            'valormoneda' => $valormoneda,
                            'valordia' => $valor_diario,
                            'precio_en_moneda' => $valor_cuota_en_moneda,
                            'precio_en_pesos' => round($valor_cuota_en_pesos),
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

            $saldo_a_favor = PagosPropietarios::where("mes", '=', $mes)
                    ->where("anio", '=', $anio)
                    ->whereIn("idtipopago", [1, 2, 8])
                    ->where("id_contratofinal", '=', $idcontrato)
                    ->where("id_inmueble", '=', $idinmueble)
                    ->sum('precio_en_pesos');

            $pago_a_rentas = PagosPropietarios::where("mes", '=', $mes)
                    ->where("anio", '=', $anio)
                    ->whereIn("idtipopago", [5, 6, 7, 31, 32])
                    ->where("id_contratofinal", '=', $idcontrato)
                    ->where("id_inmueble", '=', $idinmueble)
                    ->sum('precio_en_pesos');

            $pendiente = $saldo_a_favor - $pago_a_rentas;

            if ($pendiente < 0) {
                $dia = date("d", strtotime($fecha_ini));
                $mes = date("m", strtotime($fecha_ini));
                $anio = date("Y", strtotime($fecha_ini));
                $dias_mes = cal_days_in_month(CAL_GREGORIAN, date("m", strtotime($fecha_ini)), date("Y", strtotime($fecha_ini)));
                $pago = PagosPropietarios::create([
                            'id_contratofinal' => $idcontrato,
                            'gastocomun' => $gastocomun,
                            'id_publicacion' => $idp,
                            'id_inmueble' => $idinmueble,
                            'tipopago' => "Pago Pendiente",
                            'idtipopago' => $idtipopago,
                            'meses_contrato' => $meses_contrato,
                            'fecha_iniciocontrato' => $fechafirma,
                            'dia' => $dia,
                            'E_S' => 'e',
                            'mes' => $mes,
                            'anio' => $anio,
                            'tipopropuesta' => $tipopropuesta,
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
                $pendiente = $pendiente * -1;
                $fecha_ini = date("d-m-Y", strtotime("+1 month", strtotime($fecha_ini)));
                $dias_mes = cal_days_in_month(CAL_GREGORIAN, date("m", strtotime($fecha_ini)), date("Y", strtotime($fecha_ini)));
                $dia = date("d", strtotime($fecha_ini));
                $mes = date("m", strtotime($fecha_ini));
                $anio = date("Y", strtotime($fecha_ini));
                $pago = PagosPropietarios::create([
                            'id_contratofinal' => $idcontrato,
                            'gastocomun' => $gastocomun,
                            'id_publicacion' => $idp,
                            'id_inmueble' => $idinmueble,
                            'tipopago' => "Pago Pendiente",
                            'idtipopago' => $idtipopago,
                            'meses_contrato' => $meses_contrato,
                            'fecha_iniciocontrato' => $fechafirma,
                            'dia' => $dia,
                            'mes' => $mes,
                            'anio' => $anio,
                            'tipopropuesta' => $tipopropuesta,
                            'E_S' => 'e',
                            'descuento' => $descuento,
                            'cant_diasmes' => $dias_mes,
                            'cant_diasproporcional' => $dias_mes,
                            'moneda' => $tipomoneda,
                            'valormoneda' => $valormoneda,
                            'valordia' => 1,
                            'precio_en_moneda' => $pendiente / $valormoneda,
                            'precio_en_pesos' => $pendiente,
                            'id_creador' => $id_creador,
                            'id_modificador' => $id_creador,
                            'id_estado' => 1,
                            'canondearriendo' => $arriendo
                ]);
            }



            $fecha_ini = date('Y-m-j', strtotime(date("Y", strtotime($fechafirma)) . '-' . date("m", strtotime($fechafirma)) . '-' . 1));
            $idtipopago = 34;

            for ($i = 0; $i < $cant_meses + 1; $i++) {
                $dia = date("d", strtotime($fecha_ini));
                $mes = date("m", strtotime($fecha_ini));
                $anio = date("Y", strtotime($fecha_ini));
                $dias_mes = cal_days_in_month(CAL_GREGORIAN, date("m", strtotime($fecha_ini)), date("Y", strtotime($fecha_ini)));
                $pagomensual = PagosPropietarios::where("mes", '=', $mes)
                        ->where("anio", '=', $anio)
                        ->whereIn("idtipopago", [5, 6, 7, 31, 32, 33])
                        ->where("id_contratofinal", '=', $idcontrato)
                        ->sum('precio_en_pesos');
                $pago = PagosPropietarios::create([
                            'id_contratofinal' => $idcontrato,
                            'gastocomun' => $gastocomun,
                            'id_publicacion' => $idp,
                            'id_inmueble' => $idinmueble,
                            'tipopago' => "Total Costos Propietario",
                            'E_S' => 's',
                            'idtipopago' => $idtipopago,
                            'meses_contrato' => $meses_contrato,
                            'fecha_iniciocontrato' => $fechafirma,
                            'dia' => $dia,
                            'mes' => $mes,
                            'anio' => $anio,
                            'descuento' => $descuento,
                            'tipopropuesta' => $tipopropuesta,
                            'cant_diasmes' => $dias_mes,
                            'cant_diasproporcional' => $dias_proporcionales,
                            'moneda' => $tipomoneda,
                            'valormoneda' => $valormoneda,
                            'valordia' => $valor_diario,
                            'precio_en_moneda' => $pagomensual / $valormoneda,
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

            for ($i = 0; $i < $cant_meses + 1; $i++) {
                $dia = date("d", strtotime($fecha_ini));
                $mes = date("m", strtotime($fecha_ini));
                $anio = date("Y", strtotime($fecha_ini));
                $dias_mes = cal_days_in_month(CAL_GREGORIAN, date("m", strtotime($fecha_ini)), date("Y", strtotime($fecha_ini)));
                $saldo_a_favor = PagosPropietarios::where("mes", '=', $mes)
                        ->where("anio", '=', $anio)
                        ->whereIn("idtipopago", [1, 2, 8, 11])
                        ->where("id_contratofinal", '=', $idcontrato)
                        ->where("id_inmueble", '=', $idinmueble)
                        ->sum('precio_en_pesos');

                $pago_a_rentas = PagosPropietarios::where("mes", '=', $mes)
                        ->where("anio", '=', $anio)
                        ->whereIn("idtipopago", [5, 6, 7, 31, 32, 33])
                        ->where("id_contratofinal", '=', $idcontrato)
                        ->where("id_inmueble", '=', $idinmueble)
                        ->sum('precio_en_pesos');

                $saldo_a_depositar = $saldo_a_favor - $pago_a_rentas;
                $pago = PagosPropietarios::create([
                            'id_contratofinal' => $idcontrato,
                            'gastocomun' => $gastocomun,
                            'id_publicacion' => $idp,
                            'id_inmueble' => $idinmueble,
                            'tipopago' => "Saldo a Depositar",
                            'E_S' => 's',
                            'idtipopago' => $idtipopago,
                            'meses_contrato' => $meses_contrato,
                            'fecha_iniciocontrato' => $fechafirma,
                            'dia' => $dia,
                            'mes' => $mes,
                            'anio' => $anio,
                            'descuento' => $descuento,
                            'tipopropuesta' => $tipopropuesta,
                            'cant_diasmes' => $dias_mes,
                            'cant_diasproporcional' => $dias_proporcionales,
                            'moneda' => $tipomoneda,
                            'valormoneda' => $valormoneda,
                            'valordia' => $valor_diario,
                            'precio_en_moneda' => $saldo_a_depositar / $valormoneda,
                            'precio_en_pesos' => $saldo_a_depositar,
                            'id_creador' => $id_creador,
                            'id_modificador' => $id_creador,
                            'id_estado' => 1,
                            'canondearriendo' => $arriendo
                ]);
                $fecha_ini = date("d-m-Y", strtotime("+1 month", strtotime($fecha_ini)));
            }
        }
        if ($tipopropuesta == 1 || $tipopropuesta == 3) {
            $tipos = [1, 2, 3, 4, 5, 6, 7, 8, 10, 11, 15];
        } elseif ($tipopropuesta == 2 || $tipopropuesta == 4) {
            $tipos = [1, 2, 5, 6, 7, 8, 10, 11, 31, 32, 33];
        } else {
            $tipos = [1, 2, 5, 6, 7, 8, 10, 11, 31, 32, 33];
        }


        $fecha_ini = date('Y-m-j', strtotime(date("Y", strtotime($fechafirma)) . '-' . date("m", strtotime($fechafirma)) . '-' . 1));
        for ($i = 0; $i < $meses_contrato+1; $i++) {
            $mes = date("m", strtotime($fecha_ini));
            $anio = date("Y", strtotime($fecha_ini));
            $fecha_ini = date("d-m-Y", strtotime("+1 month", strtotime($fecha_ini)));
            $pagos_mensuales_e = DB::table('adm_pagospropietarios')
                    ->where("id_publicacion", "=", $idp)
                    ->whereIn("idTipoPago", $tipos)
                    ->where("id_contratofinal", '=', $idcontrato)
                    ->where("E_S", "=", "e")
                    ->where("id_inmueble", "=", $idinmueble)
                    ->where("mes", "=", $mes)
                    ->where("anio", "=", $anio)
                    ->sum('precio_en_pesos');
            $pagos_mensuales_s = DB::table('adm_pagospropietarios')
                    ->where("id_publicacion", "=", $idp)
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
//dd($pagar_a_propietario."    ".$pagar_a_baquedano."       e:".$pagos_mensuales_e."        s:".$pagos_mensuales_s );
            $delete = PagosMensualesPropietarios::where("id_contratofinal", "=", $idcontrato)
                    ->where("id_publicacion", "=", $idp)
                    ->where("id_inmueble", "=", $idinmueble)
                    ->where("E_S", "=", 's')
                    ->where("mes", "=", $mes)
                    ->where("anio", "=", $anio)
                    ->delete();

            $pago_mensual = PagosMensualesPropietarios::create([
                        'id_contratofinal' => $idcontrato,
                        'id_publicacion' => $idp,
                        'id_inmueble' => $idinmueble,
                        'E_S' => 's',
                        'fecha_iniciocontrato' => $fechafirma,
                        'mes' => $mes,
                        'anio' => $anio,
                        'moneda' => $tipomoneda,
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
                        'id_creador' => Auth::user()->id,
                        'id_modificador' => Auth::user()->id,
                        'id_estado' => 1
            ]);
        }
        return redirect()->route('finalContrato.edit', [$idp, 0, 0, 4])->with('status', 'Pago generado con éxito');
    }

    public function destroy($id, $idpdf) {

        $borrach = PropietarioCheques::where('id_contrato', '=', $id)->delete();

        $pdf = ContratoFinalPdf::find($idpdf);
        File::delete($pdf->ruta . '/' . $pdf->nombre);
        $pdf = ContratoFinalPdf::find($idpdf)->delete();
        $contrato = ContratoFinal::find($id);
        $condir = ContratoInmueblesPropietarios::where('id_contratofinal', '=', $id)->delete();
        $borrar = ContratoFinal::find($id)->delete();

        $cant = ContratoFinal::where("id_publicacion", "=", $contrato->id_publicacion)->get();
        if (count($cant) == 0) {
            $captacion = Captacion::find($contrato->id_publicacion)->update([
                "id_estado" => 6
            ]);
        }
        return redirect()->route('finalContrato.edit', [$contrato->id_publicacion, $contrato->id_borrador, $idpdf, 1])
                        ->with('status', 'Contrato eliminado con éxito');
    }

    static function ValidaCh($idc) {
        $chequesPendientes = DB::table('propietario_cheques')
                ->WhereNull('numero')->where('id_contrato', '=', $idc)
                ->count();
        return $chequesPendientes;
    }

    public function muestra_cheque($id, $idpdf, $idpago) {

        $chPropietario = DB::table('propietario_cheques')
                ->where("id_contrato", "=", $id)
                ->get();

        return view('contratoFinal.cheque', compact('chPropietario', 'idpago', 'id', 'idpdf'));
    }

    public function act_cheque(Request $request, $id) {

        for ($i = 0; $i < count($request->banco); $i++) {
            $actCh = DB::table('propietario_cheques')
                    ->where("id_contrato", "=", $id)->where("correlativo", "=", $request->correlativo[$i])
                    ->update([
                "banco" => $request->banco[$i],
                "numero" => $request->numero[$i],
                "fecha_pago" => $request->fecha_pago[$i]
            ]);
        }

        $contrato = ContratoFinal::find($id);

        $borradorPDF = DB::table('borradores as b')
                        ->leftjoin('notarias as n', 'b.id_notaria', '=', 'n.id')
                        ->leftjoin('servicios as s', 'b.id_servicios', '=', 's.id')
                        ->leftjoin('comisiones as c', 'b.id_comisiones', '=', 'c.id')
                        ->leftjoin('flexibilidads as f', 'b.id_flexibilidad', '=', 'f.id')
                        ->leftjoin('cap_publicaciones as cp', 'b.id_publicacion', '=', 'cp.id')
                        ->leftjoin('personas as p1', 'cp.id_propietario', '=', 'p1.id')
                        ->leftjoin('comunas as c1', 'p1.id_comuna', '=', 'c1.comuna_id')
                        ->leftjoin('inmuebles as i', 'cp.id_inmueble', '=', 'i.id')
                        ->leftjoin('comunas as c2', 'i.id_comuna', '=', 'c2.comuna_id')
                        ->leftjoin('regions as reg', 'p1.id_region', '=', 'reg.region_id')
                        ->leftjoin('contratos as con', 'b.id_contrato', '=', 'con.id')
                        ->where('b.id', '=', $contrato->id_borrador)
                        ->select(DB::raw(' b.id as id, n.razonsocial as n_n, s.nombre as n_s, c.nombre as n_c, f.nombre as n_f , cp.id as id_publicacion,DATE_FORMAT(b.fecha_gestion, "%d/%m/%Y") as fecha,
                     CONCAT_WS(" ",p1.nombre,p1.apellido_paterno,p1.apellido_materno) as propietario,
                     p1.rut as rut_p, CONCAT(p1.direccion," ", p1.numero) as direccion_p , c1.comuna_nombre as comuna_p, reg.region_nombre as region_p,
                     CONCAT(i.direccion," ",i.numero) as direccion_i, i.departamento as depto_i, c2.comuna_nombre as comuna_i,
                     i.dormitorio as dormitorio, i.bano as bano, i.bodega, i.piscina, i.precio, i.gastosComunes, 
                     con.nombre, con.nombre as contrato, con.descripcion as deta_contrato,
                     p1.profesion as profesion_p, p1.telefono as telefono_p, p1.departamento as depto_p,
                     i.rol as rol, b.detalle_revision as bodyContrato, CONCAT(c.descripcion, " ", c.comision, " %") as comision,f.descripcion as Flexibilidad, CONCAT(s.descripcion, "  $",s.valor) as Servicio'))->first();


        $simulacion = DB::table('propietario_cheques as b')
                ->where('b.id_contrato', '=', $contrato->id)
                ->get();



        $pdfnombre = DB::table('adm_contratofinalpdf')
                        ->where('id_final', '=', $contrato->id)->first();

        $pdf = new PdfController();
        $numero = rand();
        $pdf->crontratoFinalPdfAct($borradorPDF, $pdfnombre->nombre, $simulacion);
        // FIN PARA PDFsss

        return redirect()->route('finalContrato.edit', [$contrato->id_publicacion, $contrato->id_borrador, $request->idpdf, 1])
                        ->with('status', 'Contrato eliminado con éxito');
    }

}
