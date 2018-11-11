<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\User;
use App\Persona;
use App\ContratoFinal;
use App\ContratoFinalArr;
use App\PagosPropietarios;
use App\PagosArrendatarios;
use DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->roles[0]->name=='Propietario'){
            return redirect('/login_propietario');
        }

        if(Auth::user()->roles[0]->name=='Arrendatario'){
            return redirect('/login_arrendatario');
        }
        return view('home');
     }

    public function home_propietario()
    {
      
        $user = User::find(Auth::id());
        $id_persona=$user->id_persona;
        $_persona=Persona::find($id_persona);
        $contratos=ContratoFinal::contratos_activos_propietarios($id_persona);
        $idcontratos=ContratoFinal::id_contratos($id_persona);
        
        
        $ids=[];
        foreach ($idcontratos as $k) {
            array_push($ids, $k->id);
        }


         $publica = DB::table('chkinmuebles as chk')
         ->leftjoin('inmuebles as i', 'chk.id_inmueble', '=', 'i.id')
         ->leftjoin('comunas as co', 'i.id_comuna', '=', 'co.comuna_id')
        ->leftjoin('mensajes as m', function($join){
                 $join->on('m.nombre_modulo', '=',DB::raw("'Checkin'"));
                 $join->on('m.id_estado', '=', 'chk.id_estado');
            })
         ->where('chk.tipo','=','Propietario')
         ->whereIn('chk.id_contrato',$ids)
         ->select(DB::raw('chk.id, i.direccion, i.numero, co.comuna_nombre as comuna, i.departamento, m.nombre as estado,
                           chk.id_estado, chk.tipo, chk.id_bor_arr, chk.id_cap_pro, chk.created_at, chk.fecha_limite , chk.id_contrato, chk.e_s_r'))
         ->orderBy('chk.id_contrato')
         ->get();

        $pagos_actual = PagosPropietarios::pagomensual($ids,date("m"),date("Y"));

        return view('interfaz_propietario.home_propietario',compact('contratos','_persona','pagos_actual','publica'));
     }

  public function home_arrendatario()
    {
      
        $user = User::find(Auth::id());
        $id_persona=$user->id_persona;
        $_persona=Persona::find($id_persona);
        $contratos=ContratoFinalArr::contratos_activos_arrendatario($id_persona);
        $idcontratos=ContratoFinalArr::id_contratos($id_persona);
        
        
        $ids=[];
        foreach ($idcontratos as $k) {
            array_push($ids, $k->id);
        }


         $publica = DB::table('chkinmuebles as chk')
         ->leftjoin('inmuebles as i', 'chk.id_inmueble', '=', 'i.id')
         ->leftjoin('comunas as co', 'i.id_comuna', '=', 'co.comuna_id')
        ->leftjoin('mensajes as m', function($join){
                 $join->on('m.nombre_modulo', '=',DB::raw("'Checkin'"));
                 $join->on('m.id_estado', '=', 'chk.id_estado');
            })
         ->where('chk.tipo','=','Arrendatario')
         ->whereIn('chk.id_contrato',$ids)
         ->select(DB::raw('chk.id, i.direccion, i.numero, co.comuna_nombre as comuna, i.departamento, m.nombre as estado,
                           chk.id_estado, chk.tipo, chk.id_bor_arr, chk.id_cap_pro, chk.created_at, chk.fecha_limite , chk.id_contrato, chk.e_s_r'))
         ->orderBy('chk.id_contrato')
         ->get();

        $pagos_actual = PagosArrendatarios::pagomensual($ids,date("m"),date("Y"));

        return view('interfaz_arrendatario.home_arrendatario',compact('contratos','_persona','pagos_actual','publica'));
     }

        public function login()
    {
        return view('auth.login');
    }


        public function login_propietario()
    {
        return view('auth.login_propietario');
    }

    public function login_arrendatario()
    {
        return view('auth.login_propietario');
    }
}
