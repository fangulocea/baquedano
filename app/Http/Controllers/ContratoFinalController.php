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
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\File;
use Auth;

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

    public function getPagos($id,$idi) {
        $contrato = DB::table('adm_pagospropietarios')
                ->where('id_contratofinal', '=', $id)
                ->where('id_inmueble', '=', $idi)
                 ->orderBy('id', 'asc')
                ->get();
        return response()->json($contrato);
    }

    public function getpagosmensuales($id,$idi) {
        $contrato = DB::table('adm_pagosmensualespropietarios as c')
                ->leftjoin('adm_contratofinal as cp', 'c.id_contratofinal', '=', 'cp.id')
                ->where('c.id_contratofinal', '=', $id)
                ->where('c.id_inmueble', '=', $idi)
                ->select(DB::raw(' c.id, c.E_S, c.fecha_iniciocontrato, c.mes, c.anio, c.valor_a_pagar, cp.meses_contrato,c.subtotal_entrada, c.subtotal_salida, c.pago_propietario, c.pago_rentas, c.id_estado'))
                ->orderBy('c.id', 'asc')
                ->get();
        return response()->json($contrato);
    }

    public function crearContrato($idcb, $idpdf, $idu) {


        $ContratoBorrador = ContratoBorrador::find($idcb);
        $captacion = Captacion::find($ContratoBorrador->id_publicacion)->update([
            "id_estado" => 10
        ]);
        $contratoFinal = ContratoFinal::create([
                    "id_publicacion" => $ContratoBorrador->id_publicacion,
                    "id_estado" => 1,
                    "id_creador" => $idu,
                    "id_borrador" => $idcb,
                    "id_borradorpdf" => $idpdf
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
                        ->where('b.id', '=', $idcb)
                        ->select(DB::raw(' b.id as id, n.razonsocial as n_n, s.nombre as n_s, c.nombre as n_c, f.nombre as n_f , cp.id as id_publicacion,DATE_FORMAT(b.fecha_gestion, "%d/%m/%Y") as fecha,
             CONCAT_WS(" ",p1.nombre,p1.apellido_paterno,p1.apellido_materno) as propietario,
             p1.rut as rut_p, CONCAT(p1.direccion," ", p1.numero) as direccion_p , c1.comuna_nombre as comuna_p, reg.region_nombre as region_p,
             CONCAT(i.direccion," ",i.numero) as direccion_i, i.departamento as depto_i, c2.comuna_nombre as comuna_i,
             i.dormitorio as dormitorio, i.bano as bano, i.bodega, i.piscina, i.precio, i.gastosComunes, 
             con.nombre, con.nombre as contrato, con.descripcion as deta_contrato,
             p1.profesion as profesion_p, p1.telefono as telefono_p, p1.departamento as depto_p,
             i.rol as rol, b.detalle_revision as bodyContrato, CONCAT(c.descripcion, " ", c.comision, " %") as comision,f.descripcion as Flexibilidad, CONCAT(s.descripcion, "  $",s.valor) as Servicio'))->first();
        $pdf = new PdfController();
        $numero = rand();
        $pdf->crontratoFinalPdf($borradorPDF, $numero);
        // FIN PARA PDFsss

        $finalpdf = ContratoFinalPdf::create([
                    "id_final" => $contratoFinal->id,
                    "nombre" => $numero . $borradorPDF->id . $borradorPDF->direccion_i . '-FINAL.pdf',
                    "ruta" => "uploads/pdf_final/",
                    "id_creador" => $idu,
                ])->toArray();
        return redirect()->route('finalContrato.edit', [$ContratoBorrador->id_publicacion, $idcb, $idpdf, 1])
                        ->with('status', 'Contrato Final guardado con éxito');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $meses=DB::table('cap_publicaciones as c')->select(DB::raw('CONCAT(MONTH(DATE_ADD(now(), INTERVAL -6 MONTH)),"/",YEAR(DATE_ADD(now(), INTERVAL -6 MONTH))) as mesanterior6,
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
                    CONCAT(MONTH(DATE_ADD(now(), INTERVAL +6 MONTH)),"/",YEAR(DATE_ADD(now(), INTERVAL +6 MONTH))) as messiguiente6'))->first();
        $publica = DB::table('adm_contratofinal as co')
                ->leftjoin('borradores as cb','co.id_borrador','=','cb.id')
                ->leftjoin('adm_contratodirpropietarios as cd', 'cd.id_publicacion', '=', 'co.id_publicacion')
                ->leftjoin('inmuebles as i', 'cd.id_inmueble', '=', 'i.id')
                ->leftjoin('comunas as o', 'i.id_comuna', '=', 'o.comuna_id')
                ->leftjoin('cap_publicaciones as c', 'c.id', '=', 'co.id_publicacion')
                ->leftjoin('personas as p1', 'c.id_propietario', '=', 'p1.id')
                ->leftjoin('users as p2', 'c.id_creador', '=', 'p2.id')
                ->leftjoin('personas as p3', 'c.id_modificador', '=', 'p3.id')
                ->where('c.id_estado', '=', "7")
                ->Orwhere('c.id_estado', '=', "10")
                ->select(DB::raw('cb.dia_pago,c.id as id_publicacion, DATE_FORMAT(c.created_at, "%d/%m/%Y") as fecha_creacion, c.id_estado as id_estado, CONCAT_WS(" ",p1.nombre,p1.apellido_paterno,p1.apellido_materno) as Propietario, p2.name as Creador,

                  (select pago_propietario from adm_pagosmensualespropietarios where mes=MONTH(DATE_ADD(now(), INTERVAL -6 MONTH)) and anio=YEAR(DATE_ADD(now(), INTERVAL -6 MONTH)) and id_publicacion=c.id and id_inmueble=i.id ) as valoranterior6,

                    (select sum(valor_pagado) from adm_detallepagospropietarios dt inner join adm_pagosmensualespropietarios pm on dt.id_pagomensual=pm.id where pm.mes=MONTH(DATE_ADD(now(), INTERVAL -6 MONTH)) and pm.anio=YEAR(DATE_ADD(now(), INTERVAL -6 MONTH)) and pm.id_publicacion=c.id and pm.id_inmueble=i.id ) as valorpagadoanterior6,

                  (select pago_propietario from adm_pagosmensualespropietarios where mes=MONTH(DATE_ADD(now(), INTERVAL -5 MONTH)) and anio=YEAR(DATE_ADD(now(), INTERVAL -5 MONTH)) and id_publicacion=c.id and id_inmueble=i.id ) as valoranterior5,

                    (select sum(valor_pagado) from adm_detallepagospropietarios dt inner join adm_pagosmensualespropietarios pm on dt.id_pagomensual=pm.id where pm.mes=MONTH(DATE_ADD(now(), INTERVAL -5 MONTH)) and pm.anio=YEAR(DATE_ADD(now(), INTERVAL -5 MONTH)) and pm.id_publicacion=c.id and pm.id_inmueble=i.id ) as valorpagadoanterior5,

                  (select pago_propietario from adm_pagosmensualespropietarios where mes=MONTH(DATE_ADD(now(), INTERVAL -4 MONTH)) and anio=YEAR(DATE_ADD(now(), INTERVAL -4 MONTH)) and id_publicacion=c.id and id_inmueble=i.id ) as valoranterior4,

                    (select sum(valor_pagado) from adm_detallepagospropietarios dt inner join adm_pagosmensualespropietarios pm on dt.id_pagomensual=pm.id where pm.mes=MONTH(DATE_ADD(now(), INTERVAL -4 MONTH)) and pm.anio=YEAR(DATE_ADD(now(), INTERVAL -4 MONTH)) and pm.id_publicacion=c.id and pm.id_inmueble=i.id ) as valorpagadoanterior4,

                  (select pago_propietario from adm_pagosmensualespropietarios where mes=MONTH(DATE_ADD(now(), INTERVAL -3 MONTH)) and anio=YEAR(DATE_ADD(now(), INTERVAL -3 MONTH)) and id_publicacion=c.id and id_inmueble=i.id ) as valoranterior3,

                    (select sum(valor_pagado) from adm_detallepagospropietarios dt inner join adm_pagosmensualespropietarios pm on dt.id_pagomensual=pm.id where pm.mes=MONTH(DATE_ADD(now(), INTERVAL -3 MONTH)) and pm.anio=YEAR(DATE_ADD(now(), INTERVAL -3 MONTH)) and pm.id_publicacion=c.id and pm.id_inmueble=i.id ) as valorpagadoanterior3,

                  (select pago_propietario from adm_pagosmensualespropietarios where mes=MONTH(DATE_ADD(now(), INTERVAL -2 MONTH)) and anio=YEAR(DATE_ADD(now(), INTERVAL -2 MONTH)) and id_publicacion=c.id and id_inmueble=i.id ) as valoranterior2,

                    (select sum(valor_pagado) from adm_detallepagospropietarios dt inner join adm_pagosmensualespropietarios pm on dt.id_pagomensual=pm.id where pm.mes=MONTH(DATE_ADD(now(), INTERVAL -2 MONTH)) and pm.anio=YEAR(DATE_ADD(now(), INTERVAL -2 MONTH)) and pm.id_publicacion=c.id and pm.id_inmueble=i.id ) as valorpagadoanterior2,


                  (select pago_propietario from adm_pagosmensualespropietarios where mes=MONTH(DATE_ADD(now(), INTERVAL -1 MONTH)) and anio=YEAR(DATE_ADD(now(), INTERVAL -1 MONTH)) and id_publicacion=c.id and id_inmueble=i.id ) as valoranterior1,

                    (select sum(valor_pagado) from adm_detallepagospropietarios dt inner join adm_pagosmensualespropietarios pm on dt.id_pagomensual=pm.id where pm.mes=MONTH(DATE_ADD(now(), INTERVAL -1 MONTH)) and pm.anio=YEAR(DATE_ADD(now(), INTERVAL -1 MONTH)) and pm.id_publicacion=c.id and pm.id_inmueble=i.id ) as valorpagadoanterior1,

                    
                    (select pago_propietario from adm_pagosmensualespropietarios where mes=MONTH(now()) and anio=YEAR(now()) and id_publicacion=c.id and id_inmueble=i.id ) as valoractual,

                    (select sum(valor_pagado) from adm_detallepagospropietarios dt inner join adm_pagosmensualespropietarios pm on dt.id_pagomensual=pm.id where pm.mes=MONTH(now()) and pm.anio=YEAR(now()) and pm.id_publicacion=c.id and pm.id_inmueble=i.id ) as valorpagadoactual,


                      (select pago_propietario from adm_pagosmensualespropietarios where mes=MONTH(DATE_ADD(now(), INTERVAL 1 MONTH)) and anio=YEAR(DATE_ADD(now(), INTERVAL 1 MONTH)) and id_publicacion=c.id and id_inmueble=i.id ) as valorsiguiente1,

                    (select sum(valor_pagado) from adm_detallepagospropietarios dt inner join adm_pagosmensualespropietarios pm on dt.id_pagomensual=pm.id where pm.mes=MONTH(DATE_ADD(now(), INTERVAL 1 MONTH)) and pm.anio=YEAR(DATE_ADD(now(), INTERVAL 1 MONTH)) and pm.id_publicacion=c.id and pm.id_inmueble=i.id ) as valorpagadosiguiente1,

                                       (select pago_propietario from adm_pagosmensualespropietarios where mes=MONTH(DATE_ADD(now(), INTERVAL 2 MONTH)) and anio=YEAR(DATE_ADD(now(), INTERVAL 2 MONTH)) and id_publicacion=c.id and id_inmueble=i.id ) as valorsiguiente2,

                    (select sum(valor_pagado) from adm_detallepagospropietarios dt inner join adm_pagosmensualespropietarios pm on dt.id_pagomensual=pm.id where pm.mes=MONTH(DATE_ADD(now(), INTERVAL 2 MONTH)) and pm.anio=YEAR(DATE_ADD(now(), INTERVAL 2 MONTH)) and pm.id_publicacion=c.id and pm.id_inmueble=i.id ) as valorpagadosiguiente2,

                                       (select pago_propietario from adm_pagosmensualespropietarios where mes=MONTH(DATE_ADD(now(), INTERVAL 3 MONTH)) and anio=YEAR(DATE_ADD(now(), INTERVAL 3 MONTH)) and id_publicacion=c.id and id_inmueble=i.id ) as valorsiguiente3,

                    (select sum(valor_pagado) from adm_detallepagospropietarios dt inner join adm_pagosmensualespropietarios pm on dt.id_pagomensual=pm.id where pm.mes=MONTH(DATE_ADD(now(), INTERVAL 3 MONTH)) and pm.anio=YEAR(DATE_ADD(now(), INTERVAL 3 MONTH)) and pm.id_publicacion=c.id and pm.id_inmueble=i.id ) as valorpagadosiguiente3,

                                       (select pago_propietario from adm_pagosmensualespropietarios where mes=MONTH(DATE_ADD(now(), INTERVAL 4 MONTH)) and anio=YEAR(DATE_ADD(now(), INTERVAL 4 MONTH)) and id_publicacion=c.id and id_inmueble=i.id ) as valorsiguiente4,

                    (select sum(valor_pagado) from adm_detallepagospropietarios dt inner join adm_pagosmensualespropietarios pm on dt.id_pagomensual=pm.id where pm.mes=MONTH(DATE_ADD(now(), INTERVAL 4 MONTH)) and pm.anio=YEAR(DATE_ADD(now(), INTERVAL 4 MONTH)) and pm.id_publicacion=c.id and pm.id_inmueble=i.id ) as valorpagadosiguiente4,

                                       (select pago_propietario from adm_pagosmensualespropietarios where mes=MONTH(DATE_ADD(now(), INTERVAL 5 MONTH)) and anio=YEAR(DATE_ADD(now(), INTERVAL 5 MONTH)) and id_publicacion=c.id and id_inmueble=i.id ) as valorsiguiente5,

                    (select sum(valor_pagado) from adm_detallepagospropietarios dt inner join adm_pagosmensualespropietarios pm on dt.id_pagomensual=pm.id where pm.mes=MONTH(DATE_ADD(now(), INTERVAL 5 MONTH)) and pm.anio=YEAR(DATE_ADD(now(), INTERVAL 5 MONTH)) and pm.id_publicacion=c.id and pm.id_inmueble=i.id ) as valorpagadosiguiente5,

                                       (select pago_propietario from adm_pagosmensualespropietarios where mes=MONTH(DATE_ADD(now(), INTERVAL 6 MONTH)) and anio=YEAR(DATE_ADD(now(), INTERVAL 6 MONTH)) and id_publicacion=c.id and id_inmueble=i.id ) as valorsiguiente6,

                    (select sum(valor_pagado) from adm_detallepagospropietarios dt inner join adm_pagosmensualespropietarios pm on dt.id_pagomensual=pm.id where pm.mes=MONTH(DATE_ADD(now(), INTERVAL 6 MONTH)) and pm.anio=YEAR(DATE_ADD(now(), INTERVAL 6 MONTH)) and pm.id_publicacion=c.id and pm.id_inmueble=i.id ) as valorpagadosiguiente6

                    '), 'p1.id as id_propietario', 'i.id as id_inmueble', 'i.direccion', 'i.numero', 'i.departamento', 'o.comuna_nombre', 'p1.nombre as nom_p', 'p1.apellido_paterno as apep_p', 'p1.apellido_materno as apem_p', 'p3.nombre as nom_m', 'p3.apellido_paterno as apep_m', 'p3.apellido_materno as apem_m')
                ->get();

        return view('contratoFinal.index', compact('publica','meses'));
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
                ->leftjoin('personas as p2', 'c.id_creador', '=', 'p2.id')
                ->leftjoin('personas as p3', 'c.id_modificador', '=', 'p3.id')
                ->leftjoin('comunas as o', 'i.id_comuna', '=', 'o.comuna_id')
                ->leftjoin('portales as po', 'c.portal', '=', 'po.id')
                ->where('c.id', '=', $idc)
                ->select(DB::raw('c.id as id_publicacion, p1.id as id_propietario, i.id as id_inmueble, CONCAT_WS(" ",i.direccion,"#",i.numero,"Depto.",i.departamento,o.comuna_nombre) as direccion, CONCAT_WS(" ",p1.nombre , p1.apellido_paterno, " Fono: " ,p1.telefono, " Email: " ,p1.email ) as propietario, i.precio, i.gastosComunes'))
                ->first();

        $finalIndex = DB::table('adm_contratofinal  as b')
                ->leftjoin('cap_publicaciones as cp', 'b.id_publicacion', '=', 'cp.id')
                ->leftjoin('adm_contratofinalpdf as bp', 'b.id', '=', 'bp.id_final')
                ->where('b.id_publicacion', '=', $idc)
                ->select(DB::raw(' b.id ,b.id_borrador, cp.id as id_publicacion,b.fecha_firma as fecha,b.id_estado,bp.nombre, bp.id as id_pdf,b.id_notaria,b.alias'))
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


        $flag = 0;

        return view('contratoFinal.edit', compact('borrador', 'finalIndex', 'notaria', 'documentos', 'flag', 'tab','direcciones'));
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
            "id_inmueble"=> $captacion->id_inmueble,
            "id_creador"=> Auth::user()->id
        ]);

        return redirect()->route('finalContrato.edit', [$request->id_publicacion, $request->id_borrador, $request->id_pdf, 1])
                        ->with('status', 'Contrato actualizado con éxito');
    }


    public function asignarinmueble($idc,$idi,$idp) {

 $cont_inmueble = ContratoInmueblesPropietarios::where("id_inmueble","=",$idi)
 ->where("id_contratofinal","=",$idc)
 ->where("id_publicacion","=",$idp)
 ->get();
 if(count($cont_inmueble)>0){
    return redirect()->route('finalContrato.edit', [$idp, 0, 0, 6])
                        ->with('error', 'Inmueble ya se encuentra asignado a contrato');
 }

        $cont_inmueble = ContratoInmueblesPropietarios::create([
            "id_publicacion" => $idp,
            "id_contratofinal" => $idc,
            "id_inmueble"=> $idi,
            "id_creador"=> Auth::user()->id
        ]);

        return redirect()->route('finalContrato.edit', [$idp, 0, 0, 6])
                        ->with('status', 'Contrato actualizado con éxito');
    }
    public function destroy($id, $idpdf) {
        $pdf = ContratoFinalPdf::find($idpdf);
        File::delete($pdf->ruta . '/' . $pdf->nombre);
        $pdf = ContratoFinalPdf::find($idpdf)->delete();
        $contrato = ContratoFinal::find($id);
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

    public function eliminartipopago($idc, $idt) {
        $p1 = PagosPropietarios::where("id_contratofinal", "=", $idc)
                ->first();
        $idinmueble=$p1->id_inmueble;
        $PagosPropietarios = PagosPropietarios::where("id_contratofinal", "=", $idc)
                ->where("idtipopago", "=", $idt)
                ->delete();
        $p = PagosPropietarios::where("id_contratofinal", "=", $idc)
                ->first();
        if (isset($p)) {
            $fecha_ini = date('Y-m-j', strtotime(date("Y", strtotime($p->fecha_iniciocontrato)) . '-' . date("m", strtotime($p->fecha_iniciocontrato)) . '-' . 1));
            for ($i = 0; $i < $p->meses_contrato; $i++) {
                $mes = date("m", strtotime($fecha_ini));
                $anio = date("Y", strtotime($fecha_ini));
                $fecha_ini = date("d-m-Y", strtotime("+1 month", strtotime($fecha_ini)));
                $pagos_mensuales_e = PagosPropietarios::where("id_contratofinal", "=", $idc)
                        ->where("E_S", "=", "e")
                        ->where("mes", "=", $mes)
                        ->where("id_inmueble", "=", $idinmueble)
                        ->where("anio", "=", $anio)
                        ->sum('precio_en_pesos');
                $pagos_mensuales_s = PagosPropietarios::where("id_contratofinal", "=", $idc)
                        ->where("E_S", "=", "s")
                        ->where("mes", "=", $mes)
                        ->where("id_inmueble", "=", $idinmueble)
                        ->where("anio", "=", $anio)
                        ->sum('precio_en_pesos');

            $pagar_a_propietario=$pagos_mensuales_s-$pagos_mensuales_e;
            $pagar_a_baquedano=$pagos_mensuales_e-$pagos_mensuales_s;

            if($pagar_a_propietario<0)
                $pagar_a_propietario=0;

            if($pagar_a_baquedano<0)
                $pagar_a_baquedano=0;

            $pago_mensual = PagosMensualesPropietarios::
                    where("id_contratofinal", "=", $idc)
                    ->where("id_inmueble", "=", $idinmueble)
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
        }else{
            $pago_mensual = PagosMensualesPropietarios::where("id_contratofinal", "=", $idc)->delete();
        }
        return redirect()->route('finalContrato.edit', [$p1->id_publicacion, 0, 0, 4])->with('status', 'Tipo Pago eliminado con éxito');
    }

    public function updatepago(Request $request) {

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
                    ->where("E_S", "=", "e")
                    ->where("id_inmueble", "=", $request->id_inmueble_update)
                    ->where("mes", "=", $mes)
                    ->where("anio", "=", $anio)
                    ->sum('precio_en_pesos');
            $pagos_mensuales_s = DB::table('adm_pagospropietarios')
                    ->where("id_publicacion", "=", $idp)
                    ->where("E_S", "=", "s")
                    ->where("id_inmueble", "=", $request->id_inmueble_update)
                    ->where("mes", "=", $mes)
                    ->where("anio", "=", $anio)
                    ->sum('precio_en_pesos');

            $pagar_a_propietario=$pagos_mensuales_s-$pagos_mensuales_e;
            $pagar_a_baquedano=$pagos_mensuales_e-$pagos_mensuales_s;

            if($pagar_a_propietario<0)
                $pagar_a_propietario=0;

            if($pagar_a_baquedano<0)
                $pagar_a_baquedano=0;
//dd($pagar_a_propietario."    ".$pagar_a_baquedano."       e:".$pagos_mensuales_e."        s:".$pagos_mensuales_s ."     ".$request->id_inmueble_update);
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

        //general
        $idcontrato = $request->id_final_pagos;

        $contrato = ContratoFinal::where('id', '=', $idcontrato)->update([
            "meses_contrato" => $request->cant_meses
        ]);

        $idinmueble = $request->id_inmueble_pago;
        $cant_meses = $request->cant_meses;
        $meses_contrato = $request->cant_meses;
        $fechafirma = $request->fecha_firmapago;
        $tipomoneda = $request->moneda;
        $valormoneda = $request->valormoneda;
        //$fecha_ini=$fechafirma;
        //pagos
        $gastocomun = $request->gastocomun;
        $fecha_ini = date('Y-m-j', strtotime(date("Y", strtotime($fechafirma)) . '-' . date("m", strtotime($fechafirma)) . '-' . 1));
        $fecha_ini2 = $fechafirma;
        $dia_original = date("d", strtotime($fechafirma));
        $arriendo = $request->precio;
        $comision = $request->comision;
        $mes_comision = $request->mes_comision;
        $porcentaje = $request->porcentaje;
        $mes_porcentaje = $request->mes_porcentaje;
        $pagonotaria = $request->pagonotaria;
        $nombre_otropago1 = $request->nombre_otropago1;
        $nombre_otropago2 = $request->nombre_otropago2;
        $nombre_otropago3 = $request->nombre_otropago3;
        $pagootro1 = $request->pagootro1;
        $pagootro2 = $request->pagootro2;
        $pagootro3 = $request->pagootro3;
        $mes_otro1 = $request->mes_otro1;
        $mes_otro2 = $request->mes_otro2;
        $mes_otro3 = $request->mes_otro3;
        $garantia = $request->garantia;
        $pie = $request->pie;
        $iva = $request->iva;
        if (isset($request->mes_iva)) {
            $mes_iva = $request->mes_iva;
        } else {
            $mes_iva = 1;
        }
        if (isset($request->mes_otro1)) {
            $mes_otro1 = $request->mes_otro1;
        } else {
            $mes_otro1 = 1;
        }
        if (isset($request->mes_otro2)) {
            $mes_otro2 = $request->mes_otro2;
        } else {
            $mes_otro2 = 1;
        }
        if (isset($request->mes_otro3)) {
            $mes_otro3 = $request->mes_otro3;
        } else {
            $mes_otro3 = 1;
        }
        $id_creador = $request->id_creador;
        $now = new \DateTime();
        $fecha_creacion = $now->format('Y-m-d H:i:s');

        $gastos_comunes_reg = PagosPropietarios::where("id_publicacion", "=", $idp)
        ->where("idtipopago", "=", 1)
        ->where("id_inmueble", "=", $idinmueble)
        ->get();
        $arriendo_reg = PagosPropietarios::where("id_publicacion", "=", $idp)->where("idtipopago", "=", 2)       
        ->where("id_inmueble", "=", $idinmueble)
        ->get();
        $garantia_reg = PagosPropietarios::where("id_publicacion", "=", $idp)->where("idtipopago", "=", 3)        
        ->where("id_inmueble", "=", $idinmueble)
        ->get();
        $iva_reg = PagosPropietarios::where("id_publicacion", "=", $idp)->where("idtipopago", "=", 4)
        ->where("id_inmueble", "=", $idinmueble)
        ->get();
        $pie_reg = PagosPropietarios::where("id_publicacion", "=", $idp)->where("idtipopago", "=", 5)
        ->where("id_inmueble", "=", $idinmueble)
        ->get();
        $porcentaje_reg = PagosPropietarios::where("id_publicacion", "=", $idp)->where("idtipopago", "=", 6)
        ->where("id_inmueble", "=", $idinmueble)
        ->get();
        $comision_reg = PagosPropietarios::where("id_publicacion", "=", $idp)->where("idtipopago", "=", 7)
        ->where("id_inmueble", "=", $idinmueble)
        ->get();
        $notaria_reg = PagosPropietarios::where("id_publicacion", "=", $idp)->where("idtipopago", "=", 8)
        ->where("id_inmueble", "=", $idinmueble)
        ->get();
        $otro1_reg = PagosPropietarios::where("id_publicacion", "=", $idp)->where("idtipopago", "=", 9)
        ->where("id_inmueble", "=", $idinmueble)
        ->get();
        $otro2_reg = PagosPropietarios::where("id_publicacion", "=", $idp)->where("idtipopago", "=", 10)
        ->where("id_inmueble", "=", $idinmueble)
        ->get();
        $otro3_reg = PagosPropietarios::where("id_publicacion", "=", $idp)->where("idtipopago", "=", 11)
        ->where("id_inmueble", "=", $idinmueble)
        ->get();

        //gasto comun

        $texto=", Pero No se han generado los siguientes items, ya que se encuentran ingresados en el sistema : ";
        if(count($gastos_comunes_reg)>0){
            $texto.=" Gasto Común, ";
        }
        if(count($arriendo_reg)>0){
             $texto.=" Canon de Arriendo, ";
        }
        if(count($garantia_reg)>0){
                 $texto.=" Garantía, ";
        }
        if(count($iva_reg)>0){
             $texto.=" Iva, ";
        }
        if(count($pie_reg)>0){
             $texto.=" Pie, ";
        }
        if(count($porcentaje_reg)>0){
             $texto.=" Porcentaje, ";
        }
        if(count($comision_reg)>0){
             $texto.=" Comisión, ";
        }
        if(count($notaria_reg)>0){
             $texto.=" Notaria, ";
        }
        if(count($otro1_reg)>0){
             $texto.=" Pago Personalizado 1, ";
        }
        if(count($otro2_reg)>0){
             $texto.=" Pago Personalizado 2, ";
        }
        if(count($otro3_reg)>0){
             $texto.=" Pago Personalizado 3 ";
        }

        if (isset($gastocomun) && count($gastos_comunes_reg) == 0) {
            $idtipopago = 1;
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

                $pago = PagosPropietarios::create([
                            'id_contratofinal' => $idcontrato,
                            'meses_contrato' => $meses_contrato,
                            'id_publicacion' => $idp,
                            'id_inmueble' => $idinmueble,
                            'tipopago' => "Gasto Común",
                            'idtipopago' => $idtipopago,
                            'fecha_iniciocontrato' => $fechafirma,
                            'E_S' => $request->gc_radio,
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
                            'gastocomun' => $gastocomun,
                            'canondearriendo' => $gastocomun
                ]);
            }
            for ($i = $ini; $i < $cant_meses; $i++) {
                $dia = date("d", strtotime($fecha_ini));
                $mes = date("m", strtotime($fecha_ini));
                $anio = date("Y", strtotime($fecha_ini));
                $dias_mes = cal_days_in_month(CAL_GREGORIAN, date("m", strtotime($fecha_ini)), date("Y", strtotime($fecha_ini)));
                $fecha_ini = date("d-m-Y", strtotime("+1 month", strtotime($fecha_ini)));

                $pago = PagosPropietarios::create([
                            'id_contratofinal' => $idcontrato,
                            'meses_contrato' => $meses_contrato,
                            'id_publicacion' => $idp,
                            'tipopago' => "Gasto Común",
                            'idtipopago' => $idtipopago,
                            'id_inmueble' => $idinmueble,
                            'E_S' => $request->gc_radio,
                            'fecha_iniciocontrato' => $fechafirma,
                            'dia' => $dia,
                            'mes' => $mes,
                            'anio' => $anio,
                            'cant_diasmes' => $dias_mes,
                            'cant_diasproporcional' => $dias_mes,
                            'moneda' => $tipomoneda,
                            'valormoneda' => $valormoneda,
                            'valordia' => $valor_diario,
                            'precio_en_moneda' => $gastocomun,
                            'precio_en_pesos' => ceil($gastocomun * $valormoneda),
                            'id_creador' => $id_creador,
                            'id_modificador' => $id_creador,
                            'id_estado' => 1,
                            'gastocomun' => $gastocomun,
                            'canondearriendo' => $arriendo
                ]);
            }
        }

        $fecha_ini = date('Y-m-j', strtotime(date("Y", strtotime($fechafirma)) . '-' . date("m", strtotime($fechafirma)) . '-' . 1));
        //arriendo
        if (isset($arriendo) && count($arriendo_reg) == 0) {
            $idtipopago = 2;
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

                $pago = PagosPropietarios::create([
                            'id_contratofinal' => $idcontrato,
                            'meses_contrato' => $meses_contrato,
                            'id_publicacion' => $idp,
                            'id_inmueble' => $idinmueble,
                            'tipopago' => "Canon de Arriendo",
                            'idtipopago' => $idtipopago,
                            'E_S' => $request->ca_radio,
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
                            'gastocomun' => $gastocomun,
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
                $pago = PagosPropietarios::create([
                            'id_contratofinal' => $idcontrato,
                            'meses_contrato' => $meses_contrato,
                            'id_publicacion' => $idp,
                            'id_inmueble' => $idinmueble,
                            'tipopago' => "Canon de Arriendo",
                            'E_S' => $request->ca_radio,
                            'idtipopago' => $idtipopago,
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
                            'gastocomun' => $gastocomun,
                            'canondearriendo' => $arriendo
                ]);
            }
        }

        $fecha_ini = date('Y-m-j', strtotime(date("Y", strtotime($fechafirma)) . '-' . date("m", strtotime($fechafirma)) . '-' . 1));
        //garantia

        if (isset($garantia) && count($garantia_reg) == 0) {
            $idtipopago = 3;
            $dias_mes = cal_days_in_month(CAL_GREGORIAN, date("m", strtotime($fecha_ini)), date("Y", strtotime($fecha_ini)));
            $precio_proporcional = $garantia;
            $valor_en_pesos = $garantia;
            $ini = 1;
            $dia = date("d", strtotime($fecha_ini));
            $mes = date("m", strtotime($fecha_ini));
            $anio = date("Y", strtotime($fecha_ini));
            $dias_mes = cal_days_in_month(CAL_GREGORIAN, date("m", strtotime($fecha_ini)), date("Y", strtotime($fecha_ini)));
            $fecha_ini = date("d-m-Y", strtotime("+1 month", strtotime($fecha_ini)));

            $pago = PagosPropietarios::create([
                        'id_contratofinal' => $idcontrato,
                        'meses_contrato' => $meses_contrato,
                        'id_publicacion' => $idp,
                        'id_inmueble' => $idinmueble,
                        'tipopago' => "Garantía",
                        'idtipopago' => $idtipopago,
                        'E_S' => $request->ga_radio,
                        'fecha_iniciocontrato' => $fechafirma,
                        'dia' => $dia,
                        'mes' => $mes,
                        'anio' => $anio,
                        'cant_diasmes' => $dias_mes,
                        'cant_diasproporcional' => $dias_mes,
                        'moneda' => 'CLP',
                        'valormoneda' => 1,
                        'valordia' => 1,
                        'precio_en_moneda' => $garantia,
                        'precio_en_pesos' => ceil($garantia),
                        'id_creador' => $id_creador,
                        'id_modificador' => $id_creador,
                        'id_estado' => 1,
                        'gastocomun' => $gastocomun,
                        'canondearriendo' => $arriendo
            ]);
        }


        $fecha_ini = date('Y-m-j', strtotime(date("Y", strtotime($fechafirma)) . '-' . date("m", strtotime($fechafirma)) . '-' . 1));
        //IVA
        if (isset($iva) && count($iva_reg) == 0) {
            $idtipopago = 4;
            $dias_mes = cal_days_in_month(CAL_GREGORIAN, date("m", strtotime($fecha_ini)), date("Y", strtotime($fecha_ini)));
            $valor_diario = 1;
            $dias_proporcionales = cal_days_in_month(CAL_GREGORIAN, date("m", strtotime($fecha_ini)), date("Y", strtotime($fecha_ini))) - date("d", strtotime($fecha_ini)) + 1;
            $precio_proporcional = $iva;
            $valor_en_pesos = $iva;
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
                            'meses_contrato' => $meses_contrato,
                            'id_publicacion' => $idp,
                            'id_inmueble' => $idinmueble,
                            'tipopago' => "IVA",
                            'idtipopago' => $idtipopago,
                            'fecha_iniciocontrato' => $fechafirma,
                            'dia' => $dia,
                            'mes' => $mes,
                            'anio' => $anio,
                            'E_S' => $request->iva_radio,
                            'cant_diasmes' => $dias_mes,
                            'cant_diasproporcional' => $dias_proporcionales,
                            'moneda' => 'CLP',
                            'valormoneda' => 1,
                            'valordia' => $valor_diario,
                            'precio_en_moneda' => $precio_proporcional,
                            'precio_en_pesos' => ceil($valor_en_pesos),
                            'id_creador' => $id_creador,
                            'id_modificador' => $id_creador,
                            'id_estado' => 1,
                            'gastocomun' => $gastocomun,
                            'canondearriendo' => $gastocomun
                ]);
            }
            for ($i = $ini; $i < $mes_iva; $i++) {

                $dia = date("d", strtotime($fecha_ini));
                $mes = date("m", strtotime($fecha_ini));
                $anio = date("Y", strtotime($fecha_ini));
                $dias_mes = cal_days_in_month(CAL_GREGORIAN, date("m", strtotime($fecha_ini)), date("Y", strtotime($fecha_ini)));
                $fecha_ini = date("d-m-Y", strtotime("+1 month", strtotime($fecha_ini)));

                $pago = PagosPropietarios::create([
                            'id_contratofinal' => $idcontrato,
                            'meses_contrato' => $meses_contrato,
                            'id_publicacion' => $idp,
                            'id_inmueble' => $idinmueble,
                            'tipopago' => "IVA",
                            'E_S' => $request->iva_radio,
                            'idtipopago' => $idtipopago,
                            'fecha_iniciocontrato' => $fechafirma,
                            'dia' => $dia,
                            'mes' => $mes,
                            'anio' => $anio,
                            'cant_diasmes' => $dias_mes,
                            'cant_diasproporcional' => $dias_mes,
                            'moneda' => 'CLP',
                            'valormoneda' => 1,
                            'valordia' => $valor_diario,
                            'precio_en_moneda' => $iva,
                            'precio_en_pesos' => ceil($iva * $valormoneda),
                            'id_creador' => $id_creador,
                            'id_modificador' => $id_creador,
                            'id_estado' => 1,
                            'gastocomun' => $gastocomun,
                            'canondearriendo' => $arriendo
                ]);
            }
        }

        $fecha_ini = date('Y-m-j', strtotime(date("Y", strtotime($fechafirma)) . '-' . date("m", strtotime($fechafirma)) . '-' . 1));
        //pie comision
        if (isset($pie) && count($pie_reg) == 0) {
            $idtipopago = 5;
            $dias_mes = cal_days_in_month(CAL_GREGORIAN, date("m", strtotime($fecha_ini)), date("Y", strtotime($fecha_ini)));
            $precio_proporcional = $pie;
            $valor_en_pesos = $pie;
            $ini = 1;
            $dia = date("d", strtotime($fecha_ini));
            $mes = date("m", strtotime($fecha_ini));
            $anio = date("Y", strtotime($fecha_ini));
            $dias_mes = cal_days_in_month(CAL_GREGORIAN, date("m", strtotime($fecha_ini)), date("Y", strtotime($fecha_ini)));
            $fecha_ini = date("d-m-Y", strtotime("+1 month", strtotime($fecha_ini)));

            $pago = PagosPropietarios::create([
                        'id_contratofinal' => $idcontrato,
                        'meses_contrato' => $meses_contrato,
                        'id_publicacion' => $idp,
                        'id_inmueble' => $idinmueble,
                        'tipopago' => "Pie Comisión",
                        'E_S' => $request->pie_radio,
                        'idtipopago' => $idtipopago,
                        'fecha_iniciocontrato' => $fechafirma,
                        'dia' => $dia,
                        'mes' => $mes,
                        'anio' => $anio,
                        'cant_diasmes' => $dias_mes,
                        'cant_diasproporcional' => $dias_mes,
                        'moneda' => 'CLP',
                        'valormoneda' => 1,
                        'valordia' => 1,
                        'precio_en_moneda' => $pie,
                        'precio_en_pesos' => ceil($pie),
                        'id_creador' => $id_creador,
                        'id_modificador' => $id_creador,
                        'id_estado' => 1,
                        'gastocomun' => $gastocomun,
                        'canondearriendo' => $arriendo
            ]);
        }

        $fecha_ini = date('Y-m-j', strtotime(date("Y", strtotime($fechafirma)) . '-' . date("m", strtotime($fechafirma)) . '-' . 1));
        //Comisión mensual
        if (isset($porcentaje) && count($porcentaje_reg) == 0) {
            $idtipopago = 6;
            $dias_mes = cal_days_in_month(CAL_GREGORIAN, date("m", strtotime($fecha_ini)), date("Y", strtotime($fecha_ini)));
            $valor_diario = 1;
            $dias_proporcionales = cal_days_in_month(CAL_GREGORIAN, date("m", strtotime($fecha_ini)), date("Y", strtotime($fecha_ini))) - date("d", strtotime($fecha_ini)) + 1;
            $precio_proporcional = $porcentaje;
            $valor_en_pesos = $porcentaje;
            $ini = 0;
            $fecha_ini = date("d-m-Y", strtotime("+1 month", strtotime($fecha_ini)));
            if ($dias_proporcionales > 0) {
                $ini = 1;
                $dia = date("d", strtotime($fecha_ini));
                $mes = date("m", strtotime($fecha_ini));
                $anio = date("Y", strtotime($fecha_ini));
                $dias_mes = cal_days_in_month(CAL_GREGORIAN, date("m", strtotime($fecha_ini)), date("Y", strtotime($fecha_ini)));
                $fecha_ini = date("d-m-Y", strtotime("+1 month", strtotime($fecha_ini)));

                $pago = PagosPropietarios::create([
                            'id_contratofinal' => $idcontrato,
                            'meses_contrato' => $meses_contrato,
                            'id_publicacion' => $idp,
                            'id_inmueble' => $idinmueble,
                            'tipopago' => "Comisión Mensual",
                            'E_S' => $request->pj_radio,
                            'idtipopago' => $idtipopago,
                            'fecha_iniciocontrato' => $fechafirma,
                            'dia' => $dia,
                            'mes' => $mes,
                            'anio' => $anio,
                            'cant_diasmes' => $dias_mes,
                            'cant_diasproporcional' => $dias_mes,
                            'moneda' => 'CLP',
                            'valormoneda' => 1,
                            'valordia' => $valor_diario,
                            'precio_en_moneda' => $precio_proporcional,
                            'precio_en_pesos' => ceil($valor_en_pesos),
                            'id_creador' => $id_creador,
                            'id_modificador' => $id_creador,
                            'id_estado' => 1,
                            'gastocomun' => $gastocomun,
                            'canondearriendo' => $gastocomun
                ]);
            }
            for ($i = $ini; $i < $mes_porcentaje; $i++) {

                $dia = date("d", strtotime($fecha_ini));
                $mes = date("m", strtotime($fecha_ini));
                $anio = date("Y", strtotime($fecha_ini));
                $dias_mes = cal_days_in_month(CAL_GREGORIAN, date("m", strtotime($fecha_ini)), date("Y", strtotime($fecha_ini)));
                $fecha_ini = date("d-m-Y", strtotime("+1 month", strtotime($fecha_ini)));

                $pago = PagosPropietarios::create([
                            'id_contratofinal' => $idcontrato,
                            'meses_contrato' => $meses_contrato,
                            'id_publicacion' => $idp,
                            'id_inmueble' => $idinmueble,
                            'tipopago' => "Comisión Mensual",
                            'idtipopago' => $idtipopago,
                            'fecha_iniciocontrato' => $fechafirma,
                            'E_S' => $request->pj_radio,
                            'dia' => $dia,
                            'mes' => $mes,
                            'anio' => $anio,
                            'cant_diasmes' => $dias_mes,
                            'cant_diasproporcional' => $dias_mes,
                            'moneda' => 'CLP',
                            'valormoneda' => 1,
                            'valordia' => $valor_diario,
                            'precio_en_moneda' => $porcentaje,
                            'precio_en_pesos' => ceil($porcentaje * $valormoneda),
                            'id_creador' => $id_creador,
                            'id_modificador' => $id_creador,
                            'id_estado' => 1,
                            'gastocomun' => $gastocomun,
                            'canondearriendo' => $arriendo
                ]);
            }
        }


        $fecha_ini = date('Y-m-j', strtotime(date("Y", strtotime($fechafirma)) . '-' . date("m", strtotime($fechafirma)) . '-' . 1));
        //Comisión Total
        if (isset($comision) && count($comision_reg) == 0) {
            $idtipopago = 7;
            $dias_mes = cal_days_in_month(CAL_GREGORIAN, date("m", strtotime($fecha_ini)), date("Y", strtotime($fecha_ini)));
            $precio_proporcional = $comision;
            $valor_en_pesos = $comision;
            $ini = 1;
            $dia = date("d", strtotime($fecha_ini));
            $mes = date("m", strtotime($fecha_ini));
            $anio = date("Y", strtotime($fecha_ini));
            $dias_mes = cal_days_in_month(CAL_GREGORIAN, date("m", strtotime($fecha_ini)), date("Y", strtotime($fecha_ini)));
            $fecha_ini = date("d-m-Y", strtotime("+1 month", strtotime($fecha_ini)));

            $pago = PagosPropietarios::create([
                        'id_contratofinal' => $idcontrato,
                        'meses_contrato' => $meses_contrato,
                        'id_publicacion' => $idp,
                        'id_inmueble' => $idinmueble,
                        'tipopago' => "Comisión Total",
                        'idtipopago' => $idtipopago,
                        'E_S' => $request->co_radio,
                        'fecha_iniciocontrato' => $fechafirma,
                        'dia' => $dia,
                        'mes' => $mes,
                        'anio' => $anio,
                        'cant_diasmes' => $dias_mes,
                        'cant_diasproporcional' => $dias_mes,
                        'moneda' => 'CLP',
                        'valormoneda' => 1,
                        'valordia' => 1,
                        'precio_en_moneda' => $comision,
                        'precio_en_pesos' => ceil($comision),
                        'id_creador' => $id_creador,
                        'id_modificador' => $id_creador,
                        'id_estado' => 1,
                        'gastocomun' => $gastocomun,
                        'canondearriendo' => $arriendo
            ]);
        }

        $fecha_ini = date('Y-m-j', strtotime(date("Y", strtotime($fechafirma)) . '-' . date("m", strtotime($fechafirma)) . '-' . 1));
        //Notaria
        if (isset($pagonotaria) && count($notaria_reg) == 0) {
            $idtipopago = 8;
            $dias_mes = cal_days_in_month(CAL_GREGORIAN, date("m", strtotime($fecha_ini)), date("Y", strtotime($fecha_ini)));
            $precio_proporcional = $pagonotaria;
            $valor_en_pesos = $pagonotaria;
            $ini = 1;
            $dia = date("d", strtotime($fecha_ini));
            $mes = date("m", strtotime($fecha_ini));
            $anio = date("Y", strtotime($fecha_ini));
            $dias_mes = cal_days_in_month(CAL_GREGORIAN, date("m", strtotime($fecha_ini)), date("Y", strtotime($fecha_ini)));
            $fecha_ini = date("d-m-Y", strtotime("+1 month", strtotime($fecha_ini)));

            $pago = PagosPropietarios::create([
                        'id_contratofinal' => $idcontrato,
                        'meses_contrato' => $meses_contrato,
                        'id_publicacion' => $idp,
                        'id_inmueble' => $idinmueble,
                        'tipopago' => "Notaría",
                        'idtipopago' => $idtipopago,
                        'E_S' => $request->no_radio,
                        'fecha_iniciocontrato' => $fechafirma,
                        'dia' => $dia,
                        'mes' => $mes,
                        'anio' => $anio,
                        'cant_diasmes' => $dias_mes,
                        'cant_diasproporcional' => $dias_mes,
                        'moneda' => 'CLP',
                        'valormoneda' => 1,
                        'valordia' => 1,
                        'precio_en_moneda' => $pagonotaria,
                        'precio_en_pesos' => ceil($pagonotaria),
                        'id_creador' => $id_creador,
                        'id_modificador' => $id_creador,
                        'id_estado' => 1,
                        'gastocomun' => $gastocomun,
                        'canondearriendo' => $arriendo
            ]);
        }


        $fecha_ini = date('Y-m-j', strtotime(date("Y", strtotime($fechafirma)) . '-' . date("m", strtotime($fechafirma)) . '-' . 1));
        //Otro Pago 1
        if (isset($pagootro1) && count($otro1_reg) == 0) {
            $idtipopago = 9;
            $dias_mes = cal_days_in_month(CAL_GREGORIAN, date("m", strtotime($fecha_ini)), date("Y", strtotime($fecha_ini)));
            $valor_diario = 1;
            $dias_proporcionales = cal_days_in_month(CAL_GREGORIAN, date("m", strtotime($fecha_ini)), date("Y", strtotime($fecha_ini))) - date("d", strtotime($fecha_ini)) + 1;
            $precio_proporcional = $pagootro1;
            $valor_en_pesos = $pagootro1;
            $ini = 0;
            $fecha_ini = date("d-m-Y", strtotime("+1 month", strtotime($fecha_ini)));
            if ($dias_proporcionales > 0) {
                $ini = 1;
                $dia = date("d", strtotime($fecha_ini));
                $mes = date("m", strtotime($fecha_ini));
                $anio = date("Y", strtotime($fecha_ini));
                $dias_mes = cal_days_in_month(CAL_GREGORIAN, date("m", strtotime($fecha_ini)), date("Y", strtotime($fecha_ini)));
                $fecha_ini = date("d-m-Y", strtotime("+1 month", strtotime($fecha_ini)));

                $pago = PagosPropietarios::create([
                            'id_contratofinal' => $idcontrato,
                            'meses_contrato' => $meses_contrato,
                            'id_publicacion' => $idp,
                            'id_inmueble' => $idinmueble,
                            'tipopago' => $nombre_otropago1,
                            'E_S' => $request->o1_radio,
                            'idtipopago' => $idtipopago,
                            'fecha_iniciocontrato' => $fechafirma,
                            'dia' => $dia,
                            'mes' => $mes,
                            'anio' => $anio,
                            'cant_diasmes' => $dias_mes,
                            'cant_diasproporcional' => $dias_proporcionales,
                            'moneda' => 'CLP',
                            'valormoneda' => 1,
                            'valordia' => $valor_diario,
                            'precio_en_moneda' => $precio_proporcional,
                            'precio_en_pesos' => ceil($valor_en_pesos),
                            'id_creador' => $id_creador,
                            'id_modificador' => $id_creador,
                            'id_estado' => 1,
                            'gastocomun' => $gastocomun,
                            'canondearriendo' => $gastocomun
                ]);
            }
            for ($i = $ini; $i < $mes_otro1; $i++) {

                $dia = date("d", strtotime($fecha_ini));
                $mes = date("m", strtotime($fecha_ini));
                $anio = date("Y", strtotime($fecha_ini));
                $dias_mes = cal_days_in_month(CAL_GREGORIAN, date("m", strtotime($fecha_ini)), date("Y", strtotime($fecha_ini)));
                $fecha_ini = date("d-m-Y", strtotime("+1 month", strtotime($fecha_ini)));

                $pago = PagosPropietarios::create([
                            'id_contratofinal' => $idcontrato,
                            'meses_contrato' => $meses_contrato,
                            'id_publicacion' => $idp,
                            'id_inmueble' => $idinmueble,
                            'tipopago' => $nombre_otropago1,
                            'idtipopago' => $idtipopago,
                            'fecha_iniciocontrato' => $fechafirma,
                            'E_S' => $request->o1_radio,
                            'dia' => $dia,
                            'mes' => $mes,
                            'anio' => $anio,
                            'cant_diasmes' => $dias_mes,
                            'cant_diasproporcional' => $dias_mes,
                            'moneda' => 'CLP',
                            'valormoneda' => 1,
                            'valordia' => $valor_diario,
                            'precio_en_moneda' => $porcentaje,
                            'precio_en_pesos' => ceil($porcentaje * $valormoneda),
                            'id_creador' => $id_creador,
                            'id_modificador' => $id_creador,
                            'id_estado' => 1,
                            'gastocomun' => $gastocomun,
                            'canondearriendo' => $arriendo
                ]);
            }
        }

        $fecha_ini = date('Y-m-j', strtotime(date("Y", strtotime($fechafirma)) . '-' . date("m", strtotime($fechafirma)) . '-' . 1));
        //Otro Pago 2
        if (isset($pagootro2) && count($otro2_reg) == 0) {
            $idtipopago = 10;
            $dias_mes = cal_days_in_month(CAL_GREGORIAN, date("m", strtotime($fecha_ini)), date("Y", strtotime($fecha_ini)));
            $valor_diario = 1;
            $dias_proporcionales = cal_days_in_month(CAL_GREGORIAN, date("m", strtotime($fecha_ini)), date("Y", strtotime($fecha_ini))) - date("d", strtotime($fecha_ini)) + 1;
            $precio_proporcional = $pagootro2;
            $valor_en_pesos = $pagootro2;
            $ini = 0;
            $fecha_ini = date("d-m-Y", strtotime("+1 month", strtotime($fecha_ini)));
            if ($dias_proporcionales > 0) {
                $ini = 1;
                $dia = date("d", strtotime($fecha_ini));
                $mes = date("m", strtotime($fecha_ini));
                $anio = date("Y", strtotime($fecha_ini));
                $dias_mes = cal_days_in_month(CAL_GREGORIAN, date("m", strtotime($fecha_ini)), date("Y", strtotime($fecha_ini)));
                $fecha_ini = date("d-m-Y", strtotime("+1 month", strtotime($fecha_ini)));

                $pago = PagosPropietarios::create([
                            'id_contratofinal' => $idcontrato,
                            'meses_contrato' => $meses_contrato,
                            'id_publicacion' => $idp,
                            'id_inmueble' => $idinmueble,
                            'tipopago' => $nombre_otropago2,
                            'E_S' => $request->o2_radio,
                            'idtipopago' => $idtipopago,
                            'fecha_iniciocontrato' => $fechafirma,
                            'dia' => $dia,
                            'mes' => $mes,
                            'anio' => $anio,
                            'cant_diasmes' => $dias_mes,
                            'cant_diasproporcional' => $dias_proporcionales,
                            'moneda' => 'CLP',
                            'valormoneda' => 1,
                            'valordia' => $valor_diario,
                            'precio_en_moneda' => $precio_proporcional,
                            'precio_en_pesos' => ceil($valor_en_pesos),
                            'id_creador' => $id_creador,
                            'id_modificador' => $id_creador,
                            'id_estado' => 1,
                            'gastocomun' => $gastocomun,
                            'canondearriendo' => $gastocomun
                ]);
            }
            for ($i = $ini; $i < $mes_otro1; $i++) {

                $dia = date("d", strtotime($fecha_ini));
                $mes = date("m", strtotime($fecha_ini));
                $anio = date("Y", strtotime($fecha_ini));
                $dias_mes = cal_days_in_month(CAL_GREGORIAN, date("m", strtotime($fecha_ini)), date("Y", strtotime($fecha_ini)));
                $fecha_ini = date("d-m-Y", strtotime("+1 month", strtotime($fecha_ini)));

                $pago = PagosPropietarios::create([
                            'id_contratofinal' => $idcontrato,
                            'meses_contrato' => $meses_contrato,
                            'id_publicacion' => $idp,
                            'id_inmueble' => $idinmueble,
                            'tipopago' => $nombre_otropago2,
                            'idtipopago' => $idtipopago,
                            'fecha_iniciocontrato' => $fechafirma,
                            'E_S' => $request->o2_radio,
                            'dia' => $dia,
                            'mes' => $mes,
                            'anio' => $anio,
                            'cant_diasmes' => $dias_mes,
                            'cant_diasproporcional' => $dias_mes,
                            'moneda' => 'CLP',
                            'valormoneda' => 1,
                            'valordia' => $valor_diario,
                            'precio_en_moneda' => $porcentaje,
                            'precio_en_pesos' => ceil($porcentaje * $valormoneda),
                            'id_creador' => $id_creador,
                            'id_modificador' => $id_creador,
                            'id_estado' => 1,
                            'gastocomun' => $gastocomun,
                            'canondearriendo' => $arriendo
                ]);
            }
        }


        $fecha_ini = date('Y-m-j', strtotime(date("Y", strtotime($fechafirma)) . '-' . date("m", strtotime($fechafirma)) . '-' . 1));
        //Otro Pago 3
        if (isset($pagootro3) && count($otro3_reg) == 0) {
            $idtipopago = 11;
            $dias_mes = cal_days_in_month(CAL_GREGORIAN, date("m", strtotime($fecha_ini)), date("Y", strtotime($fecha_ini)));
            $valor_diario = 1;
            $dias_proporcionales = cal_days_in_month(CAL_GREGORIAN, date("m", strtotime($fecha_ini)), date("Y", strtotime($fecha_ini))) - date("d", strtotime($fecha_ini)) + 1;
            $precio_proporcional = $pagootro3;
            $valor_en_pesos = $pagootro3;
            $ini = 0;
            $fecha_ini = date("d-m-Y", strtotime("+1 month", strtotime($fecha_ini)));
            if ($dias_proporcionales > 0) {
                $ini = 1;
                $dia = date("d", strtotime($fecha_ini));
                $mes = date("m", strtotime($fecha_ini));
                $anio = date("Y", strtotime($fecha_ini));
                $dias_mes = cal_days_in_month(CAL_GREGORIAN, date("m", strtotime($fecha_ini)), date("Y", strtotime($fecha_ini)));
                $fecha_ini = date("d-m-Y", strtotime("+1 month", strtotime($fecha_ini)));

                $pago = PagosPropietarios::create([
                            'id_contratofinal' => $idcontrato,
                            'meses_contrato' => $meses_contrato,
                            'id_publicacion' => $idp,
                            'id_inmueble' => $idinmueble,
                            'tipopago' => $nombre_otropago3,
                            'E_S' => $request->o3_radio,
                            'idtipopago' => $idtipopago,
                            'fecha_iniciocontrato' => $fechafirma,
                            'dia' => $dia,
                            'mes' => $mes,
                            'anio' => $anio,
                            'cant_diasmes' => $dias_mes,
                            'cant_diasproporcional' => $dias_proporcionales,
                            'moneda' => 'CLP',
                            'valormoneda' => 1,
                            'valordia' => $valor_diario,
                            'precio_en_moneda' => $precio_proporcional,
                            'precio_en_pesos' => ceil($valor_en_pesos),
                            'id_creador' => $id_creador,
                            'id_modificador' => $id_creador,
                            'id_estado' => 1,
                            'gastocomun' => $gastocomun,
                            'canondearriendo' => $gastocomun
                ]);
            }
            for ($i = $ini; $i < $mes_otro1; $i++) {

                $dia = date("d", strtotime($fecha_ini));
                $mes = date("m", strtotime($fecha_ini));
                $anio = date("Y", strtotime($fecha_ini));
                $dias_mes = cal_days_in_month(CAL_GREGORIAN, date("m", strtotime($fecha_ini)), date("Y", strtotime($fecha_ini)));
                $fecha_ini = date("d-m-Y", strtotime("+1 month", strtotime($fecha_ini)));

                $pago = PagosPropietarios::create([
                            'id_contratofinal' => $idcontrato,
                            'meses_contrato' => $meses_contrato,
                            'id_publicacion' => $idp,
                            'id_inmueble' => $idinmueble,
                            'tipopago' => $nombre_otropago3,
                            'idtipopago' => $idtipopago,
                            'fecha_iniciocontrato' => $fechafirma,
                            'E_S' => $request->o3_radio,
                            'dia' => $dia,
                            'mes' => $mes,
                            'anio' => $anio,
                            'cant_diasmes' => $dias_mes,
                            'cant_diasproporcional' => $dias_mes,
                            'moneda' => 'CLP',
                            'valormoneda' => 1,
                            'valordia' => $valor_diario,
                            'precio_en_moneda' => $porcentaje,
                            'precio_en_pesos' => ceil($porcentaje * $valormoneda),
                            'id_creador' => $id_creador,
                            'id_modificador' => $id_creador,
                            'id_estado' => 1,
                            'gastocomun' => $gastocomun,
                            'canondearriendo' => $arriendo
                ]);
            }
        }

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
    }

}
