<?php

namespace App\Http\Controllers;

use App\Checklist;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use App\Region;
use App\Inmueble;
use App\ChkInmuebleFoto;
use Image;
use Auth;
use File;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade as PDF;

class ChecklistController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $publica = DB::table('chkinmuebles as chk')
         ->leftjoin('inmuebles as i', 'chk.id_inmueble', '=', 'i.id')
         ->leftjoin('comunas as co', 'i.id_comuna', '=', 'co.comuna_id')
         ->select(DB::raw('chk.id, i.direccion, i.numero, co.comuna_nombre as comuna, 
                           chk.id_estado, chk.tipo, chk.id_bor_arr, chk.id_cap_pro, chk.created_at,chk.fecha_limite '))
         ->get();


        return view('checklist.index',compact('publica'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id,$tipo)
    {
        $ListadoCheckList = DB::table('checklist')
        ->Where('checklist.estado','=',1)
        ->get();

        $vacio = "<!DOCTYPE html>  
                        <html><head></head><body>
                        <p><strong>CheckList</strong></p><ol>
                        <li><strong>Cocina</strong><ul>
                        <li>Item 1</li><li>Item 2</li>
                        </ul></li>
                        <li>Ba&ntilde;o<ul>
                        <li>Item 1</li><li>Item 2</li>
                        </ul></li></ol></body></html>";


        $Checklist = DB::table('chkinmuebles')
        ->Where('id','=',$id)
        ->first();  

        $inmueble = DB::table('inmuebles as i')
         ->leftjoin('comunas as co', 'i.id_comuna', '=', 'co.comuna_id')
         ->where('i.id','=', $Checklist->id_inmueble)
         ->select(DB::raw('i.id , i.direccion,i.numero,co.comuna_nombre as comuna'))
         ->first();

       

        $imgReserva = ChkInmuebleFoto::where('id_chk','=',$id)->get();

        
        return view('checklist.check',compact('ListadoCheckList','inmueble','imgReserva','tipo','Checklist','vacio'));   
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Checklist  $checklist
     * @return \Illuminate\Http\Response
     */
    public function show($id,$tipo)
    {
        $year_now = date ("Y");  
        $month_now = date ("n"); 

        $ChkInmueble = DB::table('chkinmuebles as c')
        ->leftjoin('inmuebles as i', 'c.id_inmueble', '=', 'i.id')
        ->leftjoin('comunas as co', 'i.id_comuna', '=', 'co.comuna_id')
        ->where('c.id', '=', $id)
        ->select(DB::raw('c.id as id_chk, i.direccion, i.numero, co.comuna_nombre as comuna, c.descripcion'))
        ->first();


        $foto = DB::table('chkinmueblefoto as f')
         ->where('f.id_chk', '=', $ChkInmueble->id_chk)
         ->select(DB::raw('f.id, f.ruta, f.nombre'))
         ->get();

        if($tipo == 'Arrendatario')
        {

            $persona = DB::table('chkinmuebles as c')
                ->leftjoin('arrendatarios as a', 'c.id_bor_arr', '=', 'a.id')
                ->leftjoin('personas as p', 'a.id_arrendatario', '=', 'p.id')
                ->where('c.id', '=', $id)
                ->select(DB::raw('p.nombre, p.apellido_paterno, p.telefono, p.email'))
                ->first();

            $pdf = PDF::loadView('formatospdf.checklistarrendatario', compact('ChkInmueble', 'foto','persona'));
            return $pdf->download($ChkInmueble->direccion . ' Nro.' . $ChkInmueble->numero . ' Comuna.' . $ChkInmueble->comuna . ' - ' . $month_now . '-' . $year_now . ' - CheckList Propietario.pdf');
        }
        else
        {
            
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Checklist  $checklist
     * @return \Illuminate\Http\Response
     */
    public function edit($id,$tipo)
    {
        //$inmueble = Inmueble::find($id);
        $inmueble = DB::table('inmuebles as i')
         ->leftjoin('comunas as co', 'i.id_comuna', '=', 'co.comuna_id')
         ->where('i.id','=', $id)
         ->select(DB::raw('i.id , i.direccion,i.numero,co.comuna_nombre as comuna'))
         ->first();

         $Checklist = DB::table('chkinmuebles')
        ->Where('id_inmueble','=',$id)
        ->first();  

         $imgReserva = ChkInmuebleFoto::where('id_inmueble','=',$id)->where('tipo','=',$tipo)->get();

         $NombreCheck = DB::table('checklist')
        ->Where('checklist.id','=',$tipo)
        ->first();

         return view('checklist.check',compact('inmueble','Checklist','imgReserva','tipo','NombreCheck'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Checklist  $checklist
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Checklist $checklist)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Checklist  $checklist
     * @return \Illuminate\Http\Response
     */
    public function destroy(Checklist $checklist)
    {
        //
    }

    public function savefotos(Request $request, $id){

        $checklist = DB::table('chkinmuebles')
        ->Where('chkinmuebles.id_inmueble','=',$id)
        ->first();

        if(isset($request->foto))
        {
            $path='uploads/checklist';
            $archivo=rand().$request->foto->getClientOriginalName();
            $img = Image::make($_FILES['foto']['tmp_name'])->resize(600,400, function ($constraint){ 
                $constraint->aspectRatio();
            });
            $img->save($path.'/'.$archivo,72);
            $imagen=ChkInmuebleFoto::create([
                   'id_chk'               => $checklist->id,
                   'id_inmueble'          => $id,
                   'nombre'               => $archivo,
                   'ruta'                 => $path,
                   'tipo'                   => $request->id_tipo,
                   'id_creador'           => $request->id_creador
            ]);

            Checklist::where('id', '=', $checklist->id)->update([
                        'descripcion'     => $request->descripcion
                    ]);

        }
        else
        { return redirect()->route('checklist.edit', [$id,$request->id_tipo])->with('status', 'No se ha actualizado ninguna imágen'); }
        
        return redirect()->route('checklist.edit', [$id,$request->id_tipo])->with('status', 'Foto guardada con éxito');
    }

public function eliminararchivo($idf,$idi,$idt){
        $imagen=ChkInmuebleFoto::find($idf);

        File::delete($imagen->ruta.'/'.$imagen->nombre);
        $foto = ChkInmuebleFoto::find($idf)->delete();

        return redirect()->route('checklist.edit', [$idi,$idt])->with('status', 'Foto eliminada con éxito');
    }

    
static function cantDias($fecha1,$fecha2){

        $fecha1 = Carbon::parse($fecha1);
        $fecha2 = Carbon::parse($fecha2);
        $res = $fecha2->diffInDays($fecha1);
        return $res;
    }

static function contrato($id_arr,$id_pro,$tipo){

        if($tipo == 'Arrendatario')
        {
            $resultado = 'Arrendatario';
        }
        elseif($tipo == 'Propietario')
        {
            $resultado = 'Propietario';
        }
        else
        {
            $resultado = 'Sin Contrato';
        }

        return $resultado;
    }

}

