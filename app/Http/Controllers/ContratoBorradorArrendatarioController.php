<?php

namespace App\Http\Controllers;

use App\ContratoBorradorArrendatario;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use DateTime;
use URL;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\File;    
use Illuminate\Support\Facades\Mail;
use App\ContratoBorradorArrendatarioPdf;



class ContratoBorradorArrendatarioController extends Controller
{
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
         ->where('a.id_estado','=',2)
         ->select(DB::raw('a.id as id, CONCAT_WS(" ",pa .nombre,pa.apellido_paterno,pa.apellido_materno) as arrendatario,i.direccion,i.numero,c.comuna_nombre as comuna,a.id_estado, a.id_arrendatario as id_arrendatario'))
         ->get();
         
        return view('contratoborradorarrendatario.index',compact('publica'));
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
     * @param  \App\ContratoBorradorArrendatario  $contratoBorradorArrendatario
     * @return \Illuminate\Http\Response
     */
    public function show(ContratoBorradorArrendatario $contratoBorradorArrendatario)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ContratoBorradorArrendatario  $contratoBorradorArrendatario
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $publica = DB::table('arrendatarios as a')
         ->leftjoin('personas as pc', 'a.id_creador', 'pc.id')
         ->leftjoin('personas as pm', 'a.id_modificador', 'pm.id')
         ->leftjoin('personas as pa', 'a.id_arrendatario','pa.id')
         ->leftjoin('inmuebles as i','a.id_inmueble','i.id')
         ->leftjoin('comunas as c', 'i.id_comuna', '=', 'c.comuna_id')
         ->where('a.id_arrendatario','=',$id)
         ->select(DB::raw('a.id , CONCAT_WS(" ",pa.nombre,pa.apellido_paterno,pa.apellido_materno) as arrendatario,i.direccion,i.numero,c.comuna_nombre as comuna,a.id_estado, a.id_arrendatario as id_arrendatario,i.id as id_inmueble'))
         ->first();

         $borradoresIndex = DB::table('contratoborradorarrendatarios as b')
         ->leftjoin('personas as p1','b.id_arrendatario','=','p1.id')
         ->leftjoin('contratos as con','b.id_contrato','=','con.id')
         ->leftjoin('inmuebles as i','b.id_inmueble','=','i.id')
         ->leftjoin('servicios as s', 'b.id_servicios','=', 's.id')
         ->leftjoin('formasdepagos as fp','b.id_formadepago','=','fp.id')
         ->leftjoin('comisiones as c', 'b.id_comisiones', '=', 'c.id')
         ->leftjoin('flexibilidads as f', 'b.id_flexibilidad', '=', 'f.id')
         ->leftjoin('multas as m','b.id_multa','=','m.id')
         ->leftjoin('personas as p2','b.id_creador','=','p2.id')
         ->leftjoin('contratoborradorarrendatariospdf as bp', 'b.id', '=', 'bp.id_b_arrendatario')
            ->where('b.id_arrendatario','=',$id)
         ->select(DB::raw('b.id, CONCAT_WS(" ",p1.nombre,p1.apellido_paterno,p1.apellido_materno) as arrendatario, s.nombre as servicio, fp.nombre as forma, c.nombre as comision, f.nombre as flexibilidad, m.nombre as multa, DATE_FORMAT(b.fecha_contrato, "%d/%m/%Y") as fecha, b.id_estado, CONCAT_WS(" ", p2.nombre,p2.apellido_paterno,p2.apellido_materno) as creador, b.id_arrendatario,i.id as id_inmueble, b.id_contrato, bp.nombre, con.nombre as contrato' ))
         ->get();

         $servicio = DB::table('servicios as s')
         ->where("s.estado","<>",0)
         ->select(DB::raw('s.id as id,s.nombre as nombre'))
         ->get();

         $formasdepago = DB::table('formasdepagos as s')
         ->where("s.estado","<>",0)
         ->select(DB::raw('s.id as id,s.nombre as nombre'))
         ->get();

         $comision = DB::table('comisiones as c')
         ->where("c.estado","<>",0)
         ->select(DB::raw('c.id as id,c.nombre as nombre'))
         ->get();

         $flexibilidad = DB::table('flexibilidads as f')
         ->where("f.estado","<>",0)
         ->select(DB::raw('f.id as id,f.nombre as nombre'))
         ->get();

         $multa = DB::table('multas as m')
         ->where("m.estado","<>",0)
         ->select(DB::raw('m.id as id,m.nombre as nombre'))
         ->get();

