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
use App\PagosMensualesArrendatarios;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\File;
use Auth;

class ContratoFinalArrController extends Controller
{

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
            "id_borradorpdf" => $pdfBorradorArrendatario->id  //contrato borrador PDF
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
            CONCAT(m.descripcion, " ", m.tipo_multa,m.valor ) as Multas, 
            DATE_FORMAT(b.fecha_contrato, "%d/%m/%Y") as fecha, b.id_estado, p2.name as creador, b.id_arrendatario,i.id as id_inmueble,  b.detalle as bodyContrato, b.id_contrato as id_contrato, b.dia_pago as dia_pago_p, p1.profesion as profesion_p, p1.rut as rut_p, CONCAT_WS(" ",p1.direccion,p1.numero) as direccion_p, p1.telefono as telefono_p, p1.departamento as depto_p, cc.comuna_nombre as comuna_p, rr.region_nombre as region_p, i.rol as rol, CONCAT_WS(" ",i.direccion, i.numero) as direccion_i, i.departamento as depto_i, cci.comuna_nombre as comuna_i, i.dormitorio as dormitorio, i.bano as bano,
             CONCAT_WS(" ",p1.nombre,p1.apellido_paterno,p1.apellido_materno) as arrendatario ' ))
         ->first();

        $pdf = new PdfController();
        $numero=rand();
        $pdf->pdfArrendatarioFinal($borradorPDF,$numero);
        // FIN PARA PDFsss
        $finalpdf=ContratoFinalArrPdf::create([
                    "id_final"    => $contratoFinal->id,
                    "nombre"      => $numero . $borradorPDF->id . $borradorPDF->direccion_i .'-FINAL.pdf',
                    "ruta"        => "uploads/pdfarrfinal/",
                    "id_creador"  => $request->id_creadorfinal,
                ])->toArray();
        return redirect()->route('finalContratoArr.edit', [$ContratoBorradorArrendatario->id_cap_arr,$idCbA,$idCbA,1])
         ->with('status', 'Contrato Final guardado con éxito');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    

