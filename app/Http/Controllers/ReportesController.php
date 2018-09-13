<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\File;
use DB;
use Image;
use Auth;
use App\Persona;
use App\Mensajes;
use App\Region;
use Excel;
use App\ContratoFinal;
use App\Captacion;
use App\PagosMensualesPropietarios;
use App\PagosPropietarios;



class ReportesController extends Controller
{
    

    public function index_inmueble()
    {
        $Inmuebles = null;
        return view('reportes.inmuebles')->with(compact('Inmuebles'));
    }


    public function inmueble(Request $request)
    {
        if($request->estado == 'Todos')
        {
            $estado = $request->estado;
            $Inmuebles = DB::table('inmuebles as i')
             ->leftjoin('comunas as co', 'i.id_comuna', '=', 'co.comuna_id')
             ->select(DB::raw('i.*, co.comuna_nombre as comuna'))
             ->Where('i.estado','=','*')
             ->orderBy('i.id')
             ->get();            
        }


        return view('reportes.inmuebles',compact('Inmuebles','estado'));

    }

    public function captacion_pro()
    {

        $captadores = DB::table('personas as p')
             ->join('users as u', 'u.id_persona', '=', 'p.id')
             ->select(DB::raw('u.id, u.name as captador'))
             ->where('p.tipo_cargo', '=', 'Corredor - Externo')
             ->Orwhere('p.tipo_cargo', '=', 'Empleado')
             ->orderBy('u.name')
             ->get();   

        $estados=Mensajes::where('nombre_modulo','=','Captación')->get();

        $regiones = Region::all();

        return view('reportesfinales.cap_propietarios',compact('captadores','estados','regiones'));
    }



    public function captacion_arr()
    {

        $captadores = DB::table('personas as p')
             ->join('users as u', 'u.id_persona', '=', 'p.id')
             ->select(DB::raw('u.id, u.name as captador'))
             ->where('p.tipo_cargo', '=', 'Corredor - Externo')
             ->Orwhere('p.tipo_cargo', '=', 'Empleado')
             ->orderBy('u.name')
             ->get();   

        $estados=Mensajes::where('nombre_modulo','=','Arrendatario')->get();

        $regiones = Region::all();

        return view('reportesfinales.cap_arrendatarios',compact('captadores','estados','regiones'));
    }



    public function contrato_pro()
    {

        $captadores = DB::table('personas as p')
             ->join('users as u', 'u.id_persona', '=', 'p.id')
             ->select(DB::raw('u.id, u.name as captador'))
             ->where('p.tipo_cargo', '=', 'Corredor - Externo')
             ->Orwhere('p.tipo_cargo', '=', 'Empleado')
             ->orderBy('u.name')
             ->get();   

        $estados=Mensajes::where('nombre_modulo','=','Captación')->get();

        $regiones = Region::all();

        return view('reportesfinales.contratospropietarios',compact('captadores','estados','regiones'));
    }


        public function contrato_arr()
    {

        $captadores = DB::table('personas as p')
             ->join('users as u', 'u.id_persona', '=', 'p.id')
             ->select(DB::raw('u.id, u.name as captador'))
             ->where('p.tipo_cargo', '=', 'Corredor - Externo')
             ->Orwhere('p.tipo_cargo', '=', 'Empleado')
             ->orderBy('u.name')
             ->get();   

        $estados=Mensajes::where('nombre_modulo','=','Captación')->get();

        $regiones = Region::all();

        return view('reportesfinales.contratosarrendatarios',compact('captadores','estados','regiones'));
    }

