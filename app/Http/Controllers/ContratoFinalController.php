<?php

namespace App\Http\Controllers;

use App\ContratoFinal;
use App\ContratoBorrador;
use App\ContratoFinalPdf;
use Illuminate\Http\Request;
use DB;

class ContratoFinalController extends Controller
{


     public function crearContrato($idcb,$idpdf,$idu)
    {

        $ContratoBorrador=ContratoBorrador::find($idcb);
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

        $pdf->crontratoFinalPdf($borradorPDF);
        // FIN PARA PDFsss

        $finalpdf=ContratoFinalPdf::create([
                    "id_final" => $contratoFinal->id,
                    "nombre"      => $borradorPDF->id . $borradorPDF->direccion_i .'-FINAL.pdf',
                    "ruta"        => "uploads/pdf_final/",
                    "id_creador"  => $idu,
                ])->toArray();



        return redirect()->route('finalContrato.edit', [$ContratoBorrador->id_publicacion,$idcb,$idpdf])
         ->with('status', 'Borrador guardado con éxito');
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
    public function edit($idc,$idcb,$idpdf)
    {
       $borrador = DB::table('cap_publicaciones as c')
         ->leftjoin('personas as p1', 'c.id_propietario', '=', 'p1.id')
         ->leftjoin('inmuebles as i', 'c.id_inmueble', '=', 'i.id')
         ->leftjoin('personas as p2', 'c.id_creador', '=', 'p2.id')
         ->leftjoin('personas as p3', 'c.id_modificador', '=', 'p3.id')
         ->leftjoin('comunas as o', 'i.id_comuna', '=', 'o.comuna_id')
         ->leftjoin('portales as po', 'c.portal', '=', 'po.id')
         ->where('c.id','=',$idc)
         ->select(DB::raw('c.id as id_publicacion, p1.id as id_propietario, i.id as id_inmueble, CONCAT_WS(" ",i.direccion,"#",i.numero,"Depto.",i.departamento,o.comuna_nombre) as direccion, CONCAT_WS(" ",p1.nombre , p1.apellido_paterno, " Fono: " ,p1.telefono, " Email: " ,p1.email ) as propietario '))
         ->first();

         $finalIndex = DB::table('adm_contratofinal  as b')
         ->leftjoin('cap_publicaciones as cp', 'b.id_publicacion', '=', 'cp.id')
         ->leftjoin('adm_contratofinalpdf as bp', 'b.id', '=', 'bp.id_final')
            ->where('b.id_publicacion','=',$idc)

         ->select(DB::raw(' b.id , cp.id as id_publicacion,DATE_FORMAT(b.fecha_firma, "%d/%m/%Y") as fecha,b.id_estado,bp.nombre, bp.id as id_pdf'))
         ->get();

 

         return view('contratoFinal.edit',compact('borrador','finalIndex'));
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ContratoFinal  $contratoFinal
     * @return \Illuminate\Http\Response
     */
    public function destroy(ContratoFinal $contratoFinal)
    {
        //
    }
}
