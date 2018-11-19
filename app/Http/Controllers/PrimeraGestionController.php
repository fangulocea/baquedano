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

class PrimeraGestionController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($tipo) {
        if ($tipo == 3) {
            $publica = DB::table('cap_publicaciones as c')
                    ->leftjoin('personas as p1', 'c.id_propietario', '=', 'p1.id')
                    ->leftjoin('inmuebles as i', 'c.id_inmueble', '=', 'i.id')
                    ->leftjoin('users as p2', 'c.id_creador', '=', 'p2.id')
                    ->leftjoin('personas as p3', 'c.id_modificador', '=', 'p3.id')
                    ->leftjoin('comunas as o', 'i.id_comuna', '=', 'o.comuna_id')
                    ->leftjoin('portales as po', 'c.portal', '=', 'po.id')
                    ->Where('c.id_estado', '<>', 0)->Where('c.id_estado', '=', $tipo)->OrWhere('c.id_estado', '=', 8)
                    ->Where('p1.email', '<>', '')->where('p1.email', 'like', '%@%')
                    ->select(DB::raw('c.id as id_publicacion, DATE_FORMAT(c.created_at, "%d/%m/%Y") as fecha_creacion, c.id_estado as id_estado, CONCAT(p1.nombre," ",p1.apellido_paterno," ",p1.apellido_materno) as Propietario, p2.name Creador'), 'i.id as id_inmueble', 'i.direccion', 'i.numero', 'i.departamento', 'o.comuna_nombre', 'po.nombre as portal', 'c.id_propietario', 'c.id_creador', 'p1.email', 'p1.nombre as nom_p', 'p1.apellido_paterno as apep_p', 'p1.apellido_materno as apem_p', 'p3.nombre as nom_m', 'p3.apellido_paterno as apep_m', 'p3.apellido_materno as apem_m,p1.email')
                    ->get();
        } else {
            $publica = DB::table('cap_publicaciones as c')
                    ->leftjoin('personas as p1', 'c.id_propietario', '=', 'p1.id')
                    ->leftjoin('inmuebles as i', 'c.id_inmueble', '=', 'i.id')
                    ->leftjoin('users as p2', 'c.id_creador', '=', 'p2.id')
                    ->leftjoin('personas as p3', 'c.id_modificador', '=', 'p3.id')
                    ->leftjoin('comunas as o', 'i.id_comuna', '=', 'o.comuna_id')
                    ->leftjoin('portales as po', 'c.portal', '=', 'po.id')
                    ->Where('c.id_estado', '<>', 0)->Where('c.id_estado', '=', $tipo)
                    ->Where('p1.email', '<>', '')->where('p1.email', 'like', '%@%')
                    ->select(DB::raw('c.id as id_publicacion, DATE_FORMAT(c.created_at, "%d/%m/%Y") as fecha_creacion, c.id_estado as id_estado, CONCAT(p1.nombre," ",p1.apellido_paterno," ",p1.apellido_materno) as Propietario,p2.name as Creador'), 'i.id as id_inmueble', 'i.direccion', 'i.numero', 'i.departamento', 'o.comuna_nombre', 'po.nombre as portal', 'c.id_propietario', 'c.id_creador', 'p1.email', 'p1.nombre as nom_p', 'p1.apellido_paterno as apep_p', 'p1.apellido_materno as apem_p', 'p3.nombre as nom_m', 'p3.apellido_paterno as apep_m', 'p3.apellido_materno as apem_m,p1.email')
                    ->get();
        }

        $correo = DB::table('correos')
                ->where('estado', '=', 1)
                ->get();
        if ($tipo == 1) {
            $tipo = 2;
        } elseif ($tipo == 2) {
            $tipo = 3;
        } elseif ($tipo == 3) {
            $tipo = 8;
        }