        public function historial_direccion_inicio()
    {

$publica = DB::table('adm_contratofinal as co')
                ->leftjoin('borradores as cb', 'co.id_borrador', '=', 'cb.id')
                ->leftjoin('adm_contratodirpropietarios as cd', 'cd.id_contratofinal', '=', 'co.id')
                ->leftjoin('inmuebles as i', 'cd.id_inmueble', '=', 'i.id')
                ->leftjoin('comunas as o', 'i.id_comuna', '=', 'o.comuna_id')
                ->leftjoin('cap_publicaciones as c', 'c.id', '=', 'co.id_publicacion')
                ->leftjoin('personas as p1', 'c.id_propietario', '=', 'p1.id')
                ->leftjoin('users as p2', 'c.id_creador', '=', 'p2.id')
                ->leftjoin('users as p3', 'c.id_modificador', '=', 'p3.id')
         ->leftjoin('mensajes as m', function($join){
                 $join->on('m.nombre_modulo', '=',DB::raw("'Captación'"));
                 $join->on('m.id_estado', '=', 'c.id_estado');
            })
                ->select(DB::raw('co.id, cb.dia_pago,c.id as id_publicacion, DATE_FORMAT(c.created_at, "%d/%m/%Y") as fecha_creacion, c.id_estado as id_estado, m.nombre as estado, CONCAT_WS(" ",p1.nombre,p1.apellido_paterno,p1.apellido_materno) as Propietario, p2.name as Creador                

                    '), 'p1.id as id_propietario', 'i.id as id_inmueble', 'i.direccion', 'i.numero', 'i.departamento', 'o.comuna_nombre', 'p1.nombre as nom_p', 'p1.apellido_paterno as apep_p', 'p1.apellido_materno as apem_p', 'p3.name as modifcador')
                ->get();


        return view('reportesfinales.historial_direccion',compact('publica'));
    }

     public function genera_captacion_pro(Request $request){
        //dd($request);
      
         $reporte = DB::table('cap_publicaciones as c')
                ->leftjoin('personas as p1', 'c.id_propietario', '=', 'p1.id')
                ->leftjoin('inmuebles as i', 'c.id_inmueble', '=', 'i.id')
                ->leftjoin('users as p2', 'c.id_creador', '=', 'p2.id')
                ->leftjoin('personas as p3', 'c.id_modificador', '=', 'p3.id')
                ->leftjoin('personas as p4', 'c.id_corredor', '=', 'p4.id')
                ->leftjoin('comunas as o', 'i.id_comuna', '=', 'o.comuna_id')
                ->leftjoin('portales as po', 'c.portal', '=', 'po.id')
               ->leftjoin('mensajes as m', function($join){
                 $join->on('m.nombre_modulo', '=',DB::raw("'Captación'"));
                 $join->on('m.id_estado', '=', 'c.id_estado');
            })
               ->where("c.created_at",">=",$request->fechainicio)
               ->where("c.created_at","<=",$request->fechafin)
               ->where("i.direccion","like",'%'.$request->direccion.'%')
                ->select(DB::raw('
                    m.id as id_estado,
                    c.id_creador,
                    i.id_region,
                    i.id_provincia,
                    i.id_comuna,
                    c.id as id_publicacion,
                    c.tipo,
                    DATE_FORMAT(c.created_at, "%d/%m/%Y %T") as fecha_creacion,
                    DATE_FORMAT(c.updated_at, "%d/%m/%Y") as fecha_modificacion,
                     m.nombre as estado, 
                     CONCAT_WS(" ",p1.nombre,p1.apellido_paterno,p1.apellido_materno) as Propietario, 
                     CONCAT_WS(" ",p4.nombre,p4.apellido_paterno,p4.apellido_materno) as Externo,
                    (select tipo_contacto from cap_gestion where id_captacion_gestion=c.id order by created_at asc limit 1) as ultimo_tipo_contacto,
                    (select count(*) from cap_gestion where id_captacion_gestion=c.id and (tipo_contacto="Sin Respuesta" or tipo_contacto="Reenvío" or tipo_contacto="Correo Eléctronico" or tipo_contacto="Vigente") and (dir = "Información Enviada" or dir = "Ambas")) as cantCorreos,
                    (select count(*) from cap_gestion where id_captacion_gestion=c.id) as cantGes,
                     (select (select name from users where id=id_creador_gestion limit 1)  from cap_gestion where id_captacion_gestion=c.id order by created_at asc limit 1) as creador_gestion, 
                     p2.name as Creador, 
                     CONCAT_WS(" ",p3.nombre,p3.apellido_paterno,p3.apellido_materno) as Modificador,
                     p1.email,
                     p1.telefono,
                     c.fecha_publicacion,
                     i.departamento,
                     i.numero,
                     i.direccion,
                     po.nombre as portal,
                     o.comuna_nombre'))
                ->orderBy($request->orden,$request->tipoorden)
                ->get();

        if(!in_array('todos', $request->estado)){
            $reporte = $reporte->whereIn("id_estado",$request->estado);         ;
        }

        if(!in_array('todos', $request->captador)){
            $reporte = $reporte->whereIn("id_creador",$request->captador); 
        }
        if($request->region!='todos'){
            $reporte = $reporte->where("id_region","=",$request->region); 
        }
        if($request->provincia!='todos'){
             $reporte = $reporte->where("id_provincia","=",$request->provincia); 
        }
        if($request->comuna!='todos'){
            $reporte = $reporte->where("id_comuna","=",$request->comuna); 
        }
         if(isset($request->numero)){
            $reporte = $reporte->where("numero","=",$request->numero);
        }
        if(isset($request->departamento)){
            $reporte = $reporte->where("departamento","=",$request->departamento); 
        }                

        return Excel::create('Captaciones Propietario'.$request->fechainicio.' '.$request->fechafin, function ($excel) use ($reporte) {
                        $excel->sheet('Reporte', function ($sheet) use ($reporte) {
                            $sheet->loadView('formatosexcel.reporte_captaciones', compact('reporte'));
                        });
                    })->download('xlsx');
     }

public function genera_captacion_arr(Request $request){
        //dd($request);
      
         $reporte = DB::table('arrendatarios as c')
                ->leftjoin('personas as p1', 'c.id_arrendatario', '=', 'p1.id')
                ->leftjoin('inmuebles as i', 'c.id_inmueble', '=', 'i.id')
                ->leftjoin('users as p2', 'c.id_creador', '=', 'p2.id')
                ->leftjoin('personas as p3', 'c.id_modificador', '=', 'p3.id')
                ->leftjoin('personas as p4', 'c.id_aval', '=', 'p4.id')
                ->leftjoin('comunas as o', 'i.id_comuna', '=', 'o.comuna_id')
               ->leftjoin('mensajes as m', function($join){
                 $join->on('m.nombre_modulo', '=',DB::raw("'Arrendatario'"));
                 $join->on('m.id_estado', '=', 'c.id_estado');
            })
               ->where("c.created_at",">=",$request->fechainicio)
               ->where("c.created_at","<=",$request->fechafin)
               ->where("i.direccion","like",'%'.$request->direccion.'%')
                ->select(DB::raw('
                    m.id as id_estado,
                    c.id_creador,
                    i.id_region,
                    i.id_provincia,
                    i.id_comuna,
                    c.id as id_publicacion,
                    DATE_FORMAT(c.created_at, "%d/%m/%Y %T") as fecha_creacion,
                    DATE_FORMAT(c.updated_at, "%d/%m/%Y") as fecha_modificacion,
                     m.nombre as estado, 
                     CONCAT_WS(" ",p1.nombre,p1.apellido_paterno,p1.apellido_materno) as Arrendatario, 
                     CONCAT_WS(" ",p4.nombre,p4.apellido_paterno,p4.apellido_materno) as Aval, 
                     p4.rut as rut_aval,
                     p1.rut as rut_arrendatario,
                     p2.name as Creador, 
                     CONCAT_WS(" ",p3.nombre,p3.apellido_paterno,p3.apellido_materno) as Modificador,
                     p1.email,
                     p1.telefono,
                     i.departamento,
                     i.numero,
                     i.direccion,
                     o.comuna_nombre'))
                ->orderBy($request->orden,$request->tipoorden)
                ->get();

        if(!in_array('todos', $request->estado)){
            $reporte = $reporte->whereIn("id_estado",$request->estado);         ;
        }

        if($request->region!='todos'){
            $reporte = $reporte->where("id_region","=",$request->region); 
        }
        if($request->provincia!='todos'){
             $reporte = $reporte->where("id_provincia","=",$request->provincia); 
        }
        if($request->comuna!='todos'){
            $reporte = $reporte->where("id_comuna","=",$request->comuna); 
        }
         if(isset($request->numero)){
            $reporte = $reporte->where("numero","=",$request->numero);
        }
        if(isset($request->departamento)){
            $reporte = $reporte->where("departamento","=",$request->departamento); 
        }                

        return Excel::create('Captaciones Arrendatario'.$request->fechainicio.' '.$request->fechafin, function ($excel) use ($reporte) {
                        $excel->sheet('Reporte', function ($sheet) use ($reporte) {
                            $sheet->loadView('formatosexcel.reporte_captaciones_arr', compact('reporte'));
                        });
                    })->download('xlsx');
     }


public function genera_contrato_pro(Request $request){

     $meses = DB::select(DB::raw('Select 
                    CONCAT(MONTH(DATE_ADD(now(), INTERVAL -18 MONTH)),"/",YEAR(DATE_ADD(now(), INTERVAL -6 MONTH))) as mesanterior18,
                    CONCAT(MONTH(DATE_ADD(now(), INTERVAL -17 MONTH)),"/",YEAR(DATE_ADD(now(), INTERVAL -5 MONTH))) as mesanterior17,
                    CONCAT(MONTH(DATE_ADD(now(), INTERVAL -16 MONTH)),"/",YEAR(DATE_ADD(now(), INTERVAL -4 MONTH))) as mesanterior16,
                    CONCAT(MONTH(DATE_ADD(now(), INTERVAL -15 MONTH)),"/",YEAR(DATE_ADD(now(), INTERVAL -3 MONTH))) as mesanterior15,
                    CONCAT(MONTH(DATE_ADD(now(), INTERVAL -14 MONTH)),"/",YEAR(DATE_ADD(now(), INTERVAL -2 MONTH))) as mesanterior14,
                    CONCAT(MONTH(DATE_ADD(now(), INTERVAL -13 MONTH)),"/",YEAR(DATE_ADD(now(), INTERVAL -1 MONTH))) as mesanterior13,
                    CONCAT(MONTH(DATE_ADD(now(), INTERVAL -12 MONTH)),"/",YEAR(DATE_ADD(now(), INTERVAL -6 MONTH))) as mesanterior12,
                    CONCAT(MONTH(DATE_ADD(now(), INTERVAL -11 MONTH)),"/",YEAR(DATE_ADD(now(), INTERVAL -5 MONTH))) as mesanterior11,
                    CONCAT(MONTH(DATE_ADD(now(), INTERVAL -10 MONTH)),"/",YEAR(DATE_ADD(now(), INTERVAL -4 MONTH))) as mesanterior10,
                    CONCAT(MONTH(DATE_ADD(now(), INTERVAL -9 MONTH)),"/",YEAR(DATE_ADD(now(), INTERVAL -3 MONTH))) as mesanterior9,
                    CONCAT(MONTH(DATE_ADD(now(), INTERVAL -8 MONTH)),"/",YEAR(DATE_ADD(now(), INTERVAL -2 MONTH))) as mesanterior8,
                    CONCAT(MONTH(DATE_ADD(now(), INTERVAL -7 MONTH)),"/",YEAR(DATE_ADD(now(), INTERVAL -1 MONTH))) as mesanterior7,

                    CONCAT(MONTH(DATE_ADD(now(), INTERVAL -6 MONTH)),"/",YEAR(DATE_ADD(now(), INTERVAL -6 MONTH))) as mesanterior6,
                    CONCAT(MONTH(DATE_ADD(now(), INTERVAL -5 MONTH)),"/",YEAR(DATE_ADD(now(), INTERVAL -5 MONTH))) as mesanterior5,
                    CONCAT(MONTH(DATE_ADD(now(), INTERVAL -4 MONTH)),"/",YEAR(DATE_ADD(now(), INTERVAL -4 MONTH))) as mesanterior4,
                    CONCAT(MONTH(DATE_ADD(now(), INTERVAL -3 MONTH)),"/",YEAR(DATE_ADD(now(), INTERVAL -3 MONTH))) as mesanterior3,
                    CONCAT(MONTH(DATE_ADD(now(), INTERVAL -2 MONTH)),"/",YEAR(DATE_ADD(now(), INTERVAL -2 MONTH))) as mesanterior2,
                    CONCAT(MONTH(DATE_ADD(now(), INTERVAL -1 MONTH)),"/",YEAR(DATE_ADD(now(), INTERVAL -1 MONTH))) as mesanterior1,
                    CONCAT(MONTH(now()),"/",YEAR(now())) as mesactual,
                    CONCAT(MONTH(DATE_ADD(now(), INTERVAL +1 MONTH)),"/",YEAR(DATE_ADD(now(), INTERVAL +1 MONTH))) as messiguiente1,
                    CONCAT(MONTH(DATE_ADD(now(), INTERVAL +2 MONTH)),"/",YEAR(DATE_ADD(now(), INTERVAL +2 MONTH))) as messiguiente2,
                    CONCAT(MONTH(DATE_ADD(now(), INTERVAL +3 MONTH)),"/",YEAR(DATE_ADD(now(), INTERVAL +3 MONTH))) as messiguiente3,
                    CONCAT(MONTH(DATE_ADD(now(), INTERVAL +4 MONTH)),"/",YEAR(DATE_ADD(now(), INTERVAL +4 MONTH))) as messiguiente4,
                    CONCAT(MONTH(DATE_ADD(now(), INTERVAL +5 MONTH)),"/",YEAR(DATE_ADD(now(), INTERVAL +5 MONTH))) as messiguiente5,
                    CONCAT(MONTH(DATE_ADD(now(), INTERVAL +6 MONTH)),"/",YEAR(DATE_ADD(now(), INTERVAL +6 MONTH))) as messiguiente6,
                    CONCAT(MONTH(DATE_ADD(now(), INTERVAL +7 MONTH)),"/",YEAR(DATE_ADD(now(), INTERVAL +1 MONTH))) as messiguiente7,
                    CONCAT(MONTH(DATE_ADD(now(), INTERVAL +8 MONTH)),"/",YEAR(DATE_ADD(now(), INTERVAL +2 MONTH))) as messiguiente8,
                    CONCAT(MONTH(DATE_ADD(now(), INTERVAL +9 MONTH)),"/",YEAR(DATE_ADD(now(), INTERVAL +3 MONTH))) as messiguiente9,
                    CONCAT(MONTH(DATE_ADD(now(), INTERVAL +10 MONTH)),"/",YEAR(DATE_ADD(now(), INTERVAL +4 MONTH))) as messiguiente10,
                    CONCAT(MONTH(DATE_ADD(now(), INTERVAL +11 MONTH)),"/",YEAR(DATE_ADD(now(), INTERVAL +5 MONTH))) as messiguiente11,
                    CONCAT(MONTH(DATE_ADD(now(), INTERVAL +12 MONTH)),"/",YEAR(DATE_ADD(now(), INTERVAL +6 MONTH))) as messiguiente12,
                    CONCAT(MONTH(DATE_ADD(now(), INTERVAL +13 MONTH)),"/",YEAR(DATE_ADD(now(), INTERVAL +1 MONTH))) as messiguiente13,
                    CONCAT(MONTH(DATE_ADD(now(), INTERVAL +14 MONTH)),"/",YEAR(DATE_ADD(now(), INTERVAL +2 MONTH))) as messiguiente14,
                    CONCAT(MONTH(DATE_ADD(now(), INTERVAL +15 MONTH)),"/",YEAR(DATE_ADD(now(), INTERVAL +3 MONTH))) as messiguiente15,
                    CONCAT(MONTH(DATE_ADD(now(), INTERVAL +16 MONTH)),"/",YEAR(DATE_ADD(now(), INTERVAL +4 MONTH))) as messiguiente16,
                    CONCAT(MONTH(DATE_ADD(now(), INTERVAL +17 MONTH)),"/",YEAR(DATE_ADD(now(), INTERVAL +5 MONTH))) as messiguiente17,
                    CONCAT(MONTH(DATE_ADD(now(), INTERVAL +18 MONTH)),"/",YEAR(DATE_ADD(now(), INTERVAL +6 MONTH))) as messiguiente18'));
        $meses = $meses[0];

        $reporte = DB::table('adm_contratofinal as co')
                ->leftjoin('borradores as cb', 'co.id_borrador', '=', 'cb.id')
                ->leftjoin('adm_contratodirpropietarios as cd', 'cd.id_contratofinal', '=', 'co.id')
                ->leftjoin('inmuebles as i', 'cd.id_inmueble', '=', 'i.id')
                ->leftjoin('comunas as o', 'i.id_comuna', '=', 'o.comuna_id')
                ->leftjoin('cap_publicaciones as c', 'c.id', '=', 'co.id_publicacion')
                ->leftjoin('personas as p1', 'c.id_propietario', '=', 'p1.id')
                ->leftjoin('users as p2', 'c.id_creador', '=', 'p2.id')
                ->leftjoin('users as p3', 'c.id_modificador', '=', 'p3.id')
            ->leftjoin('mensajes as m', function($join){
                 $join->on('m.nombre_modulo', '=',DB::raw("'Captación'"));
                 $join->on('m.id_estado', '=', 'c.id_estado');
            })
                ->whereIn('c.id_estado', [7, 10, 6])
                ->where("co.fecha_firma",">=",$request->fechainicio)
               ->where("co.fecha_firma","<=",$request->fechafin)
               ->where("i.direccion","like",'%'.$request->direccion.'%')
                ->select(DB::raw('co.fecha_firma, m.nombre as estado, cb.dia_pago,c.id as id_publicacion, DATE_FORMAT(c.created_at, "%d/%m/%Y") as fecha_creacion, c.id_estado as id_estado, CONCAT_WS(" ",p1.nombre,p1.apellido_paterno,p1.apellido_materno) as Propietario, p2.name as Creador, p1.rut, p1.email, p1.telefono,

(select pago_propietario from adm_pagosmensualespropietarios where mes=MONTH(DATE_ADD(now(), INTERVAL -18 MONTH)) and anio=YEAR(DATE_ADD(now(), INTERVAL -18 MONTH)) and id_publicacion=c.id and id_inmueble=i.id and id_contratofinal=co.id ) as valoranterior18,

                    (select sum(valor_pagado) from adm_detallepagospropietarios dt inner join adm_pagosmensualespropietarios pm on dt.id_pagomensual=pm.id where pm.mes=MONTH(DATE_ADD(now(), INTERVAL -18 MONTH)) and pm.anio=YEAR(DATE_ADD(now(), INTERVAL -18 MONTH)) and pm.id_publicacion=c.id and pm.id_inmueble=i.id and pm.id_contratofinal=co.id ) as valorpagadoanterior18,

                  (select pago_propietario from adm_pagosmensualespropietarios where mes=MONTH(DATE_ADD(now(), INTERVAL -17 MONTH)) and anio=YEAR(DATE_ADD(now(), INTERVAL -17 MONTH)) and id_publicacion=c.id and id_inmueble=i.id and id_contratofinal=co.id) as valoranterior17,

                    (select sum(valor_pagado) from adm_detallepagospropietarios dt inner join adm_pagosmensualespropietarios pm on dt.id_pagomensual=pm.id where pm.mes=MONTH(DATE_ADD(now(), INTERVAL -17 MONTH)) and pm.anio=YEAR(DATE_ADD(now(), INTERVAL -17 MONTH)) and pm.id_publicacion=c.id and pm.id_inmueble=i.id and pm.id_contratofinal=co.id) as valorpagadoanterior17,

                  (select pago_propietario from adm_pagosmensualespropietarios where mes=MONTH(DATE_ADD(now(), INTERVAL -16 MONTH)) and anio=YEAR(DATE_ADD(now(), INTERVAL -16 MONTH)) and id_publicacion=c.id and id_inmueble=i.id and id_contratofinal=co.id) as valoranterior16,

                    (select sum(valor_pagado) from adm_detallepagospropietarios dt inner join adm_pagosmensualespropietarios pm on dt.id_pagomensual=pm.id where pm.mes=MONTH(DATE_ADD(now(), INTERVAL -16 MONTH)) and pm.anio=YEAR(DATE_ADD(now(), INTERVAL -16 MONTH)) and pm.id_publicacion=c.id and pm.id_inmueble=i.id and pm.id_contratofinal=co.id) as valorpagadoanterior16,

                  (select pago_propietario from adm_pagosmensualespropietarios where mes=MONTH(DATE_ADD(now(), INTERVAL -15 MONTH)) and anio=YEAR(DATE_ADD(now(), INTERVAL -15 MONTH)) and id_publicacion=c.id and id_inmueble=i.id and id_contratofinal=co.id) as valoranterior15,

                    (select sum(valor_pagado) from adm_detallepagospropietarios dt inner join adm_pagosmensualespropietarios pm on dt.id_pagomensual=pm.id where pm.mes=MONTH(DATE_ADD(now(), INTERVAL -15 MONTH)) and pm.anio=YEAR(DATE_ADD(now(), INTERVAL -15 MONTH)) and pm.id_publicacion=c.id and pm.id_inmueble=i.id and pm.id_contratofinal=co.id) as valorpagadoanterior15,

                  (select pago_propietario from adm_pagosmensualespropietarios where mes=MONTH(DATE_ADD(now(), INTERVAL -14 MONTH)) and anio=YEAR(DATE_ADD(now(), INTERVAL -14 MONTH)) and id_publicacion=c.id and id_inmueble=i.id and id_contratofinal=co.id) as valoranterior14,

                    (select sum(valor_pagado) from adm_detallepagospropietarios dt inner join adm_pagosmensualespropietarios pm on dt.id_pagomensual=pm.id where pm.mes=MONTH(DATE_ADD(now(), INTERVAL -14 MONTH)) and pm.anio=YEAR(DATE_ADD(now(), INTERVAL -14 MONTH)) and pm.id_publicacion=c.id and pm.id_inmueble=i.id and pm.id_contratofinal=co.id) as valorpagadoanterior14,


                  (select pago_propietario from adm_pagosmensualespropietarios where mes=MONTH(DATE_ADD(now(), INTERVAL -13 MONTH)) and anio=YEAR(DATE_ADD(now(), INTERVAL -13 MONTH)) and id_publicacion=c.id and id_inmueble=i.id and id_contratofinal=co.id) as valoranterior13,

                    (select sum(valor_pagado) from adm_detallepagospropietarios dt inner join adm_pagosmensualespropietarios pm on dt.id_pagomensual=pm.id where pm.mes=MONTH(DATE_ADD(now(), INTERVAL -13 MONTH)) and pm.anio=YEAR(DATE_ADD(now(), INTERVAL -13 MONTH)) and pm.id_publicacion=c.id and pm.id_inmueble=i.id and pm.id_contratofinal=co.id) as valorpagadoanterior13,


(select pago_propietario from adm_pagosmensualespropietarios where mes=MONTH(DATE_ADD(now(), INTERVAL -12 MONTH)) and anio=YEAR(DATE_ADD(now(), INTERVAL -12 MONTH)) and id_publicacion=c.id and id_inmueble=i.id and id_contratofinal=co.id ) as valoranterior12,

                    (select sum(valor_pagado) from adm_detallepagospropietarios dt inner join adm_pagosmensualespropietarios pm on dt.id_pagomensual=pm.id where pm.mes=MONTH(DATE_ADD(now(), INTERVAL -12 MONTH)) and pm.anio=YEAR(DATE_ADD(now(), INTERVAL -12 MONTH)) and pm.id_publicacion=c.id and pm.id_inmueble=i.id and pm.id_contratofinal=co.id ) as valorpagadoanterior12,

                  (select pago_propietario from adm_pagosmensualespropietarios where mes=MONTH(DATE_ADD(now(), INTERVAL -11 MONTH)) and anio=YEAR(DATE_ADD(now(), INTERVAL -11 MONTH)) and id_publicacion=c.id and id_inmueble=i.id and id_contratofinal=co.id) as valoranterior11,

                    (select sum(valor_pagado) from adm_detallepagospropietarios dt inner join adm_pagosmensualespropietarios pm on dt.id_pagomensual=pm.id where pm.mes=MONTH(DATE_ADD(now(), INTERVAL -11 MONTH)) and pm.anio=YEAR(DATE_ADD(now(), INTERVAL -11 MONTH)) and pm.id_publicacion=c.id and pm.id_inmueble=i.id and pm.id_contratofinal=co.id) as valorpagadoanterior11,

                  (select pago_propietario from adm_pagosmensualespropietarios where mes=MONTH(DATE_ADD(now(), INTERVAL -10 MONTH)) and anio=YEAR(DATE_ADD(now(), INTERVAL -10 MONTH)) and id_publicacion=c.id and id_inmueble=i.id and id_contratofinal=co.id) as valoranterior10,

                    (select sum(valor_pagado) from adm_detallepagospropietarios dt inner join adm_pagosmensualespropietarios pm on dt.id_pagomensual=pm.id where pm.mes=MONTH(DATE_ADD(now(), INTERVAL -10 MONTH)) and pm.anio=YEAR(DATE_ADD(now(), INTERVAL -10 MONTH)) and pm.id_publicacion=c.id and pm.id_inmueble=i.id and pm.id_contratofinal=co.id) as valorpagadoanterior10,

                  (select pago_propietario from adm_pagosmensualespropietarios where mes=MONTH(DATE_ADD(now(), INTERVAL -9 MONTH)) and anio=YEAR(DATE_ADD(now(), INTERVAL -9 MONTH)) and id_publicacion=c.id and id_inmueble=i.id and id_contratofinal=co.id) as valoranterior9,

                    (select sum(valor_pagado) from adm_detallepagospropietarios dt inner join adm_pagosmensualespropietarios pm on dt.id_pagomensual=pm.id where pm.mes=MONTH(DATE_ADD(now(), INTERVAL -9 MONTH)) and pm.anio=YEAR(DATE_ADD(now(), INTERVAL -9 MONTH)) and pm.id_publicacion=c.id and pm.id_inmueble=i.id and pm.id_contratofinal=co.id) as valorpagadoanterior9,

                  (select pago_propietario from adm_pagosmensualespropietarios where mes=MONTH(DATE_ADD(now(), INTERVAL -8 MONTH)) and anio=YEAR(DATE_ADD(now(), INTERVAL -8 MONTH)) and id_publicacion=c.id and id_inmueble=i.id and id_contratofinal=co.id) as valoranterior8,

                    (select sum(valor_pagado) from adm_detallepagospropietarios dt inner join adm_pagosmensualespropietarios pm on dt.id_pagomensual=pm.id where pm.mes=MONTH(DATE_ADD(now(), INTERVAL -8 MONTH)) and pm.anio=YEAR(DATE_ADD(now(), INTERVAL -8 MONTH)) and pm.id_publicacion=c.id and pm.id_inmueble=i.id and pm.id_contratofinal=co.id) as valorpagadoanterior8,


                  (select pago_propietario from adm_pagosmensualespropietarios where mes=MONTH(DATE_ADD(now(), INTERVAL -7 MONTH)) and anio=YEAR(DATE_ADD(now(), INTERVAL -7 MONTH)) and id_publicacion=c.id and id_inmueble=i.id and id_contratofinal=co.id) as valoranterior7,

                    (select sum(valor_pagado) from adm_detallepagospropietarios dt inner join adm_pagosmensualespropietarios pm on dt.id_pagomensual=pm.id where pm.mes=MONTH(DATE_ADD(now(), INTERVAL -7 MONTH)) and pm.anio=YEAR(DATE_ADD(now(), INTERVAL -7 MONTH)) and pm.id_publicacion=c.id and pm.id_inmueble=i.id and pm.id_contratofinal=co.id) as valorpagadoanterior7,


                  (select pago_propietario from adm_pagosmensualespropietarios where mes=MONTH(DATE_ADD(now(), INTERVAL -6 MONTH)) and anio=YEAR(DATE_ADD(now(), INTERVAL -6 MONTH)) and id_publicacion=c.id and id_inmueble=i.id and id_contratofinal=co.id ) as valoranterior6,

                    (select sum(valor_pagado) from adm_detallepagospropietarios dt inner join adm_pagosmensualespropietarios pm on dt.id_pagomensual=pm.id where pm.mes=MONTH(DATE_ADD(now(), INTERVAL -6 MONTH)) and pm.anio=YEAR(DATE_ADD(now(), INTERVAL -6 MONTH)) and pm.id_publicacion=c.id and pm.id_inmueble=i.id and pm.id_contratofinal=co.id ) as valorpagadoanterior6,

                  (select pago_propietario from adm_pagosmensualespropietarios where mes=MONTH(DATE_ADD(now(), INTERVAL -5 MONTH)) and anio=YEAR(DATE_ADD(now(), INTERVAL -5 MONTH)) and id_publicacion=c.id and id_inmueble=i.id and id_contratofinal=co.id) as valoranterior5,

                    (select sum(valor_pagado) from adm_detallepagospropietarios dt inner join adm_pagosmensualespropietarios pm on dt.id_pagomensual=pm.id where pm.mes=MONTH(DATE_ADD(now(), INTERVAL -5 MONTH)) and pm.anio=YEAR(DATE_ADD(now(), INTERVAL -5 MONTH)) and pm.id_publicacion=c.id and pm.id_inmueble=i.id and pm.id_contratofinal=co.id) as valorpagadoanterior5,

                  (select pago_propietario from adm_pagosmensualespropietarios where mes=MONTH(DATE_ADD(now(), INTERVAL -4 MONTH)) and anio=YEAR(DATE_ADD(now(), INTERVAL -4 MONTH)) and id_publicacion=c.id and id_inmueble=i.id and id_contratofinal=co.id) as valoranterior4,

                    (select sum(valor_pagado) from adm_detallepagospropietarios dt inner join adm_pagosmensualespropietarios pm on dt.id_pagomensual=pm.id where pm.mes=MONTH(DATE_ADD(now(), INTERVAL -4 MONTH)) and pm.anio=YEAR(DATE_ADD(now(), INTERVAL -4 MONTH)) and pm.id_publicacion=c.id and pm.id_inmueble=i.id and pm.id_contratofinal=co.id) as valorpagadoanterior4,

                  (select pago_propietario from adm_pagosmensualespropietarios where mes=MONTH(DATE_ADD(now(), INTERVAL -3 MONTH)) and anio=YEAR(DATE_ADD(now(), INTERVAL -3 MONTH)) and id_publicacion=c.id and id_inmueble=i.id and id_contratofinal=co.id) as valoranterior3,

                    (select sum(valor_pagado) from adm_detallepagospropietarios dt inner join adm_pagosmensualespropietarios pm on dt.id_pagomensual=pm.id where pm.mes=MONTH(DATE_ADD(now(), INTERVAL -3 MONTH)) and pm.anio=YEAR(DATE_ADD(now(), INTERVAL -3 MONTH)) and pm.id_publicacion=c.id and pm.id_inmueble=i.id and pm.id_contratofinal=co.id) as valorpagadoanterior3,

                  (select pago_propietario from adm_pagosmensualespropietarios where mes=MONTH(DATE_ADD(now(), INTERVAL -2 MONTH)) and anio=YEAR(DATE_ADD(now(), INTERVAL -2 MONTH)) and id_publicacion=c.id and id_inmueble=i.id and id_contratofinal=co.id) as valoranterior2,

                    (select sum(valor_pagado) from adm_detallepagospropietarios dt inner join adm_pagosmensualespropietarios pm on dt.id_pagomensual=pm.id where pm.mes=MONTH(DATE_ADD(now(), INTERVAL -2 MONTH)) and pm.anio=YEAR(DATE_ADD(now(), INTERVAL -2 MONTH)) and pm.id_publicacion=c.id and pm.id_inmueble=i.id and pm.id_contratofinal=co.id) as valorpagadoanterior2,


                  (select pago_propietario from adm_pagosmensualespropietarios where mes=MONTH(DATE_ADD(now(), INTERVAL -1 MONTH)) and anio=YEAR(DATE_ADD(now(), INTERVAL -1 MONTH)) and id_publicacion=c.id and id_inmueble=i.id and id_contratofinal=co.id) as valoranterior1,

                    (select sum(valor_pagado) from adm_detallepagospropietarios dt inner join adm_pagosmensualespropietarios pm on dt.id_pagomensual=pm.id where pm.mes=MONTH(DATE_ADD(now(), INTERVAL -1 MONTH)) and pm.anio=YEAR(DATE_ADD(now(), INTERVAL -1 MONTH)) and pm.id_publicacion=c.id and pm.id_inmueble=i.id and pm.id_contratofinal=co.id) as valorpagadoanterior1,

                    
                    (select pago_propietario from adm_pagosmensualespropietarios where mes=MONTH(now()) and anio=YEAR(now()) and id_publicacion=c.id and id_inmueble=i.id and id_contratofinal=co.id) as valoractual,

                    (select sum(valor_pagado) from adm_detallepagospropietarios dt inner join adm_pagosmensualespropietarios pm on dt.id_pagomensual=pm.id where pm.mes=MONTH(now()) and pm.anio=YEAR(now()) and pm.id_publicacion=c.id and pm.id_inmueble=i.id and pm.id_contratofinal=co.id) as valorpagadoactual,


                      (select pago_propietario from adm_pagosmensualespropietarios where mes=MONTH(DATE_ADD(now(), INTERVAL 1 MONTH)) and anio=YEAR(DATE_ADD(now(), INTERVAL 1 MONTH)) and id_publicacion=c.id and id_inmueble=i.id and id_contratofinal=co.id) as valorsiguiente1,

                    (select sum(valor_pagado) from adm_detallepagospropietarios dt inner join adm_pagosmensualespropietarios pm on dt.id_pagomensual=pm.id where pm.mes=MONTH(DATE_ADD(now(), INTERVAL 1 MONTH)) and pm.anio=YEAR(DATE_ADD(now(), INTERVAL 1 MONTH)) and pm.id_publicacion=c.id and pm.id_inmueble=i.id and pm.id_contratofinal=co.id) as valorpagadosiguiente1,

                    (select pago_propietario from adm_pagosmensualespropietarios where mes=MONTH(DATE_ADD(now(), INTERVAL 2 MONTH)) and anio=YEAR(DATE_ADD(now(), INTERVAL 2 MONTH)) and id_publicacion=c.id and id_inmueble=i.id and id_contratofinal=co.id) as valorsiguiente2,

                    (select sum(valor_pagado) from adm_detallepagospropietarios dt inner join adm_pagosmensualespropietarios pm on dt.id_pagomensual=pm.id where pm.mes=MONTH(DATE_ADD(now(), INTERVAL 2 MONTH)) and pm.anio=YEAR(DATE_ADD(now(), INTERVAL 2 MONTH)) and pm.id_publicacion=c.id and pm.id_inmueble=i.id and pm.id_contratofinal=co.id) as valorpagadosiguiente2,

                     (select pago_propietario from adm_pagosmensualespropietarios where mes=MONTH(DATE_ADD(now(), INTERVAL 3 MONTH)) and anio=YEAR(DATE_ADD(now(), INTERVAL 3 MONTH)) and id_publicacion=c.id and id_inmueble=i.id and id_contratofinal=co.id) as valorsiguiente3,

                    (select sum(valor_pagado) from adm_detallepagospropietarios dt inner join adm_pagosmensualespropietarios pm on dt.id_pagomensual=pm.id where pm.mes=MONTH(DATE_ADD(now(), INTERVAL 3 MONTH)) and pm.anio=YEAR(DATE_ADD(now(), INTERVAL 3 MONTH)) and pm.id_publicacion=c.id and pm.id_inmueble=i.id and pm.id_contratofinal=co.id) as valorpagadosiguiente3,

                     (select pago_propietario from adm_pagosmensualespropietarios where mes=MONTH(DATE_ADD(now(), INTERVAL 4 MONTH)) and anio=YEAR(DATE_ADD(now(), INTERVAL 4 MONTH)) and id_publicacion=c.id and id_inmueble=i.id and id_contratofinal=co.id) as valorsiguiente4,

                    (select sum(valor_pagado) from adm_detallepagospropietarios dt inner join adm_pagosmensualespropietarios pm on dt.id_pagomensual=pm.id where pm.mes=MONTH(DATE_ADD(now(), INTERVAL 4 MONTH)) and pm.anio=YEAR(DATE_ADD(now(), INTERVAL 4 MONTH)) and pm.id_publicacion=c.id and pm.id_inmueble=i.id and pm.id_contratofinal=co.id) as valorpagadosiguiente4,

                    (select pago_propietario from adm_pagosmensualespropietarios where mes=MONTH(DATE_ADD(now(), INTERVAL 5 MONTH)) and anio=YEAR(DATE_ADD(now(), INTERVAL 5 MONTH)) and id_publicacion=c.id and id_inmueble=i.id and id_contratofinal=co.id ) as valorsiguiente5,

                    (select sum(valor_pagado) from adm_detallepagospropietarios dt inner join adm_pagosmensualespropietarios pm on dt.id_pagomensual=pm.id where pm.mes=MONTH(DATE_ADD(now(), INTERVAL 5 MONTH)) and pm.anio=YEAR(DATE_ADD(now(), INTERVAL 5 MONTH)) and pm.id_publicacion=c.id and pm.id_inmueble=i.id and pm.id_contratofinal=co.id) as valorpagadosiguiente5,

                     (select pago_propietario from adm_pagosmensualespropietarios where mes=MONTH(DATE_ADD(now(), INTERVAL 6 MONTH)) and anio=YEAR(DATE_ADD(now(), INTERVAL 6 MONTH)) and id_publicacion=c.id and id_inmueble=i.id and id_contratofinal=co.id) as valorsiguiente6,

                    (select sum(valor_pagado) from adm_detallepagospropietarios dt inner join adm_pagosmensualespropietarios pm on dt.id_pagomensual=pm.id where pm.mes=MONTH(DATE_ADD(now(), INTERVAL 6 MONTH)) and pm.anio=YEAR(DATE_ADD(now(), INTERVAL 6 MONTH)) and pm.id_publicacion=c.id and pm.id_inmueble=i.id and pm.id_contratofinal=co.id) as valorpagadosiguiente6,

                    (select pago_propietario from adm_pagosmensualespropietarios where mes=MONTH(DATE_ADD(now(), INTERVAL 7 MONTH)) and anio=YEAR(DATE_ADD(now(), INTERVAL 7 MONTH)) and id_publicacion=c.id and id_inmueble=i.id and id_contratofinal=co.id) as valorsiguiente7,

                    (select sum(valor_pagado) from adm_detallepagospropietarios dt inner join adm_pagosmensualespropietarios pm on dt.id_pagomensual=pm.id where pm.mes=MONTH(DATE_ADD(now(), INTERVAL 7 MONTH)) and pm.anio=YEAR(DATE_ADD(now(), INTERVAL 7 MONTH)) and pm.id_publicacion=c.id and pm.id_inmueble=i.id and pm.id_contratofinal=co.id) as valorpagadosiguiente7,

                    (select pago_propietario from adm_pagosmensualespropietarios where mes=MONTH(DATE_ADD(now(), INTERVAL 8 MONTH)) and anio=YEAR(DATE_ADD(now(), INTERVAL 8 MONTH)) and id_publicacion=c.id and id_inmueble=i.id and id_contratofinal=co.id) as valorsiguiente8,

                    (select sum(valor_pagado) from adm_detallepagospropietarios dt inner join adm_pagosmensualespropietarios pm on dt.id_pagomensual=pm.id where pm.mes=MONTH(DATE_ADD(now(), INTERVAL 8 MONTH)) and pm.anio=YEAR(DATE_ADD(now(), INTERVAL 8 MONTH)) and pm.id_publicacion=c.id and pm.id_inmueble=i.id and pm.id_contratofinal=co.id) as valorpagadosiguiente8,

                     (select pago_propietario from adm_pagosmensualespropietarios where mes=MONTH(DATE_ADD(now(), INTERVAL 9 MONTH)) and anio=YEAR(DATE_ADD(now(), INTERVAL 9 MONTH)) and id_publicacion=c.id and id_inmueble=i.id and id_contratofinal=co.id) as valorsiguiente9,

                    (select sum(valor_pagado) from adm_detallepagospropietarios dt inner join adm_pagosmensualespropietarios pm on dt.id_pagomensual=pm.id where pm.mes=MONTH(DATE_ADD(now(), INTERVAL 9 MONTH)) and pm.anio=YEAR(DATE_ADD(now(), INTERVAL 9 MONTH)) and pm.id_publicacion=c.id and pm.id_inmueble=i.id and pm.id_contratofinal=co.id) as valorpagadosiguiente9,

                     (select pago_propietario from adm_pagosmensualespropietarios where mes=MONTH(DATE_ADD(now(), INTERVAL 10 MONTH)) and anio=YEAR(DATE_ADD(now(), INTERVAL 10 MONTH)) and id_publicacion=c.id and id_inmueble=i.id and id_contratofinal=co.id) as valorsiguiente10,

                    (select sum(valor_pagado) from adm_detallepagospropietarios dt inner join adm_pagosmensualespropietarios pm on dt.id_pagomensual=pm.id where pm.mes=MONTH(DATE_ADD(now(), INTERVAL 10 MONTH)) and pm.anio=YEAR(DATE_ADD(now(), INTERVAL 10 MONTH)) and pm.id_publicacion=c.id and pm.id_inmueble=i.id and pm.id_contratofinal=co.id) as valorpagadosiguiente10,

                    (select pago_propietario from adm_pagosmensualespropietarios where mes=MONTH(DATE_ADD(now(), INTERVAL 11 MONTH)) and anio=YEAR(DATE_ADD(now(), INTERVAL 11 MONTH)) and id_publicacion=c.id and id_inmueble=i.id and id_contratofinal=co.id ) as valorsiguiente11,

                    (select sum(valor_pagado) from adm_detallepagospropietarios dt inner join adm_pagosmensualespropietarios pm on dt.id_pagomensual=pm.id where pm.mes=MONTH(DATE_ADD(now(), INTERVAL 11 MONTH)) and pm.anio=YEAR(DATE_ADD(now(), INTERVAL 11 MONTH)) and pm.id_publicacion=c.id and pm.id_inmueble=i.id and pm.id_contratofinal=co.id) as valorpagadosiguiente11,

                     (select pago_propietario from adm_pagosmensualespropietarios where mes=MONTH(DATE_ADD(now(), INTERVAL 12 MONTH)) and anio=YEAR(DATE_ADD(now(), INTERVAL 12 MONTH)) and id_publicacion=c.id and id_inmueble=i.id and id_contratofinal=co.id) as valorsiguiente12,

                    (select sum(valor_pagado) from adm_detallepagospropietarios dt inner join adm_pagosmensualespropietarios pm on dt.id_pagomensual=pm.id where pm.mes=MONTH(DATE_ADD(now(), INTERVAL 12 MONTH)) and pm.anio=YEAR(DATE_ADD(now(), INTERVAL 12 MONTH)) and pm.id_publicacion=c.id and pm.id_inmueble=i.id and pm.id_contratofinal=co.id) as valorpagadosiguiente12,

                    (select pago_propietario from adm_pagosmensualespropietarios where mes=MONTH(DATE_ADD(now(), INTERVAL 13 MONTH)) and anio=YEAR(DATE_ADD(now(), INTERVAL 13 MONTH)) and id_publicacion=c.id and id_inmueble=i.id and id_contratofinal=co.id) as valorsiguiente13,

                    (select sum(valor_pagado) from adm_detallepagospropietarios dt inner join adm_pagosmensualespropietarios pm on dt.id_pagomensual=pm.id where pm.mes=MONTH(DATE_ADD(now(), INTERVAL 13 MONTH)) and pm.anio=YEAR(DATE_ADD(now(), INTERVAL 13 MONTH)) and pm.id_publicacion=c.id and pm.id_inmueble=i.id and pm.id_contratofinal=co.id) as valorpagadosiguiente13,

                    (select pago_propietario from adm_pagosmensualespropietarios where mes=MONTH(DATE_ADD(now(), INTERVAL 14 MONTH)) and anio=YEAR(DATE_ADD(now(), INTERVAL 14 MONTH)) and id_publicacion=c.id and id_inmueble=i.id and id_contratofinal=co.id) as valorsiguiente14,

                    (select sum(valor_pagado) from adm_detallepagospropietarios dt inner join adm_pagosmensualespropietarios pm on dt.id_pagomensual=pm.id where pm.mes=MONTH(DATE_ADD(now(), INTERVAL 14 MONTH)) and pm.anio=YEAR(DATE_ADD(now(), INTERVAL 14 MONTH)) and pm.id_publicacion=c.id and pm.id_inmueble=i.id and pm.id_contratofinal=co.id) as valorpagadosiguiente14,

                     (select pago_propietario from adm_pagosmensualespropietarios where mes=MONTH(DATE_ADD(now(), INTERVAL 15 MONTH)) and anio=YEAR(DATE_ADD(now(), INTERVAL 15 MONTH)) and id_publicacion=c.id and id_inmueble=i.id and id_contratofinal=co.id) as valorsiguiente15,

                    (select sum(valor_pagado) from adm_detallepagospropietarios dt inner join adm_pagosmensualespropietarios pm on dt.id_pagomensual=pm.id where pm.mes=MONTH(DATE_ADD(now(), INTERVAL 15 MONTH)) and pm.anio=YEAR(DATE_ADD(now(), INTERVAL 15 MONTH)) and pm.id_publicacion=c.id and pm.id_inmueble=i.id and pm.id_contratofinal=co.id) as valorpagadosiguiente15,

                     (select pago_propietario from adm_pagosmensualespropietarios where mes=MONTH(DATE_ADD(now(), INTERVAL 16 MONTH)) and anio=YEAR(DATE_ADD(now(), INTERVAL 16 MONTH)) and id_publicacion=c.id and id_inmueble=i.id and id_contratofinal=co.id) as valorsiguiente16,

                    (select sum(valor_pagado) from adm_detallepagospropietarios dt inner join adm_pagosmensualespropietarios pm on dt.id_pagomensual=pm.id where pm.mes=MONTH(DATE_ADD(now(), INTERVAL 16 MONTH)) and pm.anio=YEAR(DATE_ADD(now(), INTERVAL 16 MONTH)) and pm.id_publicacion=c.id and pm.id_inmueble=i.id and pm.id_contratofinal=co.id) as valorpagadosiguiente16,

                    (select pago_propietario from adm_pagosmensualespropietarios where mes=MONTH(DATE_ADD(now(), INTERVAL 17 MONTH)) and anio=YEAR(DATE_ADD(now(), INTERVAL 17 MONTH)) and id_publicacion=c.id and id_inmueble=i.id and id_contratofinal=co.id ) as valorsiguiente17,

                    (select sum(valor_pagado) from adm_detallepagospropietarios dt inner join adm_pagosmensualespropietarios pm on dt.id_pagomensual=pm.id where pm.mes=MONTH(DATE_ADD(now(), INTERVAL 17 MONTH)) and pm.anio=YEAR(DATE_ADD(now(), INTERVAL 17 MONTH)) and pm.id_publicacion=c.id and pm.id_inmueble=i.id and pm.id_contratofinal=co.id) as valorpagadosiguiente17,

                     (select pago_propietario from adm_pagosmensualespropietarios where mes=MONTH(DATE_ADD(now(), INTERVAL 18 MONTH)) and anio=YEAR(DATE_ADD(now(), INTERVAL 18 MONTH)) and id_publicacion=c.id and id_inmueble=i.id and id_contratofinal=co.id) as valorsiguiente18,

                    (select sum(valor_pagado) from adm_detallepagospropietarios dt inner join adm_pagosmensualespropietarios pm on dt.id_pagomensual=pm.id where pm.mes=MONTH(DATE_ADD(now(), INTERVAL 18 MONTH)) and pm.anio=YEAR(DATE_ADD(now(), INTERVAL 18 MONTH)) and pm.id_publicacion=c.id and pm.id_inmueble=i.id and pm.id_contratofinal=co.id) as valorpagadosiguiente18

                    '), 'p1.id as id_propietario', 'i.id as id_inmueble', 'i.direccion', 'i.numero', 'i.departamento', 'o.comuna_nombre', 'p1.nombre as nom_p', 'p1.apellido_paterno as apep_p', 'p1.apellido_materno as apem_p', 'p3.name as modifcador')
                ->orderby("co.fecha_firma","asc")
                ->get();

       if(!in_array('todos', $request->estado)){
            $reporte = $reporte->whereIn("id_estado",$request->estado);         ;
        }

        if($request->region!='todos'){
            $reporte = $reporte->where("id_region","=",$request->region); 
        }
        if($request->provincia!='todos'){
             $reporte = $reporte->where("id_provincia","=",$request->provincia); 
        }
        if($request->comuna!='todos'){
            $reporte = $reporte->where("id_comuna","=",$request->comuna); 
        }
         if(isset($request->numero)){
            $reporte = $reporte->where("numero","=",$request->numero);
        }
        if(isset($request->departamento)){
            $reporte = $reporte->where("departamento","=",$request->departamento); 
        }        


                        return Excel::create('Contratos Propietarios '.$request->fechainicio.' '.$request->fechafin, function ($excel) use ($reporte, $meses) {
                        $excel->sheet('Reporte', function ($sheet) use ($reporte, $meses) {
                            $sheet->loadView('formatosexcel.reporte_contratos', compact('reporte','meses'));
                        });
                    })->download('xlsx');
    }

    public function genera_contrato_arr(Request $request){

     $meses = DB::select(DB::raw('Select 
                    CONCAT(MONTH(DATE_ADD(now(), INTERVAL -18 MONTH)),"/",YEAR(DATE_ADD(now(), INTERVAL -6 MONTH))) as mesanterior18,
                    CONCAT(MONTH(DATE_ADD(now(), INTERVAL -17 MONTH)),"/",YEAR(DATE_ADD(now(), INTERVAL -5 MONTH))) as mesanterior17,
                    CONCAT(MONTH(DATE_ADD(now(), INTERVAL -16 MONTH)),"/",YEAR(DATE_ADD(now(), INTERVAL -4 MONTH))) as mesanterior16,
                    CONCAT(MONTH(DATE_ADD(now(), INTERVAL -15 MONTH)),"/",YEAR(DATE_ADD(now(), INTERVAL -3 MONTH))) as mesanterior15,
                    CONCAT(MONTH(DATE_ADD(now(), INTERVAL -14 MONTH)),"/",YEAR(DATE_ADD(now(), INTERVAL -2 MONTH))) as mesanterior14,
                    CONCAT(MONTH(DATE_ADD(now(), INTERVAL -13 MONTH)),"/",YEAR(DATE_ADD(now(), INTERVAL -1 MONTH))) as mesanterior13,
                    CONCAT(MONTH(DATE_ADD(now(), INTERVAL -12 MONTH)),"/",YEAR(DATE_ADD(now(), INTERVAL -6 MONTH))) as mesanterior12,
                    CONCAT(MONTH(DATE_ADD(now(), INTERVAL -11 MONTH)),"/",YEAR(DATE_ADD(now(), INTERVAL -5 MONTH))) as mesanterior11,
                    CONCAT(MONTH(DATE_ADD(now(), INTERVAL -10 MONTH)),"/",YEAR(DATE_ADD(now(), INTERVAL -4 MONTH))) as mesanterior10,
                    CONCAT(MONTH(DATE_ADD(now(), INTERVAL -9 MONTH)),"/",YEAR(DATE_ADD(now(), INTERVAL -3 MONTH))) as mesanterior9,
                    CONCAT(MONTH(DATE_ADD(now(), INTERVAL -8 MONTH)),"/",YEAR(DATE_ADD(now(), INTERVAL -2 MONTH))) as mesanterior8,
                    CONCAT(MONTH(DATE_ADD(now(), INTERVAL -7 MONTH)),"/",YEAR(DATE_ADD(now(), INTERVAL -1 MONTH))) as mesanterior7,

                    CONCAT(MONTH(DATE_ADD(now(), INTERVAL -6 MONTH)),"/",YEAR(DATE_ADD(now(), INTERVAL -6 MONTH))) as mesanterior6,
                    CONCAT(MONTH(DATE_ADD(now(), INTERVAL -5 MONTH)),"/",YEAR(DATE_ADD(now(), INTERVAL -5 MONTH))) as mesanterior5,
                    CONCAT(MONTH(DATE_ADD(now(), INTERVAL -4 MONTH)),"/",YEAR(DATE_ADD(now(), INTERVAL -4 MONTH))) as mesanterior4,
                    CONCAT(MONTH(DATE_ADD(now(), INTERVAL -3 MONTH)),"/",YEAR(DATE_ADD(now(), INTERVAL -3 MONTH))) as mesanterior3,
                    CONCAT(MONTH(DATE_ADD(now(), INTERVAL -2 MONTH)),"/",YEAR(DATE_ADD(now(), INTERVAL -2 MONTH))) as mesanterior2,
                    CONCAT(MONTH(DATE_ADD(now(), INTERVAL -1 MONTH)),"/",YEAR(DATE_ADD(now(), INTERVAL -1 MONTH))) as mesanterior1,
                    CONCAT(MONTH(now()),"/",YEAR(now())) as mesactual,
                    CONCAT(MONTH(DATE_ADD(now(), INTERVAL +1 MONTH)),"/",YEAR(DATE_ADD(now(), INTERVAL +1 MONTH))) as messiguiente1,
                    CONCAT(MONTH(DATE_ADD(now(), INTERVAL +2 MONTH)),"/",YEAR(DATE_ADD(now(), INTERVAL +2 MONTH))) as messiguiente2,
                    CONCAT(MONTH(DATE_ADD(now(), INTERVAL +3 MONTH)),"/",YEAR(DATE_ADD(now(), INTERVAL +3 MONTH))) as messiguiente3,
                    CONCAT(MONTH(DATE_ADD(now(), INTERVAL +4 MONTH)),"/",YEAR(DATE_ADD(now(), INTERVAL +4 MONTH))) as messiguiente4,
                    CONCAT(MONTH(DATE_ADD(now(), INTERVAL +5 MONTH)),"/",YEAR(DATE_ADD(now(), INTERVAL +5 MONTH))) as messiguiente5,
                    CONCAT(MONTH(DATE_ADD(now(), INTERVAL +6 MONTH)),"/",YEAR(DATE_ADD(now(), INTERVAL +6 MONTH))) as messiguiente6,
                    CONCAT(MONTH(DATE_ADD(now(), INTERVAL +7 MONTH)),"/",YEAR(DATE_ADD(now(), INTERVAL +1 MONTH))) as messiguiente7,
                    CONCAT(MONTH(DATE_ADD(now(), INTERVAL +8 MONTH)),"/",YEAR(DATE_ADD(now(), INTERVAL +2 MONTH))) as messiguiente8,
                    CONCAT(MONTH(DATE_ADD(now(), INTERVAL +9 MONTH)),"/",YEAR(DATE_ADD(now(), INTERVAL +3 MONTH))) as messiguiente9,
                    CONCAT(MONTH(DATE_ADD(now(), INTERVAL +10 MONTH)),"/",YEAR(DATE_ADD(now(), INTERVAL +4 MONTH))) as messiguiente10,
                    CONCAT(MONTH(DATE_ADD(now(), INTERVAL +11 MONTH)),"/",YEAR(DATE_ADD(now(), INTERVAL +5 MONTH))) as messiguiente11,
                    CONCAT(MONTH(DATE_ADD(now(), INTERVAL +12 MONTH)),"/",YEAR(DATE_ADD(now(), INTERVAL +6 MONTH))) as messiguiente12,
                    CONCAT(MONTH(DATE_ADD(now(), INTERVAL +13 MONTH)),"/",YEAR(DATE_ADD(now(), INTERVAL +1 MONTH))) as messiguiente13,
                    CONCAT(MONTH(DATE_ADD(now(), INTERVAL +14 MONTH)),"/",YEAR(DATE_ADD(now(), INTERVAL +2 MONTH))) as messiguiente14,
                    CONCAT(MONTH(DATE_ADD(now(), INTERVAL +15 MONTH)),"/",YEAR(DATE_ADD(now(), INTERVAL +3 MONTH))) as messiguiente15,
                    CONCAT(MONTH(DATE_ADD(now(), INTERVAL +16 MONTH)),"/",YEAR(DATE_ADD(now(), INTERVAL +4 MONTH))) as messiguiente16,
                    CONCAT(MONTH(DATE_ADD(now(), INTERVAL +17 MONTH)),"/",YEAR(DATE_ADD(now(), INTERVAL +5 MONTH))) as messiguiente17,
                    CONCAT(MONTH(DATE_ADD(now(), INTERVAL +18 MONTH)),"/",YEAR(DATE_ADD(now(), INTERVAL +6 MONTH))) as messiguiente18'));
        $meses = $meses[0];

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
                ->where("c.created_at",">=",$request->fechainicio)
               ->where("c.created_at","<=",$request->fechafin)
               ->where("i.direccion","like",'%'.$request->direccion.'%')
                ->select(DB::raw('co.fecha_firma, m.nombre as estado, p1.telefono as fono_arr, p1.email as email_arr, p4.telefono as fono_aval, p4.email as email_aval, cb.dia_pago,c.id as id_publicacion, DATE_FORMAT(c.created_at, "%d/%m/%Y") as fecha_creacion, c.id_estado as id_estado, CONCAT_WS(" ",p1.nombre,p1.apellido_paterno,p1.apellido_materno) as Arrendatario, p2.name as Creador,CONCAT_WS(" ",p4.nombre,p4.apellido_paterno,p4.apellido_materno) as Aval, p4.rut as rut_aval, p1.rut as rut_arr,

(select pago_a_rentas from adm_pagosmensualesarrendatarios where mes=MONTH(DATE_ADD(now(), INTERVAL -18 MONTH)) and anio=YEAR(DATE_ADD(now(), INTERVAL -18 MONTH)) and id_publicacion=c.id and id_inmueble=i.id and id_contratofinal=co.id ) as valoranterior18,

                    (select sum(valor_pagado) from adm_detallepagosarrendatarios dt inner join adm_pagosmensualesarrendatarios pm on dt.id_pagomensual=pm.id where pm.mes=MONTH(DATE_ADD(now(), INTERVAL -18 MONTH)) and pm.anio=YEAR(DATE_ADD(now(), INTERVAL -18 MONTH)) and pm.id_publicacion=c.id and pm.id_inmueble=i.id and pm.id_contratofinal=co.id ) as valorpagadoanterior18,

                  (select pago_a_rentas from adm_pagosmensualesarrendatarios where mes=MONTH(DATE_ADD(now(), INTERVAL -17 MONTH)) and anio=YEAR(DATE_ADD(now(), INTERVAL -17 MONTH)) and id_publicacion=c.id and id_inmueble=i.id and id_contratofinal=co.id) as valoranterior17,

                    (select sum(valor_pagado) from adm_detallepagosarrendatarios dt inner join adm_pagosmensualesarrendatarios pm on dt.id_pagomensual=pm.id where pm.mes=MONTH(DATE_ADD(now(), INTERVAL -17 MONTH)) and pm.anio=YEAR(DATE_ADD(now(), INTERVAL -17 MONTH)) and pm.id_publicacion=c.id and pm.id_inmueble=i.id and pm.id_contratofinal=co.id) as valorpagadoanterior17,

                  (select pago_a_rentas from adm_pagosmensualesarrendatarios where mes=MONTH(DATE_ADD(now(), INTERVAL -16 MONTH)) and anio=YEAR(DATE_ADD(now(), INTERVAL -16 MONTH)) and id_publicacion=c.id and id_inmueble=i.id and id_contratofinal=co.id) as valoranterior16,

                    (select sum(valor_pagado) from adm_detallepagosarrendatarios dt inner join adm_pagosmensualesarrendatarios pm on dt.id_pagomensual=pm.id where pm.mes=MONTH(DATE_ADD(now(), INTERVAL -16 MONTH)) and pm.anio=YEAR(DATE_ADD(now(), INTERVAL -16 MONTH)) and pm.id_publicacion=c.id and pm.id_inmueble=i.id and pm.id_contratofinal=co.id) as valorpagadoanterior16,

                  (select pago_a_rentas from adm_pagosmensualesarrendatarios where mes=MONTH(DATE_ADD(now(), INTERVAL -15 MONTH)) and anio=YEAR(DATE_ADD(now(), INTERVAL -15 MONTH)) and id_publicacion=c.id and id_inmueble=i.id and id_contratofinal=co.id) as valoranterior15,

                    (select sum(valor_pagado) from adm_detallepagosarrendatarios dt inner join adm_pagosmensualesarrendatarios pm on dt.id_pagomensual=pm.id where pm.mes=MONTH(DATE_ADD(now(), INTERVAL -15 MONTH)) and pm.anio=YEAR(DATE_ADD(now(), INTERVAL -15 MONTH)) and pm.id_publicacion=c.id and pm.id_inmueble=i.id and pm.id_contratofinal=co.id) as valorpagadoanterior15,

                  (select pago_a_rentas from adm_pagosmensualesarrendatarios where mes=MONTH(DATE_ADD(now(), INTERVAL -14 MONTH)) and anio=YEAR(DATE_ADD(now(), INTERVAL -14 MONTH)) and id_publicacion=c.id and id_inmueble=i.id and id_contratofinal=co.id) as valoranterior14,

                    (select sum(valor_pagado) from adm_detallepagosarrendatarios dt inner join adm_pagosmensualesarrendatarios pm on dt.id_pagomensual=pm.id where pm.mes=MONTH(DATE_ADD(now(), INTERVAL -14 MONTH)) and pm.anio=YEAR(DATE_ADD(now(), INTERVAL -14 MONTH)) and pm.id_publicacion=c.id and pm.id_inmueble=i.id and pm.id_contratofinal=co.id) as valorpagadoanterior14,


                  (select pago_a_rentas from adm_pagosmensualesarrendatarios where mes=MONTH(DATE_ADD(now(), INTERVAL -13 MONTH)) and anio=YEAR(DATE_ADD(now(), INTERVAL -13 MONTH)) and id_publicacion=c.id and id_inmueble=i.id and id_contratofinal=co.id) as valoranterior13,

                    (select sum(valor_pagado) from adm_detallepagosarrendatarios dt inner join adm_pagosmensualesarrendatarios pm on dt.id_pagomensual=pm.id where pm.mes=MONTH(DATE_ADD(now(), INTERVAL -13 MONTH)) and pm.anio=YEAR(DATE_ADD(now(), INTERVAL -13 MONTH)) and pm.id_publicacion=c.id and pm.id_inmueble=i.id and pm.id_contratofinal=co.id) as valorpagadoanterior13,


(select pago_a_rentas from adm_pagosmensualesarrendatarios where mes=MONTH(DATE_ADD(now(), INTERVAL -12 MONTH)) and anio=YEAR(DATE_ADD(now(), INTERVAL -12 MONTH)) and id_publicacion=c.id and id_inmueble=i.id and id_contratofinal=co.id ) as valoranterior12,

                    (select sum(valor_pagado) from adm_detallepagosarrendatarios dt inner join adm_pagosmensualesarrendatarios pm on dt.id_pagomensual=pm.id where pm.mes=MONTH(DATE_ADD(now(), INTERVAL -12 MONTH)) and pm.anio=YEAR(DATE_ADD(now(), INTERVAL -12 MONTH)) and pm.id_publicacion=c.id and pm.id_inmueble=i.id and pm.id_contratofinal=co.id ) as valorpagadoanterior12,

                  (select pago_a_rentas from adm_pagosmensualesarrendatarios where mes=MONTH(DATE_ADD(now(), INTERVAL -11 MONTH)) and anio=YEAR(DATE_ADD(now(), INTERVAL -11 MONTH)) and id_publicacion=c.id and id_inmueble=i.id and id_contratofinal=co.id) as valoranterior11,

                    (select sum(valor_pagado) from adm_detallepagosarrendatarios dt inner join adm_pagosmensualesarrendatarios pm on dt.id_pagomensual=pm.id where pm.mes=MONTH(DATE_ADD(now(), INTERVAL -11 MONTH)) and pm.anio=YEAR(DATE_ADD(now(), INTERVAL -11 MONTH)) and pm.id_publicacion=c.id and pm.id_inmueble=i.id and pm.id_contratofinal=co.id) as valorpagadoanterior11,

                  (select pago_a_rentas from adm_pagosmensualesarrendatarios where mes=MONTH(DATE_ADD(now(), INTERVAL -10 MONTH)) and anio=YEAR(DATE_ADD(now(), INTERVAL -10 MONTH)) and id_publicacion=c.id and id_inmueble=i.id and id_contratofinal=co.id) as valoranterior10,

                    (select sum(valor_pagado) from adm_detallepagosarrendatarios dt inner join adm_pagosmensualesarrendatarios pm on dt.id_pagomensual=pm.id where pm.mes=MONTH(DATE_ADD(now(), INTERVAL -10 MONTH)) and pm.anio=YEAR(DATE_ADD(now(), INTERVAL -10 MONTH)) and pm.id_publicacion=c.id and pm.id_inmueble=i.id and pm.id_contratofinal=co.id) as valorpagadoanterior10,

                  (select pago_a_rentas from adm_pagosmensualesarrendatarios where mes=MONTH(DATE_ADD(now(), INTERVAL -9 MONTH)) and anio=YEAR(DATE_ADD(now(), INTERVAL -9 MONTH)) and id_publicacion=c.id and id_inmueble=i.id and id_contratofinal=co.id) as valoranterior9,

                    (select sum(valor_pagado) from adm_detallepagosarrendatarios dt inner join adm_pagosmensualesarrendatarios pm on dt.id_pagomensual=pm.id where pm.mes=MONTH(DATE_ADD(now(), INTERVAL -9 MONTH)) and pm.anio=YEAR(DATE_ADD(now(), INTERVAL -9 MONTH)) and pm.id_publicacion=c.id and pm.id_inmueble=i.id and pm.id_contratofinal=co.id) as valorpagadoanterior9,

                  (select pago_a_rentas from adm_pagosmensualesarrendatarios where mes=MONTH(DATE_ADD(now(), INTERVAL -8 MONTH)) and anio=YEAR(DATE_ADD(now(), INTERVAL -8 MONTH)) and id_publicacion=c.id and id_inmueble=i.id and id_contratofinal=co.id) as valoranterior8,

                    (select sum(valor_pagado) from adm_detallepagosarrendatarios dt inner join adm_pagosmensualesarrendatarios pm on dt.id_pagomensual=pm.id where pm.mes=MONTH(DATE_ADD(now(), INTERVAL -8 MONTH)) and pm.anio=YEAR(DATE_ADD(now(), INTERVAL -8 MONTH)) and pm.id_publicacion=c.id and pm.id_inmueble=i.id and pm.id_contratofinal=co.id) as valorpagadoanterior8,


                  (select pago_a_rentas from adm_pagosmensualesarrendatarios where mes=MONTH(DATE_ADD(now(), INTERVAL -7 MONTH)) and anio=YEAR(DATE_ADD(now(), INTERVAL -7 MONTH)) and id_publicacion=c.id and id_inmueble=i.id and id_contratofinal=co.id) as valoranterior7,

                    (select sum(valor_pagado) from adm_detallepagosarrendatarios dt inner join adm_pagosmensualesarrendatarios pm on dt.id_pagomensual=pm.id where pm.mes=MONTH(DATE_ADD(now(), INTERVAL -7 MONTH)) and pm.anio=YEAR(DATE_ADD(now(), INTERVAL -7 MONTH)) and pm.id_publicacion=c.id and pm.id_inmueble=i.id and pm.id_contratofinal=co.id) as valorpagadoanterior7,


                  (select pago_a_rentas from adm_pagosmensualesarrendatarios where mes=MONTH(DATE_ADD(now(), INTERVAL -6 MONTH)) and anio=YEAR(DATE_ADD(now(), INTERVAL -6 MONTH)) and id_publicacion=c.id and id_inmueble=i.id and id_contratofinal=co.id ) as valoranterior6,

                    (select sum(valor_pagado) from adm_detallepagosarrendatarios dt inner join adm_pagosmensualesarrendatarios pm on dt.id_pagomensual=pm.id where pm.mes=MONTH(DATE_ADD(now(), INTERVAL -6 MONTH)) and pm.anio=YEAR(DATE_ADD(now(), INTERVAL -6 MONTH)) and pm.id_publicacion=c.id and pm.id_inmueble=i.id and pm.id_contratofinal=co.id ) as valorpagadoanterior6,

                  (select pago_a_rentas from adm_pagosmensualesarrendatarios where mes=MONTH(DATE_ADD(now(), INTERVAL -5 MONTH)) and anio=YEAR(DATE_ADD(now(), INTERVAL -5 MONTH)) and id_publicacion=c.id and id_inmueble=i.id and id_contratofinal=co.id) as valoranterior5,

                    (select sum(valor_pagado) from adm_detallepagosarrendatarios dt inner join adm_pagosmensualesarrendatarios pm on dt.id_pagomensual=pm.id where pm.mes=MONTH(DATE_ADD(now(), INTERVAL -5 MONTH)) and pm.anio=YEAR(DATE_ADD(now(), INTERVAL -5 MONTH)) and pm.id_publicacion=c.id and pm.id_inmueble=i.id and pm.id_contratofinal=co.id) as valorpagadoanterior5,

                  (select pago_a_rentas from adm_pagosmensualesarrendatarios where mes=MONTH(DATE_ADD(now(), INTERVAL -4 MONTH)) and anio=YEAR(DATE_ADD(now(), INTERVAL -4 MONTH)) and id_publicacion=c.id and id_inmueble=i.id and id_contratofinal=co.id) as valoranterior4,

                    (select sum(valor_pagado) from adm_detallepagosarrendatarios dt inner join adm_pagosmensualesarrendatarios pm on dt.id_pagomensual=pm.id where pm.mes=MONTH(DATE_ADD(now(), INTERVAL -4 MONTH)) and pm.anio=YEAR(DATE_ADD(now(), INTERVAL -4 MONTH)) and pm.id_publicacion=c.id and pm.id_inmueble=i.id and pm.id_contratofinal=co.id) as valorpagadoanterior4,

                  (select pago_a_rentas from adm_pagosmensualesarrendatarios where mes=MONTH(DATE_ADD(now(), INTERVAL -3 MONTH)) and anio=YEAR(DATE_ADD(now(), INTERVAL -3 MONTH)) and id_publicacion=c.id and id_inmueble=i.id and id_contratofinal=co.id) as valoranterior3,

                    (select sum(valor_pagado) from adm_detallepagosarrendatarios dt inner join adm_pagosmensualesarrendatarios pm on dt.id_pagomensual=pm.id where pm.mes=MONTH(DATE_ADD(now(), INTERVAL -3 MONTH)) and pm.anio=YEAR(DATE_ADD(now(), INTERVAL -3 MONTH)) and pm.id_publicacion=c.id and pm.id_inmueble=i.id and pm.id_contratofinal=co.id) as valorpagadoanterior3,

                  (select pago_a_rentas from adm_pagosmensualesarrendatarios where mes=MONTH(DATE_ADD(now(), INTERVAL -2 MONTH)) and anio=YEAR(DATE_ADD(now(), INTERVAL -2 MONTH)) and id_publicacion=c.id and id_inmueble=i.id and id_contratofinal=co.id) as valoranterior2,

                    (select sum(valor_pagado) from adm_detallepagosarrendatarios dt inner join adm_pagosmensualesarrendatarios pm on dt.id_pagomensual=pm.id where pm.mes=MONTH(DATE_ADD(now(), INTERVAL -2 MONTH)) and pm.anio=YEAR(DATE_ADD(now(), INTERVAL -2 MONTH)) and pm.id_publicacion=c.id and pm.id_inmueble=i.id and pm.id_contratofinal=co.id) as valorpagadoanterior2,


                  (select pago_a_rentas from adm_pagosmensualesarrendatarios where mes=MONTH(DATE_ADD(now(), INTERVAL -1 MONTH)) and anio=YEAR(DATE_ADD(now(), INTERVAL -1 MONTH)) and id_publicacion=c.id and id_inmueble=i.id and id_contratofinal=co.id) as valoranterior1,

                    (select sum(valor_pagado) from adm_detallepagosarrendatarios dt inner join adm_pagosmensualesarrendatarios pm on dt.id_pagomensual=pm.id where pm.mes=MONTH(DATE_ADD(now(), INTERVAL -1 MONTH)) and pm.anio=YEAR(DATE_ADD(now(), INTERVAL -1 MONTH)) and pm.id_publicacion=c.id and pm.id_inmueble=i.id and pm.id_contratofinal=co.id) as valorpagadoanterior1,

                    
                    (select pago_a_rentas from adm_pagosmensualesarrendatarios where mes=MONTH(now()) and anio=YEAR(now()) and id_publicacion=c.id and id_inmueble=i.id and id_contratofinal=co.id) as valoractual,

                    (select sum(valor_pagado) from adm_detallepagosarrendatarios dt inner join adm_pagosmensualesarrendatarios pm on dt.id_pagomensual=pm.id where pm.mes=MONTH(now()) and pm.anio=YEAR(now()) and pm.id_publicacion=c.id and pm.id_inmueble=i.id and pm.id_contratofinal=co.id) as valorpagadoactual,


                      (select pago_a_rentas from adm_pagosmensualesarrendatarios where mes=MONTH(DATE_ADD(now(), INTERVAL 1 MONTH)) and anio=YEAR(DATE_ADD(now(), INTERVAL 1 MONTH)) and id_publicacion=c.id and id_inmueble=i.id and id_contratofinal=co.id) as valorsiguiente1,

                    (select sum(valor_pagado) from adm_detallepagosarrendatarios dt inner join adm_pagosmensualesarrendatarios pm on dt.id_pagomensual=pm.id where pm.mes=MONTH(DATE_ADD(now(), INTERVAL 1 MONTH)) and pm.anio=YEAR(DATE_ADD(now(), INTERVAL 1 MONTH)) and pm.id_publicacion=c.id and pm.id_inmueble=i.id and pm.id_contratofinal=co.id) as valorpagadosiguiente1,

                    (select pago_a_rentas from adm_pagosmensualesarrendatarios where mes=MONTH(DATE_ADD(now(), INTERVAL 2 MONTH)) and anio=YEAR(DATE_ADD(now(), INTERVAL 2 MONTH)) and id_publicacion=c.id and id_inmueble=i.id and id_contratofinal=co.id) as valorsiguiente2,

                    (select sum(valor_pagado) from adm_detallepagosarrendatarios dt inner join adm_pagosmensualesarrendatarios pm on dt.id_pagomensual=pm.id where pm.mes=MONTH(DATE_ADD(now(), INTERVAL 2 MONTH)) and pm.anio=YEAR(DATE_ADD(now(), INTERVAL 2 MONTH)) and pm.id_publicacion=c.id and pm.id_inmueble=i.id and pm.id_contratofinal=co.id) as valorpagadosiguiente2,

                     (select pago_a_rentas from adm_pagosmensualesarrendatarios where mes=MONTH(DATE_ADD(now(), INTERVAL 3 MONTH)) and anio=YEAR(DATE_ADD(now(), INTERVAL 3 MONTH)) and id_publicacion=c.id and id_inmueble=i.id and id_contratofinal=co.id) as valorsiguiente3,

                    (select sum(valor_pagado) from adm_detallepagosarrendatarios dt inner join adm_pagosmensualesarrendatarios pm on dt.id_pagomensual=pm.id where pm.mes=MONTH(DATE_ADD(now(), INTERVAL 3 MONTH)) and pm.anio=YEAR(DATE_ADD(now(), INTERVAL 3 MONTH)) and pm.id_publicacion=c.id and pm.id_inmueble=i.id and pm.id_contratofinal=co.id) as valorpagadosiguiente3,

                     (select pago_a_rentas from adm_pagosmensualesarrendatarios where mes=MONTH(DATE_ADD(now(), INTERVAL 4 MONTH)) and anio=YEAR(DATE_ADD(now(), INTERVAL 4 MONTH)) and id_publicacion=c.id and id_inmueble=i.id and id_contratofinal=co.id) as valorsiguiente4,

                    (select sum(valor_pagado) from adm_detallepagosarrendatarios dt inner join adm_pagosmensualesarrendatarios pm on dt.id_pagomensual=pm.id where pm.mes=MONTH(DATE_ADD(now(), INTERVAL 4 MONTH)) and pm.anio=YEAR(DATE_ADD(now(), INTERVAL 4 MONTH)) and pm.id_publicacion=c.id and pm.id_inmueble=i.id and pm.id_contratofinal=co.id) as valorpagadosiguiente4,

                    (select pago_a_rentas from adm_pagosmensualesarrendatarios where mes=MONTH(DATE_ADD(now(), INTERVAL 5 MONTH)) and anio=YEAR(DATE_ADD(now(), INTERVAL 5 MONTH)) and id_publicacion=c.id and id_inmueble=i.id and id_contratofinal=co.id ) as valorsiguiente5,

                    (select sum(valor_pagado) from adm_detallepagosarrendatarios dt inner join adm_pagosmensualesarrendatarios pm on dt.id_pagomensual=pm.id where pm.mes=MONTH(DATE_ADD(now(), INTERVAL 5 MONTH)) and pm.anio=YEAR(DATE_ADD(now(), INTERVAL 5 MONTH)) and pm.id_publicacion=c.id and pm.id_inmueble=i.id and pm.id_contratofinal=co.id) as valorpagadosiguiente5,

                     (select pago_a_rentas from adm_pagosmensualesarrendatarios where mes=MONTH(DATE_ADD(now(), INTERVAL 6 MONTH)) and anio=YEAR(DATE_ADD(now(), INTERVAL 6 MONTH)) and id_publicacion=c.id and id_inmueble=i.id and id_contratofinal=co.id) as valorsiguiente6,

                    (select sum(valor_pagado) from adm_detallepagosarrendatarios dt inner join adm_pagosmensualesarrendatarios pm on dt.id_pagomensual=pm.id where pm.mes=MONTH(DATE_ADD(now(), INTERVAL 6 MONTH)) and pm.anio=YEAR(DATE_ADD(now(), INTERVAL 6 MONTH)) and pm.id_publicacion=c.id and pm.id_inmueble=i.id and pm.id_contratofinal=co.id) as valorpagadosiguiente6,

                    (select pago_a_rentas from adm_pagosmensualesarrendatarios where mes=MONTH(DATE_ADD(now(), INTERVAL 7 MONTH)) and anio=YEAR(DATE_ADD(now(), INTERVAL 7 MONTH)) and id_publicacion=c.id and id_inmueble=i.id and id_contratofinal=co.id) as valorsiguiente7,

                    (select sum(valor_pagado) from adm_detallepagosarrendatarios dt inner join adm_pagosmensualesarrendatarios pm on dt.id_pagomensual=pm.id where pm.mes=MONTH(DATE_ADD(now(), INTERVAL 7 MONTH)) and pm.anio=YEAR(DATE_ADD(now(), INTERVAL 7 MONTH)) and pm.id_publicacion=c.id and pm.id_inmueble=i.id and pm.id_contratofinal=co.id) as valorpagadosiguiente7,

                    (select pago_a_rentas from adm_pagosmensualesarrendatarios where mes=MONTH(DATE_ADD(now(), INTERVAL 8 MONTH)) and anio=YEAR(DATE_ADD(now(), INTERVAL 8 MONTH)) and id_publicacion=c.id and id_inmueble=i.id and id_contratofinal=co.id) as valorsiguiente8,

                    (select sum(valor_pagado) from adm_detallepagosarrendatarios dt inner join adm_pagosmensualesarrendatarios pm on dt.id_pagomensual=pm.id where pm.mes=MONTH(DATE_ADD(now(), INTERVAL 8 MONTH)) and pm.anio=YEAR(DATE_ADD(now(), INTERVAL 8 MONTH)) and pm.id_publicacion=c.id and pm.id_inmueble=i.id and pm.id_contratofinal=co.id) as valorpagadosiguiente8,

                     (select pago_a_rentas from adm_pagosmensualesarrendatarios where mes=MONTH(DATE_ADD(now(), INTERVAL 9 MONTH)) and anio=YEAR(DATE_ADD(now(), INTERVAL 9 MONTH)) and id_publicacion=c.id and id_inmueble=i.id and id_contratofinal=co.id) as valorsiguiente9,

                    (select sum(valor_pagado) from adm_detallepagosarrendatarios dt inner join adm_pagosmensualesarrendatarios pm on dt.id_pagomensual=pm.id where pm.mes=MONTH(DATE_ADD(now(), INTERVAL 9 MONTH)) and pm.anio=YEAR(DATE_ADD(now(), INTERVAL 9 MONTH)) and pm.id_publicacion=c.id and pm.id_inmueble=i.id and pm.id_contratofinal=co.id) as valorpagadosiguiente9,

                     (select pago_a_rentas from adm_pagosmensualesarrendatarios where mes=MONTH(DATE_ADD(now(), INTERVAL 10 MONTH)) and anio=YEAR(DATE_ADD(now(), INTERVAL 10 MONTH)) and id_publicacion=c.id and id_inmueble=i.id and id_contratofinal=co.id) as valorsiguiente10,

                    (select sum(valor_pagado) from adm_detallepagosarrendatarios dt inner join adm_pagosmensualesarrendatarios pm on dt.id_pagomensual=pm.id where pm.mes=MONTH(DATE_ADD(now(), INTERVAL 10 MONTH)) and pm.anio=YEAR(DATE_ADD(now(), INTERVAL 10 MONTH)) and pm.id_publicacion=c.id and pm.id_inmueble=i.id and pm.id_contratofinal=co.id) as valorpagadosiguiente10,

                    (select pago_a_rentas from adm_pagosmensualesarrendatarios where mes=MONTH(DATE_ADD(now(), INTERVAL 11 MONTH)) and anio=YEAR(DATE_ADD(now(), INTERVAL 11 MONTH)) and id_publicacion=c.id and id_inmueble=i.id and id_contratofinal=co.id ) as valorsiguiente11,

                    (select sum(valor_pagado) from adm_detallepagosarrendatarios dt inner join adm_pagosmensualesarrendatarios pm on dt.id_pagomensual=pm.id where pm.mes=MONTH(DATE_ADD(now(), INTERVAL 11 MONTH)) and pm.anio=YEAR(DATE_ADD(now(), INTERVAL 11 MONTH)) and pm.id_publicacion=c.id and pm.id_inmueble=i.id and pm.id_contratofinal=co.id) as valorpagadosiguiente11,

                     (select pago_a_rentas from adm_pagosmensualesarrendatarios where mes=MONTH(DATE_ADD(now(), INTERVAL 12 MONTH)) and anio=YEAR(DATE_ADD(now(), INTERVAL 12 MONTH)) and id_publicacion=c.id and id_inmueble=i.id and id_contratofinal=co.id) as valorsiguiente12,

                    (select sum(valor_pagado) from adm_detallepagosarrendatarios dt inner join adm_pagosmensualesarrendatarios pm on dt.id_pagomensual=pm.id where pm.mes=MONTH(DATE_ADD(now(), INTERVAL 12 MONTH)) and pm.anio=YEAR(DATE_ADD(now(), INTERVAL 12 MONTH)) and pm.id_publicacion=c.id and pm.id_inmueble=i.id and pm.id_contratofinal=co.id) as valorpagadosiguiente12,

                    (select pago_a_rentas from adm_pagosmensualesarrendatarios where mes=MONTH(DATE_ADD(now(), INTERVAL 13 MONTH)) and anio=YEAR(DATE_ADD(now(), INTERVAL 13 MONTH)) and id_publicacion=c.id and id_inmueble=i.id and id_contratofinal=co.id) as valorsiguiente13,

                    (select sum(valor_pagado) from adm_detallepagosarrendatarios dt inner join adm_pagosmensualesarrendatarios pm on dt.id_pagomensual=pm.id where pm.mes=MONTH(DATE_ADD(now(), INTERVAL 13 MONTH)) and pm.anio=YEAR(DATE_ADD(now(), INTERVAL 13 MONTH)) and pm.id_publicacion=c.id and pm.id_inmueble=i.id and pm.id_contratofinal=co.id) as valorpagadosiguiente13,

                    (select pago_a_rentas from adm_pagosmensualesarrendatarios where mes=MONTH(DATE_ADD(now(), INTERVAL 14 MONTH)) and anio=YEAR(DATE_ADD(now(), INTERVAL 14 MONTH)) and id_publicacion=c.id and id_inmueble=i.id and id_contratofinal=co.id) as valorsiguiente14,

                    (select sum(valor_pagado) from adm_detallepagosarrendatarios dt inner join adm_pagosmensualesarrendatarios pm on dt.id_pagomensual=pm.id where pm.mes=MONTH(DATE_ADD(now(), INTERVAL 14 MONTH)) and pm.anio=YEAR(DATE_ADD(now(), INTERVAL 14 MONTH)) and pm.id_publicacion=c.id and pm.id_inmueble=i.id and pm.id_contratofinal=co.id) as valorpagadosiguiente14,

                     (select pago_a_rentas from adm_pagosmensualesarrendatarios where mes=MONTH(DATE_ADD(now(), INTERVAL 15 MONTH)) and anio=YEAR(DATE_ADD(now(), INTERVAL 15 MONTH)) and id_publicacion=c.id and id_inmueble=i.id and id_contratofinal=co.id) as valorsiguiente15,

                    (select sum(valor_pagado) from adm_detallepagosarrendatarios dt inner join adm_pagosmensualesarrendatarios pm on dt.id_pagomensual=pm.id where pm.mes=MONTH(DATE_ADD(now(), INTERVAL 15 MONTH)) and pm.anio=YEAR(DATE_ADD(now(), INTERVAL 15 MONTH)) and pm.id_publicacion=c.id and pm.id_inmueble=i.id and pm.id_contratofinal=co.id) as valorpagadosiguiente15,

                     (select pago_a_rentas from adm_pagosmensualesarrendatarios where mes=MONTH(DATE_ADD(now(), INTERVAL 16 MONTH)) and anio=YEAR(DATE_ADD(now(), INTERVAL 16 MONTH)) and id_publicacion=c.id and id_inmueble=i.id and id_contratofinal=co.id) as valorsiguiente16,

                    (select sum(valor_pagado) from adm_detallepagosarrendatarios dt inner join adm_pagosmensualesarrendatarios pm on dt.id_pagomensual=pm.id where pm.mes=MONTH(DATE_ADD(now(), INTERVAL 16 MONTH)) and pm.anio=YEAR(DATE_ADD(now(), INTERVAL 16 MONTH)) and pm.id_publicacion=c.id and pm.id_inmueble=i.id and pm.id_contratofinal=co.id) as valorpagadosiguiente16,

                    (select pago_a_rentas from adm_pagosmensualesarrendatarios where mes=MONTH(DATE_ADD(now(), INTERVAL 17 MONTH)) and anio=YEAR(DATE_ADD(now(), INTERVAL 17 MONTH)) and id_publicacion=c.id and id_inmueble=i.id and id_contratofinal=co.id ) as valorsiguiente17,

                    (select sum(valor_pagado) from adm_detallepagosarrendatarios dt inner join adm_pagosmensualesarrendatarios pm on dt.id_pagomensual=pm.id where pm.mes=MONTH(DATE_ADD(now(), INTERVAL 17 MONTH)) and pm.anio=YEAR(DATE_ADD(now(), INTERVAL 17 MONTH)) and pm.id_publicacion=c.id and pm.id_inmueble=i.id and pm.id_contratofinal=co.id) as valorpagadosiguiente17,

                     (select pago_a_rentas from adm_pagosmensualesarrendatarios where mes=MONTH(DATE_ADD(now(), INTERVAL 18 MONTH)) and anio=YEAR(DATE_ADD(now(), INTERVAL 18 MONTH)) and id_publicacion=c.id and id_inmueble=i.id and id_contratofinal=co.id) as valorsiguiente18,

                    (select sum(valor_pagado) from adm_detallepagosarrendatarios dt inner join adm_pagosmensualesarrendatarios pm on dt.id_pagomensual=pm.id where pm.mes=MONTH(DATE_ADD(now(), INTERVAL 18 MONTH)) and pm.anio=YEAR(DATE_ADD(now(), INTERVAL 18 MONTH)) and pm.id_publicacion=c.id and pm.id_inmueble=i.id and pm.id_contratofinal=co.id) as valorpagadosiguiente18

                    '), 'p1.id as id_arr', 'i.id as id_inmueble', 'i.direccion', 'i.numero', 'i.departamento', 'o.comuna_nombre', 'p1.nombre as nom_p', 'p1.apellido_paterno as apep_p', 'p1.apellido_materno as apem_p', 'p3.name as modifcador')
                ->orderby("co.fecha_firma","asc")
                ->get();

       if(!in_array('todos', $request->estado)){
            $reporte = $reporte->whereIn("id_estado",$request->estado);         ;
        }

        if($request->region!='todos'){
            $reporte = $reporte->where("id_region","=",$request->region); 
        }
        if($request->provincia!='todos'){
             $reporte = $reporte->where("id_provincia","=",$request->provincia); 
        }
        if($request->comuna!='todos'){
            $reporte = $reporte->where("id_comuna","=",$request->comuna); 
        }
         if(isset($request->numero)){
            $reporte = $reporte->where("numero","=",$request->numero);
        }
        if(isset($request->departamento)){
            $reporte = $reporte->where("departamento","=",$request->departamento); 
        }        


                        return Excel::create('Contratos Arrendatarios '.$request->fechainicio.' '.$request->fechafin, function ($excel) use ($reporte, $meses) {
                        $excel->sheet('Reporte', function ($sheet) use ($reporte, $meses) {
                            $sheet->loadView('formatosexcel.reporte_contratos_arr', compact('reporte','meses'));
                        });
                    })->download('xlsx');
    }


    public function historial_direccion($id){

$meses = DB::select(DB::raw('Select 
                    CONCAT(MONTH(DATE_ADD(now(), INTERVAL -18 MONTH)),"/",YEAR(DATE_ADD(now(), INTERVAL -6 MONTH))) as mesanterior18,
                    CONCAT(MONTH(DATE_ADD(now(), INTERVAL -17 MONTH)),"/",YEAR(DATE_ADD(now(), INTERVAL -5 MONTH))) as mesanterior17,
                    CONCAT(MONTH(DATE_ADD(now(), INTERVAL -16 MONTH)),"/",YEAR(DATE_ADD(now(), INTERVAL -4 MONTH))) as mesanterior16,
                    CONCAT(MONTH(DATE_ADD(now(), INTERVAL -15 MONTH)),"/",YEAR(DATE_ADD(now(), INTERVAL -3 MONTH))) as mesanterior15,
                    CONCAT(MONTH(DATE_ADD(now(), INTERVAL -14 MONTH)),"/",YEAR(DATE_ADD(now(), INTERVAL -2 MONTH))) as mesanterior14,
                    CONCAT(MONTH(DATE_ADD(now(), INTERVAL -13 MONTH)),"/",YEAR(DATE_ADD(now(), INTERVAL -1 MONTH))) as mesanterior13,
                    CONCAT(MONTH(DATE_ADD(now(), INTERVAL -12 MONTH)),"/",YEAR(DATE_ADD(now(), INTERVAL -6 MONTH))) as mesanterior12,
                    CONCAT(MONTH(DATE_ADD(now(), INTERVAL -11 MONTH)),"/",YEAR(DATE_ADD(now(), INTERVAL -5 MONTH))) as mesanterior11,
                    CONCAT(MONTH(DATE_ADD(now(), INTERVAL -10 MONTH)),"/",YEAR(DATE_ADD(now(), INTERVAL -4 MONTH))) as mesanterior10,
                    CONCAT(MONTH(DATE_ADD(now(), INTERVAL -9 MONTH)),"/",YEAR(DATE_ADD(now(), INTERVAL -3 MONTH))) as mesanterior9,
                    CONCAT(MONTH(DATE_ADD(now(), INTERVAL -8 MONTH)),"/",YEAR(DATE_ADD(now(), INTERVAL -2 MONTH))) as mesanterior8,
                    CONCAT(MONTH(DATE_ADD(now(), INTERVAL -7 MONTH)),"/",YEAR(DATE_ADD(now(), INTERVAL -1 MONTH))) as mesanterior7,

                    CONCAT(MONTH(DATE_ADD(now(), INTERVAL -6 MONTH)),"/",YEAR(DATE_ADD(now(), INTERVAL -6 MONTH))) as mesanterior6,
                    CONCAT(MONTH(DATE_ADD(now(), INTERVAL -5 MONTH)),"/",YEAR(DATE_ADD(now(), INTERVAL -5 MONTH))) as mesanterior5,
                    CONCAT(MONTH(DATE_ADD(now(), INTERVAL -4 MONTH)),"/",YEAR(DATE_ADD(now(), INTERVAL -4 MONTH))) as mesanterior4,
                    CONCAT(MONTH(DATE_ADD(now(), INTERVAL -3 MONTH)),"/",YEAR(DATE_ADD(now(), INTERVAL -3 MONTH))) as mesanterior3,
                    CONCAT(MONTH(DATE_ADD(now(), INTERVAL -2 MONTH)),"/",YEAR(DATE_ADD(now(), INTERVAL -2 MONTH))) as mesanterior2,
                    CONCAT(MONTH(DATE_ADD(now(), INTERVAL -1 MONTH)),"/",YEAR(DATE_ADD(now(), INTERVAL -1 MONTH))) as mesanterior1,
                    CONCAT(MONTH(now()),"/",YEAR(now())) as mesactual,
                    CONCAT(MONTH(DATE_ADD(now(), INTERVAL +1 MONTH)),"/",YEAR(DATE_ADD(now(), INTERVAL +1 MONTH))) as messiguiente1,
                    CONCAT(MONTH(DATE_ADD(now(), INTERVAL +2 MONTH)),"/",YEAR(DATE_ADD(now(), INTERVAL +2 MONTH))) as messiguiente2,
                    CONCAT(MONTH(DATE_ADD(now(), INTERVAL +3 MONTH)),"/",YEAR(DATE_ADD(now(), INTERVAL +3 MONTH))) as messiguiente3,
                    CONCAT(MONTH(DATE_ADD(now(), INTERVAL +4 MONTH)),"/",YEAR(DATE_ADD(now(), INTERVAL +4 MONTH))) as messiguiente4,
                    CONCAT(MONTH(DATE_ADD(now(), INTERVAL +5 MONTH)),"/",YEAR(DATE_ADD(now(), INTERVAL +5 MONTH))) as messiguiente5,
                    CONCAT(MONTH(DATE_ADD(now(), INTERVAL +6 MONTH)),"/",YEAR(DATE_ADD(now(), INTERVAL +6 MONTH))) as messiguiente6,
                    CONCAT(MONTH(DATE_ADD(now(), INTERVAL +7 MONTH)),"/",YEAR(DATE_ADD(now(), INTERVAL +1 MONTH))) as messiguiente7,
                    CONCAT(MONTH(DATE_ADD(now(), INTERVAL +8 MONTH)),"/",YEAR(DATE_ADD(now(), INTERVAL +2 MONTH))) as messiguiente8,
                    CONCAT(MONTH(DATE_ADD(now(), INTERVAL +9 MONTH)),"/",YEAR(DATE_ADD(now(), INTERVAL +3 MONTH))) as messiguiente9,
                    CONCAT(MONTH(DATE_ADD(now(), INTERVAL +10 MONTH)),"/",YEAR(DATE_ADD(now(), INTERVAL +4 MONTH))) as messiguiente10,
                    CONCAT(MONTH(DATE_ADD(now(), INTERVAL +11 MONTH)),"/",YEAR(DATE_ADD(now(), INTERVAL +5 MONTH))) as messiguiente11,
                    CONCAT(MONTH(DATE_ADD(now(), INTERVAL +12 MONTH)),"/",YEAR(DATE_ADD(now(), INTERVAL +6 MONTH))) as messiguiente12,
                    CONCAT(MONTH(DATE_ADD(now(), INTERVAL +13 MONTH)),"/",YEAR(DATE_ADD(now(), INTERVAL +1 MONTH))) as messiguiente13,
                    CONCAT(MONTH(DATE_ADD(now(), INTERVAL +14 MONTH)),"/",YEAR(DATE_ADD(now(), INTERVAL +2 MONTH))) as messiguiente14,
                    CONCAT(MONTH(DATE_ADD(now(), INTERVAL +15 MONTH)),"/",YEAR(DATE_ADD(now(), INTERVAL +3 MONTH))) as messiguiente15,
                    CONCAT(MONTH(DATE_ADD(now(), INTERVAL +16 MONTH)),"/",YEAR(DATE_ADD(now(), INTERVAL +4 MONTH))) as messiguiente16,
                    CONCAT(MONTH(DATE_ADD(now(), INTERVAL +17 MONTH)),"/",YEAR(DATE_ADD(now(), INTERVAL +5 MONTH))) as messiguiente17,
                    CONCAT(MONTH(DATE_ADD(now(), INTERVAL +18 MONTH)),"/",YEAR(DATE_ADD(now(), INTERVAL +6 MONTH))) as messiguiente18'));
        $meses = $meses[0];
         $inmueble = DB::table('inmuebles as i')
            ->join('comunas as c', 'i.id_comuna', '=', 'c.comuna_id')
            ->leftjoin('mensajes as m', function($join){
                 $join->on('m.nombre_modulo', '=',DB::raw("'Inmueble'"));
                 $join->on('m.id_estado', '=', 'i.estado');
            })
            ->where("i.id","=",$id)
            ->select(DB::raw("i.direccion, i.numero, i.departamento,i.dormitorio,i.rol,i.bano,i.anio_antiguedad, i.bodega, i.nro_estacionamiento, i.referencia, i.estacionamiento, i.nro_bodega, i.edificio, i.nom_administrador, i.email_administrador, i.piscina, i.precio, i.gastoscomunes, c.comuna_nombre, m.nombre as estado"))
            ->first();

        $publica = DB::table('adm_contratofinal as co')
                ->leftjoin('borradores as cb', 'co.id_borrador', '=', 'cb.id')
                ->leftjoin('adm_contratodirpropietarios as cd', 'cd.id_contratofinal', '=', 'co.id')
                ->leftjoin('inmuebles as i', 'cd.id_inmueble', '=', 'i.id')
                ->leftjoin('comunas as o', 'i.id_comuna', '=', 'o.comuna_id')
                ->leftjoin('cap_publicaciones as c', 'c.id', '=', 'co.id_publicacion')
                ->leftjoin('personas as p1', 'c.id_propietario', '=', 'p1.id')
                ->leftjoin('users as p2', 'c.id_creador', '=', 'p2.id')
                ->leftjoin('users as p3', 'c.id_modificador', '=', 'p3.id')
         ->leftjoin('mensajes as m', function($join){
                 $join->on('m.nombre_modulo', '=',DB::raw("'Captación'"));
                 $join->on('m.id_estado', '=', 'c.id_estado');
            })
         ->where("i.id","=",$id)
                ->select(DB::raw('co.id, cb.dia_pago,c.id as id_publicacion, DATE_FORMAT(c.created_at, "%d/%m/%Y") as fecha_creacion, c.id_estado as id_estado, m.nombre as estado, CONCAT_WS(" ",p1.nombre,p1.apellido_paterno,p1.apellido_materno) as Propietario, p2.name as Creador                

                    '), 'p1.id as id_propietario', 'i.id as id_inmueble', 'i.direccion', 'i.numero', 'i.departamento', 'o.comuna_nombre', 'p1.nombre as nom_p', 'p1.apellido_paterno as apep_p', 'p1.apellido_materno as apem_p', 'p3.name as modifcador')
                ->get();

        
        $contratos=array();
        $captaciones=array();
        $propietarios=array();
        $itemsdepagos=array();
        $pagosmensuales=array();
        $solpv=array();
        foreach ($publica as $key) {

        $con = DB::table('adm_contratofinal as co')
                ->leftjoin('borradores as cb', 'co.id_borrador', '=', 'cb.id')
                ->leftjoin('adm_contratodirpropietarios as cd', 'cd.id_contratofinal', '=', 'co.id')
                ->leftjoin('inmuebles as i', 'cd.id_inmueble', '=', 'i.id')
                ->leftjoin('comunas as o', 'i.id_comuna', '=', 'o.comuna_id')
                ->leftjoin('cap_publicaciones as c', 'c.id', '=', 'co.id_publicacion')
                ->leftjoin('personas as p1', 'c.id_propietario', '=', 'p1.id')
                ->leftjoin('users as p2', 'c.id_creador', '=', 'p2.id')
                ->leftjoin('users as p3', 'c.id_modificador', '=', 'p3.id')
            ->leftjoin('mensajes as m', function($join){
                 $join->on('m.nombre_modulo', '=',DB::raw("'Captación'"));
                 $join->on('m.id_estado', '=', 'c.id_estado');
            })
                ->where('co.id',"=", $key->id)
                ->select(DB::raw('m.nombre as estado, cb.dia_pago,c.id as id_publicacion, DATE_FORMAT(c.created_at, "%d/%m/%Y") as fecha_creacion, co.fecha_firma, c.id_estado as id_estado, CONCAT_WS(" ",p1.nombre,p1.apellido_paterno,p1.apellido_materno) as Propietario, p2.name as Creador, p1.rut, p1.email, p1.telefono,

                (select pago_propietario from adm_pagosmensualespropietarios where mes=MONTH(DATE_ADD(now(), INTERVAL -18 MONTH)) and anio=YEAR(DATE_ADD(now(), INTERVAL -18 MONTH)) and id_publicacion=c.id and id_inmueble=i.id and id_contratofinal=co.id ) as valoranterior18,

                    (select sum(valor_pagado) from adm_detallepagospropietarios dt inner join adm_pagosmensualespropietarios pm on dt.id_pagomensual=pm.id where pm.mes=MONTH(DATE_ADD(now(), INTERVAL -18 MONTH)) and pm.anio=YEAR(DATE_ADD(now(), INTERVAL -18 MONTH)) and pm.id_publicacion=c.id and pm.id_inmueble=i.id and pm.id_contratofinal=co.id ) as valorpagadoanterior18,

                  (select pago_propietario from adm_pagosmensualespropietarios where mes=MONTH(DATE_ADD(now(), INTERVAL -17 MONTH)) and anio=YEAR(DATE_ADD(now(), INTERVAL -17 MONTH)) and id_publicacion=c.id and id_inmueble=i.id and id_contratofinal=co.id) as valoranterior17,

                    (select sum(valor_pagado) from adm_detallepagospropietarios dt inner join adm_pagosmensualespropietarios pm on dt.id_pagomensual=pm.id where pm.mes=MONTH(DATE_ADD(now(), INTERVAL -17 MONTH)) and pm.anio=YEAR(DATE_ADD(now(), INTERVAL -17 MONTH)) and pm.id_publicacion=c.id and pm.id_inmueble=i.id and pm.id_contratofinal=co.id) as valorpagadoanterior17,

                  (select pago_propietario from adm_pagosmensualespropietarios where mes=MONTH(DATE_ADD(now(), INTERVAL -16 MONTH)) and anio=YEAR(DATE_ADD(now(), INTERVAL -16 MONTH)) and id_publicacion=c.id and id_inmueble=i.id and id_contratofinal=co.id) as valoranterior16,

                    (select sum(valor_pagado) from adm_detallepagospropietarios dt inner join adm_pagosmensualespropietarios pm on dt.id_pagomensual=pm.id where pm.mes=MONTH(DATE_ADD(now(), INTERVAL -16 MONTH)) and pm.anio=YEAR(DATE_ADD(now(), INTERVAL -16 MONTH)) and pm.id_publicacion=c.id and pm.id_inmueble=i.id and pm.id_contratofinal=co.id) as valorpagadoanterior16,

                  (select pago_propietario from adm_pagosmensualespropietarios where mes=MONTH(DATE_ADD(now(), INTERVAL -15 MONTH)) and anio=YEAR(DATE_ADD(now(), INTERVAL -15 MONTH)) and id_publicacion=c.id and id_inmueble=i.id and id_contratofinal=co.id) as valoranterior15,

                    (select sum(valor_pagado) from adm_detallepagospropietarios dt inner join adm_pagosmensualespropietarios pm on dt.id_pagomensual=pm.id where pm.mes=MONTH(DATE_ADD(now(), INTERVAL -15 MONTH)) and pm.anio=YEAR(DATE_ADD(now(), INTERVAL -15 MONTH)) and pm.id_publicacion=c.id and pm.id_inmueble=i.id and pm.id_contratofinal=co.id) as valorpagadoanterior15,

                  (select pago_propietario from adm_pagosmensualespropietarios where mes=MONTH(DATE_ADD(now(), INTERVAL -14 MONTH)) and anio=YEAR(DATE_ADD(now(), INTERVAL -14 MONTH)) and id_publicacion=c.id and id_inmueble=i.id and id_contratofinal=co.id) as valoranterior14,

                    (select sum(valor_pagado) from adm_detallepagospropietarios dt inner join adm_pagosmensualespropietarios pm on dt.id_pagomensual=pm.id where pm.mes=MONTH(DATE_ADD(now(), INTERVAL -14 MONTH)) and pm.anio=YEAR(DATE_ADD(now(), INTERVAL -14 MONTH)) and pm.id_publicacion=c.id and pm.id_inmueble=i.id and pm.id_contratofinal=co.id) as valorpagadoanterior14,


                  (select pago_propietario from adm_pagosmensualespropietarios where mes=MONTH(DATE_ADD(now(), INTERVAL -13 MONTH)) and anio=YEAR(DATE_ADD(now(), INTERVAL -13 MONTH)) and id_publicacion=c.id and id_inmueble=i.id and id_contratofinal=co.id) as valoranterior13,

                    (select sum(valor_pagado) from adm_detallepagospropietarios dt inner join adm_pagosmensualespropietarios pm on dt.id_pagomensual=pm.id where pm.mes=MONTH(DATE_ADD(now(), INTERVAL -13 MONTH)) and pm.anio=YEAR(DATE_ADD(now(), INTERVAL -13 MONTH)) and pm.id_publicacion=c.id and pm.id_inmueble=i.id and pm.id_contratofinal=co.id) as valorpagadoanterior13,


(select pago_propietario from adm_pagosmensualespropietarios where mes=MONTH(DATE_ADD(now(), INTERVAL -12 MONTH)) and anio=YEAR(DATE_ADD(now(), INTERVAL -12 MONTH)) and id_publicacion=c.id and id_inmueble=i.id and id_contratofinal=co.id ) as valoranterior12,

                    (select sum(valor_pagado) from adm_detallepagospropietarios dt inner join adm_pagosmensualespropietarios pm on dt.id_pagomensual=pm.id where pm.mes=MONTH(DATE_ADD(now(), INTERVAL -12 MONTH)) and pm.anio=YEAR(DATE_ADD(now(), INTERVAL -12 MONTH)) and pm.id_publicacion=c.id and pm.id_inmueble=i.id and pm.id_contratofinal=co.id ) as valorpagadoanterior12,

                  (select pago_propietario from adm_pagosmensualespropietarios where mes=MONTH(DATE_ADD(now(), INTERVAL -11 MONTH)) and anio=YEAR(DATE_ADD(now(), INTERVAL -11 MONTH)) and id_publicacion=c.id and id_inmueble=i.id and id_contratofinal=co.id) as valoranterior11,

                    (select sum(valor_pagado) from adm_detallepagospropietarios dt inner join adm_pagosmensualespropietarios pm on dt.id_pagomensual=pm.id where pm.mes=MONTH(DATE_ADD(now(), INTERVAL -11 MONTH)) and pm.anio=YEAR(DATE_ADD(now(), INTERVAL -11 MONTH)) and pm.id_publicacion=c.id and pm.id_inmueble=i.id and pm.id_contratofinal=co.id) as valorpagadoanterior11,

                  (select pago_propietario from adm_pagosmensualespropietarios where mes=MONTH(DATE_ADD(now(), INTERVAL -10 MONTH)) and anio=YEAR(DATE_ADD(now(), INTERVAL -10 MONTH)) and id_publicacion=c.id and id_inmueble=i.id and id_contratofinal=co.id) as valoranterior10,

                    (select sum(valor_pagado) from adm_detallepagospropietarios dt inner join adm_pagosmensualespropietarios pm on dt.id_pagomensual=pm.id where pm.mes=MONTH(DATE_ADD(now(), INTERVAL -10 MONTH)) and pm.anio=YEAR(DATE_ADD(now(), INTERVAL -10 MONTH)) and pm.id_publicacion=c.id and pm.id_inmueble=i.id and pm.id_contratofinal=co.id) as valorpagadoanterior10,

                  (select pago_propietario from adm_pagosmensualespropietarios where mes=MONTH(DATE_ADD(now(), INTERVAL -9 MONTH)) and anio=YEAR(DATE_ADD(now(), INTERVAL -9 MONTH)) and id_publicacion=c.id and id_inmueble=i.id and id_contratofinal=co.id) as valoranterior9,

                    (select sum(valor_pagado) from adm_detallepagospropietarios dt inner join adm_pagosmensualespropietarios pm on dt.id_pagomensual=pm.id where pm.mes=MONTH(DATE_ADD(now(), INTERVAL -9 MONTH)) and pm.anio=YEAR(DATE_ADD(now(), INTERVAL -9 MONTH)) and pm.id_publicacion=c.id and pm.id_inmueble=i.id and pm.id_contratofinal=co.id) as valorpagadoanterior9,

                  (select pago_propietario from adm_pagosmensualespropietarios where mes=MONTH(DATE_ADD(now(), INTERVAL -8 MONTH)) and anio=YEAR(DATE_ADD(now(), INTERVAL -8 MONTH)) and id_publicacion=c.id and id_inmueble=i.id and id_contratofinal=co.id) as valoranterior8,

                    (select sum(valor_pagado) from adm_detallepagospropietarios dt inner join adm_pagosmensualespropietarios pm on dt.id_pagomensual=pm.id where pm.mes=MONTH(DATE_ADD(now(), INTERVAL -8 MONTH)) and pm.anio=YEAR(DATE_ADD(now(), INTERVAL -8 MONTH)) and pm.id_publicacion=c.id and pm.id_inmueble=i.id and pm.id_contratofinal=co.id) as valorpagadoanterior8,


                  (select pago_propietario from adm_pagosmensualespropietarios where mes=MONTH(DATE_ADD(now(), INTERVAL -7 MONTH)) and anio=YEAR(DATE_ADD(now(), INTERVAL -7 MONTH)) and id_publicacion=c.id and id_inmueble=i.id and id_contratofinal=co.id) as valoranterior7,

                    (select sum(valor_pagado) from adm_detallepagospropietarios dt inner join adm_pagosmensualespropietarios pm on dt.id_pagomensual=pm.id where pm.mes=MONTH(DATE_ADD(now(), INTERVAL -7 MONTH)) and pm.anio=YEAR(DATE_ADD(now(), INTERVAL -7 MONTH)) and pm.id_publicacion=c.id and pm.id_inmueble=i.id and pm.id_contratofinal=co.id) as valorpagadoanterior7,


                  (select pago_propietario from adm_pagosmensualespropietarios where mes=MONTH(DATE_ADD(now(), INTERVAL -6 MONTH)) and anio=YEAR(DATE_ADD(now(), INTERVAL -6 MONTH)) and id_publicacion=c.id and id_inmueble=i.id and id_contratofinal=co.id ) as valoranterior6,

                    (select sum(valor_pagado) from adm_detallepagospropietarios dt inner join adm_pagosmensualespropietarios pm on dt.id_pagomensual=pm.id where pm.mes=MONTH(DATE_ADD(now(), INTERVAL -6 MONTH)) and pm.anio=YEAR(DATE_ADD(now(), INTERVAL -6 MONTH)) and pm.id_publicacion=c.id and pm.id_inmueble=i.id and pm.id_contratofinal=co.id ) as valorpagadoanterior6,

                  (select pago_propietario from adm_pagosmensualespropietarios where mes=MONTH(DATE_ADD(now(), INTERVAL -5 MONTH)) and anio=YEAR(DATE_ADD(now(), INTERVAL -5 MONTH)) and id_publicacion=c.id and id_inmueble=i.id and id_contratofinal=co.id) as valoranterior5,

                    (select sum(valor_pagado) from adm_detallepagospropietarios dt inner join adm_pagosmensualespropietarios pm on dt.id_pagomensual=pm.id where pm.mes=MONTH(DATE_ADD(now(), INTERVAL -5 MONTH)) and pm.anio=YEAR(DATE_ADD(now(), INTERVAL -5 MONTH)) and pm.id_publicacion=c.id and pm.id_inmueble=i.id and pm.id_contratofinal=co.id) as valorpagadoanterior5,

                  (select pago_propietario from adm_pagosmensualespropietarios where mes=MONTH(DATE_ADD(now(), INTERVAL -4 MONTH)) and anio=YEAR(DATE_ADD(now(), INTERVAL -4 MONTH)) and id_publicacion=c.id and id_inmueble=i.id and id_contratofinal=co.id) as valoranterior4,

                    (select sum(valor_pagado) from adm_detallepagospropietarios dt inner join adm_pagosmensualespropietarios pm on dt.id_pagomensual=pm.id where pm.mes=MONTH(DATE_ADD(now(), INTERVAL -4 MONTH)) and pm.anio=YEAR(DATE_ADD(now(), INTERVAL -4 MONTH)) and pm.id_publicacion=c.id and pm.id_inmueble=i.id and pm.id_contratofinal=co.id) as valorpagadoanterior4,

                  (select pago_propietario from adm_pagosmensualespropietarios where mes=MONTH(DATE_ADD(now(), INTERVAL -3 MONTH)) and anio=YEAR(DATE_ADD(now(), INTERVAL -3 MONTH)) and id_publicacion=c.id and id_inmueble=i.id and id_contratofinal=co.id) as valoranterior3,

                    (select sum(valor_pagado) from adm_detallepagospropietarios dt inner join adm_pagosmensualespropietarios pm on dt.id_pagomensual=pm.id where pm.mes=MONTH(DATE_ADD(now(), INTERVAL -3 MONTH)) and pm.anio=YEAR(DATE_ADD(now(), INTERVAL -3 MONTH)) and pm.id_publicacion=c.id and pm.id_inmueble=i.id and pm.id_contratofinal=co.id) as valorpagadoanterior3,

                  (select pago_propietario from adm_pagosmensualespropietarios where mes=MONTH(DATE_ADD(now(), INTERVAL -2 MONTH)) and anio=YEAR(DATE_ADD(now(), INTERVAL -2 MONTH)) and id_publicacion=c.id and id_inmueble=i.id and id_contratofinal=co.id) as valoranterior2,

                    (select sum(valor_pagado) from adm_detallepagospropietarios dt inner join adm_pagosmensualespropietarios pm on dt.id_pagomensual=pm.id where pm.mes=MONTH(DATE_ADD(now(), INTERVAL -2 MONTH)) and pm.anio=YEAR(DATE_ADD(now(), INTERVAL -2 MONTH)) and pm.id_publicacion=c.id and pm.id_inmueble=i.id and pm.id_contratofinal=co.id) as valorpagadoanterior2,


                  (select pago_propietario from adm_pagosmensualespropietarios where mes=MONTH(DATE_ADD(now(), INTERVAL -1 MONTH)) and anio=YEAR(DATE_ADD(now(), INTERVAL -1 MONTH)) and id_publicacion=c.id and id_inmueble=i.id and id_contratofinal=co.id) as valoranterior1,

                    (select sum(valor_pagado) from adm_detallepagospropietarios dt inner join adm_pagosmensualespropietarios pm on dt.id_pagomensual=pm.id where pm.mes=MONTH(DATE_ADD(now(), INTERVAL -1 MONTH)) and pm.anio=YEAR(DATE_ADD(now(), INTERVAL -1 MONTH)) and pm.id_publicacion=c.id and pm.id_inmueble=i.id and pm.id_contratofinal=co.id) as valorpagadoanterior1,

                    
                    (select pago_propietario from adm_pagosmensualespropietarios where mes=MONTH(now()) and anio=YEAR(now()) and id_publicacion=c.id and id_inmueble=i.id and id_contratofinal=co.id) as valoractual,

                    (select sum(valor_pagado) from adm_detallepagospropietarios dt inner join adm_pagosmensualespropietarios pm on dt.id_pagomensual=pm.id where pm.mes=MONTH(now()) and pm.anio=YEAR(now()) and pm.id_publicacion=c.id and pm.id_inmueble=i.id and pm.id_contratofinal=co.id) as valorpagadoactual,


                      (select pago_propietario from adm_pagosmensualespropietarios where mes=MONTH(DATE_ADD(now(), INTERVAL 1 MONTH)) and anio=YEAR(DATE_ADD(now(), INTERVAL 1 MONTH)) and id_publicacion=c.id and id_inmueble=i.id and id_contratofinal=co.id) as valorsiguiente1,

                    (select sum(valor_pagado) from adm_detallepagospropietarios dt inner join adm_pagosmensualespropietarios pm on dt.id_pagomensual=pm.id where pm.mes=MONTH(DATE_ADD(now(), INTERVAL 1 MONTH)) and pm.anio=YEAR(DATE_ADD(now(), INTERVAL 1 MONTH)) and pm.id_publicacion=c.id and pm.id_inmueble=i.id and pm.id_contratofinal=co.id) as valorpagadosiguiente1,

                    (select pago_propietario from adm_pagosmensualespropietarios where mes=MONTH(DATE_ADD(now(), INTERVAL 2 MONTH)) and anio=YEAR(DATE_ADD(now(), INTERVAL 2 MONTH)) and id_publicacion=c.id and id_inmueble=i.id and id_contratofinal=co.id) as valorsiguiente2,

                    (select sum(valor_pagado) from adm_detallepagospropietarios dt inner join adm_pagosmensualespropietarios pm on dt.id_pagomensual=pm.id where pm.mes=MONTH(DATE_ADD(now(), INTERVAL 2 MONTH)) and pm.anio=YEAR(DATE_ADD(now(), INTERVAL 2 MONTH)) and pm.id_publicacion=c.id and pm.id_inmueble=i.id and pm.id_contratofinal=co.id) as valorpagadosiguiente2,

                     (select pago_propietario from adm_pagosmensualespropietarios where mes=MONTH(DATE_ADD(now(), INTERVAL 3 MONTH)) and anio=YEAR(DATE_ADD(now(), INTERVAL 3 MONTH)) and id_publicacion=c.id and id_inmueble=i.id and id_contratofinal=co.id) as valorsiguiente3,

                    (select sum(valor_pagado) from adm_detallepagospropietarios dt inner join adm_pagosmensualespropietarios pm on dt.id_pagomensual=pm.id where pm.mes=MONTH(DATE_ADD(now(), INTERVAL 3 MONTH)) and pm.anio=YEAR(DATE_ADD(now(), INTERVAL 3 MONTH)) and pm.id_publicacion=c.id and pm.id_inmueble=i.id and pm.id_contratofinal=co.id) as valorpagadosiguiente3,

                     (select pago_propietario from adm_pagosmensualespropietarios where mes=MONTH(DATE_ADD(now(), INTERVAL 4 MONTH)) and anio=YEAR(DATE_ADD(now(), INTERVAL 4 MONTH)) and id_publicacion=c.id and id_inmueble=i.id and id_contratofinal=co.id) as valorsiguiente4,

                    (select sum(valor_pagado) from adm_detallepagospropietarios dt inner join adm_pagosmensualespropietarios pm on dt.id_pagomensual=pm.id where pm.mes=MONTH(DATE_ADD(now(), INTERVAL 4 MONTH)) and pm.anio=YEAR(DATE_ADD(now(), INTERVAL 4 MONTH)) and pm.id_publicacion=c.id and pm.id_inmueble=i.id and pm.id_contratofinal=co.id) as valorpagadosiguiente4,

                    (select pago_propietario from adm_pagosmensualespropietarios where mes=MONTH(DATE_ADD(now(), INTERVAL 5 MONTH)) and anio=YEAR(DATE_ADD(now(), INTERVAL 5 MONTH)) and id_publicacion=c.id and id_inmueble=i.id and id_contratofinal=co.id ) as valorsiguiente5,

                    (select sum(valor_pagado) from adm_detallepagospropietarios dt inner join adm_pagosmensualespropietarios pm on dt.id_pagomensual=pm.id where pm.mes=MONTH(DATE_ADD(now(), INTERVAL 5 MONTH)) and pm.anio=YEAR(DATE_ADD(now(), INTERVAL 5 MONTH)) and pm.id_publicacion=c.id and pm.id_inmueble=i.id and pm.id_contratofinal=co.id) as valorpagadosiguiente5,

                     (select pago_propietario from adm_pagosmensualespropietarios where mes=MONTH(DATE_ADD(now(), INTERVAL 6 MONTH)) and anio=YEAR(DATE_ADD(now(), INTERVAL 6 MONTH)) and id_publicacion=c.id and id_inmueble=i.id and id_contratofinal=co.id) as valorsiguiente6,

                    (select sum(valor_pagado) from adm_detallepagospropietarios dt inner join adm_pagosmensualespropietarios pm on dt.id_pagomensual=pm.id where pm.mes=MONTH(DATE_ADD(now(), INTERVAL 6 MONTH)) and pm.anio=YEAR(DATE_ADD(now(), INTERVAL 6 MONTH)) and pm.id_publicacion=c.id and pm.id_inmueble=i.id and pm.id_contratofinal=co.id) as valorpagadosiguiente6,

                    (select pago_propietario from adm_pagosmensualespropietarios where mes=MONTH(DATE_ADD(now(), INTERVAL 7 MONTH)) and anio=YEAR(DATE_ADD(now(), INTERVAL 7 MONTH)) and id_publicacion=c.id and id_inmueble=i.id and id_contratofinal=co.id) as valorsiguiente7,

                    (select sum(valor_pagado) from adm_detallepagospropietarios dt inner join adm_pagosmensualespropietarios pm on dt.id_pagomensual=pm.id where pm.mes=MONTH(DATE_ADD(now(), INTERVAL 7 MONTH)) and pm.anio=YEAR(DATE_ADD(now(), INTERVAL 7 MONTH)) and pm.id_publicacion=c.id and pm.id_inmueble=i.id and pm.id_contratofinal=co.id) as valorpagadosiguiente7,

                    (select pago_propietario from adm_pagosmensualespropietarios where mes=MONTH(DATE_ADD(now(), INTERVAL 8 MONTH)) and anio=YEAR(DATE_ADD(now(), INTERVAL 8 MONTH)) and id_publicacion=c.id and id_inmueble=i.id and id_contratofinal=co.id) as valorsiguiente8,

                    (select sum(valor_pagado) from adm_detallepagospropietarios dt inner join adm_pagosmensualespropietarios pm on dt.id_pagomensual=pm.id where pm.mes=MONTH(DATE_ADD(now(), INTERVAL 8 MONTH)) and pm.anio=YEAR(DATE_ADD(now(), INTERVAL 8 MONTH)) and pm.id_publicacion=c.id and pm.id_inmueble=i.id and pm.id_contratofinal=co.id) as valorpagadosiguiente8,

                     (select pago_propietario from adm_pagosmensualespropietarios where mes=MONTH(DATE_ADD(now(), INTERVAL 9 MONTH)) and anio=YEAR(DATE_ADD(now(), INTERVAL 9 MONTH)) and id_publicacion=c.id and id_inmueble=i.id and id_contratofinal=co.id) as valorsiguiente9,

                    (select sum(valor_pagado) from adm_detallepagospropietarios dt inner join adm_pagosmensualespropietarios pm on dt.id_pagomensual=pm.id where pm.mes=MONTH(DATE_ADD(now(), INTERVAL 9 MONTH)) and pm.anio=YEAR(DATE_ADD(now(), INTERVAL 9 MONTH)) and pm.id_publicacion=c.id and pm.id_inmueble=i.id and pm.id_contratofinal=co.id) as valorpagadosiguiente9,

                     (select pago_propietario from adm_pagosmensualespropietarios where mes=MONTH(DATE_ADD(now(), INTERVAL 10 MONTH)) and anio=YEAR(DATE_ADD(now(), INTERVAL 10 MONTH)) and id_publicacion=c.id and id_inmueble=i.id and id_contratofinal=co.id) as valorsiguiente10,

                    (select sum(valor_pagado) from adm_detallepagospropietarios dt inner join adm_pagosmensualespropietarios pm on dt.id_pagomensual=pm.id where pm.mes=MONTH(DATE_ADD(now(), INTERVAL 10 MONTH)) and pm.anio=YEAR(DATE_ADD(now(), INTERVAL 10 MONTH)) and pm.id_publicacion=c.id and pm.id_inmueble=i.id and pm.id_contratofinal=co.id) as valorpagadosiguiente10,

                    (select pago_propietario from adm_pagosmensualespropietarios where mes=MONTH(DATE_ADD(now(), INTERVAL 11 MONTH)) and anio=YEAR(DATE_ADD(now(), INTERVAL 11 MONTH)) and id_publicacion=c.id and id_inmueble=i.id and id_contratofinal=co.id ) as valorsiguiente11,

                    (select sum(valor_pagado) from adm_detallepagospropietarios dt inner join adm_pagosmensualespropietarios pm on dt.id_pagomensual=pm.id where pm.mes=MONTH(DATE_ADD(now(), INTERVAL 11 MONTH)) and pm.anio=YEAR(DATE_ADD(now(), INTERVAL 11 MONTH)) and pm.id_publicacion=c.id and pm.id_inmueble=i.id and pm.id_contratofinal=co.id) as valorpagadosiguiente11,

                     (select pago_propietario from adm_pagosmensualespropietarios where mes=MONTH(DATE_ADD(now(), INTERVAL 12 MONTH)) and anio=YEAR(DATE_ADD(now(), INTERVAL 12 MONTH)) and id_publicacion=c.id and id_inmueble=i.id and id_contratofinal=co.id) as valorsiguiente12,

                    (select sum(valor_pagado) from adm_detallepagospropietarios dt inner join adm_pagosmensualespropietarios pm on dt.id_pagomensual=pm.id where pm.mes=MONTH(DATE_ADD(now(), INTERVAL 12 MONTH)) and pm.anio=YEAR(DATE_ADD(now(), INTERVAL 12 MONTH)) and pm.id_publicacion=c.id and pm.id_inmueble=i.id and pm.id_contratofinal=co.id) as valorpagadosiguiente12,

                    (select pago_propietario from adm_pagosmensualespropietarios where mes=MONTH(DATE_ADD(now(), INTERVAL 13 MONTH)) and anio=YEAR(DATE_ADD(now(), INTERVAL 13 MONTH)) and id_publicacion=c.id and id_inmueble=i.id and id_contratofinal=co.id) as valorsiguiente13,

                    (select sum(valor_pagado) from adm_detallepagospropietarios dt inner join adm_pagosmensualespropietarios pm on dt.id_pagomensual=pm.id where pm.mes=MONTH(DATE_ADD(now(), INTERVAL 13 MONTH)) and pm.anio=YEAR(DATE_ADD(now(), INTERVAL 13 MONTH)) and pm.id_publicacion=c.id and pm.id_inmueble=i.id and pm.id_contratofinal=co.id) as valorpagadosiguiente13,

                    (select pago_propietario from adm_pagosmensualespropietarios where mes=MONTH(DATE_ADD(now(), INTERVAL 14 MONTH)) and anio=YEAR(DATE_ADD(now(), INTERVAL 14 MONTH)) and id_publicacion=c.id and id_inmueble=i.id and id_contratofinal=co.id) as valorsiguiente14,

                    (select sum(valor_pagado) from adm_detallepagospropietarios dt inner join adm_pagosmensualespropietarios pm on dt.id_pagomensual=pm.id where pm.mes=MONTH(DATE_ADD(now(), INTERVAL 14 MONTH)) and pm.anio=YEAR(DATE_ADD(now(), INTERVAL 14 MONTH)) and pm.id_publicacion=c.id and pm.id_inmueble=i.id and pm.id_contratofinal=co.id) as valorpagadosiguiente14,

                     (select pago_propietario from adm_pagosmensualespropietarios where mes=MONTH(DATE_ADD(now(), INTERVAL 15 MONTH)) and anio=YEAR(DATE_ADD(now(), INTERVAL 15 MONTH)) and id_publicacion=c.id and id_inmueble=i.id and id_contratofinal=co.id) as valorsiguiente15,

                    (select sum(valor_pagado) from adm_detallepagospropietarios dt inner join adm_pagosmensualespropietarios pm on dt.id_pagomensual=pm.id where pm.mes=MONTH(DATE_ADD(now(), INTERVAL 15 MONTH)) and pm.anio=YEAR(DATE_ADD(now(), INTERVAL 15 MONTH)) and pm.id_publicacion=c.id and pm.id_inmueble=i.id and pm.id_contratofinal=co.id) as valorpagadosiguiente15,

                     (select pago_propietario from adm_pagosmensualespropietarios where mes=MONTH(DATE_ADD(now(), INTERVAL 16 MONTH)) and anio=YEAR(DATE_ADD(now(), INTERVAL 16 MONTH)) and id_publicacion=c.id and id_inmueble=i.id and id_contratofinal=co.id) as valorsiguiente16,

                    (select sum(valor_pagado) from adm_detallepagospropietarios dt inner join adm_pagosmensualespropietarios pm on dt.id_pagomensual=pm.id where pm.mes=MONTH(DATE_ADD(now(), INTERVAL 16 MONTH)) and pm.anio=YEAR(DATE_ADD(now(), INTERVAL 16 MONTH)) and pm.id_publicacion=c.id and pm.id_inmueble=i.id and pm.id_contratofinal=co.id) as valorpagadosiguiente16,

                    (select pago_propietario from adm_pagosmensualespropietarios where mes=MONTH(DATE_ADD(now(), INTERVAL 17 MONTH)) and anio=YEAR(DATE_ADD(now(), INTERVAL 17 MONTH)) and id_publicacion=c.id and id_inmueble=i.id and id_contratofinal=co.id ) as valorsiguiente17,

                    (select sum(valor_pagado) from adm_detallepagospropietarios dt inner join adm_pagosmensualespropietarios pm on dt.id_pagomensual=pm.id where pm.mes=MONTH(DATE_ADD(now(), INTERVAL 17 MONTH)) and pm.anio=YEAR(DATE_ADD(now(), INTERVAL 17 MONTH)) and pm.id_publicacion=c.id and pm.id_inmueble=i.id and pm.id_contratofinal=co.id) as valorpagadosiguiente17,

                     (select pago_propietario from adm_pagosmensualespropietarios where mes=MONTH(DATE_ADD(now(), INTERVAL 18 MONTH)) and anio=YEAR(DATE_ADD(now(), INTERVAL 18 MONTH)) and id_publicacion=c.id and id_inmueble=i.id and id_contratofinal=co.id) as valorsiguiente18,

                    (select sum(valor_pagado) from adm_detallepagospropietarios dt inner join adm_pagosmensualespropietarios pm on dt.id_pagomensual=pm.id where pm.mes=MONTH(DATE_ADD(now(), INTERVAL 18 MONTH)) and pm.anio=YEAR(DATE_ADD(now(), INTERVAL 18 MONTH)) and pm.id_publicacion=c.id and pm.id_inmueble=i.id and pm.id_contratofinal=co.id) as valorpagadosiguiente18

                    '), 'p1.id as id_propietario', 'i.id as id_inmueble', 'i.direccion', 'i.numero', 'i.departamento', 'o.comuna_nombre', 'p1.nombre as nom_p', 'p1.apellido_paterno as apep_p', 'p1.apellido_materno as apem_p', 'p3.name as modifcador')
                ->first();
                $fecha_firma=$con->fecha_firma;
              $cap = DB::table('cap_publicaciones as c')
                ->leftjoin('personas as p1', 'c.id_propietario', '=', 'p1.id')
                ->leftjoin('inmuebles as i', 'c.id_inmueble', '=', 'i.id')
                ->leftjoin('users as p2', 'c.id_creador', '=', 'p2.id')
                ->leftjoin('personas as p3', 'c.id_modificador', '=', 'p3.id')
                ->leftjoin('personas as p4', 'c.id_corredor', '=', 'p4.id')
                ->leftjoin('comunas as o', 'i.id_comuna', '=', 'o.comuna_id')
                ->leftjoin('portales as po', 'c.portal', '=', 'po.id')
               ->leftjoin('mensajes as m', function($join){
                 $join->on('m.nombre_modulo', '=',DB::raw("'Captación'"));
                 $join->on('m.id_estado', '=', 'c.id_estado');
            })
               ->where('c.id','=',$key->id_publicacion)
                ->select(DB::raw('c.id as id_publicacion, DATE_FORMAT(c.created_at, "%d/%m/%Y %T") as fecha_creacion,DATE_FORMAT(c.updated_at, "%d/%m/%Y") as fecha_modificacion, m.nombre as id_estado, CONCAT_WS(" ",p1.nombre,p1.apellido_paterno,p1.apellido_materno) as Propietario, CONCAT_WS(" ",p4.nombre,p4.apellido_paterno,p4.apellido_materno) as Externo,
                    CONCAT_WS(" ",i.direccion,i.numero," Dpto ",i.departamento) as Direccion,
                    (select tipo_contacto from cap_gestion where id_captacion_gestion=c.id order by created_at asc limit 1) as tipo_contacto, (select (select name from users where id=id_creador_gestion limit 1)  from cap_gestion where id_captacion_gestion=c.id order by created_at asc limit 1) as creador_gestion, 
         c.tipo, p2.name as Creador, CONCAT_WS(" ",p3.nombre,p3.apellido_paterno,p3.apellido_materno) as Modificador,p1.email,p1.telefono,c.fecha_publicacion, c.url, c.codigo_publicacion '), 'i.id as id_inmueble', 'o.comuna_nombre', 'po.nombre as portal', 'p1.nombre as nom_p', 'p1.apellido_paterno as apep_p', 'p1.apellido_materno as apem_p', 'p3.nombre as nom_m', 'p3.apellido_paterno as apep_m', 'p3.apellido_materno as apem_m')
                ->orderBy("c.id","Desc")
                ->first();


            $pro = DB::table('personas as p')
            ->leftjoin('comunas as c', 'p.id_comuna', '=', 'c.comuna_id')
            ->Where('p.id','=',$key->id_propietario)
            ->leftjoin('mensajes as m', function($join){
                     $join->on('m.nombre_modulo', '=',DB::raw("'Vigencia'"));
                     $join->on('m.id_estado', '=', 'p.id_estado');
                })
                ->select(DB::raw("p.id,p.nombre,p.apellido_paterno,p.apellido_materno, m.nombre as estado, p.direccion, p.numero, p.profesion, p.estado_civil, p.estado_civil, p.departamento, p.telefono, p.email, p.banco, p.tipo_cuenta, p.cuenta, p.titular, p.rut_titular, p.rut, c.comuna_nombre"))
                ->first();
    
            $pmp=PagosMensualesPropietarios::where("id_contratofinal","=",$key->id)->get();
            $pp=PagosPropietarios::where("id_contratofinal","=",$key->id)->get();
            $dpp=DB::table('adm_detallepagospropietarios as dp')
            ->join("adm_pagosmensualespropietarios as pm","pm.id","dp.id_pagomensual")
            ->where("pm.id_contratofinal","=",$key->id)
            ->where("dp.id_publicacion","=",$key->id_publicacion)
            ->where("pm.id_inmueble","=",$key->id_inmueble)
            ->select(DB::raw('pm.mes, pm.anio, sum(dp.valor_pagado) as valor_pagado'))
            ->groupby("pm.mes","pm.anio")
            ->get();
            $pv=DB::table('post_venta as s')
            ->where("id_inmueble","=",$key->id_inmueble)
            ->get();



         array_push($contratos, $con);
         array_push($captaciones, $cap);
         array_push($propietarios, $pro);
         array_push($itemsdepagos, $pp);
         array_push($pagosmensuales, $dpp);   
         array_push($solpv, $pv);  
        }



        return Excel::create('Historial Dirección', function ($excel) use ($inmueble, $propietarios,$captaciones, $contratos, $itemsdepagos, $pagosmensuales, $solpv, $meses, $fecha_firma) {
                        $excel->sheet('Datos Inmueble', function ($sheet) use ($inmueble) {
                            $sheet->loadView('formatosexcel.historia_propietario.hoja1_inmueble', compact('inmueble'));
                            
                        });
                        $excel->sheet('Propietarios', function ($sheet) use ($propietarios) {
                            $sheet->loadView('formatosexcel.historia_propietario.hoja2_propietarios', compact('propietarios'));
                        });
                       $excel->sheet('Captaciones', function ($sheet) use ($captaciones) {
                            $sheet->loadView('formatosexcel.historia_propietario.hoja3_captaciones', compact('captaciones'));
                        });
                        $excel->sheet('Contratos', function ($sheet) use ($contratos,$meses) {
                            $sheet->loadView('formatosexcel.historia_propietario.hoja4_contratos', compact('contratos','meses'));
                        });
                        $excel->sheet('Items de Pagos', function ($sheet) use ($itemsdepagos, $fecha_firma, $pagosmensuales) {
                            $sheet->loadView('formatosexcel.historia_propietario.hoja5_items', compact('itemsdepagos','fecha_firma','pagosmensuales'));
                        });
                        $excel->sheet('Post Atención', function ($sheet) use ($solpv) {
                            $sheet->loadView('formatosexcel.historia_propietario.hoja7_post', compact('solpv'));
                        });
                    })->download('xlsx');
     }

}
