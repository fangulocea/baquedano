<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\User;
use App\Persona;
use App\ContratoFinal;
use App\PagosPropietarios;

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

        $pagos_actual = PagosPropietarios::pagomensual($ids,date("m"),date("Y"));

        return view('interfaz_propietario.home_propietario',compact('contratos','_persona','pagos_actual'));
     }

    public function home_arrendatario()
    {
        return view('interfaz_arrendatario.home_arrendatario');
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
