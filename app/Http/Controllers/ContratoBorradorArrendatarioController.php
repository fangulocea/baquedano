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
use App\ArrendatarioGarantia;



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
         ->leftjoin('users as pc', 'a.id_creador', 'pc.id')
         ->leftjoin('personas as pm', 'a.id_modificador', 'pm.id')
         ->leftjoin('personas as pa', 'a.id_arrendatario','pa.id')
         ->leftjoin('inmuebles as i','a.id_inmueble','i.id')
         ->leftjoin('comunas as c', 'i.id_comuna', '=', 'c.comuna_id')
         ->where('a.id_estado','=',2)
         ->OrWhere('a.id_estado','=',10)
         ->OrWhere('a.id_estado','=',6)
         ->select(DB::raw('a.id as id_cap_arr, CONCAT_WS(" ",pa .nombre,pa.apellido_paterno,pa.apellido_materno) as arrendatario,i.direccion,i.numero,c.comuna_nombre as comuna,a.id_estado, a.id_arrendatario as id_arrendatario'))
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
         ->leftjoin('users as pc', 'a.id_creador', 'pc.id')
         ->leftjoin('personas as pm', 'a.id_modificador', 'pm.id')
         ->leftjoin('personas as pa', 'a.id_arrendatario','pa.id')
         ->leftjoin('inmuebles as i','a.id_inmueble','i.id')
         ->leftjoin('comunas as c', 'i.id_comuna', '=', 'c.comuna_id')
         ->where('a.id','=',$id)
         ->select(DB::raw('a.id as id_cap_arr, CONCAT_WS(" ",pa.nombre,pa.apellido_paterno,pa.apellido_materno) as arrendatario,i.direccion,i.numero,c.comuna_nombre as comuna,a.id_estado, a.id_arrendatario as id_arrendatario,i.id as id_inmueble,i.precio, i.gastosComunes'))
         ->first();

         $id_publicacion = DB::table('arrendatarios as a')
         ->where('a.id','=',$id)->first();

         // $borradoresIndex = DB::table('contratoborradorarrendatarios as b')
         // ->leftjoin('personas as p1','b.id_arrendatario','=','p1.id')
         // ->leftjoin('contratos as con','b.id_contrato','=','con.id')
         // ->leftjoin('inmuebles as i','b.id_inmueble','=','i.id')
         // ->leftjoin('servicios as s', 'b.id_servicios','=', 's.id')
         // ->leftjoin('formasdepagos as fp','b.id_formadepago','=','fp.id')
         // ->leftjoin('comisiones as c', 'b.id_comisiones', '=', 'c.id')
         // ->leftjoin('flexibilidads as f', 'b.id_flexibilidad', '=', 'f.id')
         // ->leftjoin('multas as m','b.id_multa','=','m.id')
         // ->leftjoin('personas as p2','b.id_creador','=','p2.id')
         // ->leftjoin('contratoborradorarrendatariospdf as bp', 'b.id', '=', 'bp.id_b_arrendatario')
         //    ->where('b.id_cap_arr','=',$id)
         // ->select(DB::raw('b.id as id, b.id_cap_arr as id_cap_arr, CONCAT_WS(" ",p1.nombre,p1.apellido_paterno,p1.apellido_materno) as arrendatario, s.nombre as servicio, fp.nombre as forma, c.nombre as comision, f.nombre as flexibilidad, m.nombre as multa, DATE_FORMAT(b.fecha_contrato, "%d/%m/%Y") as fecha, b.id_estado, CONCAT_WS(" ", p2.nombre,p2.apellido_paterno,p2.apellido_materno) as creador, b.id_arrendatario,i.id as id_inmueble, b.id_contrato, bp.nombre, con.nombre as contrato, bp.id_b_arrendatario as id_pdfborrador' ))
         // ->get();

        $borradoresIndex = DB::select("select 
        b.id as id, b.id_cap_arr as id_cap_arr, CONCAT_WS(' ',p1.nombre,p1.apellido_paterno,p1.apellido_materno) as arrendatario, 
        s.nombre as servicio, fp.nombre as forma, c.nombre as comision, f.nombre as flexibilidad, m.nombre as multa, 
        DATE_FORMAT(b.fecha_contrato, '%d/%m/%Y') as fecha, b.id_estado, 
        CONCAT_WS(' ', p2.nombre,p2.apellido_paterno,p2.apellido_materno) as creador, b.id_arrendatario,i.id as id_inmueble, 
        b.id_contrato, bp.nombre, con.nombre as contrato, bp.id_b_arrendatario as id_pdfborrador
        from contratoborradorarrendatarios b
        left join personas p1 on b.id_arrendatario = p1.id
        left join inmuebles i on b.id_inmueble = i.id
        left join comunas cc on p1.id_comuna = cc.comuna_id
        left join servicios s on b.id_servicios = s.id
        left join regions rr on p1.id_region = rr.region_id
        left join formasdepagos fp on b.id_formadepago = fp.id
        left join comisiones c on b.id_comisiones = c.id 
        left join flexibilidads f on b.id_flexibilidad = f.id
        left join multas m on b.id_multa = m.id
        left join comunas cci on i.id_comuna = cci.comuna_id
        left join personas p2 on b.id_creador = p2.id
        left join contratos con on b.id_contrato = con.id
        left join contratoborradorarrendatariospdf bp on b.id = bp.id_b_arrendatario
        where b.id_cap_arr =".$id);


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

        $propuestas = DB::table('cap_simulaarrendatario')
         ->where("id_publicacion","=",$id)
         ->select(DB::raw(" id, (CASE  WHEN tipopropuesta=1 THEN '1 Cuota' WHEN tipopropuesta=2 THEN'Pie + Cuota' ELSE 'Renovación' END) as tipopropuesta, proporcional, fecha_iniciocontrato, meses_contrato, iva,descuento, pie, cobromensual, nrocuotas,canondearriendo" ))
         ->get();  

         $garantias = DB::table('arrendatario_garantia as g')
        ->where("id_publicacion","=",$id)
        ->select(DB::raw(" g.id, g.mes, g.ano, g.banco, g.numero, g.valor, DATE_FORMAT(g.fecha_cobro, '%d/%m/%Y') as fecha_cobro"))
        ->get();

        return view('contratoborradorarrendatario.edit',compact('garantias','servicio','formasdepago','comision','flexibilidad','multa','contrato','publica','borradoresIndex','id_publicacion','propuestas'));
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
         ->where('b.id','=',$borrador->id)
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
            s.descripcion as Servicio, 
            CONCAT(fp.descripcion, " Pie $", fp.pie, "  ", fp.cuotas, " Cuotas") as FormasDePago, 
            CONCAT(c.descripcion, " ", c.comision, " %") as comision, 
            f.descripcion as Flexibilidad ,
            b.valorarriendo ,
            CONCAT("Multa de ", m.valor ," % Equivalente a ", ROUND((valorarriendo * m.valor)/100,0)) as Multas, 
            DATE_FORMAT(b.fecha_contrato, "%d/%m/%Y") as fecha, b.id_estado, CONCAT_WS(" ", p2.nombre,p2.apellido_paterno,p2.apellido_materno) as creador, b.id_arrendatario,i.id as id_inmueble,  b.detalle as bodyContrato, b.id_contrato as id_contrato, b.dia_pago as dia_pago_p, p1.profesion as profesion_p, p1.rut as rut_p, CONCAT_WS(" ",p1.direccion,p1.numero) as direccion_p, p1.telefono as telefono_p, p1.departamento as depto_p, cc.comuna_nombre as comuna_p, rr.region_nombre as region_p, i.rol as rol, CONCAT_WS(" ",i.direccion, i.numero) as direccion_i, i.departamento as depto_i, cci.comuna_nombre as comuna_i, i.dormitorio as dormitorio, i.bano as bano,
             CONCAT_WS(" ",p1.nombre,p1.apellido_paterno,p1.apellido_materno) as arrendatario ' ))
         ->first();

         $capSimulacion = DB::table('cap_simulaarrendatario as s')
         ->where('s.id','=',$request->id_simulacion)->first();

         if($capSimulacion->tipopropuesta == 1)
         {
            $idTipoPago = 21;
         } elseif($capSimulacion->tipopropuesta == 2)
         {
            $idTipoPago = 35;
         } 

         $simulacion = DB::table('cap_simulapagoarrendatarios as b')
         ->where('b.id_simulacion','=',$request->id_simulacion)
         ->where('b.idtipopago','=',$idTipoPago)
         ->get();

        $nombre_pdf = $borradorPDF->id.$borradorPDF->direccion_i.".pdf";

        $pdf = new PdfController();
        $pdf->pdfArrendatario($borradorPDF,$simulacion);
        // FIN PARA PDFsss

        $borrpdf=ContratoBorradorArrendatarioPdf::create([
                    "id_b_arrendatario" => $borradorPDF->id,
                    "nombre"      => $nombre_pdf,
                    "ruta"        => "uploads/pdf/",
                    "id_creador"  => $request->id_creador
                ])->toArray();

        return redirect()->route('cbararrendatario.edit', $request->id_cap_arr)
        ->with('status', 'Contrato Borrador guardado con éxito');
    }



    public function mostrarGestion(Request $request, $idg){

        $gestion=ContratoBorradorArrendatario::where('id','=',$idg)->first();
          
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

         $propuestas = DB::table('cap_simulaarrendatario')
         ->where("id","=",$gestion->id_simulacion)
         ->select(DB::raw(" id, (CASE  WHEN tipopropuesta=1 THEN '1 Cuota' WHEN tipopropuesta=2 THEN'Pie + Cuota' ELSE 'Renovación' END) as tipopropuesta, proporcional, fecha_iniciocontrato, meses_contrato, iva,descuento, pie, cobromensual, nrocuotas,canondearriendo" ))
         ->get(); 
    

        return view('contratoborradorarrendatario.editContratoArr',compact('propuestas','servicio','formasdepago','comision','flexibilidad','multa','contrato','gestion','borradoresIndex'));


    }



    public function enviaMail($id){

        $borradorCorreo = DB::table('contratoborradorarrendatarios as b')
         ->leftjoin('personas as p1','b.id_arrendatario','=','p1.id')
         ->leftjoin('contratoborradorarrendatariospdf as pdf','b.id','=','pdf.id_b_arrendatario')
         ->where('b.id_cap_arr','=',$id)
         ->select(DB::raw('b.id as id, b.id_cap_arr as id_cap_arr , CONCAT_WS(" ",p1.nombre,p1.apellido_paterno,p1.apellido_materno) as arrendatario, p1.email as correo, CONCAT(pdf.ruta,pdf.nombre) as archivo,b.id_estado as estado,b.id_arrendatario as id_arrendatario'))
         ->first();

         
         if($borradorCorreo->estado <> 0)
         {
            $envioCorreo = array('nombre'    => $borradorCorreo->arrendatario ,
                                 'email'     => $borradorCorreo->correo, 
                                 'nombrePdf' => $borradorCorreo->archivo );

            Mail::send('emails.contratoborrador', $envioCorreo, function ($message) use($borradorCorreo) {
                $archivos = $borradorCorreo->archivo;
                $message->from('javier@ibaquedano.cl','Baquedano Rentas');
                $message->to($borradorCorreo->correo);
                $message->replyTo('javier@ibaquedano.cl', 'Javier Faria - Baquedano Rentas');
                $message->subject('Propuesta contrato borrador');
                $message->attach($borradorCorreo->archivo);
            });

            if($borradorCorreo->estado <> 10)
            {
                if($borradorCorreo->estado == 1)
                { ContratoBorradorArrendatario::find($borradorCorreo->id)->update(['id_estado' => 2]); }
                else
                { ContratoBorradorArrendatario::find($borradorCorreo->id)->update(['id_estado' => 3]); }                
            }
        

            return redirect()->route('cbararrendatario.edit', $borradorCorreo->id_cap_arr)
                ->with('status', 'Correo enviado con éxito');
        }
        else
        {
            return redirect()->route('cbararrendatario.edit', $borradorCorreo->id_cap_arr)
                ->with('error', 'No se puede enviar correo a borrador Rechazado');   
        }

    }

  public function editarGestion(Request $request)
    {

        $fecha_contrato = DateTime::createFromFormat('d-m-Y', $request->fecha_contrato);
        array_set($request, 'fecha_contrato', $fecha_contrato);


        $captacion = ContratoBorradorArrendatario::where('id_cap_arr','=',$request->id_cap_arr)
        ->update([
              "id_modificador"  => $request->id_modificador,
              "id_servicios"    => $request->id_servicios,
              "id_comisiones"   => $request->id_comision,
              "id_flexibilidad" => $request->id_flexibilidad,
               "fecha_contrato"  => $request->fecha_contrato,
              "id_estado"       => $request->id_estado,
              "detalle"         => $request->detalle,
              "id_contrato"     => $request->id_contrato,
              "id_formadepago"  => $request->id_formadepago,
              "id_multa"        => $request->id_multa,
              "dia_pago"        => $request->dia_pago,
              "valorarriendo"   => $request->valorarriendo,

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
            ->where('b.id_cap_arr','=',$request->id_cap_arr)
         ->select(DB::raw('b.id, CONCAT_WS(" ",p1.nombre,p1.apellido_paterno,p1.apellido_materno) as arrendatario, 
            s.descripcion as Servicio, 
            CONCAT(fp.descripcion, " Pie $", fp.pie, "  ", fp.cuotas, " Cuotas") as FormasDePago, 
            CONCAT(c.descripcion, " ", c.comision, " %") as comision, 
            f.descripcion as Flexibilidad ,
            b.valorarriendo ,
            CONCAT("Multa de ",m.valor," % Equivalente a ", ROUND((valorarriendo * m.valor)/100,0)) as Multas, 
            DATE_FORMAT(b.fecha_contrato, "%d/%m/%Y") as fecha, b.id_estado, CONCAT_WS(" ", p2.nombre,p2.apellido_paterno,p2.apellido_materno) as creador, b.id_arrendatario,i.id as id_inmueble,  b.detalle as bodyContrato, b.id_contrato as id_contrato, b.dia_pago as dia_pago_p, p1.profesion as profesion_p, p1.rut as rut_p, CONCAT_WS(" ",p1.direccion,p1.numero) as direccion_p, p1.telefono as telefono_p, p1.departamento as depto_p, cc.comuna_nombre as comuna_p, rr.region_nombre as region_p, i.rol as rol, CONCAT_WS(" ",i.direccion, i.numero) as direccion_i, i.departamento as depto_i, cci.comuna_nombre as comuna_i, i.dormitorio as dormitorio, i.bano as bano,
             CONCAT_WS(" ",p1.nombre,p1.apellido_paterno,p1.apellido_materno) as arrendatario ' ))
         ->first();

        $capSimulacion = DB::table('cap_simulaarrendatario as s')
         ->where('s.id','=',$request->id_simulacion)->first();

         if($capSimulacion->tipopropuesta == 1)
         {
            $idTipoPago = 21;
         } elseif($capSimulacion->tipopropuesta == 2)
         {
            $idTipoPago = 35;
         } 

         $simulacion = DB::table('cap_simulapagoarrendatarios as b')
         ->where('b.id_simulacion','=',$request->id_simulacion)
         ->where('b.idtipopago','=',$idTipoPago)
         ->get();


        $pdf = new PdfController();

        $pdf->pdfArrendatario($borradorPDF,$simulacion);
        // FIN PARA PDF

        return redirect()->route('cbararrendatario.edit', $request->id_cap_arr)
            ->with('status', 'Borrador actualizado con éxito');
    }

    public function garantia(Request $request,$id){

        $fecha_cobro = DateTime::createFromFormat('d-m-Y', $request->fecha_cobro);
        array_set($request, 'fecha_cobro', $fecha_cobro);
        array_set($request, 'id_publicacion', $id);

        $reserva = ArrendatarioGarantia::create(request()->except(['_token']));

        return redirect()->route('cbararrendatario.edit', $id)
                ->with('status', 'Garantía ingresada con éxito');

    }

    public function eliminarGarantia($id,$idp){
        ArrendatarioGarantia::destroy($id);

        return redirect()->route('cbararrendatario.edit', $idp)
                ->with('status', 'Garantía eliminada con éxito');
    }




}
