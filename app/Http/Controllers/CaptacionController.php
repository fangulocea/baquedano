<?php

namespace App\Http\Controllers;

use App\Captacion;
use App\Persona;
use App\Inmueble;
use App\Region;
use App\CaptacionFoto;
use App\CaptacionGestion;
use App\Portales;
use App\CaptacionImport;
use Illuminate\Http\Request;
use DB;
use Image;
use DateTime;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\File;
use Excel;

class CaptacionController extends Controller
{

    public function reportes(){

         $publica = DB::table('cap_publicaciones as c')
         ->leftjoin('personas as p1', 'c.id_propietario', '=', 'p1.id')
         ->leftjoin('inmuebles as i', 'c.id_inmueble', '=', 'i.id')
         ->leftjoin('personas as p2', 'c.id_creador', '=', 'p2.id')
         ->leftjoin('personas as p3', 'c.id_modificador', '=', 'p3.id')
         ->leftjoin('comunas as o', 'i.id_comuna', '=', 'o.comuna_id')
         ->leftjoin('portales as po', 'c.portal', '=', 'po.id')
         ->select(DB::raw('c.id as id_publicacion,(select count(*) from cap_gestion where id_captacion_gestion=c.id) as cantGes ,DATE_FORMAT(c.created_at, "%d/%m/%Y") as fecha_creacion, c.id_estado as id_estado, CONCAT(p1.nombre," ",p1.apellido_paterno," ",p1.apellido_materno) as Propietario, CONCAT(p2.nombre," ",p2.apellido_paterno," ",p2.apellido_materno) as Creador, (select count(*) from cap_gestion where id_captacion_gestion=c.id and (tipo_contacto="Sin Respuesta" or tipo_contacto="Reenvío" or tipo_contacto="Correo Eléctronico" or tipo_contacto="Vigente") and (dir = "Información Enviada" or dir = "Ambas")) as cantCorreos'),'i.id as id_inmueble','i.direccion','i.numero','i.departamento', 'o.comuna_nombre','po.nombre as portal','p1.nombre as nom_p','p1.apellido_paterno as apep_p','p1.apellido_materno as apem_p','p2.nombre as nom_c','p2.apellido_paterno as apep_c','p2.apellido_materno as apem_c','p3.nombre as nom_m','p3.apellido_paterno as apep_m','p3.apellido_materno as apem_m')
         ->select(DB::raw('c.id as id_publicacion,(select count(*) from cap_gestion where id_captacion_gestion=c.id) as cantGes ,DATE_FORMAT(c.created_at, "%d/%m/%Y") as fecha_creacion, c.id_estado as id_estado, CONCAT(p1.nombre," ",p1.apellido_paterno," ",p1.apellido_materno) as Propietario, CONCAT(p2.nombre," ",p2.apellido_paterno," ",p2.apellido_materno) as Creador, (select count(*) from cap_gestion where id_captacion_gestion=c.id and (tipo_contacto="Sin Respuesta" or tipo_contacto="Reenvío" or tipo_contacto="Correo Eléctronico" or tipo_contacto="Seguimiento Correo") and (dir = "Información Enviada" or dir = "Ambas")) as cantCorreos'),'i.id as id_inmueble','i.direccion','i.numero','i.departamento', 'o.comuna_nombre','po.nombre as portal','p1.nombre as nom_p','p1.apellido_paterno as apep_p','p1.apellido_materno as apem_p','p2.nombre as nom_c','p2.apellido_paterno as apep_c','p2.apellido_materno as apem_c','p3.nombre as nom_m','p3.apellido_paterno as apep_m','p3.apellido_materno as apem_m')
         ->get();
         
         return view('reporteCap.index',compact('publica'));
    }


    public function importExport()
    {

      $correo = DB::table('correos')
      ->where('estado','=',1)
      ->get();
        return view('importar.index',compact('correo'));
    }

