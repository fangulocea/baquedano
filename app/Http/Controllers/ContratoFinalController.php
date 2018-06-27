<?php

namespace App\Http\Controllers;

use App\ContratoFinal;
use App\ContratoBorrador;
use App\ContratoFinalPdf;
use App\ContratoFinalDocs;
use App\Captacion;
use App\PagosPropietarios;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\File;

class ContratoFinalController extends Controller
{

    public function getContrato($id){
         $contrato = DB::table('adm_contratofinal  as b')
         ->leftjoin('cap_publicaciones as cp', 'b.id_publicacion', '=', 'cp.id')
         ->leftjoin('adm_contratofinalpdf as bp', 'b.id', '=', 'bp.id_final')
         ->leftjoin('borradores as br','b.id_borrador','=','br.id')
         ->leftjoin('comisiones as co','br.id_comisiones','=','co.id')
         ->leftjoin('flexibilidads as f','br.id_flexibilidad','=','f.id')
         ->where('b.id','=',$id)
        ->select(DB::raw(' co.comision,b.fecha_firma'))
         ->get()->first();
            return response()->json($contrato); 
    }

    public function getPagos($id){
         $contrato = DB::table('adm_pagospropietarios')
         ->where('id_contratofinal','=',$id)
         ->get();
            return response()->json($contrato); 
    }

