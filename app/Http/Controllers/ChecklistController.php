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
        $publica = DB::table('chkinmuebles as chk')
         ->leftjoin('inmuebles as i', 'chk.id_inmueble', '=', 'i.id')
         ->leftjoin('comunas as co', 'i.id_comuna', '=', 'co.comuna_id')
         ->select(DB::raw('i.id , i.direccion,i.numero,co.comuna_nombre as comuna,chk.id_estado,chk.tipo'))
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


        $inmueble = DB::table('inmuebles as i')
         ->leftjoin('comunas as co', 'i.id_comuna', '=', 'co.comuna_id')
         ->where('i.id','=', $id)
         ->select(DB::raw('i.id , i.direccion,i.numero,co.comuna_nombre as comuna'))
         ->first();

        $Checklist = DB::table('chkinmuebles')
        ->Where('id_inmueble','=',$id)
        ->first();         

        $imgReserva = ChkInmuebleFoto::where('id_inmueble','=',$id)->get();

        
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


}

