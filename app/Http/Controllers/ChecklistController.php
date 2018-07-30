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

class ChecklistController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $publica = DB::table('inmuebles as i')
         ->leftjoin('comunas as co', 'i.id_comuna', '=', 'co.comuna_id')
         ->leftjoin('chkinmuebles as chk', 'i.id', '=', 'chk.id_inmueble')
         ->select(DB::raw('i.id , i.direccion,i.numero,co.comuna_nombre as comuna,chk.id_estado'))
         ->get();

        return view('checklist.index',compact('publica'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $ListadoCheckList = DB::table('checklist')
        ->Where('checklist.estado','=',1)
        ->get();

        $inmueble = DB::table('inmuebles as i')
         ->leftjoin('comunas as co', 'i.id_comuna', '=', 'co.comuna_id')
         ->where('i.id','=', $id)
         ->select(DB::raw('i.id , i.direccion,i.numero,co.comuna_nombre as comuna'))
         ->first();

        $Checklist = DB::table('chkinmuebles')
        ->Where('id_inmueble','=',$id)
        ->count();         

        if($Checklist < 1)
        {
            $checklist  = Checklist::create([                      
                        'id_inmueble'       => $id,
                        'id_creador'        => Auth::user()->id_persona,
                        'id_modificador'    => Auth::user()->id_persona,
                        'id_estado'         => '1',
            ]);
        }
        
        return view('checklist.check',compact('ListadoCheckList','inmueble'));   
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
    public function show($id)
    {
        $foto = DB::table('chkinmueblefoto as f')
         ->leftjoin('checklist as c', 'f.id_item', '=', 'c.id')
         ->select(DB::raw('f.id, f.descripcion, f.nombre, f.ruta, c.nombre as tipo'))
         ->where('f.id_inmueble','=',$id)
         ->where('c.estado','=',1)
         ->get();


        $inmueble = DB::table('inmuebles as i')
         ->leftjoin('comunas as co', 'i.id_comuna', '=', 'co.comuna_id')
         ->where('i.id','=', $id)
         ->select(DB::raw('i.id , i.direccion,i.numero,co.comuna_nombre as comuna'))
         ->first();



        return view('checklist.show',compact('foto','inmueble'));
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

         $checklist = Checklist::where('id_inmueble','=',$id)->first();

         $imgReserva = ChkInmuebleFoto::where('id_inmueble','=',$id)->where('id_item','=',$tipo)->get();

         $NombreCheck = DB::table('checklist')
        ->Where('checklist.id','=',$tipo)
        ->first();

         return view('checklist.edit',compact('inmueble','checklist','imgReserva','tipo','NombreCheck'));

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
                   'descripcion'          => $request->descripcion,
                   'id_inmueble'          => $id,
                   'nombre'               => $archivo,
                   'ruta'                 => $path,
                   'id_item'              => $request->id_tipo,
                   'id_creador'           => $request->id_creador
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


}