    public function getCaptacionesCorreo($id)
    {
      $publica = DB::table('cap_publicaciones as c')
           ->leftjoin('personas as p1', 'c.id_propietario', '=', 'p1.id')
           ->leftjoin('inmuebles as i', 'c.id_inmueble', '=', 'i.id')
           ->leftjoin('personas as p2', 'c.id_creador', '=', 'p2.id')
           ->leftjoin('personas as p3', 'c.id_modificador', '=', 'p3.id')
           ->leftjoin('comunas as o', 'i.id_comuna', '=', 'o.comuna_id')
           ->leftjoin('portales as po', 'c.portal', '=', 'po.id')
           ->Where('p1.email','<>','')
           ->where('p1.email','like','%@%')
           ->where('c.id_creador','=',$id)
           ->where('c.id_estado','=','1')
           ->select(DB::raw('c.id as id_publicacion, DATE_FORMAT(c.created_at, "%d/%m/%Y") as fecha_creacion, c.id_estado as id_estado, CONCAT(p1.nombre," ",p1.apellido_paterno," ",p1.apellido_materno) as Propietario, CONCAT(p2.nombre," ",p2.apellido_paterno," ",p2.apellido_materno) as Creador'),'i.id as id_inmueble','i.direccion','i.numero','i.departamento', 'o.comuna_nombre','po.nombre as portal','c.id_propietario','c.id_creador','p1.email','p1.nombre as nom_p','p1.apellido_paterno as apep_p','p1.apellido_materno as apem_p','p2.nombre as nom_c','p2.apellido_paterno as apep_c','p2.apellido_materno as apem_c','p3.nombre as nom_m','p3.apellido_paterno as apep_m','p3.apellido_materno as apem_m')
           ->get();
           return response()->json($publica);


    }

        public function getCaptacionesGestiones($id)
    {
      $publica = DB::table('cap_publicaciones as c')
           ->leftjoin('personas as p1', 'c.id_propietario', '=', 'p1.id')
           ->leftjoin('inmuebles as i', 'c.id_inmueble', '=', 'i.id')
           ->leftjoin('personas as p2', 'c.id_creador', '=', 'p2.id')
           ->leftjoin('personas as p3', 'c.id_modificador', '=', 'p3.id')
           ->leftjoin('comunas as o', 'i.id_comuna', '=', 'o.comuna_id')
           ->leftjoin('portales as po', 'c.portal', '=', 'po.id')
           ->Where('p1.email','<>','')
           ->where('p1.email','like','%@%')
           ->where('c.id_creador','=',$id)
           ->select(DB::raw('c.id as id_publicacion, DATE_FORMAT(c.created_at, "%d/%m/%Y") as fecha_creacion, c.id_estado as id_estado, CONCAT(p1.nombre," ",p1.apellido_paterno," ",p1.apellido_materno) as Propietario, CONCAT(p2.nombre," ",p2.apellido_paterno," ",p2.apellido_materno) as Creador'),'i.id as id_inmueble','i.direccion','i.numero','i.departamento', 'o.comuna_nombre','po.nombre as portal','c.id_propietario','c.id_creador','p1.email','p1.nombre as nom_p','p1.apellido_paterno as apep_p','p1.apellido_materno as apem_p','p2.nombre as nom_c','p2.apellido_paterno as apep_c','p2.apellido_materno as apem_c','p3.nombre as nom_m','p3.apellido_paterno as apep_m','p3.apellido_materno as apem_m')
           ->get();
           return response()->json($publica);

           

    }

    public function downloadExcel($type)
    {
        $data = CaptacionImport::
        whereRaw('Date(created_at) = CURDATE()')
        ->orderBy('created_at','DESC')
        ->get()->toArray();
        return Excel::create('captaciones', function($excel) use ($data) {
            $excel->sheet('baquedano', function($sheet) use ($data)
            {
                $sheet->fromArray($data);
            });
        })->download($type);
    }

