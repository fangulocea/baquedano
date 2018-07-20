<?php

namespace App\Http\Controllers;

use App\ContratoFinalArr;
use App\ContratoBorradorArrendatario;
use App\ContratoFinalPdf;
use App\ContratoFinalDocs;
use App\ContratoFinalArrPdf;
use App\ContratoFinalArrDocs;
use App\Arrendatario;
use App\PagosArrendatarios;
use App\ArrendatarioGarantia;
use App\PagosMensualesArrendatarios;
    use App\Arr_Reservas;
use App\SimulaArrendatario;
use Illuminate\Http\Request;
use App\GenerarPagoArrendatario;
use DB;
use Illuminate\Support\Facades\File;
use Auth;
use App\ArrendatarioCheques;

class ContratoFinalArrController extends Controller
{



    public function eliminartipopago(Request $request) {
        $eliminamensual=PagosMensualesArrendatarios::where("id_contratofinal","=",$request->id_final_detalle)
        ->delete();
        $eliminapagos=PagosArrendatarios::where("id_contratofinal","=",$request->id_final_detalle)
        ->delete();
        return redirect()->route('finalContratoArr.edit', [$request->id_pub_borrar, 0, 0, 4])->with('status', 'Pagos Eliminados con éxito');
    }

    public function getContrato($id) {
        $contrato = DB::table('adm_contratofinalarr  as b')
                        ->leftjoin('arrendatarios as cp', 'b.id_publicacion', '=', 'cp.id')
                        ->leftjoin('adm_contratofinalarrpdf as bp', 'b.id', '=', 'bp.id_final')
                        ->leftjoin('contratoborradorarrendatarios as br', 'b.id_borrador', '=', 'br.id')
                        ->leftjoin('comisiones as co', 'br.id_comisiones', '=', 'co.id')
                        ->leftjoin('flexibilidads as f', 'br.id_flexibilidad', '=', 'f.id')
                        ->where('b.id', '=', $id)
                        ->select(DB::raw(' br.valorarriendo,b.fecha_firma'))
                        ->get()->first();
        return response()->json($contrato);
    }

    public function getPagos($id,$idi) {
        $contrato = DB::table('adm_pagosarrendatarios')
                ->where('id_contratofinal', '=', $id)
                 ->orderBy('id', 'asc')
                ->get();
        return response()->json($contrato);
    }

    public function getpagosmensuales($id,$idi) {
        $contrato = DB::table('adm_pagosmensualesarrendatarios as c')
                ->leftjoin('adm_contratofinalarr as cp', 'c.id_contratofinal', '=', 'cp.id')
                ->where('c.id_contratofinal', '=', $id)
                ->select(DB::raw(' c.id, c.fecha_iniciocontrato, c.mes, c.anio, c.valor_a_pagar, cp.meses_contrato,c.subtotal_entrada, c.subtotal_salida, c.pago_a_arrendatario, c.pago_a_rentas, c.id_estado'))
                ->orderBy('c.id', 'asc')
                ->get();
        return response()->json($contrato);
    }

    public function mostrarsimulacion($id) {
        $simulacion=SimulaArrendatario::find($id);
        return response()->json($simulacion);
    }

