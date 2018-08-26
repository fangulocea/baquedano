<?php

namespace App\Http\Controllers;

use App\ContratoBorrador;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use App\Captacion;
use App\Servicio;
use DateTime;
use App\Contratoborradorpdf;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\File;    
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use URL;
use App\PropietarioGarantia;
use Auth;

class ContratoBorradorController extends Controller
{
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
         ->leftjoin('users as p2', 'c.id_creador', '=', 'p2.id')
         ->leftjoin('personas as p3', 'c.id_modificador', '=', 'p3.id')
         ->leftjoin('comunas as o', 'i.id_comuna', '=', 'o.comuna_id')
         ->leftjoin('portales as po', 'c.portal', '=', 'po.id')
         ->where('c.id_estado','=',6)
         ->OrWhere('c.id_estado','=',7)
        ->OrWhere('c.id_estado','=',10)
         ->select(DB::raw('c.id as id_publicacion, DATE_FORMAT(c.created_at, "%d/%m/%Y") as fecha_creacion, c.id_estado as id_estado, CONCAT_WS(" ",p1.nombre,p1.apellido_paterno,p1.apellido_materno) as Propietario, p2.name as Creador'),'p1.id as id_propietario','i.id as id_inmueble','i.direccion','i.numero','i.departamento', 'o.comuna_nombre','po.nombre as portal','p1.nombre as nom_p','p1.apellido_paterno as apep_p','p1.apellido_materno as apem_p','p3.nombre as nom_m','p3.apellido_paterno as apep_m','p3.apellido_materno as apem_m')
         ->get();
         