    public function importExcel(Request $request)
    {

        if(Input::hasFile('import_file')){
            $path = Input::file('import_file')->getRealPath();
            $data = Excel::load($path, function($reader) {
            })->get();
            $now = new \DateTime();
            $fecha_creacion= $now->format('Y-m-d H:i:s');
            if(!empty($data) && $data->count()){
                foreach ($data as $key => $value) {
                      if($value->captador=='' || $value->captador==null){
                    break;
                }
                
                    $insert[] = [
                    'captador'               => $value->captador
                    ,'fecha_publicacion'     => $value->fecha_de_publicacion
                    ,'Direccion'             => $value->direccion
                    ,'nro'                   => $value["nro."]
                    ,'dpto'                  => $value["dpto."]
                    ,'comuna'                => $value->comuna
                    ,'dorm'                  => $value->dorm
                    ,'bano'                  => $value->bano
                    ,'esta'                  => $value->esta
                    ,'pisc'                  => $value->pisc
                    ,'Precio'                => $value->precio
                    ,'GASTOS_COMUNES'        => $value->gastos_comunes
                    ,'CONDICION'             => $value->condicion
                    ,'nombre_propietario'    => $value->nombre_propietario
                    ,'TELEFONO'              => $value->telefono
                    ,'correo'                => $value->correo
                    ,'portal'                => $value->portal
                    ,'FECHA_ENVIO_CLIENTE'   => $value->fecha_envio_info_a_cliente
                    ,'OBSERVACIONES'         => $value->observaciones
                    ,'LINK'                  => $value->link_ubicacion_web
                    ,'Codigo_Publicacion'    => $value->codigo_publicacion
                    ,'id_creador'            => $request->idusuario
                    ,'created_at'            => $fecha_creacion
                     ];

                }                        
                if(!empty($insert)){
                    DB::table('cap_import')->insert($insert);
                    return back()->with('status', 'Registros subidos a memoria exitosamente');
                }
               
            }
        }
        return back()->with('error', 'No fue posible subir la información a memoria');
    }

   public function limpiarxls($id)
    {
          DB::table('cap_import')
          ->where("id_creador","=",$id)
          ->where("id_estado","=",null)
          ->delete();
          return back()->with('status', 'Se ha limpiado la memoria exitosamente');
    }

