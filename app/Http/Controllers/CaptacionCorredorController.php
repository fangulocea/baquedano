<?php

namespace App\Http\Controllers;

use App\CaptacionCorredor;
use Illuminate\Http\Request;
use App\Persona;
use App\Inmueble;
use App\Region;
use DB;
use Image;
use DateTime;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\File;

class CaptacionCorredorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         $publica = DB::table('cap_corredores as c')
         ->leftjoin('personas as p1', 'c.id_propietario', '=', 'p1.id')
         ->leftjoin('inmuebles as i', 'c.id_inmueble', '=', 'i.id')
         ->leftjoin('personas as p2', 'c.id_creador', '=', 'p2.id')
         ->leftjoin('personas as p3', 'c.id_modificador', '=', 'p3.id')
         ->leftjoin('comunas as o', 'i.id_comuna', '=', 'o.comuna_id')
         ->select(DB::raw('c.id as id_publicacion, DATE_FORMAT(c.created_at, "%d/%m/%Y") as fecha_creacion, c.id_estado as id_estado, CONCAT(p1.nombre," ",p1.apellido_paterno," ",p1.apellido_materno) as Propietario, CONCAT(p2.nombre," ",p2.apellido_paterno," ",p2.apellido_materno) as Creador'),'i.id as id_inmueble','i.direccion','i.numero','i.departamento', 'o.comuna_nombre','p1.nombre as nom_p','p1.apellido_paterno as apep_p','p1.apellido_materno as apem_p','p2.nombre as nom_c','p2.apellido_paterno as apep_c','p2.apellido_materno as apem_c','p3.nombre as nom_m','p3.apellido_paterno as apep_m','p3.apellido_materno as apem_m')
         ->get();
         
         return view('captacionesCorredor.index',compact('publica'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $corredores=Persona::where('tipo_cargo','=','Corredor')
        ->select(DB::raw('id , CONCAT(nombre," ",apellido_paterno," ",apellido_materno) as Corredor'))
        ->pluck('Corredor', 'id');
        return view('captacionesCorredor.create',compact('corredores'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
         $fecha_publicacion = DateTime::createFromFormat('d/m/Y', $request->fecha_publicacion);
        array_set($request, 'fecha_publicacion', $fecha_publicacion);
        
        if(isset($request->fecha_expiracion)){
                $fecha_expiracion = DateTime::createFromFormat('d/m/Y', $request->fecha_expiracion);
                array_set($request, 'fecha_expiracion',$fecha_expiracion);
        }


        $captacion = CaptacionCorredor::create($request->all());
        return redirect()->route('captacioncorredor.edit', $captacion->id)

            ->with('status', 'Publicación guardada con éxito');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\CaptacionCorredor  $captacionCorredor
     * @return \Illuminate\Http\Response
     */
    public function show(CaptacionCorredor $captacionCorredor)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\CaptacionCorredor  $captacionCorredor
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
         $regiones=Region::pluck('region_nombre','region_id');
        $captacion = CaptacionCorredor::find($id);
        $persona = Persona::find(isset($captacion->id_propietario)?$captacion->id_propietario:0);
        $inmueble = Inmueble::find(isset($captacion->id_inmueble)?$captacion->id_inmueble:0);

 $captaciones_persona = DB::table('cap_corredores as c')
         ->leftjoin('personas as p1', 'c.id_propietario', '=', 'p1.id')
         ->leftjoin('inmuebles as i', 'c.id_inmueble', '=', 'i.id')
         ->leftjoin('personas as p2', 'c.id_creador', '=', 'p2.id')
         ->leftjoin('personas as p3', 'c.id_modificador', '=', 'p3.id')
         ->leftjoin('comunas as o', 'i.id_comuna', '=', 'o.comuna_id')
         -> where("c.id_propietario","=",isset($captacion->id_propietario)?$captacion->id_propietario:0)
          -> where("c.id_propietario","!=","null")
        ->where("c.id_estado","=",1)
         ->select(DB::raw('c.id as id_publicacion, DATE_FORMAT(c.created_at, "%d/%m/%Y") as fecha_creacion, c.id_estado as id_estado, CONCAT(p1.nombre," ",p1.apellido_paterno," ",p1.apellido_materno) as Propietario, CONCAT(p2.nombre," ",p2.apellido_paterno," ",p2.apellido_materno) as Creador'),'i.id as id_inmueble','i.direccion','i.numero','i.departamento', 'o.comuna_nombre')
         ->get();

   $captaciones_inmueble = DB::table('cap_corredores as c')
         ->leftjoin('personas as p1', 'c.id_propietario', '=', 'p1.id')
         ->leftjoin('inmuebles as i', 'c.id_inmueble', '=', 'i.id')
         ->leftjoin('personas as p2', 'c.id_creador', '=', 'p2.id')
         ->leftjoin('personas as p3', 'c.id_modificador', '=', 'p3.id')
         ->leftjoin('comunas as o', 'i.id_comuna', '=', 'o.comuna_id')
         -> where("c.id_inmueble","=",isset($captacion->id_inmueble)?$captacion->id_inmueble:0)
         -> where("c.id_inmueble","!=","null")
        ->where("c.id_estado","=",1)
         ->select(DB::raw('c.id as id_publicacion, DATE_FORMAT(c.created_at, "%d/%m/%Y") as fecha_creacion, c.id_estado as id_estado, CONCAT(p1.nombre," ",p1.apellido_paterno," ",p1.apellido_materno) as Propietario, CONCAT(p2.nombre," ",p2.apellido_paterno," ",p2.apellido_materno) as Creador'),'i.id as id_inmueble','i.direccion','i.numero','i.departamento', 'o.comuna_nombre')
         ->get();
        $idr=null;

         $gestion = DB::table('cap_gestioncorredor as g')
         ->leftjoin('personas as p2', 'g.id_creador_gestion', '=', 'p2.id')
         ->where("g.id_capcorredor_gestion","=",$id)
         ->select(DB::raw('g.id, DATE_FORMAT(g.fecha_gestion, "%d/%m/%Y") as fecha_gestion,  CONCAT(p2.nombre," ",p2.apellido_paterno," ",p2.apellido_materno) as Creador'), 'g.dir','g.tipo_contacto','g.hora_gestion')
         ->get();

        $imagenes=CaptacionImageCorredor::where('id_capcorredor','=',$id)->get();
        return view('captacionesCorredor.edit',compact('captacion','regiones','persona','inmueble','idr','captaciones_persona','captaciones_inmueble','imagenes','gestion'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\CaptacionCorredor  $captacionCorredor
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CaptacionCorredor $captacionCorredor)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\CaptacionCorredor  $captacionCorredor
     * @return \Illuminate\Http\Response
     */
    public function destroy(CaptacionCorredor $captacionCorredor)
    {
        //
    }
}
