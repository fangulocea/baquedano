<?php

namespace App\Http\Controllers;

use App\Arrendatario;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Persona;
use App\Inmueble;
use App\Region;
use App\ArrendatarioFoto;
use App\CaptacionGestion;
use App\Portales;
use App\CaptacionImport;
use App\ArrendatarioCitas;
use DB;
use Image;
use DateTime;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\File;

class ArrendatarioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         $arrendador = DB::table('arrendatarios as a')
         ->leftjoin('personas as p1', 'a.id_arrendatario', '=', 'p1.id')
         ->leftjoin('users as p2', 'a.id_creador', '=', 'p2.id')
         ->leftjoin('personas as p3', 'a.id_modificador', '=', 'p3.id')
         ->select(DB::raw('a.id, DATE_FORMAT(a.created_at, "%d/%m/%Y") as fecha_creacion, a.id_estado, CONCAT_WS(" ", p1.nombre, p1.apellido_paterno, p1.apellido_materno) as Arrendador, p2.name as Creador'))->get();
         
         return view('arrendatario.index',compact('arrendador'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $regiones=Region::pluck('region_nombre','region_id');
        return view('arrendatario.create',compact('regiones')); 
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request = array_add($request, 'id_estado', 1);
        $request = array_add($request, 'tipo_cargo', 'Arrendatario');
        
        $persona = Persona::create($request->all());

        $arrendatario=Arrendatario::create([                      
                            'id_arrendatario'   => $persona->id,
                            'id_creador'        => $request->id_creador,
                            'id_modificador'    => $request->id_creador,
                            'preferencias'      => $request->preferencias,
                            'id_estado'         => '1',
                    ]);

        return redirect()->route('arrendatario.edit', $arrendatario->id)
            ->with('status', 'Persona guardada con éxito');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Arrendatario  $arrendatario
     * @return \Illuminate\Http\Response
     */
    public function show(Arrendatario $arrendatario)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Arrendatario  $arrendatario
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $regiones=Region::pluck('region_nombre','region_id');
        $arrendatario = Arrendatario::find($id);
        $persona = Persona::find(isset($arrendatario->id_arrendatario)?$arrendatario->id_arrendatario:0);
        $imagenes=ArrendatarioFoto::where('id_arrendatario','=',$id)->get();
        $citas=ArrendatarioCitas::where('id_arrendatario','=',$id)->get();
        $inmueble = Inmueble::find($arrendatario->id_inmueble);
        return view('arrendatario.edit',compact('arrendatario','regiones','persona','imagenes','citas','inmueble'));
    }

    public function agregarInmueble($idc,$idi)
    {        
             $captacion = Arrendatario::whereId($idc)->update([
                'id_inmueble'=> $idi
            ]
            );
        $inmueble = Inmueble::whereId($idi)->update([
                'estado'=> 1
            ]
            );
        return redirect()->route('arrendatario.edit', $idc)->with('status', 'Inmueble agregado con éxito');
    }



    public function updateinmueble(Request $request, $id)
    {

         $captacion = Arrendatario::find($id);
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
                            'rol'               => $request->i_rol,
                            'nro_bodega'        => $request->i_nro_bodega,
                            'referencia'         => $request->i_referencia,
                            'piscina'           => $request->i_piscina,
                            'precio'            => $request->i_precio,
                            'gastosComunes'     => $request->i_gastosComunes,
                            'condicion'         => $request->i_condicion,

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
                            'nro_bodega'        => $request->i_nro_bodega,
                            'rol'               => $request->i_rol,
                            'referencia'         => $request->i_referencia,
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

                $captacion = Arrendatario::find($id)->update([
                    "id_inmueble"  => $inmueble->id
                ]);

        return redirect()->route('arrendatario.edit', $id)->with('status', 'Datos almacenados correctamente');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Arrendatario  $arrendatario
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if($request->paso=='2')
        {
             $arrendatario = Arrendatario::find($id);
            //Propietario Nuevo
            if($arrendatario->id_arrendatario==null)
            {
                    $p = Persona::where('rut', '=', $request->p_rut)->first();
                    if ($p != null && isset($request->p_rut)) 
                    {
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
                            'tipo_cargo'        => 'Arrendatario',
          
                    ]);
            }
            //Propietario ya ingresado
            else
            {
                    $persona=Persona::whereId($arrendatario->id_arrendatario)->update([
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
                    $persona = Persona::find($arrendatario->id_arrendatario);
            }
            

            $arrendatario = Arrendatario::whereId($id)->update([
                'id_modificador' => $request->id_modificador,
                'preferencias' => $request->preferencias,
                'id_arrendatario' => $persona->id,
            ]
            );
            
        }elseif($request->paso=='3'){

            $citaArr = ArrendatarioCitas::where('id_arrendatario','=',$id)->get();
            $fecha=date("Y-m-d",strtotime($request->fecha));
            if(isset($citaArr))
            {
                    $citas=ArrendatarioCitas::create([
                            'nombre'            => $request->c_nombre,
                            'telefono'          => $request->c_telefono,
                            'email'             => $request->c_email,
                            'direccion'         => $request->c_direccion,
                            'numero'            => $request->c_numero,
                            'departamento'      => $request->c_departamento,
                            'nombre_c'          => $request->cc_nombre,
                            'telefono_c'        => $request->cc_telefono,
                            'email_c'           => $request->cc_email,
                            'fecha'             => $fecha,
                            'id_estado'         => $request->id_estado,
                            'id_creador'        => $request->id_modificador,
                            'id_arrendatario'   => $request->idarriendos,
                    ]);
            }
            //Cita ya ingresado
            else
            {
                    $persona=ArrendatarioCitas::whereId($citaArr->id)->update([
                            'nombre'            => $request->c_nombre,
                            'telefono'          => $request->c_telefono,
                            'email'             => $request->c_email,
                            'direccion'         => $request->c_direccion,
                            'numero'            => $request->c_numero,
                            'departamento'      => $request->c_departamento,
                            'nombre_c'          => $request->cc_nombre,
                            'telefono_c'        => $request->cc_telefono,
                            'email_c'           => $request->cc_email,
                            'fecha'             => $fecha,
                            'id_estado'         => $request->id_estado,
                            'id_creador'        => $request->id_modificador,
                            'id_arrendatario'   => $request->idarriendos,
          
                    ]);
                   
            }
 
        }elseif($request->paso=='4'){
            
        }else{

        }

        $regiones=Region::pluck('region_nombre','region_id');
        $arrendatario = Arrendatario::find($id);

        $arrendatario1 = Arrendatario::whereId($id)->update([
                'id_estado' => $request->id_estado
            ]
            );

        // $imagenes=CaptacionFoto::where('id_captacion','=',$id)->get();

        return redirect()->route('arrendatario.edit', $id)->with('status', 'Datos almacenados correctamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Arrendatario  $arrendatario
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        
        $arr = Arrendatario::where('id','=',$id)->update([
            'id_estado' => '0'
        ]);

        return redirect()->route('arrendatario.edit', $id)->with('status', 'Arrendatario desactivado con éxito');
    }


    public function savefotos(Request $request, $id){
     /*    if ($_FILES['foto']['size'] > 1000000) 
         {
            return back()->with('error', 'Imágen supera 1MB');      
         } */
        if(isset($request->foto))
        {
            $path='uploads/arrendatarios';
            $archivo=rand().$request->foto->getClientOriginalName();
            $img = Image::make($_FILES['foto']['tmp_name'])->resize(600,400, function ($constraint){ 
                            $constraint->aspectRatio();
                        });
            $img->save($path.'/'.$archivo,72);

            $imagen=ArrendatarioFoto::create([
                   'id_arrendatario'      => $id,
                   'descripcion'          => '',
                   'nombre'               => $archivo,
                   'ruta'                 => $path,
                   'id_creador'           => $request->id_creador
            ]);
        }
        else
        {
            return redirect()->route('arrendatario.edit', $id)->with('status', 'No se ha actualizado ninguna imágen');
        }
        return redirect()->route('arrendatario.edit', $id)->with('status', 'Foto guardada con éxito');
    }


/**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\captacion  $captacion
     * @return \Illuminate\Http\Response
     */
    public function eliminarfoto($idf,$idc){
        $imagen=ArrendatarioFoto::find($idf);
        File::delete($imagen->ruta.'/'.$imagen->nombre);
        $foto = ArrendatarioFoto::find($idf)->delete();
        return redirect()->route('arrendatario.edit', $idc)->with('status', 'Foto eliminada con éxito');
    }


  public function crearGestion(Request $request)
    {
        $fecha = DateTime::createFromFormat('d-m-Y', $request->fecha);
        array_set($request, 'fecha', $fecha);

        $citas = ArrendatarioCitas::create($request->all());
        return redirect()->route('arrendatario.edit', $request->id_arrendatario)

            ->with('status', 'Cita guardada con éxito');
    }

  public function editarGestion(Request $request)
    {
        $fecha = DateTime::createFromFormat('d-m-Y', $request->fecha);
        array_set($request, 'fecha', $fecha);

        $captacion = ArrendatarioCitas::where('id','=',$request->id_citas)
        ->update([
            'nombre'            => $request->nombre,
            'telefono'          => $request->telefono,
            'email'             => $request->email,
            'direccion'         => $request->direccion,
            'numero'            => $request->numero,
            'departamento'      => $request->departamento,
            'nombre_c'          => $request->nombre_c,
            'telefono_c'        => $request->telefono_c,
            'email_c'           => $request->email_c,
            'fecha'             => $request->fecha,
            'estado'            => $request->estado,
            'id_creador'        => $request->id_creador,
            'id_arrendatario'   => $request->id_arrendatario
        ]);
        return redirect()->route('arrendatario.edit', $request->id_citas)

            ->with('status', 'Cita guardada con éxito');
    }

public function mostrarGestion(Request $request, $idg){
            $gestion=ArrendatarioCitas::where('id','=',$idg)->get();
            return response()->json($gestion);  
    }





}
