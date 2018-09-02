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

        $estados=Mensajes::where('nombre_modulo','=','Captación')->get();

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

        return Excel::create('Captaciones '.$request->fechainicio.' '.$request->fechafin, function ($excel) use ($reporte) {
                        $excel->sheet('Reporte', function ($sheet) use ($reporte) {
                            $sheet->loadView('formatosexcel.reporte_captaciones', compact('reporte'));
                        });
                    })->download('xlsx');
     }



}