     public function crearContrato(Request $request)
    {
       
      $ContratoBorradorArrendatario=ContratoBorradorArrendatario::find($request->id_borradorfinal);

      $pdfBorradorArrendatario = DB::table('contratoborradorarrendatariospdf as pdf')
        ->where("pdf.id_b_arrendatario","=",$request->id_borradorfinal)
        ->select(DB::raw('pdf.id as id'))
        ->first();  

       $captacionArrendatario=Arrendatario::find($ContratoBorradorArrendatario->id_cap_arr)->update([
             "id_estado"=> 10
         ]);

      $contratoBorrador = ContratoBorradorArrendatario::find($request->id_borradorfinal)->update([
             "id_estado"=> 10
         ]);

       $contratoFinal=ContratoFinalArr::create([
             "id_publicacion" => $ContratoBorradorArrendatario->id_cap_arr, //arrendatarios
             "id_estado"      => 1,
             "id_creador"     => $request->id_creadorfinal,
             "id_borrador"    => $request->id_borradorfinal, //contrato borrador arrendatario
             "id_borradorpdf" => $pdfBorradorArrendatario->id,//contrato borrador PDF
             "id_simulacion"  => $request->id_propuesta
       ]);


      // //PARA PDF
      $borradorPDF = DB::table('contratoborradorarrendatarios as b')
         ->where('b.id','=',$request->id_borradorfinal)
         ->leftjoin('personas as p1','b.id_arrendatario','=','p1.id')
         ->leftjoin('inmuebles as i','b.id_inmueble','=','i.id')
         ->leftjoin('comunas as cc','p1.id_comuna','=','cc.comuna_id')
         ->leftjoin('servicios as s', 'b.id_servicios','=', 's.id')
         ->leftjoin('regions as rr','p1.id_region','=','rr.region_id')
         ->leftjoin('formasdepagos as fp','b.id_formadepago','=','fp.id')
         ->leftjoin('comisiones as c', 'b.id_comisiones', '=', 'c.id')
         ->leftjoin('flexibilidads as f', 'b.id_flexibilidad', '=', 'f.id')
         ->leftjoin('multas as m','b.id_multa','=','m.id')
         ->leftjoin('users as p2','b.id_creador','=','p2.id')
         ->leftjoin('comunas as cci','i.id_comuna','=','cci.comuna_id')
         ->leftjoin('contratoborradorarrendatariospdf as bp', 'b.id_arrendatario', '=', 'bp.id_b_arrendatario')
         ->select(DB::raw('b.id, CONCAT_WS(" ",p1.nombre,p1.apellido_paterno,p1.apellido_materno) as arrendatario, 
            CONCAT(s.descripcion, "  $",s.valor) as Servicio, 
            CONCAT(fp.descripcion, " Pie $", fp.pie, "  ", fp.cuotas, " Cuotas") as FormasDePago, 
            CONCAT(c.descripcion, " ", c.comision, " %") as comision, 
            f.descripcion as Flexibilidad ,
            b.valorarriendo ,
            CONCAT("Multa de ", m.valor ," % Equivalente a ", ROUND((valorarriendo * m.valor)/100,0)) as Multas,
            DATE_FORMAT(b.fecha_contrato, "%d/%m/%Y") as fecha, b.id_estado, p2.name as creador, b.id_arrendatario,i.id as id_inmueble,  b.detalle as bodyContrato, b.id_contrato as id_contrato, b.dia_pago as dia_pago_p, p1.profesion as profesion_p, p1.rut as rut_p, CONCAT_WS(" ",p1.direccion,p1.numero) as direccion_p, p1.telefono as telefono_p, p1.departamento as depto_p, cc.comuna_nombre as comuna_p, rr.region_nombre as region_p, i.rol as rol, CONCAT_WS(" ",i.direccion, i.numero) as direccion_i, i.departamento as depto_i, cci.comuna_nombre as comuna_i, i.dormitorio as dormitorio, i.bano as bano,
             CONCAT_WS(" ",p1.nombre,p1.apellido_paterno,p1.apellido_materno) as arrendatario ' ))
         ->first();

         $capSimulacion = DB::table('cap_simulaarrendatario as s')
         ->where('s.id','=',$request->id_propuesta)->first();

         if($capSimulacion->tipopropuesta == 1)
         {
            $idTipoPago = 21;
         } elseif($capSimulacion->tipopropuesta == 2)
         {
            $idTipoPago = 35;
         } 

         $simulacion = DB::table('cap_simulapagoarrendatarios as b')
         ->where('b.id_simulacion','=',$request->id_propuesta)
         ->where('b.idtipopago','=',$idTipoPago)
         ->get();

        $textoContrato = DB::table('contratoborradorarrendatarios as c')
        ->where('c.id','=',$request->id_borradorfinal)
        ->first();
      
        $cadenaAbuscar   = '{Cheques}';
        $posicion_coincidencia = strrpos($textoContrato->detalle, $cadenaAbuscar);

        $correlativo = 1;
        if ($posicion_coincidencia != false) {
            foreach ($simulacion as $s) {
                 $contratoCh=ArrendatarioCheques::create([
                        'id_contrato'   => $contratoFinal->id,
                        'monto'         => $s->precio_en_pesos,
                        'id_estado'     => 1,
                        'correlativo'   => $correlativo,
                        'mes_arriendo'  => $s->mes.'/'.$s->anio
                  ]);
                  $correlativo++;
            }
        } 

        $simulacion = DB::table('arrendatario_cheques as b')
         ->where('b.id_contrato','=',$contratoFinal->id)
         ->get();


        $pdf = new PdfController();
        $numero=rand();
        $pdf->pdfArrendatarioFinal($borradorPDF,$numero,$simulacion);
        // FIN PARA PDFsss
        $finalpdf=ContratoFinalArrPdf::create([
                    "id_final"    => $contratoFinal->id,
                    "nombre"      => $numero . $borradorPDF->id . $borradorPDF->direccion_i .'-FINAL.pdf',
                    "ruta"        => "uploads/pdfarrfinal/",
                    "id_creador"  => $request->id_creadorfinal,
                ])->toArray();
        return redirect()->route('finalContratoArr.edit', [$ContratoBorradorArrendatario->id_cap_arr,0,0,1])
         ->with('status', 'Contrato Final guardado con éxito');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    
$meses=DB::select(DB::raw('Select CONCAT(MONTH(DATE_ADD(now(), INTERVAL -6 MONTH)),"/",YEAR(DATE_ADD(now(), INTERVAL -6 MONTH))) as mesanterior6,
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
$meses=$meses[0];

    $publica = DB::table('adm_contratofinalarr as co')
                ->leftjoin('contratoborradorarrendatarios as cb','co.id_borrador','=','cb.id')
                 ->leftjoin('arrendatarios as c', 'c.id', '=', 'co.id_publicacion')
                ->leftjoin('inmuebles as i', 'c.id_inmueble', '=', 'i.id')
                ->leftjoin('comunas as o', 'i.id_comuna', '=', 'o.comuna_id')

                ->leftjoin('personas as p1', 'c.id_arrendatario', '=', 'p1.id')
                ->leftjoin('users as p2', 'c.id_creador', '=', 'p2.id')
                ->leftjoin('personas as p3', 'c.id_modificador', '=', 'p3.id')

                ->where('c.id_estado', '=', "7")
                ->Orwhere('c.id_estado', '=', "10")
                ->Orwhere('c.id_estado', '=', "11")
                ->select(DB::raw('cb.dia_pago, c.id as id_publicacion, DATE_FORMAT(c.created_at, "%d/%m/%Y") as fecha_creacion, c.id_estado as id_estado, CONCAT_WS(" ",p1.nombre,p1.apellido_paterno,p1.apellido_materno) as Arrendatario, p2.name as Creador,

                  (select pago_a_rentas from adm_pagosmensualesarrendatarios where mes=MONTH(DATE_ADD(now(), INTERVAL -6 MONTH)) and anio=YEAR(DATE_ADD(now(), INTERVAL -6 MONTH)) and id_publicacion=c.id and id_inmueble=i.id ) as valoranterior6,

                    (select sum(valor_pagado) from adm_detallepagosarrendatarios dt inner join adm_pagosmensualesarrendatarios pm on dt.id_pagomensual=pm.id where pm.mes=MONTH(DATE_ADD(now(), INTERVAL -6 MONTH)) and pm.anio=YEAR(DATE_ADD(now(), INTERVAL -6 MONTH)) and pm.id_publicacion=c.id and pm.id_inmueble=i.id ) as valorpagadoanterior6,

                  (select pago_a_rentas from adm_pagosmensualesarrendatarios where mes=MONTH(DATE_ADD(now(), INTERVAL -5 MONTH)) and anio=YEAR(DATE_ADD(now(), INTERVAL -5 MONTH)) and id_publicacion=c.id and id_inmueble=i.id ) as valoranterior5,

                    (select sum(valor_pagado) from adm_detallepagosarrendatarios dt inner join adm_pagosmensualesarrendatarios pm on dt.id_pagomensual=pm.id where pm.mes=MONTH(DATE_ADD(now(), INTERVAL -5 MONTH)) and pm.anio=YEAR(DATE_ADD(now(), INTERVAL -5 MONTH)) and pm.id_publicacion=c.id and pm.id_inmueble=i.id ) as valorpagadoanterior5,

                  (select pago_a_rentas from adm_pagosmensualesarrendatarios where mes=MONTH(DATE_ADD(now(), INTERVAL -4 MONTH)) and anio=YEAR(DATE_ADD(now(), INTERVAL -4 MONTH)) and id_publicacion=c.id and id_inmueble=i.id ) as valoranterior4,

                    (select sum(valor_pagado) from adm_detallepagosarrendatarios dt inner join adm_pagosmensualesarrendatarios pm on dt.id_pagomensual=pm.id where pm.mes=MONTH(DATE_ADD(now(), INTERVAL -4 MONTH)) and pm.anio=YEAR(DATE_ADD(now(), INTERVAL -4 MONTH)) and pm.id_publicacion=c.id and pm.id_inmueble=i.id ) as valorpagadoanterior4,

                  (select pago_a_rentas from adm_pagosmensualesarrendatarios where mes=MONTH(DATE_ADD(now(), INTERVAL -3 MONTH)) and anio=YEAR(DATE_ADD(now(), INTERVAL -3 MONTH)) and id_publicacion=c.id and id_inmueble=i.id ) as valoranterior3,

                    (select sum(valor_pagado) from adm_detallepagosarrendatarios dt inner join adm_pagosmensualesarrendatarios pm on dt.id_pagomensual=pm.id where pm.mes=MONTH(DATE_ADD(now(), INTERVAL -3 MONTH)) and pm.anio=YEAR(DATE_ADD(now(), INTERVAL -3 MONTH)) and pm.id_publicacion=c.id and pm.id_inmueble=i.id ) as valorpagadoanterior3,

                  (select pago_a_rentas from adm_pagosmensualesarrendatarios where mes=MONTH(DATE_ADD(now(), INTERVAL -2 MONTH)) and anio=YEAR(DATE_ADD(now(), INTERVAL -2 MONTH)) and id_publicacion=c.id and id_inmueble=i.id ) as valoranterior2,

                    (select sum(valor_pagado) from adm_detallepagosarrendatarios dt inner join adm_pagosmensualesarrendatarios pm on dt.id_pagomensual=pm.id where pm.mes=MONTH(DATE_ADD(now(), INTERVAL -2 MONTH)) and pm.anio=YEAR(DATE_ADD(now(), INTERVAL -2 MONTH)) and pm.id_publicacion=c.id and pm.id_inmueble=i.id ) as valorpagadoanterior2,


                  (select pago_a_rentas from adm_pagosmensualesarrendatarios where mes=MONTH(DATE_ADD(now(), INTERVAL -1 MONTH)) and anio=YEAR(DATE_ADD(now(), INTERVAL -1 MONTH)) and id_publicacion=c.id and id_inmueble=i.id ) as valoranterior1,

                    (select sum(valor_pagado) from adm_detallepagosarrendatarios dt inner join adm_pagosmensualesarrendatarios pm on dt.id_pagomensual=pm.id where pm.mes=MONTH(DATE_ADD(now(), INTERVAL -1 MONTH)) and pm.anio=YEAR(DATE_ADD(now(), INTERVAL -1 MONTH)) and pm.id_publicacion=c.id and pm.id_inmueble=i.id ) as valorpagadoanterior1,

                    
                    (select pago_a_rentas from adm_pagosmensualesarrendatarios where mes=MONTH(now()) and anio=YEAR(now()) and id_publicacion=c.id and id_inmueble=i.id ) as valoractual,

                    (select sum(valor_pagado) from adm_detallepagosarrendatarios dt inner join adm_pagosmensualesarrendatarios pm on dt.id_pagomensual=pm.id where pm.mes=MONTH(now()) and pm.anio=YEAR(now()) and pm.id_publicacion=c.id and pm.id_inmueble=i.id ) as valorpagadoactual,


                      (select pago_a_rentas from adm_pagosmensualesarrendatarios where mes=MONTH(DATE_ADD(now(), INTERVAL 1 MONTH)) and anio=YEAR(DATE_ADD(now(), INTERVAL 1 MONTH)) and id_publicacion=c.id and id_inmueble=i.id ) as valorsiguiente1,

                    (select sum(valor_pagado) from adm_detallepagosarrendatarios dt inner join adm_pagosmensualesarrendatarios pm on dt.id_pagomensual=pm.id where pm.mes=MONTH(DATE_ADD(now(), INTERVAL 1 MONTH)) and pm.anio=YEAR(DATE_ADD(now(), INTERVAL 1 MONTH)) and pm.id_publicacion=c.id and pm.id_inmueble=i.id ) as valorpagadosiguiente1,

                                       (select pago_a_rentas from adm_pagosmensualesarrendatarios where mes=MONTH(DATE_ADD(now(), INTERVAL 2 MONTH)) and anio=YEAR(DATE_ADD(now(), INTERVAL 2 MONTH)) and id_publicacion=c.id and id_inmueble=i.id ) as valorsiguiente2,

                    (select sum(valor_pagado) from adm_detallepagosarrendatarios dt inner join adm_pagosmensualesarrendatarios pm on dt.id_pagomensual=pm.id where pm.mes=MONTH(DATE_ADD(now(), INTERVAL 2 MONTH)) and pm.anio=YEAR(DATE_ADD(now(), INTERVAL 2 MONTH)) and pm.id_publicacion=c.id and pm.id_inmueble=i.id ) as valorpagadosiguiente2,

                                       (select pago_a_rentas from adm_pagosmensualesarrendatarios where mes=MONTH(DATE_ADD(now(), INTERVAL 3 MONTH)) and anio=YEAR(DATE_ADD(now(), INTERVAL 3 MONTH)) and id_publicacion=c.id and id_inmueble=i.id ) as valorsiguiente3,

                    (select sum(valor_pagado) from adm_detallepagosarrendatarios dt inner join adm_pagosmensualesarrendatarios pm on dt.id_pagomensual=pm.id where pm.mes=MONTH(DATE_ADD(now(), INTERVAL 3 MONTH)) and pm.anio=YEAR(DATE_ADD(now(), INTERVAL 3 MONTH)) and pm.id_publicacion=c.id and pm.id_inmueble=i.id ) as valorpagadosiguiente3,

                                       (select pago_a_rentas from adm_pagosmensualesarrendatarios where mes=MONTH(DATE_ADD(now(), INTERVAL 4 MONTH)) and anio=YEAR(DATE_ADD(now(), INTERVAL 4 MONTH)) and id_publicacion=c.id and id_inmueble=i.id ) as valorsiguiente4,

                    (select sum(valor_pagado) from adm_detallepagosarrendatarios dt inner join adm_pagosmensualesarrendatarios pm on dt.id_pagomensual=pm.id where pm.mes=MONTH(DATE_ADD(now(), INTERVAL 4 MONTH)) and pm.anio=YEAR(DATE_ADD(now(), INTERVAL 4 MONTH)) and pm.id_publicacion=c.id and pm.id_inmueble=i.id ) as valorpagadosiguiente4,

                                       (select pago_a_rentas from adm_pagosmensualesarrendatarios where mes=MONTH(DATE_ADD(now(), INTERVAL 5 MONTH)) and anio=YEAR(DATE_ADD(now(), INTERVAL 5 MONTH)) and id_publicacion=c.id and id_inmueble=i.id ) as valorsiguiente5,

                    (select sum(valor_pagado) from adm_detallepagosarrendatarios dt inner join adm_pagosmensualesarrendatarios pm on dt.id_pagomensual=pm.id where pm.mes=MONTH(DATE_ADD(now(), INTERVAL 5 MONTH)) and pm.anio=YEAR(DATE_ADD(now(), INTERVAL 5 MONTH)) and pm.id_publicacion=c.id and pm.id_inmueble=i.id ) as valorpagadosiguiente5,

                                       (select pago_a_rentas from adm_pagosmensualesarrendatarios where mes=MONTH(DATE_ADD(now(), INTERVAL 6 MONTH)) and anio=YEAR(DATE_ADD(now(), INTERVAL 6 MONTH)) and id_publicacion=c.id and id_inmueble=i.id ) as valorsiguiente6,

                    (select sum(valor_pagado) from adm_detallepagosarrendatarios dt inner join adm_pagosmensualesarrendatarios pm on dt.id_pagomensual=pm.id where pm.mes=MONTH(DATE_ADD(now(), INTERVAL 6 MONTH)) and pm.anio=YEAR(DATE_ADD(now(), INTERVAL 6 MONTH)) and pm.id_publicacion=c.id and pm.id_inmueble=i.id ) as valorpagadosiguiente6,

                    c.id as id_cap_arr, CONCAT_WS(" ",p1.nombre,p1.apellido_paterno,p1.apellido_materno) as arrendatario,i.direccion,i.numero,o.comuna_nombre as comuna,c.id_estado, c.id_arrendatario as id_arrendatario

                    '), 'p1.id as id_propietario', 'i.id as id_inmueble', 'i.direccion', 'i.numero', 'i.departamento', 'o.comuna_nombre', 'p1.nombre as nom_p', 'p1.apellido_paterno as apep_p', 'p1.apellido_materno as apem_p', 'p3.nombre as nom_m', 'p3.apellido_paterno as apep_m', 'p3.apellido_materno as apem_m')
                ->get();


    /*    $publica = DB::table('arrendatarios as a')
         ->leftjoin('users as pc', 'a.id_creador', 'pc.id')
         ->leftjoin('personas as pm', 'a.id_modificador', 'pm.id')
         ->leftjoin('personas as pa', 'a.id_arrendatario','pa.id')
         ->leftjoin('inmuebles as i','a.id_inmueble','i.id')
         ->leftjoin('comunas as c', 'i.id_comuna', '=', 'c.comuna_id')
         ->Where('a.id_estado','=',10)
         ->orWhere('a.id_estado','=',11 )
         ->select(DB::raw('a.id as id_cap_arr, CONCAT_WS(" ",pa .nombre,pa.apellido_paterno,pa.apellido_materno) as arrendatario,i.direccion,i.numero,c.comuna_nombre as comuna,a.id_estado, a.id_arrendatario as id_arrendatario'))
         ->get(); */

        return view('finalContratoArr.index',compact('publica','meses'));
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
     * @param  \App\ContratoFinalArr  $contratoFinalArr
     * @return \Illuminate\Http\Response
     */
    public function show(ContratoFinalArr $contratoFinalArr)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ContratoFinalArr  $contratoFinalArr
     * @return \Illuminate\Http\Response
     */
    public function edit($idc,$idcb,$idpdf,$tab)
    {
       // $borrador = DB::table('cap_publicaciones as c')
       //   ->leftjoin('personas as p1', 'c.id_propietario', '=', 'p1.id')
       //   ->leftjoin('inmuebles as i', 'c.id_inmueble', '=', 'i.id')
       //   ->leftjoin('personas as p2', 'c.id_creador', '=', 'p2.id')
       //   ->leftjoin('personas as p3', 'c.id_modificador', '=', 'p3.id')
       //   ->leftjoin('comunas as o', 'i.id_comuna', '=', 'o.comuna_id')
       //   ->leftjoin('portales as po', 'c.portal', '=', 'po.id')
       //   ->where('c.id','=',$idc)
       //   ->select(DB::raw('c.id as id_publicacion, p1.id as id_propietario, i.id as id_inmueble, CONCAT_WS(" ",i.direccion,"#",i.numero,"Depto.",i.departamento,o.comuna_nombre) as direccion, CONCAT_WS(" ",p1.nombre , p1.apellido_paterno, " Fono: " ,p1.telefono, " Email: " ,p1.email ) as propietario, i.precio, i.gastosComunes'))
       //   ->first();
        $borrador = DB::table('arrendatarios as a')
         ->leftjoin('users as pc', 'a.id_creador', 'pc.id')
         ->leftjoin('personas as pm', 'a.id_modificador', 'pm.id')
         ->leftjoin('personas as pa', 'a.id_arrendatario','pa.id')
         ->leftjoin('inmuebles as i','a.id_inmueble','i.id')
         ->leftjoin('comunas as c', 'i.id_comuna', '=', 'c.comuna_id')
         ->where('a.id','=',$idc)
         ->select(DB::raw('a.id id_cap_arr, CONCAT_WS(" ",pa.nombre,pa.apellido_paterno,pa.apellido_materno) as arrendatario,i.direccion,i.numero,c.comuna_nombre as comuna,a.id_estado, a.id_arrendatario as id_arrendatario,i.id as id_inmueble'))
         ->first();         

         $finalIndex = DB::table('adm_contratofinalarr  as b')
         ->leftjoin('arrendatarios as cp', 'b.id_publicacion', '=', 'cp.id')
         ->leftjoin('adm_contratofinalarrpdf as bp', 'b.id', '=', 'bp.id_final')
         ->leftjoin('contratoborradorarrendatarios as cb','b.id_borrador','=','cb.id')
            ->where('b.id_publicacion','=',$idc)
         ->select(DB::raw('cb.dia_pago, b.id ,b.id_borrador, cp.id as id_publicacion,b.fecha_firma as fecha,b.id_estado,bp.nombre, bp.id as id_pdf,b.id_notaria,b.alias'))
         ->get();

              $notaria = DB::table('notarias as n')
         ->where("n.estado","<>",0)
         ->select(DB::raw('n.id as id,n.razonsocial as nombre'))
         ->get();

   $documentos = DB::table('adm_contratofinalarrdocs as n')
         ->where("n.id_publicacion","=",$idc)
         ->get();

       $propuestas = DB::table('cap_simulaarrendatario as s')
             ->join("adm_contratofinalarr as cf","cf.id_simulacion","s.id")
         ->where("s.id_publicacion","=",$idc)
         ->select(DB::raw(" s.id, (CASE  WHEN s.tipopropuesta=1 THEN '1 Cuota' WHEN s.tipopropuesta=2 THEN'Pie + Cuota' ELSE 'Renovación' END) as tipopropuesta, s.proporcional, s.fecha_iniciocontrato, s.meses_contrato, s.iva,descuento, s.pie, cobromensual, s.nrocuotas,s.canondearriendo" ))
         ->get();  
 $flag=0;

         return view('finalContratoArr.edit',compact('borrador','finalIndex','notaria','documentos','flag','tab','propuestas'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ContratoFinalArr  $contratoFinalArr
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ContratoFinalArr $contratoFinalArr)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ContratoFinalArr  $contratoFinalArr
     * @return \Illuminate\Http\Response
     */
    public function destroy($id,$idpdf)
    {
        $borrach = ArrendatarioCheques::where('id_contrato','=',$id)->delete();

        $pdf=ContratoFinalArrPdf::find($idpdf);
        File::delete($pdf->ruta.'/'.$pdf->nombre);
        $pdf=ContratoFinalArrPdf::find($idpdf)->delete();
        $contrato = ContratoFinalArr::find($id);
        $borrar = ContratoFinalArr::find($id)->delete();


        $cant = ContratoFinalArr::where("id_publicacion","=",$contrato->id_publicacion)->get();
        if(count($cant)==0){
                $captacion=arrendatario::find($contrato->id_publicacion)->update([
                    "id_estado"=> 2
                ]);
        }
         return redirect()->route('finalContratoArr.edit', [$contrato->id_publicacion,$contrato->id_borrador,$idpdf,1])
         ->with('status', 'Contrato eliminado con éxito'); 
    }    

    public function asignarNotaria(Request $request, $id)
    {

        $now = new \DateTime();
        $fecha_creacion= $now->format('Y-m-d H:i:s');
        $contrato=ContratoFinalArr::where('id','=',$id)->update([
            "id_notaria"=>$request->id_notaria,
            "fecha_firma"=>$request->fecha_firma,
            "id_modificador"=>$request->id_modificador,
            "updated_at"=>$fecha_creacion,
            "alias"=>$request->alias,
            "id_estado"=> 7
       ]);

        $Arr=Arrendatario::find($request->id_publicacion)->update([
            "id_estado"=> 11
        ]);
         return redirect()->route('finalContratoArr.edit', [$request->id_publicacion,$request->id_borrador,$request->id_pdf,1])
         ->with('status', 'Contrato actualizado con éxito');  
    }

    public function savedocs(Request $request, $id){
         if(!isset($request->foto)){
            return redirect()->route('finalContratoArr.edit', $id)->with('error', 'Debe seleccionar archivo');
         }

        $destinationPath='uploads/contratoarrfinaldocs';
        $archivo=rand().$request->foto->getClientOriginalName();
        $file = $request->file('foto');
        $file->move($destinationPath,$archivo);

                $imagen=ContratoFinalArrDocs::create([
                            'id_final'             => $request->id_final,
                            'id_publicacion'       => $request->id_publicacion,
                            'tipo'                 => $request->tipo,
                            'nombre'               => $archivo,
                            'ruta'                 => $destinationPath,
                            'id_creador'           => $request->id_creador
                        ]);


        return redirect()->route('finalContratoArr.edit', [$request->id_publicacion,0,0,2])->with('status', 'Documento guardada con éxito');
    }

    public function eliminarfoto($idf){

        $imagen=ContratoFinalArrDocs::find($idf);

        File::delete($imagen->ruta.'/'.$imagen->nombre);
        $foto = ContratoFinalArrDocs::find($idf)->delete();

        return redirect()->route('finalContratoArr.edit', [$imagen->id_publicacion,0,0,2])->with('status', 'Documento eliminado con éxito');
    }



    public function updatepago(Request $request) {

        $pp = PagosArrendatarios::find($request->id_pago_update)->update([
            "precio_en_pesos" => $request->pago_update
        ]);
        $idp = $request->id_publicacion_update;

        $arre=Arrendatario::find($idp);
        $idinmueble=$arre->id_inmueble;
        $p = PagosArrendatarios::find($request->id_pago_update);

        $fecha_ini = date('Y-m-j', strtotime(date("Y", strtotime($p->fecha_iniciocontrato)) . '-' . date("m", strtotime($p->fecha_iniciocontrato)) . '-' . 1));
        for ($i = 0; $i < $p->meses_contrato; $i++) {
            $mes = date("m", strtotime($fecha_ini));
            $anio = date("Y", strtotime($fecha_ini));
            $fecha_ini = date("d-m-Y", strtotime("+1 month", strtotime($fecha_ini)));
            $pagos_mensuales_e = DB::table('adm_pagosarrendatarios')
                    ->where("id_publicacion", "=", $idp)
                    ->where("id_inmueble", "=", $idinmueble)
                    ->where("E_S", "=", "e")
                    ->where("mes", "=", $mes)
                    ->where("anio", "=", $anio)
                    ->sum('precio_en_pesos');
            $pagos_mensuales_s = DB::table('adm_pagosarrendatarios')
                    ->where("id_publicacion", "=", $idp)
                    ->where("id_inmueble", "=", $idinmueble)
                    ->where("E_S", "=", "s")
                    ->where("mes", "=", $mes)
                    ->where("anio", "=", $anio)
                    ->sum('precio_en_pesos');

            $pagar_a_arrendatario=$pagos_mensuales_s-$pagos_mensuales_e;
            $pagar_a_baquedano=$pagos_mensuales_e-$pagos_mensuales_s;

            if($pagar_a_arrendatario<0)
                $pagar_a_arrendatario=0;

            if($pagar_a_baquedano<0)
                $pagar_a_baquedano=0;
//dd($pagar_a_arrendatario."    ".$pagar_a_baquedano."       e:".$pagos_mensuales_e."        s:".$pagos_mensuales_s ."     ".$request->id_inmueble_update);
            $pago_mensual = PagosMensualesArrendatarios::
                    where("id_contratofinal", "=", $idp)
                    ->where("mes", "=", $mes)
                    ->where("id_inmueble", "=", $idinmueble)
                    ->where("anio", "=", $anio)
                    ->update([
                'valor_a_pagar' => $pagos_mensuales_e,
                'id_modificador' => Auth::user()->id,
                'subtotal_entrada' => $pagos_mensuales_e,
                'subtotal_salida' => $pagos_mensuales_s,
                'pago_a_arrendatario' => $pagar_a_arrendatario,
                'pago_a_rentas' => $pagar_a_baquedano
            ]);


        }
        return redirect()->route('finalContratoArr.edit', [$p->id_publicacion, 0, 0, 4])->with('status', 'Pago actualizado con éxito');
    }

    public function mostrar_un_pago($id) {
        $pago = PagosArrendatarios::find($id);
        return response()->json($pago);
    }


    public function generarpagos(Request $request, $idp) {

        $canMPagos=PagosMensualesArrendatarios::where("id_contratofinal","=",$request->id_final_pagos)
        ->where("id_inmueble","=",$request->id_inmueble_pago)->get();
        $canPagos=PagosArrendatarios::where("id_contratofinal","=",$request->id_final_pagos)
        ->where("id_inmueble","=",$request->id_inmueble_pago)->get();


        if(count($canMPagos)>0 || count($canPagos)>0){
            return redirect()->route('finalContratoArr.edit', [$idp, 0, 0, 4])->with('error', 'Debe eliminar pagos antes de volver a crear');
        }


        $captacion = Arrendatario::find($idp);
        $idcontrato=$request->id_final_pagos;
        $idinmueble = $request->id_inmueble_pago;
        $idarrendatario = $captacion->id_arrendatario;
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

        $simula = GenerarPagoArrendatario::create([
                    'meses_contrato' => $meses_contrato,
                    'id_publicacion' => $idp,
                    'id_propuesta' => $id_propuesta,
                    'id_inmueble' => $idinmueble,
                    'id_arrendatario' => $idarrendatario,
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
                    'gastocomun' => $gastocomun,
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
            $pago = PagosArrendatarios::create([
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

            $pago = PagosArrendatarios::create([
                        'id_contratofinal' => $idcontrato,
                        'id_publicacion' => $idp,
                        'id_inmueble' => $idinmueble,
                        'tipopago' => "Canon de Arriendo",
                        'idtipopago' => $idtipopago,
                        'meses_contrato' => $meses_contrato,
                        'fecha_iniciocontrato' => $fechafirma,
                        'E_S' => 'e',
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
            $pago = PagosArrendatarios::create([
                        'id_contratofinal' => $idcontrato,
                        'gastocomun' => $gastocomun,
                        'id_publicacion' => $idp,
                        'id_inmueble' => $idinmueble,
                        'tipopropuesta' => $tipopropuesta,
                        'E_S' => 'e',
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
                        'gastocomun' => $gastocomun,
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

                $pago = PagosArrendatarios::create([
                        'id_contratofinal' => $idcontrato,
                        'gastocomun' => $gastocomun,
                            'id_publicacion' => $idp,
                            'id_inmueble' => $idinmueble,
                            'tipopago' => "Gasto Común",
                            'E_S' => 'e',
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
                            'precio_en_pesos' => $valor_en_pesos,
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

                $pago = PagosArrendatarios::create([
                        'id_contratofinal' => $idcontrato,
                        'gastocomun' => $gastocomun,
                            'id_publicacion' => $idp,
                            'id_inmueble' => $idinmueble,
                            'E_S' => 'e',
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
                            'precio_en_pesos' => $gastocomun * $valormoneda,
                            'id_creador' => $id_creador,
                            'id_modificador' => $id_creador,
                            'gastocomun' => $gastocomun,
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
            $pago = PagosArrendatarios::create([
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
                        'precio_en_moneda' => $valor_en_pesos,
                        'precio_en_pesos' => $valor_en_pesos,
                        'id_creador' => $id_creador,
                        'id_modificador' => $id_creador,
                        'id_estado' => 1,
                        'gastocomun' => $gastocomun,
                        'canondearriendo' => $arriendo
            ]);
            $primer_mes += $valor_en_pesos;
        }

        //pago iva
        if ($tipopropuesta == 1) {
            $idtipopago = 4;

            $pago = PagosArrendatarios::create([
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
                        'precio_en_moneda' => $valor_en_pesos_con_desc * ($iva / 100),
                        'precio_en_pesos' => $valor_en_pesos_con_desc * ($iva / 100),
                        'id_creador' => $id_creador,
                        'id_modificador' => $id_creador,
                        'id_estado' => 1,
                        'gastocomun' => $gastocomun,
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
                        $idtipopago = 11;
                        $precio_proporcional = $g->valor;
                        $valor_en_pesos = $g->valor;
                        $pago = PagosArrendatarios::create([
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
                        'E_S' => 'e',
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

        $reservas=Arr_Reservas::where("id_arr_ges","=",$idp)->get();
$fecha_ini = date('Y-m-j', strtotime(date("Y", strtotime($fechafirma)) . '-' . date("m", strtotime($fechafirma)) . '-' . 1));
        if (count($reservas) > 0) {
            $monto_reserva=0;
                foreach ($reservas as $g) {
                        $monto_reserva+=$g->monto_reserva;
                }
                        $idtipopago = 10;
                        $precio_proporcional = $monto_reserva;
                        $valor_en_pesos = $monto_reserva;
                        $pago = PagosArrendatarios::create([
                        'id_contratofinal' => $idcontrato,
                        'id_publicacion' => $idp,
                        'id_inmueble' => $idinmueble,
                        'tipopropuesta' => $tipopropuesta,
                        'tipopago' => "Reserva",
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
                      $fecha_ini = date("d-m-Y", strtotime("+1 month", strtotime($fecha_ini)));
                
            
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

            $pago = PagosArrendatarios::create([
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
                        'precio_en_moneda' => $valor_en_pesos,
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

            $pago = PagosArrendatarios::create([
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
                        'precio_en_moneda' => $valor_en_pesos,
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

            $pago = PagosArrendatarios::create([
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
                        'precio_en_moneda' => $valor_en_pesos,
                        'precio_en_pesos' => $valor_en_pesos,
                        'id_creador' => $id_creador,
                        'id_modificador' => $id_creador,
                        'id_estado' => 1,
                        'gastocomun' => $gastocomun,
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
                $pago = PagosArrendatarios::create([
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
                $pendiente = ($valor_en_pesos_proporcional - $primer_mes) * -1;
                $fecha_ini = date("d-m-Y", strtotime("+1 month", strtotime($fecha_ini)));
                $dias_mes = cal_days_in_month(CAL_GREGORIAN, date("m", strtotime($fecha_ini)), date("Y", strtotime($fecha_ini)));
                $dia = date("d", strtotime($fecha_ini));
                $mes = date("m", strtotime($fecha_ini));
                $anio = date("Y", strtotime($fecha_ini));
                $pago = PagosArrendatarios::create([
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
                            'precio_en_moneda' => $pendiente,
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

            for ($i = 0; $i < $cant_meses; $i++) {
                $dia = date("d", strtotime($fecha_ini));
                $mes = date("m", strtotime($fecha_ini));
                $anio = date("Y", strtotime($fecha_ini));
                $dias_mes = cal_days_in_month(CAL_GREGORIAN, date("m", strtotime($fecha_ini)), date("Y", strtotime($fecha_ini)));
                $pagomensual = PagosArrendatarios::where("mes", '=', $mes)
                        ->where("anio", '=', $anio)
                        ->whereIn("idtipopago", [1,2,3,4,5,6,7,8,9,11,15])
                        ->where("id_contratofinal", '=', $idcontrato)
                        ->where("id_inmueble", '=', $idinmueble)
                        ->sum('precio_en_pesos');

                $pago = PagosArrendatarios::create([
                        'id_contratofinal' => $idcontrato,
                        'gastocomun' => $gastocomun,
                            'id_publicacion' => $idp,
                            'id_inmueble' => $idinmueble,
                            'tipopago' => "Total Costos Arrendatario",
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
                            'precio_en_moneda' => $pagomensual,
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


            for ($i = 0; $i < $cant_meses; $i++) {
                $dia = date("d", strtotime($fecha_ini));
                $mes = date("m", strtotime($fecha_ini));
                $anio = date("Y", strtotime($fecha_ini));
                $dias_mes = cal_days_in_month(CAL_GREGORIAN, date("m", strtotime($fecha_ini)), date("Y", strtotime($fecha_ini)));
                $pagomensual = PagosArrendatarios::where("mes", '=', $mes)
                        ->where("anio", '=', $anio)
                        ->whereIn("idtipopago", [1,2,3,4,5,6,7,8,11,15])
                        ->where("id_contratofinal", '=', $idcontrato)
                        ->where("id_inmueble", '=', $idinmueble)
                        ->sum('precio_en_pesos');
                        $saldo = $pagomensual - $monto_reserva;
         

                $pago = PagosArrendatarios::create([
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
                            'precio_en_moneda' => $saldo,
                            'precio_en_pesos' => $saldo,
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
            $pago = PagosArrendatarios::create([
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
                        'tipopropuesta' => '2',
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

            $pago = PagosArrendatarios::create([
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
                        'tipopropuesta' => '2',
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
                $valor_cuota = $arriendo * ($cobromensual / 100);
               $pago = PagosArrendatarios::create([
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

           $primer_mes=  PagosArrendatarios::where("mes", '=', $mes)
                        ->where("anio", '=', $anio)
                        ->whereIn("idtipopago", [2,3,4,5,6,7,31,32])
                        ->where("id_contratofinal", '=', $idcontrato)
                        ->where("id_inmueble", '=', $idinmueble)
                        ->sum('precio_en_pesos');
                $valor_en_pesos_proporcional=  PagosArrendatarios::where("mes", '=', $mes)
                        ->where("anio", '=', $anio)
                        ->whereIn("idtipopago", [1])
                        ->where("id_contratofinal", '=', $idcontrato)
                        ->where("id_inmueble", '=', $idinmueble)
                        ->sum('precio_en_pesos');

            $pendiente = $valor_en_pesos_proporcional - $primer_mes;
//dd(" pendiente : $pendiente valor_en_pesos_proporcional : $valor_en_pesos_proporcional primer_mes : $primer_mes");
            if (($valor_en_pesos_proporcional - $primer_mes) < 0) {
                $dia = date("d", strtotime($fecha_ini));
                $mes = date("m", strtotime($fecha_ini));
                $anio = date("Y", strtotime($fecha_ini));
                $dias_mes = cal_days_in_month(CAL_GREGORIAN, date("m", strtotime($fecha_ini)), date("Y", strtotime($fecha_ini)));
                $pago = PagosArrendatarios::create([
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
                            'tipopropuesta' => '2',
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
                $pago = PagosArrendatarios::create([
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
           $pagomensual=PagosArrendatarios::where("mes",'=',$mes)
          ->where("anio",'=',$anio)
          ->whereIn("idtipopago", [1,2,3,4,5,6,7,8,11,31,32,33])
                        ->where("id_contratofinal", '=', $idcontrato)
                        ->where("id_inmueble", '=', $idinmueble)
          ->sum('precio_en_pesos');
          $pago = PagosArrendatarios::create([
                        'id_contratofinal' => $idcontrato,
                        'gastocomun' => $gastocomun,
          'id_publicacion' => $idp,
          'id_inmueble' => $idinmueble,
          'tipopago' => "Total Costos Arrendatario",
          'E_S' => 's',
          'idtipopago' => $idtipopago,
          'meses_contrato' => $meses_contrato,
          'fecha_iniciocontrato' => $fechafirma,
          'dia' => $dia,
          'mes' => $mes,
          'anio' => $anio,
          'descuento' => $descuento,
          'tipopropuesta' => '2',
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
        $valor_en_pesos_proporcional=  PagosArrendatarios::where("mes", '=', $mes)
                        ->where("anio", '=', $anio)
                        ->whereIn("idtipopago", [1])
                        ->where("id_contratofinal", '=', $idcontrato)
                        ->where("id_inmueble", '=', $idinmueble)
                        ->sum('precio_en_pesos');
          $pagomensual=PagosArrendatarios::where("mes",'=',$mes)
          ->where("anio",'=',$anio)
          ->whereIn("idtipopago", [1,2,3,4,5,6,7,8,11,31,32,33])
                        ->where("id_contratofinal", '=', $idcontrato)
                        ->where("id_inmueble", '=', $idinmueble)
          ->sum('precio_en_pesos');
          if($i==0){
            $saldo=$pagomensual-$monto_reserva;
          }else{
            $saldo=$pagomensual ;
          }
          
          $pago = PagosArrendatarios::create([
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
          'tipopropuesta' => '2',
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
        

 if ($tipopropuesta == 1) {
    $tipos=[1,2,3,4,5,6,7,8,10,11,15];
 }elseif($tipopropuesta == 2){
    $tipos=[1,2,5,6,7,8,10,11,31,32,33];

 }else{
    $tipos=[1,2,5,6,7,8,10,11,31,32,33];
 }


          $fecha_ini = date('Y-m-j', strtotime(date("Y", strtotime($fechafirma)) . '-' . date("m", strtotime($fechafirma)) . '-' . 1));
        for ($i = 0; $i < $meses_contrato; $i++) {
            $mes = date("m", strtotime($fecha_ini));
            $anio = date("Y", strtotime($fecha_ini));
            $fecha_ini = date("d-m-Y", strtotime("+1 month", strtotime($fecha_ini)));
            $pagos_mensuales_e = DB::table('adm_pagosarrendatarios')
                    ->where("id_publicacion", "=", $idp)
                    ->whereIn("idTipoPago", $tipos)
                    ->where("E_S", "=", "e")
                    ->where("id_inmueble", "=", $idinmueble)
                    ->where("mes", "=", $mes)
                    ->where("anio", "=", $anio)
                    ->sum('precio_en_pesos');
            $pagos_mensuales_s = DB::table('adm_pagosarrendatarios')
                    ->where("id_publicacion", "=", $idp)
                    ->whereIn("idTipoPago", $tipos)
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
            $delete=PagosMensualesArrendatarios::where("id_contratofinal","=",$idcontrato)
                    ->where("id_publicacion","=",$idp)
                    ->where("id_inmueble","=",$idinmueble)
                    ->where("mes","=",$mes)
                    ->where("anio","=",$anio)
                    ->delete();

            $pago_mensual = PagosMensualesArrendatarios::create([
                        'id_contratofinal' => $idcontrato,
                        'id_publicacion' => $idp,
                        'id_inmueble' => $idinmueble,
                        'fecha_iniciocontrato' => $fechafirma,
                        'mes' => $mes,
                        'anio' => $anio,
                        'subtotal_entrada' => $pagos_mensuales_e,
                        'subtotal_salida' => $pagos_mensuales_s,
                        'pago_a_arrendatario' => $pagar_a_propietario,
                        'pago_a_rentas' => $pagar_a_baquedano,
                        'id_creador' => Auth::user()->id,
                        'id_modificador' => Auth::user()->id,
                        'id_estado' => 1
            ]);

           
        }

        return redirect()->route('finalContratoArr.edit', [$idp, 0, 0, 4])
                        ->with('status', 'Pagos Generados con éxito ');
    }

    static function ValidaCh($idc){
        $chequesPendientes = DB::table('arrendatario_cheques')
        ->WhereNull('numero')->where('id_contrato','=',$idc)
        ->count();
        return $chequesPendientes;
       
    }

    public function muestra_cheque($id, $idpdf, $idpago){

        $chPropietario = DB::table('arrendatario_cheques')
                ->where("id_contrato", "=", $id)
                ->get();

        return view('finalContratoArr.cheque', compact('chPropietario','idpago','id','idpdf'));
    }

    public function act_cheque(Request $request,$id){


        for ($i = 0; $i < count($request->banco); $i++)
        {

            $actCh = DB::table('arrendatario_cheques')
                ->where("id_contrato", "=", $id)->where("correlativo", "=", $request->correlativo[$i])
                ->update([
                    "banco"      => $request->banco[$i],
                    "numero"     => $request->numero[$i],
                    "fecha_pago" => $request->fecha_pago[$i]
                ]);   
        }

       

     $contrato = ContratoFinalArr::find($id);


      $borradorPDF = DB::table('contratoborradorarrendatarios as b')
         ->where('b.id','=',$contrato->id_borrador)
         ->leftjoin('personas as p1','b.id_arrendatario','=','p1.id')
         ->leftjoin('inmuebles as i','b.id_inmueble','=','i.id')
         ->leftjoin('comunas as cc','p1.id_comuna','=','cc.comuna_id')
         ->leftjoin('servicios as s', 'b.id_servicios','=', 's.id')
         ->leftjoin('regions as rr','p1.id_region','=','rr.region_id')
         ->leftjoin('formasdepagos as fp','b.id_formadepago','=','fp.id')
         ->leftjoin('comisiones as c', 'b.id_comisiones', '=', 'c.id')
         ->leftjoin('flexibilidads as f', 'b.id_flexibilidad', '=', 'f.id')
         ->leftjoin('multas as m','b.id_multa','=','m.id')
         ->leftjoin('users as p2','b.id_creador','=','p2.id')
         ->leftjoin('comunas as cci','i.id_comuna','=','cci.comuna_id')
         ->leftjoin('contratoborradorarrendatariospdf as bp', 'b.id_arrendatario', '=', 'bp.id_b_arrendatario')
         ->select(DB::raw('b.id, CONCAT_WS(" ",p1.nombre,p1.apellido_paterno,p1.apellido_materno) as arrendatario, 
            CONCAT(s.descripcion, "  $",s.valor) as Servicio, 
            CONCAT(fp.descripcion, " Pie $", fp.pie, "  ", fp.cuotas, " Cuotas") as FormasDePago, 
            CONCAT(c.descripcion, " ", c.comision, " %") as comision, 
            f.descripcion as Flexibilidad ,
            b.valorarriendo ,
            CONCAT("Multa de ", m.valor ," % Equivalente a ", ROUND((valorarriendo * m.valor)/100,0)) as Multas,
            DATE_FORMAT(b.fecha_contrato, "%d/%m/%Y") as fecha, b.id_estado, p2.name as creador, b.id_arrendatario,i.id as id_inmueble,  b.detalle as bodyContrato, b.id_contrato as id_contrato, b.dia_pago as dia_pago_p, p1.profesion as profesion_p, p1.rut as rut_p, CONCAT_WS(" ",p1.direccion,p1.numero) as direccion_p, p1.telefono as telefono_p, p1.departamento as depto_p, cc.comuna_nombre as comuna_p, rr.region_nombre as region_p, i.rol as rol, CONCAT_WS(" ",i.direccion, i.numero) as direccion_i, i.departamento as depto_i, cci.comuna_nombre as comuna_i, i.dormitorio as dormitorio, i.bano as bano,
             CONCAT_WS(" ",p1.nombre,p1.apellido_paterno,p1.apellido_materno) as arrendatario ' ))
         ->first();


        $simulacion = DB::table('arrendatario_cheques as b')
         ->where('b.id_contrato','=',$contrato->id)
         ->get();

         

        $pdfnombre = DB::table('adm_contratofinalarrpdf')
        ->where('id_final','=',$contrato->id)->first();


        $pdf = new PdfController();
        $numero = rand();
        $pdf->pdfArrendatarioFinalAct($borradorPDF, $pdfnombre->nombre, $simulacion);
        // FIN PARA PDFsss

        return redirect()->route('finalContratoArr.edit', [$contrato->id_publicacion, $contrato->id_borrador, $request->idpdf, 1])
                        ->with('status', 'Contrato eliminado con éxito');
    }


}
