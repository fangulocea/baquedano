<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

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
        return view('interfaz_propietario.home_propietario');
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