         return view('contratoBorrador.index',compact('publica'));
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
     * @param  \App\ContratoBorrador  $contratoBorrador
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
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
         ->where('b.id','=',$id)
         ->select(DB::raw(' b.id as id, n.razonsocial as n_n, s.nombre as n_s, c.nombre as n_c, f.nombre as n_f , cp.id as id_publicacion,b.fecha_gestion as fecha,
             CONCAT_WS(" ",p1.nombre,p1.apellido_paterno,p1.apellido_materno) as propietario,
             p1.rut as rut_p, CONCAT(p1.direccion," ", p1.numero) as direccion_p , c1.comuna_nombre as comuna_p, reg.region_nombre as region_p,
             CONCAT(i.direccion," ",i.numero) as direccion_i, i.departamento as depto_i, c2.comuna_nombre as comuna_i,
             i.dormitorio as dormitorio, i.bano as bano, i.bodega, i.piscina, i.precio, i.gastosComunes, 
             con.nombre, con.nombre as contrato, con.descripcion as deta_contrato,
             p1.profesion as profesion_p, p1.telefono as telefono_p, p1.departamento as depto_p,
             i.rol as rol, b.detalle_revision as bodyContrato'))->first();
        $pdf = new PdfController();
        $pdf->show($borradorPDF);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ContratoBorrador  $contratoBorrador
     * @return \Illuminate\Http\Response
     */
    public function edit($id,$tab)
    {
        $borrador = DB::table('cap_publicaciones as c')
         ->leftjoin('personas as p1', 'c.id_propietario', '=', 'p1.id')
         ->leftjoin('inmuebles as i', 'c.id_inmueble', '=', 'i.id')
         ->leftjoin('personas as p2', 'c.id_creador', '=', 'p2.id')
         ->leftjoin('personas as p3', 'c.id_modificador', '=', 'p3.id')
         ->leftjoin('comunas as o', 'i.id_comuna', '=', 'o.comuna_id')
         ->leftjoin('portales as po', 'c.portal', '=', 'po.id')
         ->where('c.id','=',$id)
         ->select(DB::raw('c.id as id_publicacion, p1.id as id_propietario, i.id as id_inmueble, CONCAT_WS(" ",i.direccion,"#",i.numero,"Depto.",i.departamento,o.comuna_nombre) as direccion, CONCAT_WS(" ",p1.nombre , p1.apellido_paterno, " Fono: " ,p1.telefono, " Email: " ,p1.email ) as propietario, i.precio, i.gastosComunes '))
         ->first();

         $borradoresIndex = DB::table('borradores as b')
         ->leftjoin('notarias as n', 'b.id_notaria', '=', 'n.id')
         ->leftjoin('servicios as s', 'b.id_servicios', '=', 's.id')
         ->leftjoin('comisiones as c', 'b.id_comisiones', '=', 'c.id')
         ->leftjoin('flexibilidads as f', 'b.id_flexibilidad', '=', 'f.id')
         ->leftjoin('cap_publicaciones as cp', 'b.id_publicacion', '=', 'cp.id')
         ->leftjoin('borradorespdf as bp', 'b.id', '=', 'bp.id_borrador')
         ->leftjoin('cap_simulapropietario as csp', 'b.id_simulacion', '=', 'csp.id')
         ->where('b.id_publicacion','=',$id)
         ->select(DB::raw(' b.id as id, n.razonsocial as n_n, s.nombre as n_s, c.nombre as n_c, f.nombre as n_f , cp.id as id_publicacion,DATE_FORMAT(b.fecha_gestion, "%d/%m/%Y") as fecha,b.id_servicios as id_servicios,b.id_estado,bp.nombre, bp.id as id_pdfborrador, b.tipo_contrato, csp.tipopropuesta '))
         ->get();
            
        $gestBorradores = DB::table('borradores as g')
         ->where("g.id_publicacion","=",$id)
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


        $uf = DB::table('adm_uf')
         ->where("fecha","=",Carbon::now()->format('Y/m/d'))
         ->first();  


        $propuestas = DB::table('cap_simulapropietario')
         ->where("id_publicacion","=",$id)
         ->select(DB::raw(" id, (CASE  WHEN tipopropuesta=1 THEN '1 Cuota' WHEN tipopropuesta=2 THEN'Pie + Cuota' WHEN tipopropuesta=3 THEN 'Renovación, 1 Cuota' WHEN tipopropuesta=4 THEN 'Renovación, Pie + Cuotas' ELSE 'Renovación' END) as tipopropuesta, proporcional, fecha_iniciocontrato, meses_contrato, iva,descuento, pie, cobromensual, nrocuotas,canondearriendo" ))
         ->get();     

        $garantias = DB::table('propietario_garantia as g')
        ->where("id_publicacion","=",$id)
        ->select(DB::raw(" g.id, g.mes, g.ano, g.banco, g.numero, g.valor, DATE_FORMAT(g.fecha_cobro, '%d/%m/%Y') as fecha_cobro"))
        ->get();
        if ($tab == 2) {
            if (count($borradoresIndex) > 0) {
                $tab = 3;
            }

           
        }
        return view('contratoBorrador.edit',compact('garantias','borrador','borradoresIndex','gestBorradores','notaria','servicio','comision','flexibilidad','contrato','formasdepago','multa','propuestas','tab','uf'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ContratoBorrador  $contratoBorrador
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ContratoBorrador $contratoBorrador)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ContratoBorrador  $contratoBorrador
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function crearBorrador(Request $request)
    {   

        $fecha_gestion = DateTime::createFromFormat('Y-m-d', $request->fecha_gestion);

         $contratoTipo = DB::table('contratos as c')
         ->where("c.id","=",$request->id_contrato)
         ->select(DB::raw('c.id as id,c.descripcion as descripcion'))
         ->first();  

        array_set($request, 'fecha_gestion', $fecha_gestion);
        array_set($request, 'detalle_revision',$contratoTipo->descripcion);
        array_set($request, 'id_estado', 1);

        $tipo_simulacion = DB::table('cap_simulapropietario')
        ->where("id","=",$request->id_simulacion)->first();
        if($tipo_simulacion->tipopropuesta == 1 || $tipo_simulacion->tipopropuesta == 2)
        { $tContrato = "N"; }
        elseif($tipo_simulacion->tipopropuesta == 3 || $tipo_simulacion->tipopropuesta == 4)
        { $tContrato = "R"; }
        else
        { $tContrato = "X";  }

        array_set($request, 'tipo_contrato', $tContrato);
        $borrador = ContratoBorrador::create($request->all());
        
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
         ->leftjoin('formasdepagos as fp', 'b.id_formadepago','=','fp.id')
         ->leftjoin('multas as mul', 'b.id_multa','=','mul.id')
         ->where('b.id','=',$borrador->id)
         ->select(DB::raw(' b.id as id, n.razonsocial as n_n, s.nombre as n_s, c.nombre as n_c, f.nombre as n_f , cp.id as id_publicacion,b.fecha_gestion as fecha,
             CONCAT_WS(" ",p1.nombre,p1.apellido_paterno,p1.apellido_materno) as propietario,
             p1.rut as rut_p, CONCAT(p1.direccion," ", p1.numero) as direccion_p , c1.comuna_nombre as comuna_p, reg.region_nombre as region_p,
             CONCAT(i.direccion," ",i.numero) as direccion_i, i.departamento as depto_i, c2.comuna_nombre as comuna_i,
             i.dormitorio as dormitorio, i.bano as bano, i.bodega, i.piscina, i.precio, i.gastosComunes, 
             con.nombre, con.nombre as contrato, con.descripcion as deta_contrato,
             p1.profesion as profesion_p, p1.telefono as telefono_p, p1.departamento as depto_p,
             CONCAT(s.descripcion, "  $",s.valor) as Servicio, 
             CONCAT(c.descripcion, " ", c.comision, " %") as comision, 
             f.descripcion as Flexibilidad , b.valorarriendo,
             i.rol as rol, b.detalle_revision as bodyContrato,
             fp.nombre as FormasDePago, mul.nombre as Multas'))->first();   

         $capSimulacion = DB::table('cap_simulapropietario as s')
         ->where('s.id','=',$request->id_simulacion)->first();

         if($capSimulacion->tipopropuesta == 1  || $capSimulacion->tipopropuesta == 3)
         {
            $idTipoPago = 21;
         } elseif($capSimulacion->tipopropuesta == 2  || $capSimulacion->tipopropuesta == 4)
         {
            $idTipoPago = 35;
         } 
         

         $simulacion = DB::table('cap_simulapagopropietarios as b')
         ->where('b.id_simulacion','=',$request->id_simulacion)
         ->where('b.idtipopago','=',$idTipoPago)
         ->get();

        $pdf = new PdfController();
        $pdf->index($borradorPDF,$simulacion);
        // FIN PARA PDFsss
        $borrpdf=Contratoborradorpdf::create([
                    "id_borrador" => $borradorPDF->id,
                    "nombre"      => $borradorPDF->id.$borradorPDF->direccion_i.".pdf",
                    "ruta"        => "uploads/pdf/",
                    "id_creador"  => $request->id_creador
                ])->toArray();



        return redirect()->route('borradorContrato.edit', [$request->id_publicacion,3])
         ->with('status', 'Borrador guardado con éxito');
    }

  public function editarGestion(Request $request)
    {

        $fecha_gestion = DateTime::createFromFormat('d-m-Y', $request->fecha_gestion);
        array_set($request, 'fecha_gestion', $fecha_gestion);

        $captacion = ContratoBorrador::where('id','=',$request->id_borrador)
        ->update([
            "id_modificador" => $request->id_modificador,
            "id_notaria" => $request->id_notaria_m,
            "id_comisiones" => $request->id_comision,
            "id_flexibilidad" => $request->id_flexibilidad,
            "id_servicios" => $request->id_servicios,
            "id_formadepago" => $request->id_formadepago,
            "id_multa" => $request->id_multa,
            "id_contrato" => $request->id_contrato,
            "dia_pago"        => $request->dia_pago,
            "valorarriendo"   => $request->valorarriendo,
            "id_estado" => $request->id_estado,         
            "fecha_gestion" => $request->fecha_gestion,
            "detalle_revision" => $request->detalle_revision
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
         ->leftjoin('formasdepagos as fp', 'b.id_formadepago','=','fp.id')
         ->leftjoin('multas as mul', 'b.id_multa','=','mul.id')
         ->where('b.id','=',$request->id_borrador)
         ->select(DB::raw(' b.id as id, n.razonsocial as n_n, s.nombre as n_s, c.nombre as n_c, f.nombre as n_f , cp.id as id_publicacion,b.fecha_gestion as fecha,
             CONCAT_WS(" ",p1.nombre,p1.apellido_paterno,p1.apellido_materno) as propietario,
             p1.rut as rut_p, CONCAT(p1.direccion," ", p1.numero) as direccion_p , c1.comuna_nombre as comuna_p, reg.region_nombre as region_p,
             CONCAT(i.direccion," ",i.numero) as direccion_i, i.departamento as depto_i, c2.comuna_nombre as comuna_i,
             i.dormitorio as dormitorio, i.bano as bano, i.bodega, i.piscina, i.precio, i.gastosComunes, 
             con.nombre, con.nombre as contrato, con.descripcion as deta_contrato,
             p1.profesion as profesion_p, p1.telefono as telefono_p, p1.departamento as depto_p,
             CONCAT(s.descripcion, "  $",s.valor) as Servicio, 
             CONCAT(c.descripcion, " ", c.comision, " %") as comision, 
             f.descripcion as Flexibilidad , b.valorarriendo,
             i.rol as rol, b.detalle_revision as bodyContrato,
             fp.nombre as FormasDePago, mul.nombre as Multas'))->first();

         //dd($borradorPDF);

         $capSimulacion = DB::table('cap_simulapropietario as s')
         ->where('s.id','=',$request->id_simulacion)->first();

         if($capSimulacion->tipopropuesta == 1  || $capSimulacion->tipopropuesta == 3)
         {
            $idTipoPago = 21;
         } elseif($capSimulacion->tipopropuesta == 2  || $capSimulacion->tipopropuesta == 4)
         {
            $idTipoPago = 35;
         }  

         $simulacion = DB::table('cap_simulapagopropietarios as b')
         ->where('b.id_simulacion','=',$request->id_simulacion)
         ->where('b.idtipopago','=',$idTipoPago)
         ->get();


        $pdf = new PdfController();


        $pdf->index($borradorPDF,$simulacion);
        // FIN PARA PDF
        $borrpdf=Contratoborradorpdf::where("id_borrador","=",$request->id_borrador)->update([
                    "id_borrador" => $request->id_borrador,
                    "nombre"      => $request->id_borrador.$borradorPDF->direccion_i.".pdf",
                    "ruta"        => "uploads/pdf/",
                    "id_creador"  => Auth::user()->id
                ]);

   return redirect()->route('borradorContrato.edit', [$request->id_publicacion,3])
            ->with('status', 'Borrador actualizado con éxito');

    }


public function editargestion2(Request $request)
    {
        dd($request->detalle_revision_m);
        $fecha_gestion = DateTime::createFromFormat('d-m-Y', $request->fecha_gestion);
        array_set($request, 'fecha_gestion_m', $fecha_gestion);

        dd($request->detalle_revision);

        $captacion = ContratoBorrador::where('id','=',$request->id_borrador)
        ->update([
              "id_modificador" => $request->id_modificador,
              "id_notaria" => $request->id_notaria_m,
              "id_comisiones" => $request->id_comision,
              "id_flexibilidad" => $request->id_flexibilidad,
              "id_servicios" => $request->id_servicios,
              "id_formadepago" => $request->id_formadepago,
              "id_multa" => $request->id_multa,
              "id_contrato" => $request->id_contrato,
              "dia_pago"        => $request->dia_pago,
              "valorarriendo"   => $request->valorarriendo,
              "id_estado" => $request->id_estado,         
              "fecha_gestion" => $request->fecha_gestion,
              "detalle_revision" => $request->detalle_revision
              
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
         ->leftjoin('formasdepagos as fp', 'b.id_formadepago','=','fp.id')
         ->leftjoin('multas as mul', 'b.id_multa','=','mul.id')
         ->where('b.id','=',$request->id_borrador)
         ->select(DB::raw(' b.id as id, n.razonsocial as n_n, s.nombre as n_s, c.nombre as n_c, f.nombre as n_f , cp.id as id_publicacion,b.fecha_gestion as fecha,
             CONCAT_WS(" ",p1.nombre,p1.apellido_paterno,p1.apellido_materno) as propietario,
             p1.rut as rut_p, CONCAT(p1.direccion," ", p1.numero) as direccion_p , c1.comuna_nombre as comuna_p, reg.region_nombre as region_p,
             CONCAT(i.direccion," ",i.numero) as direccion_i, i.departamento as depto_i, c2.comuna_nombre as comuna_i,
             i.dormitorio as dormitorio, i.bano as bano, i.bodega, i.piscina, i.precio, i.gastosComunes, 
             con.nombre, con.nombre as contrato, con.descripcion as deta_contrato,
             p1.profesion as profesion_p, p1.telefono as telefono_p, p1.departamento as depto_p,
             CONCAT(s.descripcion, "  $",s.valor) as Servicio, 
             CONCAT(c.descripcion, " ", c.comision, " %") as comision, 
             f.descripcion as Flexibilidad , b.valorarriendo,
             i.rol as rol, b.detalle_revision as bodyContrato,
             fp.nombre as FormasDePago, mul.nombre as Multas'))->first();

        $pdf = new PdfController();

        $pdf->index($borradorPDF);
        // FIN PARA PDF


   return redirect()->route('borradorContrato.edit', [$request->id_publicacion,3])
            ->with('status', 'Borrador actualizado con éxito');

    }

    public function mostrarGestion(Request $request, $idg){

        $gestion=ContratoBorrador::where('id','=',$idg)->first();
        
        $gestBorradores = DB::table('borradores as g')
         ->where("g.id_publicacion","=",$idg)
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

         $propuestas = DB::table('cap_simulapropietario')
         ->where("id","=",$gestion->id_simulacion)
         ->select(DB::raw(" id, (CASE  WHEN tipopropuesta=1 THEN '1 Cuota' WHEN tipopropuesta=2 THEN'Pie + Cuota' ELSE 'Renovación' END) as tipopropuesta, proporcional, fecha_iniciocontrato, meses_contrato, iva,descuento, pie, cobromensual, nrocuotas,canondearriendo" ))
         ->get(); 

         return view('contratoBorrador.editContrato',compact('propuestas','borrador','gestion','notaria','servicio','comision','flexibilidad','contrato','multa','formasdepago'));

    }

    public function mostrarServicio(){
                $servicio=Servicio::where('estado','<>',0)->get();
                return $servicio; 
        }

    public function enviaMail($id){

        $borradorCorreo = DB::table('borradores as b')
         ->leftjoin('cap_publicaciones as cp', 'b.id_publicacion', '=', 'cp.id') 
         ->leftjoin('personas as p1', 'cp.id_propietario','=','p1.id')
         ->leftjoin('comunas as c1', 'p1.id_comuna','=','c1.comuna_id')
         ->leftjoin('borradorespdf as pdf','b.id','=','pdf.id_borrador')
         ->where('b.id','=',$id)
         ->select(DB::raw(' b.id as id,CONCAT_WS(" ",p1.nombre,p1.apellido_paterno,p1.apellido_materno) as propietario, p1.email as correo,CONCAT(pdf.ruta,pdf.nombre) as archivo,b.id_estado as estado,b.id_publicacion as id_pub'))
         ->first();
         
         if($borradorCorreo->estado <> 0)
         {
            $envioCorreo = array('nombre' => $borradorCorreo->propietario ,
                  'email' => $borradorCorreo->correo );

            Mail::send('emails.contratoborrador', $envioCorreo, function ($message) use($borradorCorreo) {
                $archivos = 'uploads\pdf\4serafin zamora190.pdf';
                 $message->from('javier@ibaquedano.cl','Baquedano Rentas');
                $message->to($borradorCorreo->correo);
                $message->replyTo('javier@ibaquedano.cl', 'Javier Faria - Baquedano Rentas');
                $message->subject('Propuesta contrato borrador');
                $message->attach($borradorCorreo->archivo);
            });

            if($borradorCorreo->estado == 1)
            { ContratoBorrador::find($id)->update(['id_estado' => 2]); }
            else
            { ContratoBorrador::find($id)->update(['id_estado' => 3]); }
        

            return redirect()->route('borradorContrato.edit', [$borradorCorreo->id_pub,3])
                ->with('status', 'Correo enviado con éxito');
        }
        else
        {
            return redirect()->route('borradorContrato.edit', [$borradorCorreo->id_pub,3])
                ->with('error', 'No se puede enviar correo a borrador Rechazado');   
        }

    }

    public function garantia(Request $request,$id){

        if(isset($request->fecha_cobro)){
            $fecha_cobro = DateTime::createFromFormat('d-m-Y', $request->fecha_cobro);
            array_set($request, 'fecha_cobro', $fecha_cobro);
        }
        array_set($request, 'id_publicacion', $id);

        $reserva = PropietarioGarantia::create(request()->except(['_token']));


        return redirect()->route('borradorContrato.edit', [$id,1])
                ->with('status', 'Garantía ingresada con éxito');

    }

    public function eliminarGarantia($id,$idp){
        PropietarioGarantia::destroy($id);
        return redirect()->route('borradorContrato.edit', [$idp,1])
                ->with('status', 'Garantía eliminada con éxito');
    }




}