    public function procesarxls($id)
    {
        $registros=DB::table('cap_import')
        ->where('id_creador','=',$id)
        ->where('id_estado','=',null)
        ->where('id_estado','=',null)
        ->whereRaw('Date(created_at) = CURDATE()')
        ->get();
        
        if(count($registros)==0){
            return back()->with('error', 'No tiene registros por procesar');
        }

        foreach ($registros as $r ) {
           $user=DB::table('personas')->where('email','=',$r->CAPTADOR)->first();
           if(count($user)==0){
                CaptacionImport::where('id','=',$r->id)->update([
                'id_estado' => 0,
                'ob_estado' => 'Usuario captador no coincide'
                ]);
                continue;
           }
           $id_usuario=$user->id;

           $part_portal=explode("/", $r->LINK);
           $portal=DB::table('portales')->where('nombre','=',trim($part_portal[2]))->first();
           if(count($portal)==0){
                    $portal=Portales::create([
                    "nombre"         => $part_portal[2]
                ])->toArray();
           }
           $portal=DB::table('portales')->where('nombre','=',trim($part_portal[2]))->first();
           $id_portal=$portal->id;

           $comuna=DB::table('comunas')->where('comuna_nombre','=',$r->Comuna)->first();
           if(count($comuna)==0){
                CaptacionImport::where('id','=',$r->id)->update([
                'id_estado' => 0,
                'ob_estado' => 'Comuna no coincide'
                ]);
                continue;
           }
           $id_comuna=$comuna->comuna_id;
           $id_provincia=$comuna->provincia_id;
           $provincia=DB::table('provincias')->where('provincia_id','=',$comuna->provincia_id)->first();
           $id_region=$provincia->region_id;
           $fecha_publicacion=$r->Fecha_publicacion;
           if($r->Esta=='si'){
                $estacionamiento=1;
           }else{
                $estacionamiento=0;
           }
           if($r->Bode=='si'){
                $bodega=1;
           }else{
                $bodega=0;
           }
           $inmueble=Inmueble::where("direccion","=",$r->Direccion)
           ->where("numero","=",$r->Nro)
           ->where("departamento","=",$r->Dpto)
           ->where("id_comuna","=",$id_comuna)->first();

           if(count($inmueble)==0){

                $inmueble=Inmueble::create([
                    "direccion"         => $r->Direccion,
                    "numero"            => $r->Nro,
                    "departamento"      => $r->Dpto,
                    "id_comuna"         => $id_comuna,
                    "id_region"         => $id_region,
                    "id_provincia"      => $id_provincia,
                    "dormitorio"        => $r->Dorm,
                    "bano"              => $r->Bano,
                    "estacionamiento"   => $estacionamiento,
                    "bodega"            => $bodega,
                    "piscina"           => $r->Pisc,
                    "precio"            => $r->Precio,
                    "observaciones"     => $r->OBSERVACIONES,
                    "gastosComunes"     => $r->GASTOS_COMUNES,
                    "estado"            => '1',
                    "condicion"         => $r->CONDICION
                ])->toArray();
                
           }

           
           //dd($inmueble);
            $id_inmueble=$inmueble['id'];

           if(!isset($r->correo)){
                $correo="sin informacion";
           }else{
                 $correo=$r->correo;
           }

           if(!isset($r->nombre_propietario) || $r->nombre_propietario==""){
                $nombre_propietario="Sin información";
           }else{
                $nombre_propietario=$r->nombre_propietario;
           }
           $parte_prop=explode(" ", $nombre_propietario);
           $nom="";
           $seg="";
           $apep="";
           $apem="";

           switch (count($parte_prop)) {
            case 1:
                   $nom=$parte_prop[0];
                   break;
              case 2:
                   $nom=$parte_prop[0];
                   $apep=$parte_prop[1];
                   break;
              case 3:
              //dd($nombre_propietario);
                   $nom=$parte_prop[0];
                   $apep=$parte_prop[1];
                   $apem=$parte_prop[2];
                   break;
             case 4:
                   $nom=$parte_prop[0].' '.$parte_prop[1];
                   $apep=$parte_prop[2];
                   $apem=$parte_prop[3];
                   break;
               
               default:
                   # code...
                   break;
           }

            $persona=Persona::where("email","=",$r->correo)
           ->where("telefono","=",$r->TELEFONO)
           ->where("nombre","=",$nom)
           ->where("apellido_paterno","=",$apep)
           ->where("apellido_materno","=",$apem)
           ->whereNotNull("email")
           ->whereNotNull("telefono")
            ->first();

           if(count($persona)==0){

            $partes=explode(" ", $r->nombre_propietario);

                $persona=Persona::create([
                    "nombre" => $nom,
                    "apellido_paterno" => $apep,
                    "apellido_materno" => $apem,
                    "telefono"        => $r->TELEFONO,
                    "email"          => $correo,
                    "id_estado"          => '1',
                    "tipo_cargo"      => 'Propietario'
                ])->toArray();
           }

            $id_persona=$persona['id'];

           Captacion::create([
                "portal" => $id_portal,
                "url" => $r->LINK,
                "fecha_publicacion" => $r->Fecha_publicacion,
                "codigo_publicacion" => $r->Codigo_Publicacion,
                "id_creador" => $id_usuario,
                "id_propietario" => $id_persona,
                "id_inmueble" => $id_inmueble,
                "id_estado" => "1"
           ]);
           CaptacionImport::where('id','=',$r->id)->update([
                'id_estado' => 1,
                'ob_estado' => 'Importado'
                ]);
        }
        
        return back()->with('status', 'Registros procesados, Favor continue al siguiente paso');
    }



