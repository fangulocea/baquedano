<?php

namespace App\Http\Controllers;

use App\ContratoBorrador;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use App\Captacion;
use DateTime;

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
         ->leftjoin('personas as p2', 'c.id_creador', '=', 'p2.id')
         ->leftjoin('personas as p3', 'c.id_modificador', '=', 'p3.id')
         ->leftjoin('comunas as o', 'i.id_comuna', '=', 'o.comuna_id')
         ->leftjoin('portales as po', 'c.portal', '=', 'po.id')
         ->where('c.id_estado','=',6)
         ->select(DB::raw('c.id as id_publicacion, DATE_FORMAT(c.created_at, "%d/%m/%Y") as fecha_creacion, c.id_estado as id_estado, CONCAT(p1.nombre," ",p1.apellido_paterno," ",p1.apellido_materno) as Propietario, CONCAT(p2.nombre," ",p2.apellido_paterno," ",p2.apellido_materno) as Creador'),'i.id as id_inmueble','i.direccion','i.numero','i.departamento', 'o.comuna_nombre','po.nombre as portal','p1.nombre as nom_p','p1.apellido_paterno as apep_p','p1.apellido_materno as apem_p','p2.nombre as nom_c','p2.apellido_paterno as apep_c','p2.apellido_materno as apem_c','p3.nombre as nom_m','p3.apellido_paterno as apep_m','p3.apellido_materno as apem_m')
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
    public function show(ContratoBorrador $contratoBorrador)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ContratoBorrador  $contratoBorrador
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $borrador = DB::table('cap_publicaciones as c')
         ->leftjoin('personas as p1', 'c.id_propietario', '=', 'p1.id')
         ->leftjoin('inmuebles as i', 'c.id_inmueble', '=', 'i.id')
         ->leftjoin('personas as p2', 'c.id_creador', '=', 'p2.id')
         ->leftjoin('personas as p3', 'c.id_modificador', '=', 'p3.id')
         ->leftjoin('comunas as o', 'i.id_comuna', '=', 'o.comuna_id')
         ->leftjoin('portales as po', 'c.portal', '=', 'po.id')
         ->where('c.id','=',$id)
         ->select(DB::raw('c.id as id_publicacion, CONCAT(i.direccion," N°",i.numero,", ",o.comuna_nombre) as Dirección' ))
         ->first();

         $borradoresIndex = DB::table('borradores as b')
         ->leftjoin('notarias as n', 'b.id_notaria', '=', 'n.id')
         ->leftjoin('servicios as s', 'b.id_servicios', '=', 's.id')
         ->leftjoin('comisiones as c', 'b.id_comisiones', '=', 'c.id')
         ->leftjoin('flexibilidads as f', 'b.id_flexibilidad', '=', 'f.id')
         ->leftjoin('cap_publicaciones as cp', 'b.id_publicacion', '=', 'cp.id')
            ->where('b.id','=',$id)
         ->select(DB::raw(' b.id as id, n.razonsocial as n_n, s.nombre as n_s, c.nombre as n_c, f.nombre as n_f , cp.id as id_publicacion,DATE_FORMAT(b.fecha_gestion, "%d/%m/%Y") as fecha'))
         ->get();


            
        $gestBorradores = DB::table('borradores as g')
         ->where("g.id_publicacion","=",$id)
         ->get();

         $notaria = DB::table('notarias as n')
         ->where("n.estado","<>",0)
         ->select(DB::raw('n.id as id,n.razonsocial as nombre'))
         ->get();

        $servicio = DB::table('servicios as s')
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

        return view('contratoBorrador.edit',compact('borrador','borradoresIndex','gestBorradores','notaria','servicio','comision','flexibilidad'));
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
        $fecha_gestion = DateTime::createFromFormat('d-m-Y', $request->fecha_gestion);
        array_set($request, 'fecha_gestion', $fecha_gestion);
        array_set($request, 'detalle_revision', '');   
        $borrador = ContratoBorrador::create($request->all());
        return redirect()->route('contratoBorrador.edit', $request->id_publicacion)
        ->with('status', 'Borrador guardado con éxito');
    }

  public function editarGestion(Request $request)
    {
        // $fecha_gestion = DateTime::createFromFormat('d-m-Y', $request->fecha_gestion);
        // array_set($request, 'fecha_gestion', $fecha_gestion);
        // $captacion = CaptacionGestion::where('id','=',$request->id_captacion_gestion)
        // ->update([
        //     'dir' => $request->dir,
        //     'detalle_contacto' => $request->detalle_contacto,
        //     'id_modificador_gestion' => $request->id_modificador_gestion,
        //     'fecha_gestion' => $request->fecha_gestion,
        //     'hora_gestion' => $request->hora_gestion
        // ]);
        // return redirect()->route('captacion.edit', $request->id_captacion_gestion)

        //     ->with('status', 'Gestión guardada con éxito');
    }


public function mostrarGestion(Request $request, $idg){
            $gestion=ContratoBorrador::where('id','=',$idg)->get();
            dd($gestion);
            return response()->json($gestion);  
    }


}
