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
    

    public function ArriendosDisponibles()
    {
        $ArrDisp = DB::table('inmuebles as i')
         ->leftjoin('comunas as co', 'i.id_comuna', '=', 'co.comuna_id')
         ->select(DB::raw('i.*, co.comuna_nombre as comuna'))
         ->Where('i.estado','=',1)
         ->orderBy('i.id')
         ->get();

        return view('reportes.arriendosdisponibles',compact('ArrDisp'));

    }





}
