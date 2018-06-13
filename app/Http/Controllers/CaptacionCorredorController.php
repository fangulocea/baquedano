<?php

namespace App\Http\Controllers;

use App\CaptacionCorredor;
use App\CaptacionImageCorredor;
use App\CaptacionGestionCorredor;
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

        public function agregarInmueble($idc,$idi)
    {        
             $captacion = CaptacionCorredor::whereId($idc)->update([
                'id_inmueble'=> $idi
            ]
            );
        $inmueble = Inmueble::whereId($idi)->update([
                'estado'=> 1
            ]
            );
        return redirect()->route('captacioncorredor.edit', $idc)->with('status', 'Inmueble agregado con éxito');
    }

        public function agregarPropietario($idc,$idp)
    {        
             $captacion = CaptacionCorredor::whereId($idc)->update([
                'id_propietario'=> $idp
            ]
            );
        $persona = Persona::whereId($idp)->update([
                'id_estado'=> 1
            ]
            );
        
        return redirect()->route('captacioncorredor.edit', $idc)->with('status', 'Propietario agregado con éxito');
    }

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
        $corredores=Persona::where('tipo_cargo','=','Corredor')
        ->select(DB::raw('id , CONCAT(nombre," ",apellido_paterno," ",apellido_materno) as Corredor'))
        ->pluck('Corredor', 'id');
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
        return view('captacionesCorredor.edit',compact('captacion','regiones','persona','inmueble','idr','captaciones_persona','captaciones_inmueble','imagenes','gestion','corredores'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\CaptacionCorredor  $captacionCorredor
     * @return \Illuminate\Http\Response
     */
   public function update(Request $request, $id)
    {
         $corredores=Persona::where('tipo_cargo','=','Corredor')
        ->select(DB::raw('id , CONCAT(nombre," ",apellido_paterno," ",apellido_materno) as Corredor'))
        ->pluck('Corredor', 'id');
        if($request->paso=='1'){
        $fecha_publicacion = DateTime::createFromFormat('d/m/Y', $request->fecha_publicacion);
        array_set($request, 'fecha_publicacion', $fecha_publicacion);
        
        if(isset($request->fecha_expiracion)){
                $fecha_expiracion = DateTime::createFromFormat('d/m/Y', $request->fecha_expiracion);
                array_set($request, 'fecha_expiracion',$fecha_expiracion);
        }
            $data = request()->except(['_token','paso']);
            $captacion = CaptacionCorredor::whereId($id)->update($data);
            $captacion = CaptacionCorredor::find($id);
            $persona = Persona::find($captacion->id_propietario);
            $inmueble = Inmueble::find($captacion->id_inmueble);

        }elseif($request->paso=='2'){
              
            $captacion = CaptacionCorredor::find($id);

            //Propietario Nuevo
            if($captacion->id_propietario==null){
                    $p = Persona::where('rut', '=', $request->p_rut)->first();
                    if ($p != null && isset($request->p_rut)) {
                       return back()->with('error', 'Rut existente en el sistema');
                    }
                    $persona=Persona::create([
                            'rut'               => $request->p_rut,
                            'nombre'            => $request->p_nombre,
                            'apellido_paterno'  => $request->p_apellido_paterno,
                            'apellido_materno'  => $request->p_apellido_materno,
                            'direccion'         => $request->p_direccion,
                            'numero'            => $request->p_numero,
                            'departamento'      => $request->p_departamento,
                            'id_estado'         => '1',
                            'telefono'          => $request->p_telefono,
                            'email'             => $request->p_email,
                            'id_comuna'         => $request->p_id_comuna,
                            'id_region'         => $request->p_id_region,
                            'id_provincia'      => $request->p_id_provincia,
                            'tipo_cargo'        => 'Propietario',
          
                    ]);
            }
            //Propietario ya ingresado
            else{
                    $persona=Persona::whereId($captacion->id_propietario)->update([
                            'rut'               => $request->p_rut,
                            'nombre'            => $request->p_nombre,
                            'apellido_paterno'  => $request->p_apellido_paterno,
                            'apellido_materno'  => $request->p_apellido_materno,
                            'direccion'         => $request->p_direccion,
                            'numero'            => $request->p_numero,
                            'departamento'      => $request->p_departamento,
                            'telefono'          => $request->p_telefono,
                            'email'             => $request->p_email,
                            'id_comuna'         => $request->p_id_comuna,
                            'id_region'         => $request->p_id_region,
                            'id_provincia'      => $request->p_id_provincia,
                            'tipo_cargo'        => 'Propietario',
          
                    ]);
                    $persona = Persona::find($captacion->id_propietario);
            }
            //inmueble nuevo
            if($captacion->id_inmueble==null){
                    $p = Inmueble::where('direccion', '=', $request->i_direccion )
                    ->where('numero', '=', $request->i_numero)
                    ->where('departamento', '=',$request->i_departamento)
                    ->where('id_comuna', '=', $request->i_id_comuna)
                    ->first();
                    if ($p != null) {
                       return back()->with('error', 'Dirección existente en el sistema');
                    }
                    $inmueble=Inmueble::create([
                            'direccion'         => $request->i_direccion,
                            'numero'            => $request->i_numero,
                            'departamento'      => $request->i_departamento,
                            'dormitorio'        => $request->i_dormitorio,
                            'bano'              => $request->i_bano,
                            'estacionamiento'   => $request->i_estacionamiento,
                            'bodega'            => $request->i_bodega,
                            'piscina'           => $request->i_piscina,
                            'precio'            => $request->i_precio,
                            'gastosComunes'     => $request->i_gastosComunes,
                            'condicion'     => $request->i_condicion,
                            'estado'            => '1',
                            'id_comuna'         => $request->i_id_comuna,
                            'id_region'         => $request->i_id_region,
                            'id_provincia'      => $request->i_id_provincia,   
                    ]);
                    //inmueble ya ingresado
            }else{
                    $inmueble=Inmueble::whereId($captacion->id_inmueble)->update([
                            'direccion'         => $request->i_direccion,
                            'numero'            => $request->i_numero,
                            'departamento'      => $request->i_departamento,
                            'dormitorio'        => $request->i_dormitorio,
                            'bano'              => $request->i_bano,
                            'estacionamiento'   => $request->i_estacionamiento,
                            'bodega'            => $request->i_bodega,
                            'piscina'           => $request->i_piscina,
                            'precio'            => $request->i_precio,
                            'gastosComunes'     => $request->i_gastosComunes,
                            'condicion'         => $request->i_condicion,
                            'id_comuna'         => $request->i_id_comuna,
                            'id_region'         => $request->i_id_region,
                            'id_provincia'      => $request->i_id_provincia,  
                    ]);
                     $inmueble = Inmueble::find($captacion->id_inmueble);
            }


            $captacion = CaptacionCorredor::whereId($id)->update([
                'id_modificador' => $request->id_modificador,
                'id_propietario' => $persona->id,
                'id_inmueble'=> $inmueble->id
            ]
            );
            
        }elseif($request->paso=='3'){

        }elseif($request->paso=='4'){
            
        }else{

        }

        $regiones=Region::pluck('region_nombre','region_id');
        $captacion = CaptacionCorredor::find($id);

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
        return view('captacionesCorredor.edit',compact('captacion','regiones','persona','inmueble','idr','captaciones_persona','captaciones_inmueble','imagenes','gestion','corredores'));
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



//FOTOS
        public function savefotos(Request $request, $id){

         if(!isset($request->foto)){
            return redirect()->route('captacioncorredor.edit', $id)->with('error', 'Debe seleccionar una imagen');
         }
        $path='uploads/captacionesCorredor';
        $archivo=rand().$request->foto->getClientOriginalName();
        $img = Image::make($_FILES['foto']['tmp_name'])->resize(600,400, function ($constraint){ 
                        $constraint->aspectRatio();
                    });
        $img->save($path.'/'.$archivo,72);

                $imagen=CaptacionImageCorredor::create([
                            'id_capcorredor'         => $id,
                            'descripcion'          => '',
                            'nombre'               => $archivo,
                            'ruta'                 => $path,
                            'id_creador'           => $request->id_creador
                        ]);

        

        return redirect()->route('captacioncorredor.edit', $id)->with('status', 'Foto guardada con éxito');
    }

       public function eliminarfoto($idf,$idc){
        $imagen=CaptacionImageCorredor::find($idf);
        File::delete($imagen->ruta.'/'.$imagen->nombre);
        $foto = CaptacionImageCorredor::find($idf)->delete();

        return redirect()->route('captacioncorredor.edit', $idc)->with('status', 'Foto eliminada con éxito');
    }

//FIN FOTOS

    //GESTION

    public function crearGestion(Request $request)
    {
        $fecha_gestion = DateTime::createFromFormat('d-m-Y', $request->fecha_gestion);
        array_set($request, 'fecha_gestion', $fecha_gestion);
        $captacion = CaptacionGestionCorredor::create($request->all());
        return redirect()->route('captacioncorredor.edit', $request->id_capcorredor_gestion)

            ->with('status', 'Gestión guardada con éxito');
    }

  public function editarGestion(Request $request)
    {
        $fecha_gestion = DateTime::createFromFormat('d-m-Y', $request->fecha_gestion);
        array_set($request, 'fecha_gestion', $fecha_gestion);
        $captacion = CaptacionGestionCorredor::where('id','=',$request->id_capcorredor_gestion)
        ->update([
            'dir' => $request->dir,
            'detalle_contacto' => $request->detalle_contacto,
            'id_modificador_gestion' => $request->id_modificador_gestion,
            'fecha_gestion' => $request->fecha_gestion,
            'hora_gestion' => $request->hora_gestion
        ]);
        return redirect()->route('captacioncorredor.edit', $request->id_capcorredor_gestion)

            ->with('status', 'Gestión guardada con éxito');
    }

    public function mostrarGestion(Request $request, $idg){
            $gestion=CaptacionGestionCorredor::where('id','=',$idg)->get();
            return response()->json($gestion);  
    }

    // FIN GESTION
}