         $contrato = DB::table('contratos as c')
         ->where("c.estado","<>",0)
         ->select(DB::raw('c.id as id,c.nombre as nombre'))
         ->get();  

        return view('contratoborradorarrendatario.edit',compact('servicio','formasdepago','comision','flexibilidad','multa','contrato','publica','borradoresIndex'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ContratoBorradorArrendatario  $contratoBorradorArrendatario
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ContratoBorradorArrendatario $contratoBorradorArrendatario)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ContratoBorradorArrendatario  $contratoBorradorArrendatario
     * @return \Illuminate\Http\Response
     */
    public function destroy(ContratoBorradorArrendatario $contratoBorradorArrendatario)
    {
        //
    }

    public function crearBorrador(Request $request)
    {

        $fecha = DateTime::createFromFormat('d-m-Y', $request->fecha_contrato);

        $contratoTipo = DB::table('contratos as c')
        ->where("c.id","=",$request->id_contrato)
        ->select(DB::raw('c.id as id,c.descripcion as descripcion'))
        ->first();  

        array_set($request, 'fecha_contrato', $fecha);
        array_set($request, 'detalle',$contratoTipo->descripcion);
        array_set($request, 'id_estado', 1);

        $borrador = ContratoBorradorArrendatario::create($request->all());

        //PARA PDF
        $borradorPDF = DB::table('contratoborradorarrendatarios as b')
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
            ->where('b.id_arrendatario','=',$borrador->id_arrendatario)
         ->select(DB::raw('b.id, CONCAT_WS(" ",p1.nombre,p1.apellido_paterno,p1.apellido_materno) as arrendatario, 
            CONCAT(s.descripcion, "  $",s.valor) as Servicio, 
            CONCAT(fp.descripcion, " Pie $", fp.pie, "  ", fp.cuotas, " Cuotas") as FormasDePago, 
            CONCAT(c.descripcion, " ", c.comision, " %") as comision, 
            f.descripcion as Flexibilidad ,
            CONCAT(m.descripcion, " ", m.tipo_multa,m.valor ) as Multas, 
            DATE_FORMAT(b.fecha_contrato, "%d/%m/%Y") as fecha, b.id_estado, CONCAT_WS(" ", p2.nombre,p2.apellido_paterno,p2.apellido_materno) as creador, b.id_arrendatario,i.id as id_inmueble,  b.detalle as bodyContrato, b.id_contrato as id_contrato, b.dia_pago as dia_pago_p, p1.profesion as profesion_p, p1.rut as rut_p, CONCAT_WS(" ",p1.direccion,p1.numero) as direccion_p, p1.telefono as telefono_p, p1.departamento as depto_p, cc.comuna_nombre as comuna_p, rr.region_nombre as region_p, i.rol as rol, CONCAT_WS(" ",i.direccion, i.numero) as direccion_i, i.departamento as depto_i, cci.comuna_nombre as comuna_i, i.dormitorio as dormitorio, i.bano as bano,
             CONCAT_WS(" ",p1.nombre,p1.apellido_paterno,p1.apellido_materno) as arrendatario ' ))
         ->first();



        $pdf = new PdfController();
        $pdf->pdfArrendatario($borradorPDF);
        // FIN PARA PDFsss

        $borrpdf=ContratoBorradorArrendatarioPdf::create([
                    "id_b_arrendatario" => $borradorPDF->id,
                    "nombre"      => $borradorPDF->id.$borradorPDF->direccion_i.".pdf",
                    "ruta"        => "uploads/pdf/",
                    "id_creador"  => $request->id_creador
                ])->toArray();

        return redirect()->route('cbararrendatario.edit', $request->id_arrendatario)
        ->with('status', 'Contrato Borrador guardado con éxito');
    }



    public function mostrarGestion(Request $request, $idg){

                $gestion=ContratoBorradorArrendatario::where('id','=',$idg)->get();
                return response()->json($gestion);  
        }



    public function enviaMail($id){

        $borradorCorreo = DB::table('contratoborradorarrendatarios as b')
         ->leftjoin('personas as p1','b.id_arrendatario','=','p1.id')
         ->leftjoin('contratoborradorarrendatariospdf as pdf','b.id','=','pdf.id_b_arrendatario')
         ->where('b.id','=',$id)
         ->select(DB::raw('b.id as id , CONCAT_WS(" ",p1.nombre,p1.apellido_paterno,p1.apellido_materno) as arrendatario, p1.email as correo, CONCAT(pdf.ruta,pdf.nombre) as archivo,b.id_estado as estado,b.id_arrendatario as id_arrendatario'))
         ->first();

         
         if($borradorCorreo->estado <> 0)
         {
            $envioCorreo = array('nombre' => $borradorCorreo->arrendatario ,
                  'email' => $borradorCorreo->correo );

            Mail::send('emails.contratoborrador', $envioCorreo, function ($message) use($borradorCorreo) {
                $archivos = 'uploads\pdf\4serafin zamora190.pdf';
                $message->from('edison.carrizo.j@gmail.com');
                $message->to($borradorCorreo->correo);
                $message->subject('Asunto del correo');
                $message->attach($borradorCorreo->archivo);
            });

            if($borradorCorreo->estado == 1)
            { ContratoBorradorArrendatario::find($id)->update(['id_estado' => 2]); }
            else
            { ContratoBorradorArrendatario::find($id)->update(['id_estado' => 3]); }
        

            return redirect()->route('cbararrendatario.edit', $borradorCorreo->id_arrendatario)
                ->with('status', 'Correo enviado con éxito');
        }
        else
        {
            return redirect()->route('cbararrendatario.edit', $borradorCorreo->id_arrendatario)
                ->with('error', 'No se puede enviar correo a borrador Rechazado');   
        }

    }

  public function editarGestion(Request $request)
    {

        $fecha_contrato = DateTime::createFromFormat('d-m-Y', $request->fecha_contrato);
        array_set($request, 'fecha_contrato', $fecha_contrato);

        $captacion = ContratoBorradorArrendatario::where('id','=',$request->id_borrador)
        ->update([
              "id_modificador"  => $request->id_modificador,
              "id_servicios"    => $request->id_servicios,
              "id_comisiones"   => $request->id_comisiones,
              "id_flexibilidad" => $request->id_flexibilidad,
              // "fecha_contrato"  => $request->fecha_contrato1,
              // "id_estado"       => $request->id_estado,
              "detalle"         => $request->detalle,
              "id_contrato"     => $request->id_contrato,
              "id_formadepago"  => $request->id_formadepago,
              "id_multa"        => $request->id_multa,
              "dia_pago"        => $request->dia_pago,

        ]);



        //PARA PDF
         $borradorPDF = DB::table('contratoborradorarrendatarios as b')
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
            ->where('b.id_arrendatario','=',$request->id_arrendtario)
         ->select(DB::raw('b.id, CONCAT_WS(" ",p1.nombre,p1.apellido_paterno,p1.apellido_materno) as arrendatario, 
            CONCAT(s.descripcion, "  $",s.valor) as Servicio, 
            CONCAT(fp.descripcion, " Pie $", fp.pie, "  ", fp.cuotas, " Cuotas") as FormasDePago, 
            CONCAT(c.descripcion, " ", c.comision, " %") as comision, 
            f.descripcion as Flexibilidad ,
            CONCAT(m.descripcion, " ", m.tipo_multa,m.valor ) as Multas, 
            DATE_FORMAT(b.fecha_contrato, "%d/%m/%Y") as fecha, b.id_estado, CONCAT_WS(" ", p2.nombre,p2.apellido_paterno,p2.apellido_materno) as creador, b.id_arrendatario,i.id as id_inmueble,  b.detalle as bodyContrato, b.id_contrato as id_contrato, b.dia_pago as dia_pago_p, p1.profesion as profesion_p, p1.rut as rut_p, CONCAT_WS(" ",p1.direccion,p1.numero) as direccion_p, p1.telefono as telefono_p, p1.departamento as depto_p, cc.comuna_nombre as comuna_p, rr.region_nombre as region_p, i.rol as rol, CONCAT_WS(" ",i.direccion, i.numero) as direccion_i, i.departamento as depto_i, cci.comuna_nombre as comuna_i, i.dormitorio as dormitorio, i.bano as bano,
             CONCAT_WS(" ",p1.nombre,p1.apellido_paterno,p1.apellido_materno) as arrendatario ' ))
         ->first();

        $pdf = new PdfController();

        $pdf->pdfArrendatario($borradorPDF);
        // FIN PARA PDF

        return redirect()->route('cbararrendatario.edit', $request->id_arrendtario)
            ->with('status', 'Borrador actualizado con éxito');
    }



}
