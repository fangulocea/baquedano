<?php

namespace App\Http\Controllers;

use App\ContratoFinalArr;
use App\ContratoBorradorArrendatario;
use App\ContratoFinalPdf;
use App\ContratoFinalDocs;
use App\ContratoFinalArrPdf;
use App\ContratoFinalArrDocs;
use App\Arrendatario;
use App\PagosPropietarios;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\File;

class ContratoFinalArrController extends Controller
{
     public function crearContrato($idArr,$idCbA,$idu)
    {
      
      $ContratoBorradorArrendatario=ContratoBorradorArrendatario::find($idCbA);



      $pdfBorradorArrendatario = DB::table('contratoborradorarrendatariospdf as pdf')
        ->where("pdf.id_b_arrendatario","=",$idCbA)
        ->select(DB::raw('pdf.id as id'))
        ->first();  

      $captacionArrendatario=Arrendatario::find($idArr)->update([
            "id_estado"=> 10
        ]);

      $contratoBorrador = ContratoBorradorArrendatario::find($idCbA)->update([
            "id_estado"=> 10
        ]);

      $contratoFinal=ContratoFinalArr::create([
            "id_publicacion" => $idArr, //arrendatarios
            "id_estado"      => 1,
            "id_creador"     => $idu,
            "id_borrador"    => $idCbA, //contrato borrador arrendatario
            "id_borradorpdf" => $pdfBorradorArrendatario->id  //contrato borrador PDF
      ]);
      // //PARA PDF
      $borradorPDF = DB::table('contratoborradorarrendatarios as b')
         ->where('b.id','=',$idCbA)
         ->leftjoin('personas as p1','b.id_arrendatario','=','p1.id')
         ->leftjoin('inmuebles as i','b.id_inmueble','=','i.id')
         ->leftjoin('comunas as cc','p1.id_comuna','=','cc.comuna_id')
         ->leftjoin('servicios as s', 'b.id_servicios','=', 's.id')
         ->leftjoin('regions as rr','p1.id_region','=','rr.region_id')
         ->leftjoin('formasdepagos as fp','b.id_formadepago','=','fp.id')
         ->leftjoin('comisiones as c', 'b.id_comisiones', '=', 'c.id')
         ->leftjoin('flexibilidads as f', 'b.id_flexibilidad', '=', 'f.id')
         ->leftjoin('multas as m','b.id_multa','=','m.id')
         ->leftjoin('personas as p2','b.id_creador','=','p2.id')
         ->leftjoin('comunas as cci','i.id_comuna','=','cci.comuna_id')
         ->leftjoin('contratoborradorarrendatariospdf as bp', 'b.id_arrendatario', '=', 'bp.id_b_arrendatario')
         ->select(DB::raw('b.id, CONCAT_WS(" ",p1.nombre,p1.apellido_paterno,p1.apellido_materno) as arrendatario, 
            CONCAT(s.descripcion, "  $",s.valor) as Servicio, 
            CONCAT(fp.descripcion, " Pie $", fp.pie, "  ", fp.cuotas, " Cuotas") as FormasDePago, 
            CONCAT(c.descripcion, " ", c.comision, " %") as comision, 
            f.descripcion as Flexibilidad ,
            b.valorarriendo ,
            CONCAT(m.descripcion, " ", m.tipo_multa,m.valor ) as Multas, 
            DATE_FORMAT(b.fecha_contrato, "%d/%m/%Y") as fecha, b.id_estado, CONCAT_WS(" ", p2.nombre,p2.apellido_paterno,p2.apellido_materno) as creador, b.id_arrendatario,i.id as id_inmueble,  b.detalle as bodyContrato, b.id_contrato as id_contrato, b.dia_pago as dia_pago_p, p1.profesion as profesion_p, p1.rut as rut_p, CONCAT_WS(" ",p1.direccion,p1.numero) as direccion_p, p1.telefono as telefono_p, p1.departamento as depto_p, cc.comuna_nombre as comuna_p, rr.region_nombre as region_p, i.rol as rol, CONCAT_WS(" ",i.direccion, i.numero) as direccion_i, i.departamento as depto_i, cci.comuna_nombre as comuna_i, i.dormitorio as dormitorio, i.bano as bano,
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
                    "id_creador"  => $idu,
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
        $publica = DB::table('arrendatarios as a')
         ->leftjoin('personas as pc', 'a.id_creador', 'pc.id')
         ->leftjoin('personas as pm', 'a.id_modificador', 'pm.id')
         ->leftjoin('personas as pa', 'a.id_arrendatario','pa.id')
         ->leftjoin('inmuebles as i','a.id_inmueble','i.id')
         ->leftjoin('comunas as c', 'i.id_comuna', '=', 'c.comuna_id')
         ->Where('a.id_estado','=',10)
         ->orWhere('a.id_estado','=',11 )
         ->select(DB::raw('a.id as id_cap_arr, CONCAT_WS(" ",pa .nombre,pa.apellido_paterno,pa.apellido_materno) as arrendatario,i.direccion,i.numero,c.comuna_nombre as comuna,a.id_estado, a.id_arrendatario as id_arrendatario'))
         ->get();

        return view('finalContratoArr.index',compact('publica'));
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
         ->leftjoin('personas as pc', 'a.id_creador', 'pc.id')
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

}
