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
        return view('reportesfinales.index');
    }



}