    $meses=DB::table('arrendatarios as c')->select(DB::raw('CONCAT(MONTH(DATE_ADD(now(), INTERVAL -6 MONTH)),"/",YEAR(DATE_ADD(now(), INTERVAL -6 MONTH))) as mesanterior6,
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
                ->select(DB::raw('cb.dia_pago, c.id as id_publicacion, DATE_FORMAT(c.created_at, "%d/%m/%Y") as fecha_creacion, c.id_estado as id_estado, CONCAT_WS(" ",p1.nombre,p1.apellido_paterno,p1.apellido_materno) as Propietario, p2.name as Creador,

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
            ->where('b.id_publicacion','=',$idc)

         ->select(DB::raw(' b.id ,b.id_borrador, cp.id as id_publicacion,b.fecha_firma as fecha,b.id_estado,bp.nombre, bp.id as id_pdf,b.id_notaria,b.alias'))
         ->get();

              $notaria = DB::table('notarias as n')
         ->where("n.estado","<>",0)
         ->select(DB::raw('n.id as id,n.razonsocial as nombre'))
         ->get();

   $documentos = DB::table('adm_contratofinalarrdocs as n')
         ->where("n.id_publicacion","=",$idc)
         ->get();
 $flag=0;

         return view('finalContratoArr.edit',compact('borrador','finalIndex','notaria','documentos','flag','tab'));
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

public function eliminartipopago($idc, $idt) {
        $p1 = PagosArrendatarios::where("id_contratofinal", "=", $idc)
                ->first();
        $idinmueble=$p1->id_inmueble;
        $PagosArrendatarios = PagosArrendatarios::where("id_contratofinal", "=", $idc)
                ->where("idtipopago", "=", $idt)
                ->delete();
        $p = PagosArrendatarios::where("id_contratofinal", "=", $idc)
                ->first();
        if (isset($p)) {
            $fecha_ini = date('Y-m-j', strtotime(date("Y", strtotime($p->fecha_iniciocontrato)) . '-' . date("m", strtotime($p->fecha_iniciocontrato)) . '-' . 1));
            for ($i = 0; $i < $p->meses_contrato; $i++) {
                $mes = date("m", strtotime($fecha_ini));
                $anio = date("Y", strtotime($fecha_ini));
                $fecha_ini = date("d-m-Y", strtotime("+1 month", strtotime($fecha_ini)));
                $pagos_mensuales_e = PagosArrendatarios::where("id_contratofinal", "=", $idc)
                        ->where("E_S", "=", "e")
                        ->where("mes", "=", $mes)
                        ->where("anio", "=", $anio)
                        ->sum('precio_en_pesos');
                $pagos_mensuales_s = PagosArrendatarios::where("id_contratofinal", "=", $idc)
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

            $pago_mensual = PagosMensualesArrendatarios::
                    where("id_contratofinal", "=", $idc)
                    ->where("mes", "=", $mes)
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
        }else{
            $pago_mensual = PagosMensualesArrendatarios::where("id_contratofinal", "=", $idc)->delete();
        }
        return redirect()->route('finalContratoArr.edit', [$p1->id_publicacion, 0, 0, 4])->with('status', 'Tipo Pago eliminado con éxito');
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

        //general
        $arrend=Arrendatario::find($idp);
        $idinmueble=$arrend->id_inmueble;
        $idcontrato = $request->id_final_pagos;

        $contrato = ContratoFinalArr::where('id', '=', $idcontrato)->update([
            "meses_contrato" => $request->cant_meses
        ]);
        $cant_meses = $request->cant_meses;
        $meses_contrato = $request->cant_meses;
        $fechafirma = $request->fecha_firmapago;
        $tipomoneda = $request->moneda;
        $valormoneda = $request->valormoneda;
        $fecha_ini = date('Y-m-j', strtotime(date("Y", strtotime($fechafirma)) . '-' . date("m", strtotime($fechafirma)) . '-' . 1));
        $fecha_ini2 = $fechafirma;
        $dia_original = date("d", strtotime($fechafirma));
        $arriendo = $request->precio;
        $reserva=$request->reserva;
        $comision = $request->comision;
        $mes_comision = $request->mes_comision;
        $comisionmensual = $request->comisionmensual;
        $mes_comisionmensual = $request->mes_comisionmensual;
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
        $mes_garantia=$request->mes_garantia;
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

        $reserva_reg = PagosArrendatarios::where("id_publicacion", "=", $idp)->where("idtipopago", "=", 1)
        ->get();
        $arriendo_reg = PagosArrendatarios::where("id_publicacion", "=", $idp)->where("idtipopago", "=", 2)       
        ->get();
        $garantia_reg = PagosArrendatarios::where("id_publicacion", "=", $idp)->where("idtipopago", "=", 4)                   
        ->get();
        $iva_reg = PagosArrendatarios::where("id_publicacion", "=", $idp)->where("idtipopago", "=", 3)
        ->get();
        $pie_reg = PagosArrendatarios::where("id_publicacion", "=", $idp)->where("idtipopago", "=", 5)
        ->get();
        $comisionmensual_reg = PagosArrendatarios::where("id_publicacion", "=", $idp)->where("idtipopago", "=", 6)
        ->get();
        $comision_reg = PagosArrendatarios::where("id_publicacion", "=", $idp)->where("idtipopago", "=", 7)
        ->get();
        $notaria_reg = PagosArrendatarios::where("id_publicacion", "=", $idp)->where("idtipopago", "=", 8)
        ->get();
        $otro1_reg = PagosArrendatarios::where("id_publicacion", "=", $idp)->where("idtipopago", "=", 9)
        ->get();
        $otro2_reg = PagosArrendatarios::where("id_publicacion", "=", $idp)->where("idtipopago", "=", 10)
        ->get();
        $otro3_reg = PagosArrendatarios::where("id_publicacion", "=", $idp)->where("idtipopago", "=", 11)
        ->get();

        //gasto comun

        $texto=", Pero No se han generado los siguientes items, ya que se encuentran ingresados en el sistema : ";
        if(count($reserva_reg)>0){
            $texto.=" Reserva, ";
        }
        if(count($arriendo_reg)>0){
             $texto.=" Canon de Arriendo, ";
        }
        if(count($iva_reg)>0){
             $texto.=" Iva, ";
        }
        if(count($garantia_reg)>0){
                 $texto.=" Garantía, ";
        }
        if(count($pie_reg)>0){
             $texto.=" Pie, ";
        }
        if(count($comision_reg)>0){
             $texto.=" Comisión total, ";
        }
        if(count($comisionmensual_reg)>0){
             $texto.=" Comisión Mensual, ";
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

//RESERVA
        if (isset($reserva) && count($reserva_reg) == 0) {
            $idtipopago = 1;
            $dias_mes = cal_days_in_month(CAL_GREGORIAN, date("m", strtotime($fecha_ini2)), date("Y", strtotime($fecha_ini2)));
            $valor_en_pesos = $reserva * $valormoneda;
            $ini = 0;

                $dia = date("d", strtotime($fecha_ini));
                $mes = date("m", strtotime($fecha_ini));
                $anio = date("Y", strtotime($fecha_ini));
                $dias_mes = cal_days_in_month(CAL_GREGORIAN, date("m", strtotime($fecha_ini)), date("Y", strtotime($fecha_ini)));
                $fecha_ini = date("d-m-Y", strtotime("+1 month", strtotime($fecha_ini)));

                $pago = PagosArrendatarios::create([
                            'id_contratofinal' => $idcontrato,
                            'meses_contrato' => $meses_contrato,
                            'id_publicacion' => $idp,
                            'tipopago' => "Reserva",
                            'idtipopago' => $idtipopago,
                            'E_S' => $request->re_radio,
                            'id_inmueble' => $idinmueble,
                            'fecha_iniciocontrato' => $fechafirma,
                            'dia' => $dia,
                            'mes' => $mes,
                            'anio' => $anio,
                            'cant_diasmes' => $dias_mes,
                            'cant_diasproporcional' => $dias_mes,
                            'moneda' => $tipomoneda,
                            'valormoneda' => $valormoneda,
                            'valordia' => 1,
                            'precio_en_moneda' => $reserva,
                            'precio_en_pesos' => ceil($reserva * $valormoneda),
                            'id_creador' => $id_creador,
                            'id_modificador' => $id_creador,
                            'id_estado' => 1,
                            'canondearriendo' => $arriendo
                ]);
            
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

                $pago = PagosArrendatarios::create([
                            'id_contratofinal' => $idcontrato,
                            'meses_contrato' => $meses_contrato,
                            'id_publicacion' => $idp,
                            'tipopago' => "Canon de Arriendo",
                            'idtipopago' => $idtipopago,
                            'E_S' => $request->ar_radio,
                            'id_inmueble' => $idinmueble,
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
                $pago = PagosArrendatarios::create([
                            'id_contratofinal' => $idcontrato,
                            'meses_contrato' => $meses_contrato,
                            'id_publicacion' => $idp,
                            'tipopago' => "Canon de Arriendo",
                            'E_S' => $request->ar_radio,
                            'id_inmueble' => $idinmueble,
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
                            'canondearriendo' => $arriendo
                ]);
            }
        }


$fecha_ini = date('Y-m-j', strtotime(date("Y", strtotime($fechafirma)) . '-' . date("m", strtotime($fechafirma)) . '-' . 1));
        //IVA
        if (isset($iva) && count($iva_reg) == 0) {
            $idtipopago = 3;
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

                $pago = PagosArrendatarios::create([
                            'id_contratofinal' => $idcontrato,
                            'meses_contrato' => $meses_contrato,
                            'id_publicacion' => $idp,
                            'tipopago' => "IVA",
                            'id_inmueble' => $idinmueble,
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
                            'canondearriendo' => $arriendo
                ]);
            }
            for ($i = $ini; $i < $mes_iva; $i++) {

                $dia = date("d", strtotime($fecha_ini));
                $mes = date("m", strtotime($fecha_ini));
                $anio = date("Y", strtotime($fecha_ini));
                $dias_mes = cal_days_in_month(CAL_GREGORIAN, date("m", strtotime($fecha_ini)), date("Y", strtotime($fecha_ini)));
                $fecha_ini = date("d-m-Y", strtotime("+1 month", strtotime($fecha_ini)));

                $pago = PagosArrendatarios::create([
                            'id_contratofinal' => $idcontrato,
                            'meses_contrato' => $meses_contrato,
                            'id_publicacion' => $idp,
                            'tipopago' => "IVA",
                            'E_S' => $request->iva_radio,
                            'idtipopago' => $idtipopago,
                            'fecha_iniciocontrato' => $fechafirma,
                            'id_inmueble' => $idinmueble,
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
                            'canondearriendo' => $arriendo
                ]);
            }
        }

        $fecha_ini = date('Y-m-j', strtotime(date("Y", strtotime($fechafirma)) . '-' . date("m", strtotime($fechafirma)) . '-' . 1));
        //GARANTIA
        if (isset($garantia) && count($garantia_reg) == 0) {
            $idtipopago = 4;
            $dias_mes = cal_days_in_month(CAL_GREGORIAN, date("m", strtotime($fecha_ini)), date("Y", strtotime($fecha_ini)));
            $valor_diario = 1;
            $dias_proporcionales = cal_days_in_month(CAL_GREGORIAN, date("m", strtotime($fecha_ini)), date("Y", strtotime($fecha_ini))) - date("d", strtotime($fecha_ini)) + 1;
            $precio_proporcional = $iva;
            $valor_en_pesos = $garantia;
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
                            'meses_contrato' => $meses_contrato,
                            'id_publicacion' => $idp,
                            'tipopago' => "GARANTÍA",
                            'idtipopago' => $idtipopago,
                            'id_inmueble' => $idinmueble,
                            'fecha_iniciocontrato' => $fechafirma,
                            'dia' => $dia,
                            'mes' => $mes,
                            'anio' => $anio,
                            'E_S' => $request->gar_radio,
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

            $pago = PagosArrendatarios::create([
                        'id_contratofinal' => $idcontrato,
                        'meses_contrato' => $meses_contrato,
                        'id_publicacion' => $idp,
                        'tipopago' => "Pie Comisión",
                        'id_inmueble' => $idinmueble,
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
                        'canondearriendo' => $arriendo
            ]);
        }

        $fecha_ini = date('Y-m-j', strtotime(date("Y", strtotime($fechafirma)) . '-' . date("m", strtotime($fechafirma)) . '-' . 1));
        //Comisión mensual
        if (isset($comisionmensual) && count($comisionmensual_reg) == 0) {
            $idtipopago = 6;
            $dias_mes = cal_days_in_month(CAL_GREGORIAN, date("m", strtotime($fecha_ini)), date("Y", strtotime($fecha_ini)));
            $valor_diario = 1;
            $dias_proporcionales = cal_days_in_month(CAL_GREGORIAN, date("m", strtotime($fecha_ini)), date("Y", strtotime($fecha_ini))) - date("d", strtotime($fecha_ini)) + 1;
            $precio_proporcional = $comisionmensual;
            $valor_en_pesos = $comisionmensual;
            $ini = 0;
            $fecha_ini = date("d-m-Y", strtotime("+1 month", strtotime($fecha_ini)));
            if ($dias_proporcionales > 0) {
                $ini = 1;
                $dia = date("d", strtotime($fecha_ini));
                $mes = date("m", strtotime($fecha_ini));
                $anio = date("Y", strtotime($fecha_ini));
                $dias_mes = cal_days_in_month(CAL_GREGORIAN, date("m", strtotime($fecha_ini)), date("Y", strtotime($fecha_ini)));
                $fecha_ini = date("d-m-Y", strtotime("+1 month", strtotime($fecha_ini)));

                $pago = PagosArrendatarios::create([
                            'id_contratofinal' => $idcontrato,
                            'meses_contrato' => $meses_contrato,
                            'id_publicacion' => $idp,
                            'tipopago' => "Comisión Mensual",
                            'E_S' => $request->cm_radio,
                            'id_inmueble' => $idinmueble,
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
                            'canondearriendo' => $arriendo
                ]);
            }
            for ($i = $ini; $i < $mes_comisionmensual; $i++) {

                $dia = date("d", strtotime($fecha_ini));
                $mes = date("m", strtotime($fecha_ini));
                $anio = date("Y", strtotime($fecha_ini));
                $dias_mes = cal_days_in_month(CAL_GREGORIAN, date("m", strtotime($fecha_ini)), date("Y", strtotime($fecha_ini)));
                $fecha_ini = date("d-m-Y", strtotime("+1 month", strtotime($fecha_ini)));

                $pago = PagosArrendatarios::create([
                            'id_contratofinal' => $idcontrato,
                            'meses_contrato' => $meses_contrato,
                            'id_publicacion' => $idp,
                            'tipopago' => "Comisión Mensual",
                            'idtipopago' => $idtipopago,
                            'id_inmueble' => $idinmueble,
                            'fecha_iniciocontrato' => $fechafirma,
                            'E_S' => $request->cm_radio,
                            'dia' => $dia,
                            'mes' => $mes,
                            'anio' => $anio,
                            'cant_diasmes' => $dias_mes,
                            'cant_diasproporcional' => $dias_mes,
                            'moneda' => 'CLP',
                            'valormoneda' => 1,
                            'valordia' => $valor_diario,
                            'precio_en_moneda' => $comisionmensual,
                            'precio_en_pesos' => ceil($comisionmensual * $valormoneda),
                            'id_creador' => $id_creador,
                            'id_modificador' => $id_creador,
                            'id_estado' => 1,
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

            $pago = PagosArrendatarios::create([
                        'id_contratofinal' => $idcontrato,
                        'meses_contrato' => $meses_contrato,
                        'id_publicacion' => $idp,
                        'tipopago' => "Comisión Total",
                        'idtipopago' => $idtipopago,
                        'E_S' => $request->co_radio,
                        'id_inmueble' => $idinmueble,
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

            $pago = PagosArrendatarios::create([
                        'id_contratofinal' => $idcontrato,
                        'meses_contrato' => $meses_contrato,
                        'id_publicacion' => $idp,
                        'tipopago' => "Notaría",
                        'idtipopago' => $idtipopago,
                        'E_S' => $request->no_radio,
                        'id_inmueble' => $idinmueble,
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

                $pago = PagosArrendatarios::create([
                            'id_contratofinal' => $idcontrato,
                            'meses_contrato' => $meses_contrato,
                            'id_publicacion' => $idp,
                            'tipopago' => $nombre_otropago1,
                            'E_S' => $request->o1_radio,
                            'id_inmueble' => $idinmueble,
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
                            'canondearriendo' => $arriendo
                ]);
            }
            for ($i = $ini; $i < $mes_otro1; $i++) {

                $dia = date("d", strtotime($fecha_ini));
                $mes = date("m", strtotime($fecha_ini));
                $anio = date("Y", strtotime($fecha_ini));
                $dias_mes = cal_days_in_month(CAL_GREGORIAN, date("m", strtotime($fecha_ini)), date("Y", strtotime($fecha_ini)));
                $fecha_ini = date("d-m-Y", strtotime("+1 month", strtotime($fecha_ini)));

                $pago = PagosArrendatarios::create([
                            'id_contratofinal' => $idcontrato,
                            'meses_contrato' => $meses_contrato,
                            'id_publicacion' => $idp,
                            'tipopago' => $nombre_otropago1,
                            'idtipopago' => $idtipopago,
                            'fecha_iniciocontrato' => $fechafirma,
                            'E_S' => $request->o1_radio,
                            'id_inmueble' => $idinmueble,
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

                $pago = PagosArrendatarios::create([
                            'id_contratofinal' => $idcontrato,
                            'meses_contrato' => $meses_contrato,
                            'id_publicacion' => $idp,
                            'tipopago' => $nombre_otropago2,
                            'id_inmueble' => $idinmueble,
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
                            'canondearriendo' => $arriendo
                ]);
            }
            for ($i = $ini; $i < $mes_otro1; $i++) {

                $dia = date("d", strtotime($fecha_ini));
                $mes = date("m", strtotime($fecha_ini));
                $anio = date("Y", strtotime($fecha_ini));
                $dias_mes = cal_days_in_month(CAL_GREGORIAN, date("m", strtotime($fecha_ini)), date("Y", strtotime($fecha_ini)));
                $fecha_ini = date("d-m-Y", strtotime("+1 month", strtotime($fecha_ini)));

                $pago = PagosArrendatarios::create([
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

                $pago = PagosArrendatarios::create([
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
                            'canondearriendo' => $arriendo
                ]);
            }
            for ($i = $ini; $i < $mes_otro1; $i++) {

                $dia = date("d", strtotime($fecha_ini));
                $mes = date("m", strtotime($fecha_ini));
                $anio = date("Y", strtotime($fecha_ini));
                $dias_mes = cal_days_in_month(CAL_GREGORIAN, date("m", strtotime($fecha_ini)), date("Y", strtotime($fecha_ini)));
                $fecha_ini = date("d-m-Y", strtotime("+1 month", strtotime($fecha_ini)));

                $pago = PagosArrendatarios::create([
                            'id_contratofinal' => $idcontrato,
                            'meses_contrato' => $meses_contrato,
                            'id_publicacion' => $idp,
                            'tipopago' => $nombre_otropago3,
                            'id_inmueble' => $idinmueble,
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
                            'canondearriendo' => $arriendo
                ]);
            }
        }

        $fecha_ini = date('Y-m-j', strtotime(date("Y", strtotime($fechafirma)) . '-' . date("m", strtotime($fechafirma)) . '-' . 1));
        for ($i = 0; $i < $meses_contrato; $i++) {
            $mes = date("m", strtotime($fecha_ini));
            $anio = date("Y", strtotime($fecha_ini));
            $fecha_ini = date("d-m-Y", strtotime("+1 month", strtotime($fecha_ini)));
            $pagos_mensuales_e = DB::table('adm_pagosarrendatarios')
                    ->where("id_publicacion", "=", $idp)
                    ->where("id_inmueble","=", $idinmueble)
                    ->where("E_S", "=", "e")
                    ->where("mes", "=", $mes)
                    ->where("anio", "=", $anio)
                    ->sum('precio_en_pesos');
            $pagos_mensuales_s = DB::table('adm_pagosarrendatarios')
                    ->where("id_publicacion", "=", $idp)
                    ->where("id_inmueble","=", $idinmueble)
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
//dd($pagar_a_arrendatario."    ".$pagar_a_baquedano."       e:".$pagos_mensuales_e."        s:".$pagos_mensuales_s );
            $delete=PagosMensualesArrendatarios::where("id_contratofinal","=",$idcontrato)
                    ->where("id_publicacion","=",$idp)
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
                        'pago_a_arrendatario' => $pagar_a_arrendatario,
                        'pago_a_rentas' => $pagar_a_baquedano,
                        'id_creador' => Auth::user()->id,
                        'id_modificador' => Auth::user()->id,
                        'id_estado' => 1
            ]);

           
        }
        if($texto=="Pero no fue posible generar nuevamente los siguientes items, ya que deben ser borrados primero : "){
            $texto="";
        }
        return redirect()->route('finalContratoArr.edit', [$idp, 0, 0, 4])
                        ->with('status', 'Pagos Generados con éxito '.$texto);
    }

}