        return view('primeraGestion.index', compact('publica', 'correo', 'tipo'));
    }

    public function volver_proceso($id) {

        $correo = DB::table('correos')
                ->where('estado', '=', 1)
                ->get();
        $est = 2;
        return view('importarbaquedano.index', compact('correo', 'est'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        return view('primeraGestion.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        for ($i = 0; $i < count($request->check); $i++) {
            $BuscaPublicacion = DB::table('cap_publicaciones')
                            ->where('id', '=', $request->check[$i])->first();

            $usuario = DB::table('personas')
                    ->where('id', '=', $BuscaPublicacion->id_propietario)
                    ->select(DB::raw("CONCAT(nombre,' ',apellido_paterno,' ',apellido_materno)  AS nombre"), 'email')
                    ->first();

            $correo = DB::table('correos')
                    ->where('id', '=', $request->correo)
                    ->select('descripcion')
                    ->first();

            $envioCorreo = array('nombre' => $usuario->nombre,
                'email' => $usuario->email,
                'correo' => $correo->descripcion);

            Mail::send('emails.notificacion', $envioCorreo, function ($message) use($usuario) {

                $message->from('javier@ibaquedano.cl', 'Baquedano Rentas');
                $message->to($usuario->email);
                $message->replyTo('javier@ibaquedano.cl', 'Javier Faria - Baquedano Rentas');
                $message->subject('Propuesta de arriendo garantizado de Baquedano Rentas');
            });

            $date = Carbon::now();
            $fechaActual = $date->format('Y-m-d');
            $horaActual = $date->format('H:i');

            $persona = CaptacionGestion::create([
                        'id_captacion_gestion' => $BuscaPublicacion->id,
                        'tipo_contacto' => 'Envío de Correo',
                        'dir' => 'Información Enviada',
                        'detalle_contacto' => $correo->descripcion,
                        'id_creador_gestion' => $BuscaPublicacion->id_creador,
                        'fecha_gestion' => $fechaActual,
                        'hora_gestion' => $horaActual]);

            Captacion::find($BuscaPublicacion->id)->update(['id_estado' => $request->tipo]);
        }

        return redirect()->route('primeraGestion.index', 1)
                        ->with('status', 'Gestión Realizada');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeCaptacion(Request $request) {
        for ($i = 0; $i < count($request->check); $i++) {
            $BuscaPublicacion = DB::table('cap_publicaciones')
                            ->where('id', '=', $request->check[$i])->first();

            $usuario = DB::table('personas')
                    ->where('id', '=', $BuscaPublicacion->id_propietario)
                    ->select(DB::raw("CONCAT(nombre,' ',apellido_paterno,' ',apellido_materno)  AS nombre"), 'email')
                    ->first();

            $correo = DB::table('correos')
                    ->where('id', '=', $request->correo)
                    ->select('descripcion')
                    ->first();

            $envioCorreo = array('nombre' => $usuario->nombre,
                'email' => $usuario->email,
                'correo' => $correo->descripcion);

            Mail::send('emails.notificacion', $envioCorreo, function ($message) use($usuario) {
                $message->from('javier@ibaquedano.cl', 'Baquedano Rentas');
                $message->to($usuario->email);
                $message->replyTo('javier@ibaquedano.cl', 'Javier Faria - Baquedano Rentas');
                $message->subject('Propuesta de arriendo garantizado de Baquedano Rentas');
            });

            $date = Carbon::now();
            $fechaActual = $date->format('Y-m-d');
            $horaActual = $date->format('H:i');

            $persona = CaptacionGestion::create([
                        'id_captacion_gestion' => $BuscaPublicacion->id,
                        'tipo_contacto' => 'Re-Envío de Correo',
                        'dir' => 'Información Enviada',
                        'detalle_contacto' => $correo->descripcion,
                        'id_creador_gestion' => $BuscaPublicacion->id_creador,
                        'fecha_gestion' => $fechaActual,
                        'hora_gestion' => $horaActual]);

            Captacion::find($BuscaPublicacion->id)->update(['id_estado' => 2]);
        }
        $correo = DB::table('correos')
                ->where('estado', '=', 1)
                ->get();
        $est = 1;
        return view('importarbaquedano.index', compact('correo', 'est'));
    }

    public function storeCaptacion2(Request $request) {
        for ($i = 0; $i < count($request->check); $i++) {
            $BuscaPublicacion = DB::table('cap_publicaciones')
                            ->where('id', '=', $request->check[$i])->first();

            $usuario = DB::table('personas')
                    ->where('id', '=', $BuscaPublicacion->id_propietario)
                    ->select(DB::raw("CONCAT(nombre,' ',apellido_paterno,' ',apellido_materno)  AS nombre"), 'email')
                    ->first();

            $correo = DB::table('correos')
                    ->where('id', '=', $request->correo)
                    ->select('descripcion')
                    ->first();

            $envioCorreo = array('nombre' => $usuario->nombre,
                'email' => $usuario->email,
                'correo' => $correo->descripcion);

            Mail::send('emails.notificacion', $envioCorreo, function ($message) use($usuario) {
                $message->from('javier@ibaquedano.cl', 'Baquedano Rentas');
                $message->to($usuario->email);
                $message->replyTo('javier@ibaquedano.cl', 'Javier Faria - Baquedano Rentas');
                $message->subject('Propuesta de arriendo garantizado de Baquedano Rentas');
            });

            $date = Carbon::now();
            $fechaActual = $date->format('Y-m-d');
            $horaActual = $date->format('H:i');

            $persona = CaptacionGestion::create([
                        'id_captacion_gestion' => $BuscaPublicacion->id,
                        'tipo_contacto' => trans_choice('mensajes.vigencia', 2),
                        'dir' => 'Información Enviada',
                        'detalle_contacto' => $correo->descripcion,
                        'id_creador_gestion' => $BuscaPublicacion->id_creador,
                        'fecha_gestion' => $fechaActual,
                        'hora_gestion' => $horaActual]);

            Captacion::find($BuscaPublicacion->id)->update(['id_estado' => 2]);
        }
        $correo = DB::table('correos')
                ->where('estado', '=', 1)
                ->get();
        $est = 1;
        return view('importarcontact.index', compact('correo', 'est'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\PrimeraGestion  $primeraGestion
     * @return \Illuminate\Http\Response
     */
    public function show(PrimeraGestion $primeraGestion) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\PrimeraGestion  $primeraGestion
     * @return \Illuminate\Http\Response
     */
    public function edit(PrimeraGestion $primeraGestion) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\PrimeraGestion  $primeraGestion
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PrimeraGestion $primeraGestion) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\PrimeraGestion  $primeraGestion
     * @return \Illuminate\Http\Response
     */
    public function destroy(PrimeraGestion $primeraGestion) {
        //
    }

    static function totalCaptaciones() {
        $tc = DB::table('cap_publicaciones')
                ->where('id_estado', '<>', 0)
                ->count();

        if ($tc == 0) {
            $d = 1;
        } else {
            $d = $tc;
        }
        return $d;
    }

//ARRENDATARIOS

    static function arr_cantidadmesual() {
        $cc = DB::table('arrendatarios')
                ->where('created_at', '>', date('Y-m-d', strtotime('-30 day', strtotime(date("Y-m-d")))))
                ->count();
        return $cc;
    }

    static function arr_cantidadanual() {
        $cc = DB::table('arrendatarios')
                ->where('created_at', '>', date('Y-m-d', strtotime('-365 day', strtotime(date("Y-m-d")))))
                ->count();
        return $cc;
    }

    static function arr_cantidaddescartada() {
        $cc = DB::table('arrendatarios')
                ->wherein('id_estado', [0])
                ->count();
        return $cc;
    }

    static function arr_cantidadborrador() {
        $cc = DB::table('arrendatarios')
                ->wherein('id_estado', [6, 10])
                ->count();
        return $cc;
    }

    static function arr_cantidadfinal() {
        $cc = DB::table('arrendatarios')
                ->wherein('id_estado', [11])
                ->count();
        return $cc;
    }

//PROPIETARIOS





    static function cantCorreos() {
        $cc = DB::table('cap_gestion')
                ->where('tipo_contacto', '=', 'Sin Respuesta')
                ->OrWhere('tipo_contacto', '=', 'Reenvío')
                ->count();
        return $cc;
    }

    static function cantGestiones() {
        $canGes = DB::table('cap_gestion')
                ->count();
        return $canGes;
    }

    static function cantborradores() {
        $canGes = DB::table('cap_publicaciones')
                ->whereIn('id_estado', [5, 6, 7])
                ->count();
        return $canGes;
    }

    static function cantactivos() {
        $canGes = DB::table('cap_publicaciones')
                ->whereIn('id_estado', [10])
                ->count();
        return $canGes;
    }

    static function cantCaptacionesAnuales() {
        $canGes = DB::table('cap_publicaciones')
                ->where("id_estado", "<>", 0)
                ->where('created_at', '>', date('Y-m-d', strtotime('-365 day', strtotime(date("Y-m-d")))))
                ->count();
        return $canGes;
    }

    static function cantCaptacionesMensuales() {
        $canGes = DB::table('cap_publicaciones')
                ->where("id_estado", "<>", 0)
                ->where('created_at', '>', date('Y-m-d', strtotime('-30 day', strtotime(date("Y-m-d")))))
                ->count();
        return $canGes;
    }

    static function cantGesDia() {
        $res = DB::table('cap_gestion')
                ->where('fecha_gestion', '=', date("Y-m-d"))
                ->count();
        return $res;
    }

    static function cantGesMes() {
        $res = DB::table('cap_gestion')
                ->where('fecha_gestion', '>', date('Y-m-d', strtotime('-30 day', strtotime(date("Y-m-d")))))
                ->count();
        return $res;
    }

    static function cantGesAnio() {
        $res = DB::table('cap_gestion')
                ->where('fecha_gestion', '>', date('Y-m-d', strtotime('-365 day', strtotime(date("Y-m-d")))))
                ->count();
        return $res;
    }

    static function SinRespuesta() {
        $apg = DB::table('cap_publicaciones')
                ->where('id_estado', '=', 2)->Where('id_estado', '<>', 0)
                ->count();
        return $apg;
    }

    static function Descartados() {
        $apg = DB::table('cap_publicaciones')
                ->where('id_estado', '=', 0)
                ->count();
        return $apg;
    }

    static function PrimeraGestion() {
        $asg = DB::table('cap_publicaciones')
                ->where('id_estado', '=', 3)->Where('id_estado', '<>', 0)
                ->count();
        return $asg;
    }

    static function SinGestion() {

        $asg = DB::selectOne('SELECT count(*) as cantidad FROM cap_publicaciones p where (select count(*) from cap_gestion g where g.id_captacion_gestion = p.id) = 0 and p.id_estado<>0');
        return $asg->cantidad;
    }

    //ALERTAS ADM PROPIETARIO

    static function MontoPendienteProximoPro() {

        $reporte = DB::table('adm_contratofinal as co')
                ->leftjoin('borradores as cb', 'co.id_borrador', '=', 'cb.id')
                ->leftjoin('adm_contratodirpropietarios as cd', 'cd.id_contratofinal', '=', 'co.id')
                ->leftjoin('inmuebles as i', 'cd.id_inmueble', '=', 'i.id')
                ->leftjoin('comunas as o', 'i.id_comuna', '=', 'o.comuna_id')
                ->leftjoin('cap_publicaciones as c', 'c.id', '=', 'co.id_publicacion')
                ->leftjoin('personas as p1', 'c.id_propietario', '=', 'p1.id')
                ->leftjoin('users as p2', 'c.id_creador', '=', 'p2.id')
                ->leftjoin('users as p3', 'c.id_modificador', '=', 'p3.id')
                ->leftjoin('mensajes as m', function($join) {
                    $join->on('m.nombre_modulo', '=', DB::raw("'Captación'"));
                    $join->on('m.id_estado', '=', 'c.id_estado');
                })
                ->whereIn('c.id_estado', [7, 10, 6])
                ->select(DB::raw('co.fecha_firma, m.nombre as estado, cb.dia_pago,c.id as id_publicacion, DATE_FORMAT(c.created_at, "%d/%m/%Y") as fecha_creacion, c.id_estado as id_estado, CONCAT_WS(" ",p1.nombre,p1.apellido_paterno,p1.apellido_materno) as Propietario, p2.name as Creador, p1.rut, p1.email, p1.telefono,


                    (select pago_propietario from adm_pagosmensualespropietarios where mes=MONTH(DATE_ADD(now(), INTERVAL 1 MONTH)) and anio=YEAR(DATE_ADD(now(), INTERVAL 1 MONTH)) and id_publicacion=c.id and id_inmueble=i.id and id_contratofinal=co.id) as valorsiguiente1


                    '), 'p1.id as id_propietario', 'i.id as id_inmueble', 'i.direccion', 'i.numero', 'i.departamento', 'o.comuna_nombre', 'p1.nombre as nom_p', 'p1.apellido_paterno as apep_p', 'p1.apellido_materno as apem_p', 'p3.name as modifcador')
                ->orderby("co.fecha_firma", "asc")
                ->get();
        $r = [];
        $valor = 0;
        foreach ($reporte as $k) {
            if ($k->valorsiguiente1 != null)
                $valor += round($k->valorsiguiente1);
            array_push($r, $k);
        }

        return $valor;
    }

    static function MontoPendientePasadoPro() {

        $reporte = DB::table('adm_contratofinal as co')
                ->leftjoin('borradores as cb', 'co.id_borrador', '=', 'cb.id')
                ->leftjoin('adm_contratodirpropietarios as cd', 'cd.id_contratofinal', '=', 'co.id')
                ->leftjoin('inmuebles as i', 'cd.id_inmueble', '=', 'i.id')
                ->leftjoin('comunas as o', 'i.id_comuna', '=', 'o.comuna_id')
                ->leftjoin('cap_publicaciones as c', 'c.id', '=', 'co.id_publicacion')
                ->leftjoin('personas as p1', 'c.id_propietario', '=', 'p1.id')
                ->leftjoin('users as p2', 'c.id_creador', '=', 'p2.id')
                ->leftjoin('users as p3', 'c.id_modificador', '=', 'p3.id')
                ->leftjoin('mensajes as m', function($join) {
                    $join->on('m.nombre_modulo', '=', DB::raw("'Captación'"));
                    $join->on('m.id_estado', '=', 'c.id_estado');
                })
                ->whereIn('c.id_estado', [7, 10, 6])
                ->select(DB::raw('co.fecha_firma, m.nombre as estado, cb.dia_pago,c.id as id_publicacion, DATE_FORMAT(c.created_at, "%d/%m/%Y") as fecha_creacion, c.id_estado as id_estado, CONCAT_WS(" ",p1.nombre,p1.apellido_paterno,p1.apellido_materno) as Propietario, p2.name as Creador, p1.rut, p1.email, p1.telefono,


                  (select pago_propietario from adm_pagosmensualespropietarios where mes=MONTH(DATE_ADD(now(), INTERVAL -1 MONTH)) and anio=YEAR(DATE_ADD(now(), INTERVAL -1 MONTH)) and id_publicacion=c.id and id_inmueble=i.id and id_contratofinal=co.id) as valoranterior1

               
                    '), 'p1.id as id_propietario', 'i.id as id_inmueble', 'i.direccion', 'i.numero', 'i.departamento', 'o.comuna_nombre', 'p1.nombre as nom_p', 'p1.apellido_paterno as apep_p', 'p1.apellido_materno as apem_p', 'p3.name as modifcador')
                ->orderby("co.fecha_firma", "asc")
                ->get();
        $r = [];
        $valor = 0;
        foreach ($reporte as $k) {
            if ($k->valoranterior1 != null)
                $valor += round($k->valoranterior1) ;
            array_push($r, $k);
        }

        return $valor;
    }

    static function MontoPendienteActualPro() {

        $reporte = DB::table('adm_contratofinal as co')
                ->leftjoin('borradores as cb', 'co.id_borrador', '=', 'cb.id')
                ->leftjoin('adm_contratodirpropietarios as cd', 'cd.id_contratofinal', '=', 'co.id')
                ->leftjoin('inmuebles as i', 'cd.id_inmueble', '=', 'i.id')
                ->leftjoin('comunas as o', 'i.id_comuna', '=', 'o.comuna_id')
                ->leftjoin('cap_publicaciones as c', 'c.id', '=', 'co.id_publicacion')
                ->leftjoin('personas as p1', 'c.id_propietario', '=', 'p1.id')
                ->leftjoin('users as p2', 'c.id_creador', '=', 'p2.id')
                ->leftjoin('users as p3', 'c.id_modificador', '=', 'p3.id')
                ->leftjoin('mensajes as m', function($join) {
                    $join->on('m.nombre_modulo', '=', DB::raw("'Captación'"));
                    $join->on('m.id_estado', '=', 'c.id_estado');
                })
                ->whereIn('c.id_estado', [7, 10, 6])
                ->select(DB::raw('co.fecha_firma, m.nombre as estado, cb.dia_pago,c.id as id_publicacion, DATE_FORMAT(c.created_at, "%d/%m/%Y") as fecha_creacion, c.id_estado as id_estado, CONCAT_WS(" ",p1.nombre,p1.apellido_paterno,p1.apellido_materno) as Propietario, p2.name as Creador, p1.rut, p1.email, p1.telefono,

                    
                    (select pago_propietario from adm_pagosmensualespropietarios where mes=MONTH(now()) and anio=YEAR(now()) and id_publicacion=c.id and id_inmueble=i.id and id_contratofinal=co.id) as valoractual

               

                    '), 'p1.id as id_propietario', 'i.id as id_inmueble', 'i.direccion', 'i.numero', 'i.departamento', 'o.comuna_nombre', 'p1.nombre as nom_p', 'p1.apellido_paterno as apep_p', 'p1.apellido_materno as apem_p', 'p3.name as modifcador')
                ->orderby("co.fecha_firma", "asc")
                ->get();
        $r = [];
        $valor = 0;
        foreach ($reporte as $k) {
            if ($k->valoractual != null)
                $valor += round($k->valoractual);
            array_push($r, $k);
        }
        return $valor;
    }


    static function MorososPasadoPro() {

          $reporte = DB::table('adm_contratofinal as co')
                ->leftjoin('borradores as cb', 'co.id_borrador', '=', 'cb.id')
                ->leftjoin('adm_contratodirpropietarios as cd', 'cd.id_contratofinal', '=', 'co.id')
                ->leftjoin('inmuebles as i', 'cd.id_inmueble', '=', 'i.id')
                ->leftjoin('comunas as o', 'i.id_comuna', '=', 'o.comuna_id')
                ->leftjoin('cap_publicaciones as c', 'c.id', '=', 'co.id_publicacion')
                ->leftjoin('personas as p1', 'c.id_propietario', '=', 'p1.id')
                ->leftjoin('users as p2', 'c.id_creador', '=', 'p2.id')
                ->leftjoin('users as p3', 'c.id_modificador', '=', 'p3.id')
                ->leftjoin('mensajes as m', function($join) {
                    $join->on('m.nombre_modulo', '=', DB::raw("'Captación'"));
                    $join->on('m.id_estado', '=', 'c.id_estado');
                })
                ->whereIn('c.id_estado', [7, 10, 6])
                ->select(DB::raw('co.fecha_firma, m.nombre as estado, cb.dia_pago,c.id as id_publicacion, DATE_FORMAT(c.created_at, "%d/%m/%Y") as fecha_creacion, c.id_estado as id_estado, CONCAT_WS(" ",p1.nombre,p1.apellido_paterno,p1.apellido_materno) as Propietario, p2.name as Creador, p1.rut, p1.email, p1.telefono,


                  (select pago_propietario from adm_pagosmensualespropietarios where mes=MONTH(DATE_ADD(now(), INTERVAL -1 MONTH)) and anio=YEAR(DATE_ADD(now(), INTERVAL -1 MONTH)) and id_publicacion=c.id and id_inmueble=i.id and id_contratofinal=co.id) as valoranterior1,

                    (select sum(valor_pagado) from adm_detallepagospropietarios dt inner join adm_pagosmensualespropietarios pm on dt.id_pagomensual=pm.id where pm.mes=MONTH(DATE_ADD(now(), INTERVAL -1 MONTH)) and pm.anio=YEAR(DATE_ADD(now(), INTERVAL -1 MONTH)) and pm.id_publicacion=c.id and pm.id_inmueble=i.id and pm.id_contratofinal=co.id) as valorpagadoanterior1

                    '), 'p1.id as id_propietario', 'i.id as id_inmueble', 'i.direccion', 'i.numero', 'i.departamento', 'o.comuna_nombre', 'p1.nombre as nom_p', 'p1.apellido_paterno as apep_p', 'p1.apellido_materno as apem_p', 'p3.name as modifcador')
                ->orderby("co.fecha_firma", "asc")
                ->get();
        $r = [];
        $valor = 0;
        foreach ($reporte as $k) {
            if ($k->valoranterior1 != null)
                $valor += round($k->valoranterior1 - $k->valorpagadoanterior1) ;
            array_push($r, $k);
        }

        return $valor;
    }


    static function MorosoActualPro() {

        $reporte = DB::table('adm_contratofinal as co')
                ->leftjoin('borradores as cb', 'co.id_borrador', '=', 'cb.id')
                ->leftjoin('adm_contratodirpropietarios as cd', 'cd.id_contratofinal', '=', 'co.id')
                ->leftjoin('inmuebles as i', 'cd.id_inmueble', '=', 'i.id')
                ->leftjoin('comunas as o', 'i.id_comuna', '=', 'o.comuna_id')
                ->leftjoin('cap_publicaciones as c', 'c.id', '=', 'co.id_publicacion')
                ->leftjoin('personas as p1', 'c.id_propietario', '=', 'p1.id')
                ->leftjoin('users as p2', 'c.id_creador', '=', 'p2.id')
                ->leftjoin('users as p3', 'c.id_modificador', '=', 'p3.id')
                ->leftjoin('mensajes as m', function($join) {
                    $join->on('m.nombre_modulo', '=', DB::raw("'Captación'"));
                    $join->on('m.id_estado', '=', 'c.id_estado');
                })
                ->whereIn('c.id_estado', [7, 10, 6])
                ->where("cb.dia_pago","<",Carbon::now()->day)
                ->select(DB::raw('co.fecha_firma, m.nombre as estado, cb.dia_pago,c.id as id_publicacion, DATE_FORMAT(c.created_at, "%d/%m/%Y") as fecha_creacion, c.id_estado as id_estado, CONCAT_WS(" ",p1.nombre,p1.apellido_paterno,p1.apellido_materno) as Propietario, p2.name as Creador, p1.rut, p1.email, p1.telefono,

                    
                    (select pago_propietario from adm_pagosmensualespropietarios where mes=MONTH(now()) and anio=YEAR(now()) and id_publicacion=c.id and id_inmueble=i.id and id_contratofinal=co.id) as valoractual,

                    (select sum(valor_pagado) from adm_detallepagospropietarios dt inner join adm_pagosmensualespropietarios pm on dt.id_pagomensual=pm.id where pm.mes=MONTH(now()) and pm.anio=YEAR(now()) and pm.id_publicacion=c.id and pm.id_inmueble=i.id and pm.id_contratofinal=co.id) as valorpagadoactual


                    '), 'p1.id as id_propietario', 'i.id as id_inmueble', 'i.direccion', 'i.numero', 'i.departamento', 'o.comuna_nombre', 'p1.nombre as nom_p', 'p1.apellido_paterno as apep_p', 'p1.apellido_materno as apem_p', 'p3.name as modifcador')
                ->orderby("co.fecha_firma", "asc")
                ->get();
        $r = [];
        $valor = 0;
        foreach ($reporte as $k) {
            if ($k->valoractual != null)
                $valor += round($k->valoractual-$k->valorpagadoactual);
            array_push($r, $k);
        }
        return $valor;
    }

static function MontoPagadoActualPro() {

        $reporte = DB::table('adm_contratofinal as co')
                ->leftjoin('borradores as cb', 'co.id_borrador', '=', 'cb.id')
                ->leftjoin('adm_contratodirpropietarios as cd', 'cd.id_contratofinal', '=', 'co.id')
                ->leftjoin('inmuebles as i', 'cd.id_inmueble', '=', 'i.id')
                ->leftjoin('comunas as o', 'i.id_comuna', '=', 'o.comuna_id')
                ->leftjoin('cap_publicaciones as c', 'c.id', '=', 'co.id_publicacion')
                ->leftjoin('personas as p1', 'c.id_propietario', '=', 'p1.id')
                ->leftjoin('users as p2', 'c.id_creador', '=', 'p2.id')
                ->leftjoin('users as p3', 'c.id_modificador', '=', 'p3.id')
                ->leftjoin('mensajes as m', function($join) {
                    $join->on('m.nombre_modulo', '=', DB::raw("'Captación'"));
                    $join->on('m.id_estado', '=', 'c.id_estado');
                })
                ->whereIn('c.id_estado', [7, 10, 6])
                ->select(DB::raw('co.fecha_firma, m.nombre as estado, cb.dia_pago,c.id as id_publicacion, DATE_FORMAT(c.created_at, "%d/%m/%Y") as fecha_creacion, c.id_estado as id_estado, CONCAT_WS(" ",p1.nombre,p1.apellido_paterno,p1.apellido_materno) as Propietario, p2.name as Creador, p1.rut, p1.email, p1.telefono,


                    (select sum(valor_pagado) from adm_detallepagospropietarios dt inner join adm_pagosmensualespropietarios pm on dt.id_pagomensual=pm.id where pm.mes=MONTH(now()) and pm.anio=YEAR(now()) and pm.id_publicacion=c.id and pm.id_inmueble=i.id and pm.id_contratofinal=co.id) as valorpagadoactual


                    '), 'p1.id as id_propietario', 'i.id as id_inmueble', 'i.direccion', 'i.numero', 'i.departamento', 'o.comuna_nombre', 'p1.nombre as nom_p', 'p1.apellido_paterno as apep_p', 'p1.apellido_materno as apem_p', 'p3.name as modifcador')
                ->orderby("co.fecha_firma", "asc")
                ->get();
        $r = [];
        $valor = 0;
        foreach ($reporte as $k) {
            if ($k->valorpagadoactual != null)
                $valor += round($k->valorpagadoactual);
            array_push($r, $k);
        }
        return $valor;
    }
static function MontoPagadoAnteriorPro() {

        $reporte = DB::table('adm_contratofinal as co')
                ->leftjoin('borradores as cb', 'co.id_borrador', '=', 'cb.id')
                ->leftjoin('adm_contratodirpropietarios as cd', 'cd.id_contratofinal', '=', 'co.id')
                ->leftjoin('inmuebles as i', 'cd.id_inmueble', '=', 'i.id')
                ->leftjoin('comunas as o', 'i.id_comuna', '=', 'o.comuna_id')
                ->leftjoin('cap_publicaciones as c', 'c.id', '=', 'co.id_publicacion')
                ->leftjoin('personas as p1', 'c.id_propietario', '=', 'p1.id')
                ->leftjoin('users as p2', 'c.id_creador', '=', 'p2.id')
                ->leftjoin('users as p3', 'c.id_modificador', '=', 'p3.id')
                ->leftjoin('mensajes as m', function($join) {
                    $join->on('m.nombre_modulo', '=', DB::raw("'Captación'"));
                    $join->on('m.id_estado', '=', 'c.id_estado');
                })
                ->whereIn('c.id_estado', [7, 10, 6])
                ->select(DB::raw('co.fecha_firma, m.nombre as estado, cb.dia_pago,c.id as id_publicacion, DATE_FORMAT(c.created_at, "%d/%m/%Y") as fecha_creacion, c.id_estado as id_estado, CONCAT_WS(" ",p1.nombre,p1.apellido_paterno,p1.apellido_materno) as Propietario, p2.name as Creador, p1.rut, p1.email, p1.telefono,

                    (select sum(valor_pagado) from adm_detallepagospropietarios dt inner join adm_pagosmensualespropietarios pm on dt.id_pagomensual=pm.id where pm.mes=MONTH(DATE_ADD(now(), INTERVAL -1 MONTH)) and pm.anio=YEAR(DATE_ADD(now(), INTERVAL -1 MONTH)) and pm.id_publicacion=c.id and pm.id_inmueble=i.id and pm.id_contratofinal=co.id) as valorpagadoanterior1

                    '), 'p1.id as id_propietario', 'i.id as id_inmueble', 'i.direccion', 'i.numero', 'i.departamento', 'o.comuna_nombre', 'p1.nombre as nom_p', 'p1.apellido_paterno as apep_p', 'p1.apellido_materno as apem_p', 'p3.name as modifcador')
                ->orderby("co.fecha_firma", "asc")
                ->get();
        $r = [];
        $valor = 0;
        foreach ($reporte as $k) {
            if ($k->valorpagadoanterior1 != null)
                $valor += round($k->valorpagadoanterior1) ;
            array_push($r, $k);
        }

        return $valor;
    }




    static function transhoypro() {

        $reporte = DB::table('adm_contratofinal as co')
                ->leftjoin('borradores as cb', 'co.id_borrador', '=', 'cb.id')
                ->leftjoin('adm_contratodirpropietarios as cd', 'cd.id_contratofinal', '=', 'co.id')
                ->leftjoin('inmuebles as i', 'cd.id_inmueble', '=', 'i.id')
                ->leftjoin('comunas as o', 'i.id_comuna', '=', 'o.comuna_id')
                ->leftjoin('cap_publicaciones as c', 'c.id', '=', 'co.id_publicacion')
                ->leftjoin('personas as p1', 'c.id_propietario', '=', 'p1.id')
                ->leftjoin('users as p2', 'c.id_creador', '=', 'p2.id')
                ->leftjoin('users as p3', 'c.id_modificador', '=', 'p3.id')
                ->leftjoin('mensajes as m', function($join) {
                    $join->on('m.nombre_modulo', '=', DB::raw("'Captación'"));
                    $join->on('m.id_estado', '=', 'c.id_estado');
                })
                ->whereIn('c.id_estado', [7, 10, 6])
                ->where("cb.dia_pago","=",Carbon::now()->day)
                ->select(DB::raw('co.fecha_firma, m.nombre as estado, cb.dia_pago,c.id as id_publicacion, DATE_FORMAT(c.created_at, "%d/%m/%Y") as fecha_creacion, c.id_estado as id_estado, CONCAT_WS(" ",p1.nombre,p1.apellido_paterno,p1.apellido_materno) as Propietario, p2.name as Creador, p1.rut, p1.email, p1.telefono,

                    
                    (select pago_propietario from adm_pagosmensualespropietarios where mes=MONTH(now()) and anio=YEAR(now()) and id_publicacion=c.id and id_inmueble=i.id and id_contratofinal=co.id) as valoractual,

                    (select sum(valor_pagado) from adm_detallepagospropietarios dt inner join adm_pagosmensualespropietarios pm on dt.id_pagomensual=pm.id where pm.mes=MONTH(now()) and pm.anio=YEAR(now()) and pm.id_publicacion=c.id and pm.id_inmueble=i.id and pm.id_contratofinal=co.id) as valorpagadoactual


                    '), 'p1.id as id_propietario', 'i.id as id_inmueble', 'i.direccion', 'i.numero', 'i.departamento', 'o.comuna_nombre', 'p1.nombre as nom_p', 'p1.apellido_paterno as apep_p', 'p1.apellido_materno as apem_p', 'p3.name as modifcador')
                ->orderby("co.fecha_firma", "asc")
                ->get();
        $r = [];
        $valor = 0;
        foreach ($reporte as $k) {
            if ($k->valoractual != null)
                $valor += round($k->valoractual-$k->valorpagadoactual);
            array_push($r, $k);
        }
        return $valor;
    }

    static function transmananaPro() {

          $reporte = DB::table('adm_contratofinal as co')
                ->leftjoin('borradores as cb', 'co.id_borrador', '=', 'cb.id')
                ->leftjoin('adm_contratodirpropietarios as cd', 'cd.id_contratofinal', '=', 'co.id')
                ->leftjoin('inmuebles as i', 'cd.id_inmueble', '=', 'i.id')
                ->leftjoin('comunas as o', 'i.id_comuna', '=', 'o.comuna_id')
                ->leftjoin('cap_publicaciones as c', 'c.id', '=', 'co.id_publicacion')
                ->leftjoin('personas as p1', 'c.id_propietario', '=', 'p1.id')
                ->leftjoin('users as p2', 'c.id_creador', '=', 'p2.id')
                ->leftjoin('users as p3', 'c.id_modificador', '=', 'p3.id')
                ->leftjoin('mensajes as m', function($join) {
                    $join->on('m.nombre_modulo', '=', DB::raw("'Captación'"));
                    $join->on('m.id_estado', '=', 'c.id_estado');
                })
                ->whereIn('c.id_estado', [7, 10, 6])
                ->where("cb.dia_pago","=",Carbon::tomorrow()->day)
                ->select(DB::raw('co.fecha_firma, m.nombre as estado, cb.dia_pago,c.id as id_publicacion, DATE_FORMAT(c.created_at, "%d/%m/%Y") as fecha_creacion, c.id_estado as id_estado, CONCAT_WS(" ",p1.nombre,p1.apellido_paterno,p1.apellido_materno) as Propietario, p2.name as Creador, p1.rut, p1.email, p1.telefono,


                  (select pago_propietario from adm_pagosmensualespropietarios where mes=MONTH(DATE_ADD(now(), INTERVAL -1 MONTH)) and anio=YEAR(DATE_ADD(now(), INTERVAL -1 MONTH)) and id_publicacion=c.id and id_inmueble=i.id and id_contratofinal=co.id) as valoranterior1,

                    (select sum(valor_pagado) from adm_detallepagospropietarios dt inner join adm_pagosmensualespropietarios pm on dt.id_pagomensual=pm.id where pm.mes=MONTH(DATE_ADD(now(), INTERVAL -1 MONTH)) and pm.anio=YEAR(DATE_ADD(now(), INTERVAL -1 MONTH)) and pm.id_publicacion=c.id and pm.id_inmueble=i.id and pm.id_contratofinal=co.id) as valorpagadoanterior1

                    '), 'p1.id as id_propietario', 'i.id as id_inmueble', 'i.direccion', 'i.numero', 'i.departamento', 'o.comuna_nombre', 'p1.nombre as nom_p', 'p1.apellido_paterno as apep_p', 'p1.apellido_materno as apem_p', 'p3.name as modifcador')
                ->orderby("co.fecha_firma", "asc")
                ->get();
        $r = [];
        $valor = 0;
        foreach ($reporte as $k) {
            if ($k->valoranterior1 != null)
                $valor += round($k->valoranterior1 - $k->valorpagadoanterior1) ;
            array_push($r, $k);
        }

        return $valor;
    }



    //ALERTAS ADM ARRENDATARIO

    static function MontoPendienteProximoARR() {

        $reporte = DB::table('adm_contratofinalarr as co')
                ->leftjoin('contratoborradorarrendatarios as cb', 'co.id_borrador', '=', 'cb.id')
                ->leftjoin('inmuebles as i', 'cb.id_inmueble', '=', 'i.id')
                ->leftjoin('comunas as o', 'i.id_comuna', '=', 'o.comuna_id')
                ->leftjoin('arrendatarios as c', 'c.id', '=', 'co.id_publicacion')
                ->leftjoin('personas as p1', 'c.id_arrendatario', '=', 'p1.id')
                ->leftjoin('personas as p4', 'c.id_aval', '=', 'p4.id')
                ->leftjoin('users as p2', 'c.id_creador', '=', 'p2.id')
                ->leftjoin('users as p3', 'c.id_modificador', '=', 'p3.id')
            ->leftjoin('mensajes as m', function($join){
                 $join->on('m.nombre_modulo', '=',DB::raw("'Arrendatario'"));
                 $join->on('m.id_estado', '=', 'c.id_estado');
            })
                ->whereIn('c.id_estado', [10, 6, 11])
                ->select(DB::raw('co.fecha_firma, m.nombre as estado, p1.telefono as fono_arr, p1.email as email_arr, p4.telefono as fono_aval, p4.email as email_aval, cb.dia_pago,c.id as id_publicacion, DATE_FORMAT(c.created_at, "%d/%m/%Y") as fecha_creacion, c.id_estado as id_estado, CONCAT_WS(" ",p1.nombre,p1.apellido_paterno,p1.apellido_materno) as Arrendatario, p2.name as Creador,CONCAT_WS(" ",p4.nombre,p4.apellido_paterno,p4.apellido_materno) as Aval, p4.rut as rut_aval, p1.rut as rut_arr,

                      (select pago_a_rentas from adm_pagosmensualesarrendatarios where mes=MONTH(DATE_ADD(now(), INTERVAL 1 MONTH)) and anio=YEAR(DATE_ADD(now(), INTERVAL 1 MONTH)) and id_publicacion=c.id and id_inmueble=i.id and id_contratofinal=co.id) as valorsiguiente1

                    '), 'p1.id as id_arr', 'i.id as id_inmueble', 'i.direccion', 'i.numero', 'i.departamento', 'o.comuna_nombre', 'p1.nombre as nom_p', 'p1.apellido_paterno as apep_p', 'p1.apellido_materno as apem_p', 'p3.name as modifcador')
                ->orderby("co.fecha_firma","asc")
                ->get();
        $r = [];
        $valor = 0;
        foreach ($reporte as $k) {
            if ($k->valorsiguiente1 != null)
                $valor += round($k->valorsiguiente1);
            array_push($r, $k);
        }

        return $valor;
    }

    static function MontoPendientePasadoARR() {

        $reporte = DB::table('adm_contratofinalarr as co')
                ->leftjoin('contratoborradorarrendatarios as cb', 'co.id_borrador', '=', 'cb.id')
                ->leftjoin('inmuebles as i', 'cb.id_inmueble', '=', 'i.id')
                ->leftjoin('comunas as o', 'i.id_comuna', '=', 'o.comuna_id')
                ->leftjoin('arrendatarios as c', 'c.id', '=', 'co.id_publicacion')
                ->leftjoin('personas as p1', 'c.id_arrendatario', '=', 'p1.id')
                ->leftjoin('personas as p4', 'c.id_aval', '=', 'p4.id')
                ->leftjoin('users as p2', 'c.id_creador', '=', 'p2.id')
                ->leftjoin('users as p3', 'c.id_modificador', '=', 'p3.id')
            ->leftjoin('mensajes as m', function($join){
                 $join->on('m.nombre_modulo', '=',DB::raw("'Arrendatario'"));
                 $join->on('m.id_estado', '=', 'c.id_estado');
            })
                ->whereIn('c.id_estado', [10, 6, 11])
                ->select(DB::raw('co.fecha_firma, m.nombre as estado, p1.telefono as fono_arr, p1.email as email_arr, p4.telefono as fono_aval, p4.email as email_aval, cb.dia_pago,c.id as id_publicacion, DATE_FORMAT(c.created_at, "%d/%m/%Y") as fecha_creacion, c.id_estado as id_estado, CONCAT_WS(" ",p1.nombre,p1.apellido_paterno,p1.apellido_materno) as Arrendatario, p2.name as Creador,CONCAT_WS(" ",p4.nombre,p4.apellido_paterno,p4.apellido_materno) as Aval, p4.rut as rut_aval, p1.rut as rut_arr,


                  (select pago_a_rentas from adm_pagosmensualesarrendatarios where mes=MONTH(DATE_ADD(now(), INTERVAL -1 MONTH)) and anio=YEAR(DATE_ADD(now(), INTERVAL -1 MONTH)) and id_publicacion=c.id and id_inmueble=i.id and id_contratofinal=co.id) as valoranterior1

                    '), 'p1.id as id_arr', 'i.id as id_inmueble', 'i.direccion', 'i.numero', 'i.departamento', 'o.comuna_nombre', 'p1.nombre as nom_p', 'p1.apellido_paterno as apep_p', 'p1.apellido_materno as apem_p', 'p3.name as modifcador')
                ->orderby("co.fecha_firma","asc")
                ->get();
        $r = [];
        $valor = 0;
        foreach ($reporte as $k) {
            if ($k->valoranterior1 != null)
                $valor += round($k->valoranterior1) ;
            array_push($r, $k);
        }

        return $valor;
    }

    static function MontoPendienteActualARR() {

       $reporte = DB::table('adm_contratofinalarr as co')
                ->leftjoin('contratoborradorarrendatarios as cb', 'co.id_borrador', '=', 'cb.id')
                ->leftjoin('inmuebles as i', 'cb.id_inmueble', '=', 'i.id')
                ->leftjoin('comunas as o', 'i.id_comuna', '=', 'o.comuna_id')
                ->leftjoin('arrendatarios as c', 'c.id', '=', 'co.id_publicacion')
                ->leftjoin('personas as p1', 'c.id_arrendatario', '=', 'p1.id')
                ->leftjoin('personas as p4', 'c.id_aval', '=', 'p4.id')
                ->leftjoin('users as p2', 'c.id_creador', '=', 'p2.id')
                ->leftjoin('users as p3', 'c.id_modificador', '=', 'p3.id')
            ->leftjoin('mensajes as m', function($join){
                 $join->on('m.nombre_modulo', '=',DB::raw("'Arrendatario'"));
                 $join->on('m.id_estado', '=', 'c.id_estado');
            })
                ->whereIn('c.id_estado', [10, 6, 11])
                ->select(DB::raw('co.fecha_firma, m.nombre as estado, p1.telefono as fono_arr, p1.email as email_arr, p4.telefono as fono_aval, p4.email as email_aval, cb.dia_pago,c.id as id_publicacion, DATE_FORMAT(c.created_at, "%d/%m/%Y") as fecha_creacion, c.id_estado as id_estado, CONCAT_WS(" ",p1.nombre,p1.apellido_paterno,p1.apellido_materno) as Arrendatario, p2.name as Creador,CONCAT_WS(" ",p4.nombre,p4.apellido_paterno,p4.apellido_materno) as Aval, p4.rut as rut_aval, p1.rut as rut_arr,

                    
                    (select pago_a_rentas from adm_pagosmensualesarrendatarios where mes=MONTH(now()) and anio=YEAR(now()) and id_publicacion=c.id and id_inmueble=i.id and id_contratofinal=co.id) as valoractual

                    '), 'p1.id as id_arr', 'i.id as id_inmueble', 'i.direccion', 'i.numero', 'i.departamento', 'o.comuna_nombre', 'p1.nombre as nom_p', 'p1.apellido_paterno as apep_p', 'p1.apellido_materno as apem_p', 'p3.name as modifcador')
                ->orderby("co.fecha_firma","asc")
                ->get();
        $r = [];
        $valor = 0;
        foreach ($reporte as $k) {
            if ($k->valoractual != null)
                $valor += round($k->valoractual);
            array_push($r, $k);
        }
        return $valor;
    }


    static function MorososPasadoARR() {

          $reporte = DB::table('adm_contratofinalarr as co')
                ->leftjoin('contratoborradorarrendatarios as cb', 'co.id_borrador', '=', 'cb.id')
                ->leftjoin('inmuebles as i', 'cb.id_inmueble', '=', 'i.id')
                ->leftjoin('comunas as o', 'i.id_comuna', '=', 'o.comuna_id')
                ->leftjoin('arrendatarios as c', 'c.id', '=', 'co.id_publicacion')
                ->leftjoin('personas as p1', 'c.id_arrendatario', '=', 'p1.id')
                ->leftjoin('personas as p4', 'c.id_aval', '=', 'p4.id')
                ->leftjoin('users as p2', 'c.id_creador', '=', 'p2.id')
                ->leftjoin('users as p3', 'c.id_modificador', '=', 'p3.id')
            ->leftjoin('mensajes as m', function($join){
                 $join->on('m.nombre_modulo', '=',DB::raw("'Arrendatario'"));
                 $join->on('m.id_estado', '=', 'c.id_estado');
            })
                ->whereIn('c.id_estado', [10, 6, 11])
                ->select(DB::raw('co.fecha_firma, m.nombre as estado, p1.telefono as fono_arr, p1.email as email_arr, p4.telefono as fono_aval, p4.email as email_aval, cb.dia_pago,c.id as id_publicacion, DATE_FORMAT(c.created_at, "%d/%m/%Y") as fecha_creacion, c.id_estado as id_estado, CONCAT_WS(" ",p1.nombre,p1.apellido_paterno,p1.apellido_materno) as Arrendatario, p2.name as Creador,CONCAT_WS(" ",p4.nombre,p4.apellido_paterno,p4.apellido_materno) as Aval, p4.rut as rut_aval, p1.rut as rut_arr,


                  (select pago_a_rentas from adm_pagosmensualesarrendatarios where mes=MONTH(DATE_ADD(now(), INTERVAL -1 MONTH)) and anio=YEAR(DATE_ADD(now(), INTERVAL -1 MONTH)) and id_publicacion=c.id and id_inmueble=i.id and id_contratofinal=co.id) as valoranterior1,

                    (select sum(valor_pagado) from adm_detallepagosarrendatarios dt inner join adm_pagosmensualesarrendatarios pm on dt.id_pagomensual=pm.id where pm.mes=MONTH(DATE_ADD(now(), INTERVAL -1 MONTH)) and pm.anio=YEAR(DATE_ADD(now(), INTERVAL -1 MONTH)) and pm.id_publicacion=c.id and pm.id_inmueble=i.id and pm.id_contratofinal=co.id) as valorpagadoanterior1

                    '), 'p1.id as id_arr', 'i.id as id_inmueble', 'i.direccion', 'i.numero', 'i.departamento', 'o.comuna_nombre', 'p1.nombre as nom_p', 'p1.apellido_paterno as apep_p', 'p1.apellido_materno as apem_p', 'p3.name as modifcador')
                ->orderby("co.fecha_firma","asc")
                ->get();
        $r = [];
        $valor = 0;
        foreach ($reporte as $k) {
            if ($k->valoranterior1 != null)
                $valor += round($k->valoranterior1 - $k->valorpagadoanterior1) ;
            array_push($r, $k);
        }

        return $valor;
    }


    static function MorosoActualARR() {

        $reporte = DB::table('adm_contratofinalarr as co')
                ->leftjoin('contratoborradorarrendatarios as cb', 'co.id_borrador', '=', 'cb.id')
                ->leftjoin('inmuebles as i', 'cb.id_inmueble', '=', 'i.id')
                ->leftjoin('comunas as o', 'i.id_comuna', '=', 'o.comuna_id')
                ->leftjoin('arrendatarios as c', 'c.id', '=', 'co.id_publicacion')
                ->leftjoin('personas as p1', 'c.id_arrendatario', '=', 'p1.id')
                ->leftjoin('personas as p4', 'c.id_aval', '=', 'p4.id')
                ->leftjoin('users as p2', 'c.id_creador', '=', 'p2.id')
                ->leftjoin('users as p3', 'c.id_modificador', '=', 'p3.id')
            ->leftjoin('mensajes as m', function($join){
                 $join->on('m.nombre_modulo', '=',DB::raw("'Arrendatario'"));
                 $join->on('m.id_estado', '=', 'c.id_estado');
            })
                ->whereIn('c.id_estado', [10, 6, 11])
                ->select(DB::raw('co.fecha_firma, m.nombre as estado, p1.telefono as fono_arr, p1.email as email_arr, p4.telefono as fono_aval, p4.email as email_aval, cb.dia_pago,c.id as id_publicacion, DATE_FORMAT(c.created_at, "%d/%m/%Y") as fecha_creacion, c.id_estado as id_estado, CONCAT_WS(" ",p1.nombre,p1.apellido_paterno,p1.apellido_materno) as Arrendatario, p2.name as Creador,CONCAT_WS(" ",p4.nombre,p4.apellido_paterno,p4.apellido_materno) as Aval, p4.rut as rut_aval, p1.rut as rut_arr,

                    
                    (select pago_a_rentas from adm_pagosmensualesarrendatarios where mes=MONTH(now()) and anio=YEAR(now()) and id_publicacion=c.id and id_inmueble=i.id and id_contratofinal=co.id) as valoractual,

                    (select sum(valor_pagado) from adm_detallepagosarrendatarios dt inner join adm_pagosmensualesarrendatarios pm on dt.id_pagomensual=pm.id where pm.mes=MONTH(now()) and pm.anio=YEAR(now()) and pm.id_publicacion=c.id and pm.id_inmueble=i.id and pm.id_contratofinal=co.id) as valorpagadoactual

                    '), 'p1.id as id_arr', 'i.id as id_inmueble', 'i.direccion', 'i.numero', 'i.departamento', 'o.comuna_nombre', 'p1.nombre as nom_p', 'p1.apellido_paterno as apep_p', 'p1.apellido_materno as apem_p', 'p3.name as modifcador')
                ->orderby("co.fecha_firma","asc")
                ->get();
        $r = [];
        $valor = 0;
        foreach ($reporte as $k) {
            if ($k->valoractual != null)
                $valor += round($k->valoractual-$k->valorpagadoactual);
            array_push($r, $k);
        }
        return $valor;
    }

static function MontoPagadoActualARR() {

       $reporte = DB::table('adm_contratofinalarr as co')
                ->leftjoin('contratoborradorarrendatarios as cb', 'co.id_borrador', '=', 'cb.id')
                ->leftjoin('inmuebles as i', 'cb.id_inmueble', '=', 'i.id')
                ->leftjoin('comunas as o', 'i.id_comuna', '=', 'o.comuna_id')
                ->leftjoin('arrendatarios as c', 'c.id', '=', 'co.id_publicacion')
                ->leftjoin('personas as p1', 'c.id_arrendatario', '=', 'p1.id')
                ->leftjoin('personas as p4', 'c.id_aval', '=', 'p4.id')
                ->leftjoin('users as p2', 'c.id_creador', '=', 'p2.id')
                ->leftjoin('users as p3', 'c.id_modificador', '=', 'p3.id')
            ->leftjoin('mensajes as m', function($join){
                 $join->on('m.nombre_modulo', '=',DB::raw("'Arrendatario'"));
                 $join->on('m.id_estado', '=', 'c.id_estado');
            })
                ->whereIn('c.id_estado', [10, 6, 11])
                ->select(DB::raw('co.fecha_firma, m.nombre as estado, p1.telefono as fono_arr, p1.email as email_arr, p4.telefono as fono_aval, p4.email as email_aval, cb.dia_pago,c.id as id_publicacion, DATE_FORMAT(c.created_at, "%d/%m/%Y") as fecha_creacion, c.id_estado as id_estado, CONCAT_WS(" ",p1.nombre,p1.apellido_paterno,p1.apellido_materno) as Arrendatario, p2.name as Creador,CONCAT_WS(" ",p4.nombre,p4.apellido_paterno,p4.apellido_materno) as Aval, p4.rut as rut_aval, p1.rut as rut_arr,

                    (select sum(valor_pagado) from adm_detallepagosarrendatarios dt inner join adm_pagosmensualesarrendatarios pm on dt.id_pagomensual=pm.id where pm.mes=MONTH(now()) and pm.anio=YEAR(now()) and pm.id_publicacion=c.id and pm.id_inmueble=i.id and pm.id_contratofinal=co.id) as valorpagadoactual

                    '), 'p1.id as id_arr', 'i.id as id_inmueble', 'i.direccion', 'i.numero', 'i.departamento', 'o.comuna_nombre', 'p1.nombre as nom_p', 'p1.apellido_paterno as apep_p', 'p1.apellido_materno as apem_p', 'p3.name as modifcador')
                ->orderby("co.fecha_firma","asc")
                ->get();
        $r = [];
        $valor = 0;
        foreach ($reporte as $k) {
            if ($k->valorpagadoactual != null)
                $valor += round($k->valorpagadoactual);
            array_push($r, $k);
        }
        return $valor;
    }
static function MontoPagadoAnteriorARR() {

        $reporte = DB::table('adm_contratofinalarr as co')
                ->leftjoin('contratoborradorarrendatarios as cb', 'co.id_borrador', '=', 'cb.id')
                ->leftjoin('inmuebles as i', 'cb.id_inmueble', '=', 'i.id')
                ->leftjoin('comunas as o', 'i.id_comuna', '=', 'o.comuna_id')
                ->leftjoin('arrendatarios as c', 'c.id', '=', 'co.id_publicacion')
                ->leftjoin('personas as p1', 'c.id_arrendatario', '=', 'p1.id')
                ->leftjoin('personas as p4', 'c.id_aval', '=', 'p4.id')
                ->leftjoin('users as p2', 'c.id_creador', '=', 'p2.id')
                ->leftjoin('users as p3', 'c.id_modificador', '=', 'p3.id')
            ->leftjoin('mensajes as m', function($join){
                 $join->on('m.nombre_modulo', '=',DB::raw("'Arrendatario'"));
                 $join->on('m.id_estado', '=', 'c.id_estado');
            })
                ->whereIn('c.id_estado', [10, 6, 11])
                ->select(DB::raw('co.fecha_firma, m.nombre as estado, p1.telefono as fono_arr, p1.email as email_arr, p4.telefono as fono_aval, p4.email as email_aval, cb.dia_pago,c.id as id_publicacion, DATE_FORMAT(c.created_at, "%d/%m/%Y") as fecha_creacion, c.id_estado as id_estado, CONCAT_WS(" ",p1.nombre,p1.apellido_paterno,p1.apellido_materno) as Arrendatario, p2.name as Creador,CONCAT_WS(" ",p4.nombre,p4.apellido_paterno,p4.apellido_materno) as Aval, p4.rut as rut_aval, p1.rut as rut_arr,


                    (select sum(valor_pagado) from adm_detallepagosarrendatarios dt inner join adm_pagosmensualesarrendatarios pm on dt.id_pagomensual=pm.id where pm.mes=MONTH(DATE_ADD(now(), INTERVAL -1 MONTH)) and pm.anio=YEAR(DATE_ADD(now(), INTERVAL -1 MONTH)) and pm.id_publicacion=c.id and pm.id_inmueble=i.id and pm.id_contratofinal=co.id) as valorpagadoanterior1

                    '), 'p1.id as id_arr', 'i.id as id_inmueble', 'i.direccion', 'i.numero', 'i.departamento', 'o.comuna_nombre', 'p1.nombre as nom_p', 'p1.apellido_paterno as apep_p', 'p1.apellido_materno as apem_p', 'p3.name as modifcador')
                ->orderby("co.fecha_firma","asc")
                ->get();
        $r = [];
        $valor = 0;
        foreach ($reporte as $k) {
            if ($k->valorpagadoanterior1 != null)
                $valor += round($k->valorpagadoanterior1) ;
            array_push($r, $k);
        }

        return $valor;
    }


}
