<?php

namespace App\Http\Controllers;

use App\Captacion;
use App\Persona;
use App\Inmueble;
use App\Region;
use App\CaptacionFoto;
use App\Portales;
use App\Correo;
use App\CaptacionGestion;
use Illuminate\Http\Request;
use DB;
use Image;
use DateTime;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\File;    
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class PrimeraGestionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($tipo)
    {
     $tipo_f = 0;
     if($tipo == 2)
     { $tipo_f = 3; }
     elseif ($tipo == 3) 
     { $tipo_f = 1; }

     $publica = DB::table('cap_publicaciones as c')
     ->leftjoin('personas as p1', 'c.id_propietario', '=', 'p1.id')
     ->leftjoin('inmuebles as i', 'c.id_inmueble', '=', 'i.id')
     ->leftjoin('personas as p2', 'c.id_creador', '=', 'p2.id')
     ->leftjoin('personas as p3', 'c.id_modificador', '=', 'p3.id')
     ->leftjoin('comunas as o', 'i.id_comuna', '=', 'o.comuna_id')
     ->leftjoin('portales as po', 'c.portal', '=', 'po.id')
     ->Where('c.id_estado', '<>', $tipo)
     ->Where('c.id_estado', '<>', 0)
     ->Where('c.id_estado', '<>', $tipo_f)
     ->Where('p1.email','<>','')
     ->where('p1.email','like','%@%')
     ->select(DB::raw('c.id as id_publicacion, DATE_FORMAT(c.created_at, "%d/%m/%Y") as fecha_creacion, c.id_estado as id_estado, CONCAT(p1.nombre," ",p1.apellido_paterno," ",p1.apellido_materno) as Propietario, CONCAT(p2.nombre," ",p2.apellido_paterno," ",p2.apellido_materno) as Creador'),'i.id as id_inmueble','i.direccion','i.numero','i.departamento', 'o.comuna_nombre','po.nombre as portal','c.id_propietario','c.id_creador','p1.email','p1.nombre as nom_p','p1.apellido_paterno as apep_p','p1.apellido_materno as apem_p','p2.nombre as nom_c','p2.apellido_paterno as apep_c','p2.apellido_materno as apem_c','p3.nombre as nom_m','p3.apellido_paterno as apep_m','p3.apellido_materno as apem_m')
     ->get();

     $correo = DB::table('correos')
     ->where('estado','=',1)
     ->get();

    return view('primeraGestion.index',compact('publica','correo','tipo','tipo_f'));
}


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('primeraGestion.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
        for ($i = 0; $i < count($request->check); $i++)
        {
            $BuscaPublicacion = DB::table('cap_publicaciones')
            ->where('id','=',$request->check[$i])->first();

            $usuario = DB::table('personas')
            ->where('id','=',$BuscaPublicacion->id_propietario)
            ->select( DB::raw("CONCAT(nombre,' ',apellido_paterno,' ',apellido_materno)  AS nombre"),'email')
            ->first();

            $correo = DB::table('correos')
            ->where('id','=',$request->correo)
            ->select( 'descripcion' )
            ->first();

            $envioCorreo = array('nombre' => $usuario->nombre ,
             'email' => $usuario->email ,
             'correo' => $correo->descripcion);

            Mail::send('emails.notificacion', $envioCorreo, function ($message) use($usuario) {
                $message->from('edison.carrizo.j@gmail.com');
                $message->to($usuario->email);
                $message->subject('Asunto del correo');
            });

            $date = Carbon::now();
            $fechaActual = $date->format('Y-m-d');
            $horaActual  = $date->format('H:i');

            $persona=CaptacionGestion::create([
                'id_captacion_gestion'  => $BuscaPublicacion->id,
                'tipo_contacto'         => trans_choice('mensajes.captacion', $request->tipo),
                'dir'                   => 'Información Enviada',
                'detalle_contacto'      => $correo->descripcion,
                'id_creador_gestion'    => $BuscaPublicacion->id_creador,
                'fecha_gestion'         => $fechaActual,
                'hora_gestion'          => $horaActual ]);

            Captacion::find($BuscaPublicacion->id)->update(['id_estado' => $request->tipo]);   

        }
   
        return redirect()->route('primeraGestion.index',2)
        ->with('status', 'Gestión Realizada');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeCaptacion(Request $request)
    {   
        for ($i = 0; $i < count($request->check); $i++)
        {
            $BuscaPublicacion = DB::table('cap_publicaciones')
            ->where('id','=',$request->check[$i])->first();

            $usuario = DB::table('personas')
            ->where('id','=',$BuscaPublicacion->id_propietario)
            ->select( DB::raw("CONCAT(nombre,' ',apellido_paterno,' ',apellido_materno)  AS nombre"),'email')
            ->first();

            $correo = DB::table('correos')
            ->where('id','=',$request->correo)
            ->select( 'descripcion' )
            ->first();

            $envioCorreo = array('nombre' => $usuario->nombre ,
             'email' => $usuario->email ,
             'correo' => $correo->descripcion);

            Mail::send('emails.notificacion', $envioCorreo, function ($message) use($usuario) {
                $message->from('edison.carrizo.j@gmail.com');
                $message->to($usuario->email);
                $message->subject('Asunto del correo');
            });

            $date = Carbon::now();
            $fechaActual = $date->format('Y-m-d');
            $horaActual  = $date->format('H:i');

            $persona=CaptacionGestion::create([
                'id_captacion_gestion'  => $BuscaPublicacion->id,
                'tipo_contacto'         => trans_choice('mensajes.vigencia', 2),
                'dir'                   => 'Información Enviada',
                'detalle_contacto'      => $correo->descripcion,
                'id_creador_gestion'    => $BuscaPublicacion->id_creador,
                'fecha_gestion'         => $fechaActual,
                'hora_gestion'          => $horaActual ]);

            Captacion::find($BuscaPublicacion->id)->update(['id_estado' => 2]);   

        }
      $correo = DB::table('correos')
      ->where('estado','=',1)
      ->get();
      $est=1;
        return view('importar.index',compact('correo','est'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\PrimeraGestion  $primeraGestion
     * @return \Illuminate\Http\Response
     */
    public function show(PrimeraGestion $primeraGestion)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\PrimeraGestion  $primeraGestion
     * @return \Illuminate\Http\Response
     */
    public function edit(PrimeraGestion $primeraGestion)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\PrimeraGestion  $primeraGestion
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PrimeraGestion $primeraGestion)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\PrimeraGestion  $primeraGestion
     * @return \Illuminate\Http\Response
     */
    public function destroy(PrimeraGestion $primeraGestion)
    {
        //
    }
    static  function totalCaptaciones(){
        $tc = DB::table('cap_publicaciones')
        ->where('id_estado', '<>', 0)
        ->count();

        if($tc==0){
            $d=1;
        }else{
            $d=$tc;
        }
        return $d;
    }

    static function cantCorreos(){
        $cc = DB::table('cap_gestion')
        ->where('tipo_contacto','=','Sin Respuesta')
        ->OrWhere('tipo_contacto','=','Reenvío')
        ->count();
        return $cc;   
    }

    static function cantGestiones(){
        $canGes = DB::table('cap_gestion')
        ->count();
        return $canGes;   
    }

    static function cantGesDia(){
        $res = DB::table('cap_gestion')
        ->where('fecha_gestion','=',date("Y-m-d"))
        ->count();
        return $res;
    }

    static function cantGesMes(){
        $res = DB::table('cap_gestion')
        ->where('fecha_gestion','>',date('Y-m-d',strtotime('-30 day', strtotime(date("Y-m-d")))))
        ->count();
        return $res;
    }    

    static function cantGesAnio(){
        $res = DB::table('cap_gestion')
        ->where('fecha_gestion','>',date('Y-m-d',strtotime('-365 day', strtotime(date("Y-m-d")))))
        ->count();
        return $res;
    }    

    static  function SinRespuesta(){
        $apg = DB::table('cap_publicaciones')
        ->where('id_estado','=',2)->Where('id_estado', '<>', 0)
        ->count();
        return $apg;
    }

    static  function Descartados(){
        $apg = DB::table('cap_publicaciones')
        ->where('id_estado','=',0)
        ->count();
        return $apg;
    }

    static  function PrimeraGestion(){
        $asg = DB::table('cap_publicaciones')
        ->where('id_estado','=',3)->Where('id_estado', '<>', 0)
        ->count();
        return $asg;
    }    

    static  function SinGestion(){

        $asg = DB::selectOne('SELECT count(*) as cantidad FROM cap_publicaciones p where (select count(*) from cap_gestion g where g.id_captacion_gestion = p.id) = 0');
        return $asg->cantidad;
    }  






}