     public function crearContrato($idcb,$idpdf,$idu)
    {


        $ContratoBorrador=ContratoBorrador::find($idcb);
        $captacion=Captacion::find($ContratoBorrador->id_publicacion)->update([
            "id_estado"=> 10
        ]);
        $contratoFinal=ContratoFinal::create([
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
         ->leftjoin('personas as p1', 'cp.id_propietario','=','p1.id')
         ->leftjoin('comunas as c1', 'p1.id_comuna','=','c1.comuna_id')
         ->leftjoin('inmuebles as i', 'cp.id_inmueble','=','i.id')
         ->leftjoin('comunas as c2', 'i.id_comuna','=','c2.comuna_id')
         ->leftjoin('regions as reg', 'p1.id_region','=', 'reg.region_id'  )
         ->leftjoin('contratos as con', 'b.id_contrato','=','con.id')
         ->where('b.id','=',$idcb)
         ->select(DB::raw(' b.id as id, n.razonsocial as n_n, s.nombre as n_s, c.nombre as n_c, f.nombre as n_f , cp.id as id_publicacion,DATE_FORMAT(b.fecha_gestion, "%d/%m/%Y") as fecha,
             CONCAT_WS(" ",p1.nombre,p1.apellido_paterno,p1.apellido_materno) as propietario,
             p1.rut as rut_p, CONCAT(p1.direccion," ", p1.numero) as direccion_p , c1.comuna_nombre as comuna_p, reg.region_nombre as region_p,
             CONCAT(i.direccion," ",i.numero) as direccion_i, i.departamento as depto_i, c2.comuna_nombre as comuna_i,
             i.dormitorio as dormitorio, i.bano as bano, i.bodega, i.piscina, i.precio, i.gastosComunes, 
             con.nombre, con.nombre as contrato, con.descripcion as deta_contrato,
             p1.profesion as profesion_p, p1.telefono as telefono_p, p1.departamento as depto_p,
             i.rol as rol, b.detalle_revision as bodyContrato'))->first();
        $pdf = new PdfController();
        $numero=rand();
        $pdf->crontratoFinalPdf($borradorPDF,$numero);
        // FIN PARA PDFsss

        $finalpdf=ContratoFinalPdf::create([
                    "id_final" => $contratoFinal->id,
                    "nombre"      => $numero . $borradorPDF->id . $borradorPDF->direccion_i .'-FINAL.pdf',
                    "ruta"        => "uploads/pdf_final/",
                    "id_creador"  => $idu,
                ])->toArray();
        return redirect()->route('finalContrato.edit', [$ContratoBorrador->id_publicacion,$idcb,$idpdf,1])
         ->with('status', 'Contrato Final guardado con éxito');
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         $publica = DB::table('cap_publicaciones as c')
         ->leftjoin('personas as p1', 'c.id_propietario', '=', 'p1.id')
         ->leftjoin('inmuebles as i', 'c.id_inmueble', '=', 'i.id')
         ->leftjoin('personas as p2', 'c.id_creador', '=', 'p2.id')
         ->leftjoin('personas as p3', 'c.id_modificador', '=', 'p3.id')
         ->leftjoin('comunas as o', 'i.id_comuna', '=', 'o.comuna_id')
         ->leftjoin('portales as po', 'c.portal', '=', 'po.id')
         ->where('c.id_estado','=',"7")
         ->Orwhere('c.id_estado','=',"10")
         ->select(DB::raw('c.id as id_publicacion, DATE_FORMAT(c.created_at, "%d/%m/%Y") as fecha_creacion, c.id_estado as id_estado, CONCAT_WS(" ",p1.nombre,p1.apellido_paterno,p1.apellido_materno) as Propietario, CONCAT(p2.nombre," ",p2.apellido_paterno," ",p2.apellido_materno) as Creador'),'p1.id as id_propietario','i.id as id_inmueble','i.direccion','i.numero','i.departamento', 'o.comuna_nombre','po.nombre as portal','p1.nombre as nom_p','p1.apellido_paterno as apep_p','p1.apellido_materno as apem_p','p2.nombre as nom_c','p2.apellido_paterno as apep_c','p2.apellido_materno as apem_c','p3.nombre as nom_m','p3.apellido_paterno as apep_m','p3.apellido_materno as apem_m')
         ->get();
         
         return view('contratoFinal.index',compact('publica'));
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
     * @param  \App\ContratoFinal  $contratoFinal
     * @return \Illuminate\Http\Response
     */
    public function show(ContratoFinal $contratoFinal)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ContratoFinal  $contratoFinal
     * @return \Illuminate\Http\Response
     */
    public function edit($idc,$idcb,$idpdf,$tab)
    {
       $borrador = DB::table('cap_publicaciones as c')
         ->leftjoin('personas as p1', 'c.id_propietario', '=', 'p1.id')
         ->leftjoin('inmuebles as i', 'c.id_inmueble', '=', 'i.id')
         ->leftjoin('personas as p2', 'c.id_creador', '=', 'p2.id')
         ->leftjoin('personas as p3', 'c.id_modificador', '=', 'p3.id')
         ->leftjoin('comunas as o', 'i.id_comuna', '=', 'o.comuna_id')
         ->leftjoin('portales as po', 'c.portal', '=', 'po.id')
         ->where('c.id','=',$idc)
         ->select(DB::raw('c.id as id_publicacion, p1.id as id_propietario, i.id as id_inmueble, CONCAT_WS(" ",i.direccion,"#",i.numero,"Depto.",i.departamento,o.comuna_nombre) as direccion, CONCAT_WS(" ",p1.nombre , p1.apellido_paterno, " Fono: " ,p1.telefono, " Email: " ,p1.email ) as propietario, i.precio, i.gastosComunes'))
         ->first();

         $finalIndex = DB::table('adm_contratofinal  as b')
         ->leftjoin('cap_publicaciones as cp', 'b.id_publicacion', '=', 'cp.id')
         ->leftjoin('adm_contratofinalpdf as bp', 'b.id', '=', 'bp.id_final')
            ->where('b.id_publicacion','=',$idc)

         ->select(DB::raw(' b.id ,b.id_borrador, cp.id as id_publicacion,b.fecha_firma as fecha,b.id_estado,bp.nombre, bp.id as id_pdf,b.id_notaria,b.alias'))
         ->get();

              $notaria = DB::table('notarias as n')
         ->where("n.estado","<>",0)
         ->select(DB::raw('n.id as id,n.razonsocial as nombre'))
         ->get();

   $documentos = DB::table('adm_contratofinaldocs as n')
         ->where("n.id_publicacion","=",$idc)
         ->get();
 $flag=0;

         return view('contratoFinal.edit',compact('borrador','finalIndex','notaria','documentos','flag','tab'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ContratoFinal  $contratoFinal
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ContratoFinal $contratoFinal)
    {
        //
    }

    public function asignarNotaria(Request $request, $id)
    {
        $now = new \DateTime();
        $fecha_creacion= $now->format('Y-m-d H:i:s');
        $contrato=ContratoFinal::where('id','=',$id)->update([
            "id_notaria"=>$request->id_notaria,
            "fecha_firma"=>$request->fecha_firma,
            "id_modificador"=>$request->id_modificador,
            "updated_at"=>$fecha_creacion,
            "alias"=>$request->alias,
            "id_estado"=> 7
       ]);
        $captacion=Captacion::find($request->id_publicacion)->update([
            "id_estado"=> 7
        ]);
         return redirect()->route('finalContrato.edit', [$request->id_publicacion,$request->id_borrador,$request->id_pdf,1])
         ->with('status', 'Contrato actualizado con éxito');  
    }

    public function destroy($id,$idpdf)
    {
        $pdf=ContratoFinalPdf::find($idpdf);
        File::delete($pdf->ruta.'/'.$pdf->nombre);
        $pdf=ContratoFinalPdf::find($idpdf)->delete();
        $contrato = ContratoFinal::find($id);
        $borrar = ContratoFinal::find($id)->delete();

        $cant = ContratoFinal::where("id_publicacion","=",$contrato->id_publicacion)->get();
        if(count($cant)==0){
                $captacion=Captacion::find($contrato->id_publicacion)->update([
                    "id_estado"=> 6
                ]);
        }
         return redirect()->route('finalContrato.edit', [$contrato->id_publicacion,$contrato->id_borrador,$idpdf,1])
         ->with('status', 'Contrato eliminado con éxito'); 
    }     

    public function savedocs(Request $request, $id){
         if(!isset($request->foto)){
            return redirect()->route('finalContrato.edit', $id)->with('error', 'Debe seleccionar archivo');
         }

        $destinationPath='uploads/contratofinaldocs';
        $archivo=rand().$request->foto->getClientOriginalName();
        $file = $request->file('foto');
        $file->move($destinationPath,$archivo);

                $imagen=ContratoFinalDocs::create([
                            'id_final'             => $request->id_final,
                            'id_publicacion'       => $request->id_publicacion,
                            'tipo'                 => $request->tipo,
                            'nombre'               => $archivo,
                            'ruta'                 => $destinationPath,
                            'id_creador'           => $request->id_creador
                        ]);


        return redirect()->route('finalContrato.edit', [$request->id_publicacion,0,0,2])->with('status', 'Documento guardada con éxito');
    }

    public function eliminarfoto($idf){

        $imagen=ContratoFinalDocs::find($idf);

        File::delete($imagen->ruta.'/'.$imagen->nombre);
        $foto = ContratoFinalDocs::find($idf)->delete();

        return redirect()->route('finalContrato.edit', [$imagen->id_publicacion,0,0,2])->with('status', 'Documento eliminado con éxito');
    }



    public function generarpagos(Request $request, $idp)
    {

        //general
        $idcontrato=$request->id_final_pagos;
        $cant_meses=$request->cant_meses;
        $fechafirma=$request->fecha_firmapago;
        $tipomoneda=$request->moneda;
        $valormoneda=$request->valormoneda;



        //pagos
        $gastocomun=$request->gastocomun;
        $arriendo=$request->precio;
        $comision=$request->comision;
        $mes_comision=$request->mes_comision;
        $porcentaje=$request->porcentaje;
        $mes_porcentaje=$request->mes_porcentaje;
        $pagonotaria=$request->pagonotaria;
        $mes_notaria=$request->mes_notaria;
        $nombre_otropago=$request->nombre_otropago;
        $pagootro=$request->pagootro;
        $mes_otro=$request->mes_otro;
        $id_creador=$request->id_creador;
        $now = new \DateTime();
        $fecha_creacion= $now->format('Y-m-d H:i:s');

        //gasto comun
        if(isset($gastocomun)){
                    if($tipomoneda=='UF'){
                      $precio_en_pesos=  $gastocomun * $valormoneda;
                    }else{
                        $precio_en_pesos=$gastocomun;
                    }
                    $fecha_ini=$fechafirma;
                for ($i=0; $i < $cant_meses; $i++) { 

                        $dia=date("d", strtotime($fecha_ini));
                        $mes=date("m", strtotime($fecha_ini));
                        $anio=date("Y", strtotime($fecha_ini));
                        $fecha_ini=date("d-m-Y", strtotime("+1 month", strtotime($fecha_ini)));

                       $pago=PagosPropietarios::create([
                        'id_contratofinal'=>$idcontrato,
                        'id_publicacion'=> $idp,
                        'tipopago' => "Gasto Común",
                        'fecha_iniciocontrato' => $fechafirma,
                        'dia' =>$dia ,
                        'mes' => $mes,
                        'anio'=> $anio,
                        'cant_diasmes'=> cal_days_in_month(CAL_GREGORIAN, date("m", strtotime($fechafirma)), date("Y", strtotime($fechafirma))),
                        'cant_diasproporcional'=> cal_days_in_month(CAL_GREGORIAN, date("m", strtotime($fechafirma)), date("Y", strtotime($fechafirma)))-date("d", strtotime($fechafirma)),
                        'moneda'=>$tipomoneda,
                        'valormoneda'=>$valormoneda,
                        'precio_en_moneda'=>$gastocomun,
                        'precio_en_pesos' => $gastocomun * $valormoneda,
                        'id_creador'=>$id_creador,
                        'id_modificador'=>$id_creador,
 //                       'created_at'  => $fecha_creacion,
                        'id_estado'=>1,
                        'gastocomun'=>$gastocomun,
                        'canondearriendo'=>$arriendo
                       ]);

                       
                }
        }
         //arriendo
                if(isset($arriendo)){
                    if($tipomoneda=='UF'){
                      $precio_en_pesos=  $arriendo * $valormoneda;
                    }else{
                        $precio_en_pesos=$arriendo;
                    }
                    $fecha_ini=$fechafirma;
                for ($i=0; $i < $cant_meses; $i++) { 

                        $dia=date("d", strtotime($fecha_ini));
                        $mes=date("m", strtotime($fecha_ini));
                        $anio=date("Y", strtotime($fecha_ini));
                        $fecha_ini=date("d-m-Y", strtotime("+1 month", strtotime($fecha_ini)));

                       $pago=PagosPropietarios::create([
                        'id_contratofinal'=>$idcontrato,
                        'id_publicacion'=> $idp,
                        'tipopago' => "Canon de Arriendo",
                        'fecha_iniciocontrato' => $fechafirma,
                        'dia' =>$dia ,
                        'mes' => $mes,
                        'anio'=> $anio,
                        'cant_diasmes'=> cal_days_in_month(CAL_GREGORIAN, date("m", strtotime($fechafirma)), date("Y", strtotime($fechafirma))),
                        'cant_diasproporcional'=> cal_days_in_month(CAL_GREGORIAN, date("m", strtotime($fechafirma)), date("Y", strtotime($fechafirma)))-date("d", strtotime($fechafirma)),
                        'moneda'=>$tipomoneda,
                        'valormoneda'=>$valormoneda,
                        'precio_en_moneda'=>$arriendo,
                        'precio_en_pesos' => $arriendo * $valormoneda,
                        'id_creador'=>$id_creador,
                        'id_modificador'=>$id_creador,
 //                       'created_at'  => $fecha_creacion,
                        'id_estado'=>1,
                        'gastocomun'=>$gastocomun,
                        'canondearriendo'=>$arriendo
                       ]);

                       
                }
        }
         return redirect()->route('finalContrato.edit', [$idp,0,0,3])
         ->with('status', 'Pagos Generados con éxito');  
    }

}