    public function importarGestion($id){
        
        $captacion = Captacion::find($id);

         $personas = DB::table('personas')
        ->leftjoin('comunas', 'personas.id_comuna', '=', 'comunas.comuna_id')
        ->Where('personas.id','<>',1)
        ->Where('personas.id','=',isset($captacion->id_propietario)?$captacion->id_propietario:0)
        ->get();
        $persona=$personas[0];

        $inmueble = DB::table('inmuebles')
        ->join('comunas', 'inmuebles.id_comuna', '=', 'comunas.comuna_id')
        ->where('id','=',isset($captacion->id_inmueble)?$captacion->id_inmueble:0)
        ->get();
        $inmueble=$inmueble[0];

        $gestion = DB::table('cap_gestion as g')
         ->leftjoin('personas as p2', 'g.id_creador_gestion', '=', 'p2.id')
         ->where("g.id_captacion_gestion","=",$id)
         ->select(DB::raw('g.id, DATE_FORMAT(g.fecha_gestion, "%d/%m/%Y") as fecha_gestion,  CONCAT(p2.nombre," ",p2.apellido_paterno," ",p2.apellido_materno) as Creador'), 'g.dir','g.tipo_contacto','g.hora_gestion')
         ->get();

       return view('importar.gestion',compact('gestion','id','persona','inmueble'));
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
         ->select(DB::raw('c.id as id_publicacion, DATE_FORMAT(c.created_at, "%d/%m/%Y") as fecha_creacion, c.id_estado as id_estado, CONCAT(p1.nombre," ",p1.apellido_paterno," ",p1.apellido_materno) as Propietario, CONCAT(p2.nombre," ",p2.apellido_paterno," ",p2.apellido_materno) as Creador'),'i.id as id_inmueble','i.direccion','i.numero','i.departamento', 'o.comuna_nombre','po.nombre as portal','p1.nombre as nom_p','p1.apellido_paterno as apep_p','p1.apellido_materno as apem_p','p2.nombre as nom_c','p2.apellido_paterno as apep_c','p2.apellido_materno as apem_c','p3.nombre as nom_m','p3.apellido_paterno as apep_m','p3.apellido_materno as apem_m')
         ->get();
         
         return view('captaciones.index',compact('publica'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $portales=Portales::pluck('nombre','id');
        return view('captaciones.create',compact('portales'));
    }

  public function crearGestion(Request $request)
    {
        $fecha_gestion = DateTime::createFromFormat('d-m-Y', $request->fecha_gestion);
        array_set($request, 'fecha_gestion', $fecha_gestion);
        $captacion = CaptacionGestion::create($request->all());
        return redirect()->route('captacion.edit', $request->id_captacion_gestion)

            ->with('status', 'Gestión guardada con éxito');
    }

  public function editarGestion(Request $request)
    {
        $fecha_gestion = DateTime::createFromFormat('d-m-Y', $request->fecha_gestion);
        array_set($request, 'fecha_gestion', $fecha_gestion);
        $captacion = CaptacionGestion::where('id','=',$request->id_captacion_gestion)
        ->update([
            'dir' => $request->dir,
            'detalle_contacto' => $request->detalle_contacto,
            'id_modificador_gestion' => $request->id_modificador_gestion,
            'fecha_gestion' => $request->fecha_gestion,
            'hora_gestion' => $request->hora_gestion
        ]);
        return redirect()->route('captacion.edit', $request->id_captacion_gestion)

            ->with('status', 'Gestión guardada con éxito');
    }


    public function crearGestion_proceso(Request $request)
    {
        $fecha_gestion = DateTime::createFromFormat('d-m-Y', $request->fecha_gestion);
        array_set($request, 'fecha_gestion', $fecha_gestion);
        $captacion = CaptacionGestion::create($request->all());
        return redirect()->route('captacion.importarGestion', $request->id_captacion_gestion)

            ->with('status', 'Gestión guardada con éxito');
    }

  public function editarGestion_proceso(Request $request)
    {
        $fecha_gestion = DateTime::createFromFormat('d-m-Y', $request->fecha_gestion);
        array_set($request, 'fecha_gestion', $fecha_gestion);
        $captacion = CaptacionGestion::where('id','=',$request->id_captacion_gestion)
        ->update([
            'dir' => $request->dir,
            'detalle_contacto' => $request->detalle_contacto,
            'id_modificador_gestion' => $request->id_modificador_gestion,
            'fecha_gestion' => $request->fecha_gestion,
            'hora_gestion' => $request->hora_gestion
        ]);
        return redirect()->route('captacion.importarGestion', $request->id_captacion_gestion)

            ->with('status', 'Gestión guardada con éxito');
    }

    public function mostrarGestion(Request $request, $idg){
            $gestion=CaptacionGestion::where('id','=',$idg)->get();
            return response()->json($gestion);  
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


        $captacion = Captacion::create($request->all());
        return redirect()->route('captacion.edit', $captacion->id)

            ->with('status', 'Publicación guardada con éxito');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\captacion  $captacion
     * @return \Illuminate\Http\Response
     */
    public function show(captacion $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\captacion  $captacion
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $portales=Portales::pluck('nombre','id');
         $regiones=Region::pluck('region_nombre','region_id');
        $captacion = Captacion::find($id);
        $persona = Persona::find(isset($captacion->id_propietario)?$captacion->id_propietario:0);
        $inmueble = Inmueble::find(isset($captacion->id_inmueble)?$captacion->id_inmueble:0);

 $captaciones_persona = DB::table('cap_publicaciones as c')
         ->leftjoin('personas as p1', 'c.id_propietario', '=', 'p1.id')
         ->leftjoin('inmuebles as i', 'c.id_inmueble', '=', 'i.id')
         ->leftjoin('personas as p2', 'c.id_creador', '=', 'p2.id')
         ->leftjoin('personas as p3', 'c.id_modificador', '=', 'p3.id')
         ->leftjoin('comunas as o', 'i.id_comuna', '=', 'o.comuna_id')
         ->leftjoin('portales as po', 'c.portal', '=', 'po.id')
         -> where("c.id_propietario","=",isset($captacion->id_propietario)?$captacion->id_propietario:0)
          -> where("c.id_propietario","!=","null")
        ->where("c.id_estado","=",1)
         ->select(DB::raw('c.id as id_publicacion, DATE_FORMAT(c.created_at, "%d/%m/%Y") as fecha_creacion, c.id_estado as id_estado, CONCAT(p1.nombre," ",p1.apellido_paterno," ",p1.apellido_materno) as Propietario, CONCAT(p2.nombre," ",p2.apellido_paterno," ",p2.apellido_materno) as Creador'),'i.id as id_inmueble','i.direccion','i.numero','i.departamento', 'o.comuna_nombre','po.nombre as portal')
         ->get();

   $captaciones_inmueble = DB::table('cap_publicaciones as c')
         ->leftjoin('personas as p1', 'c.id_propietario', '=', 'p1.id')
         ->leftjoin('inmuebles as i', 'c.id_inmueble', '=', 'i.id')
         ->leftjoin('personas as p2', 'c.id_creador', '=', 'p2.id')
         ->leftjoin('personas as p3', 'c.id_modificador', '=', 'p3.id')
         ->leftjoin('comunas as o', 'i.id_comuna', '=', 'o.comuna_id')
         ->leftjoin('portales as po', 'c.portal', '=', 'po.id')
         -> where("c.id_inmueble","=",isset($captacion->id_inmueble)?$captacion->id_inmueble:0)
         -> where("c.id_inmueble","!=","null")
        ->where("c.id_estado","=",1)
         ->select(DB::raw('c.id as id_publicacion, DATE_FORMAT(c.created_at, "%d/%m/%Y") as fecha_creacion, c.id_estado as id_estado, CONCAT(p1.nombre," ",p1.apellido_paterno," ",p1.apellido_materno) as Propietario, CONCAT(p2.nombre," ",p2.apellido_paterno," ",p2.apellido_materno) as Creador'),'i.id as id_inmueble','i.direccion','i.numero','i.departamento', 'o.comuna_nombre','po.nombre as portal')
         ->get();
        $idr=null;

         $gestion = DB::table('cap_gestion as g')
         ->leftjoin('personas as p2', 'g.id_creador_gestion', '=', 'p2.id')
         ->where("g.id_captacion_gestion","=",$id)
         ->select(DB::raw('g.id, DATE_FORMAT(g.fecha_gestion, "%d/%m/%Y") as fecha_gestion,  CONCAT(p2.nombre," ",p2.apellido_paterno," ",p2.apellido_materno) as Creador'), 'g.dir','g.tipo_contacto','g.hora_gestion')
         ->get();

        $imagenes=CaptacionFoto::where('id_captacion','=',$id)->get();

        return view('captaciones.edit',compact('captacion','regiones','persona','inmueble','idr','captaciones_persona','captaciones_inmueble','imagenes','portales','gestion'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\captacion  $captacion
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {        

        if($request->paso=='1'){
        $fecha_publicacion = DateTime::createFromFormat('d/m/Y', $request->fecha_publicacion);
        array_set($request, 'fecha_publicacion', $fecha_publicacion);
        
        if(isset($request->fecha_expiracion)){
                $fecha_expiracion = DateTime::createFromFormat('d/m/Y', $request->fecha_expiracion);
                array_set($request, 'fecha_expiracion',$fecha_expiracion);
        }
            $data = request()->except(['_token','paso']);
            $captacion = Captacion::whereId($id)->update($data);
            $captacion = Captacion::find($id);
            $persona = Persona::find($captacion->id_propietario);
            $inmueble = Inmueble::find($captacion->id_inmueble);

        }elseif($request->paso=='2'){
              
            $captacion = Captacion::find($id);

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


            $captacion = Captacion::whereId($id)->update([
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
        $captacion = Captacion::find($id);

      $captaciones_persona = DB::table('cap_publicaciones as c')
         ->leftjoin('personas as p1', 'c.id_propietario', '=', 'p1.id')
         ->leftjoin('inmuebles as i', 'c.id_inmueble', '=', 'i.id')
         ->leftjoin('personas as p2', 'c.id_creador', '=', 'p2.id')
         ->leftjoin('personas as p3', 'c.id_modificador', '=', 'p3.id')
         ->leftjoin('comunas as o', 'i.id_comuna', '=', 'o.comuna_id')
         ->leftjoin('portales as po', 'c.portal', '=', 'po.id')
         -> where("c.id_propietario","=",$captacion->id_propietario)
        ->where("c.id_estado","=",1)
         ->select(DB::raw('c.id as id_publicacion, DATE_FORMAT(c.created_at, "%d/%m/%Y") as fecha_creacion, c.id_estado as id_estado, CONCAT(p1.nombre," ",p1.apellido_paterno," ",p1.apellido_materno) as Propietario, CONCAT(p2.nombre," ",p2.apellido_paterno," ",p2.apellido_materno) as Creador'),'i.id as id_inmueble','i.direccion','i.numero','i.departamento', 'o.comuna_nombre','po.nombre as portal')
         ->get();

   $captaciones_inmueble = DB::table('cap_publicaciones as c')
         ->leftjoin('personas as p1', 'c.id_propietario', '=', 'p1.id')
         ->leftjoin('inmuebles as i', 'c.id_inmueble', '=', 'i.id')
         ->leftjoin('personas as p2', 'c.id_creador', '=', 'p2.id')
         ->leftjoin('personas as p3', 'c.id_modificador', '=', 'p3.id')
         ->leftjoin('comunas as o', 'i.id_comuna', '=', 'o.comuna_id')
         ->leftjoin('portales as po', 'c.portal', '=', 'po.id')
         -> where("c.id_inmueble","=",$captacion->id_inmueble)
        ->where("c.id_estado","=",1)
         ->select(DB::raw('c.id as id_publicacion, DATE_FORMAT(c.created_at, "%d/%m/%Y") as fecha_creacion, c.id_estado as id_estado, CONCAT(p1.nombre," ",p1.apellido_paterno," ",p1.apellido_materno) as Propietario, CONCAT(p2.nombre," ",p2.apellido_paterno," ",p2.apellido_materno) as Creador'),'i.id as id_inmueble','i.direccion','i.numero','i.departamento', 'o.comuna_nombre','po.nombre as portal')
         ->get();

         $imagenes=CaptacionFoto::where('id_captacion','=',$id)->get();
         $portales=Portales::pluck('nombre','id');
        return redirect()->route('captacion.edit', $id)->with('status', 'Captación grabado con éxito');
    }


/**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\captacion  $captacion
     * @return \Illuminate\Http\Response
     */
    public function agregarInmueble($idc,$idi)
    {        
             $captacion = Captacion::whereId($idc)->update([
                'id_inmueble'=> $idi
            ]
            );
        $inmueble = Inmueble::whereId($idi)->update([
                'estado'=> 1
            ]
            );
        return redirect()->route('captacion.edit', $idc)->with('status', 'Inmueble agregado con éxito');
    }


/**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\captacion  $captacion
     * @return \Illuminate\Http\Response
     */
    public function savefotos(Request $request, $id){
     /*    if ($_FILES['foto']['size'] > 1000000) 
         {
            return back()->with('error', 'Imágen supera 1MB');      
         } */

        $path='uploads/captaciones';
        $archivo=rand().$request->foto->getClientOriginalName();
        $img = Image::make($_FILES['foto']['tmp_name'])->resize(600,400, function ($constraint){ 
                        $constraint->aspectRatio();
                    });
        $img->save($path.'/'.$archivo,72);

                $imagen=CaptacionFoto::create([
                            'id_captacion'         => $id,
                            'descripcion'          => '',
                            'nombre'               => $archivo,
                            'ruta'                 => $path,
                            'id_creador'           => $request->id_creador
                        ]);

        

        return redirect()->route('captacion.edit', $id)->with('status', 'Foto guardada con éxito');
    }


/**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\captacion  $captacion
     * @return \Illuminate\Http\Response
     */
    public function eliminarfoto($idf,$idc){
        $imagen=CaptacionFoto::find($idf);
        File::delete($imagen->ruta.'/'.$imagen->nombre);
        $foto = CaptacionFoto::find($idf)->delete();

        return redirect()->route('captacion.edit', $idc)->with('status', 'Foto eliminada con éxito');
    }

/**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\captacion  $captacion
     * @return \Illuminate\Http\Response
     */
    public function agregarPropietario($idc,$idp)
    {        
             $captacion = Captacion::whereId($idc)->update([
                'id_propietario'=> $idp
            ]
            );
        $persona = Persona::whereId($idp)->update([
                'id_estado'=> 1
            ]
            );
        
        return redirect()->route('captacion.edit', $idc)->with('status', 'Propietario agregado con éxito');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\captacion  $captacion
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $captacion = Captacion::where('id','=',$id)->update([
            'id_estado' => '0'
        ]);

        return redirect()->route('captacion.edit', $id)->with('status', 'Captacion desactivado con éxito');
    }
}
