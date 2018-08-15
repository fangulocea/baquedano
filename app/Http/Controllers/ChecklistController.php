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
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;

class ChecklistController extends Controller
{


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function create_detalle($id_contrato,$id_chk,$tipo,$edr,$tipo_chk)
    {
        $imgReserva = DB::table('chkinmueblefoto')
                    ->where('id_chk',   '=', $id_chk)
                    ->where('tipo_chk', '=', $tipo_chk)
                    ->whereNotNull('nombre')
                    ->get();

        if($tipo == 'Propietario')
        {
            $Checklist = DB::table('adm_contratofinal as cf')
                        ->leftjoin('cap_publicaciones as p', 'cf.id_publicacion' , '=', 'p.id' )
                        ->leftjoin('inmuebles as i', 'p.id_inmueble', '=', 'i.id')
                        ->leftjoin('comunas as co', 'i.id_comuna', '=', 'co.comuna_id')
                        ->where('cf.id', '=', $id_contrato)
                        ->select(DB::raw('p.id, i.direccion,i.numero,i.departamento,i.id as id_inmueble,co.comuna_nombre as comuna'))
                        ->first();             

        }
        else
        {
            $Checklist = DB::table('adm_contratofinalarr as cf')
                        ->leftjoin('arrendatarios as p', 'cf.id_publicacion' , '=', 'p.id' )
                        ->leftjoin('inmuebles as i', 'p.id_inmueble', '=', 'i.id')
                        ->leftjoin('comunas as co', 'i.id_comuna', '=', 'co.comuna_id')
                        ->where('cf.id', '=', $id_contrato)
                        ->select(DB::raw('i.direccion,i.numero,i.departamento,i.id as id_inmueble,co.comuna_nombre as comuna'))
                        ->first();       
        }

        $listadoCheckList = DB::table('checklist')
                    ->where('estado', '=', 1)->get(); 

        $NombreTipoCheckList = DB::table('checklist')
                    ->where('id', '=', $tipo_chk)->first();                     

        $NombreCheckList = DB::table('chkinmueblefoto')
                    ->where('id_chk',   '=', $id_chk)
                    ->where('tipo_chk', '=', $tipo_chk)
                    ->first();

          
        return view('checklist.create_detalle',compact('NombreCheckList','NombreTipoCheckList','deta_check','listadoCheckList','imgReserva','Checklist','vacio','tipo','id_contrato','id_chk','edr','tipo_chk'));  
    }





    public function create($id_contrato,$id_chk,$tipo,$edr)
    {

        $vacio = "CheckList
                    Cocina
                    Item 1, Item 2
                    Baño
                    Item 1, Item 2";

        $imgReserva = ChkInmuebleFoto::where('id_chk','=',$id_chk)->get();

        if($tipo == 'Propietario')
        {
            $Checklist = DB::table('adm_contratofinal as cf')
                        ->leftjoin('cap_publicaciones as p', 'cf.id_publicacion' , '=', 'p.id' )
                        ->leftjoin('inmuebles as i', 'p.id_inmueble', '=', 'i.id')
                        ->leftjoin('comunas as co', 'i.id_comuna', '=', 'co.comuna_id')
                        ->where('cf.id', '=', $id_contrato)
                        ->select(DB::raw('i.direccion,i.numero,i.departamento,i.id as id_inmueble,co.comuna_nombre as comuna'))
                        ->first();             
        }
        else
        {
            $Checklist = DB::table('adm_contratofinalarr as cf')
                        ->leftjoin('arrendatarios as p', 'cf.id_publicacion' , '=', 'p.id' )
                        ->leftjoin('inmuebles as i', 'p.id_inmueble', '=', 'i.id')
                        ->leftjoin('comunas as co', 'i.id_comuna', '=', 'co.comuna_id')
                        ->where('cf.id', '=', $id_contrato)
                        ->select(DB::raw('i.direccion,i.numero,i.departamento,i.id as id_inmueble,co.comuna_nombre as comuna'))
                        ->first();                         
        }

        $listadoCheckList = DB::table('checklist')
                    ->where('estado', '=', 1)->get(); 
  
        
        return view('checklist.create',compact('listadoCheckList','imgReserva','Checklist','vacio','tipo','id_contrato','id_chk','edr'));   
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




    public function chkmanual($id_contrato, $id_chk, $tipo, $edr)
    {
        $year_now = date ("Y");  
        $month_now = date ("n"); 

        if($tipo == 'Propietario')
        {
            $Checklist = DB::table('adm_contratofinal as cf')
                        ->leftjoin('cap_publicaciones as p', 'cf.id_publicacion' , '=', 'p.id' )
                        ->leftjoin('personas as per', 'p.id_propietario' , '=', 'per.id' )
                        ->leftjoin('inmuebles as i', 'p.id_inmueble', '=', 'i.id')
                        ->leftjoin('comunas as co', 'i.id_comuna', '=', 'co.comuna_id')
                        ->where('cf.id', '=', $id_contrato)
                        ->select(DB::raw('p.id, i.direccion,i.numero,i.departamento,i.id as id_inmueble,co.comuna_nombre as comuna,per.nombre, per.apellido_paterno,per.apellido_materno, per.email, per.telefono'))
                        ->first();             
        }
        else
        {
            $Checklist = DB::table('adm_contratofinalarr as cf')
                        ->leftjoin('arrendatarios as p', 'cf.id_publicacion' , '=', 'p.id' )
                        ->leftjoin('personas as per', 'p.id_arrendatario' , '=', 'per.id' )
                        ->leftjoin('inmuebles as i', 'p.id_inmueble', '=', 'i.id')
                        ->leftjoin('comunas as co', 'i.id_comuna', '=', 'co.comuna_id')
                        ->where('cf.id', '=', $id_contrato)
                        ->select(DB::raw('i.direccion,i.numero,i.departamento,i.id as id_inmueble,co.comuna_nombre as comuna, per.nombre, per.apellido_paterno,per.apellido_materno, per.email, per.telefono'))
                        ->first();       
        }

        $listadoCheckList = DB::table('checklist')
                    ->where('estado', '=', 1)->get(); 


        $pdf = PDF::loadView('formatospdf.checklistmanual', compact('Checklist', 'listadoCheckList','id_contrato', 'id_chk', 'tipo', 'edr'));
        
        return $pdf->download($Checklist->direccion . ' Nro.' . $Checklist->numero . ' Comuna.' . $Checklist->comuna . ' - ' . $month_now . '-' . $year_now . ' - CheckList.pdf');
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
        ->select(DB::raw('c.id as id_chk, i.direccion, i.numero, co.comuna_nombre as comuna, c.descripcion, c.comentarios'))
        ->first();


        $descripcion = $ChkInmueble->descripcion;
        $comentarios = $ChkInmueble->comentarios;
        //$descripcion = nl2br($ChkInmueble->descripcion);
        //$descripcion = str_replace("<br />", " /n", $descripcion);
        //$descripcion = str_replace(array("\r\n", "\r", "\n"), "<br />", $descripcion);
        

        $foto = DB::table('chkinmueblefoto as f')
         ->where('f.id_chk', '=', $ChkInmueble->id_chk)
         ->select(DB::raw('f.id, f.ruta, f.nombre'))
         ->get();

        if($tipo == 'Arrendatario')
        {
            $persona = DB::table('chkinmuebles as c')
                ->leftjoin('arrendatarios as a', 'c.id_bor_arr', '=', 'a.id')
                ->leftjoin('personas as p', 'a.id_arrendatario', '=', 'p.id')
                ->where('c.id', '=', $tipo)
                ->select(DB::raw('p.nombre, p.apellido_paterno, p.telefono, p.email'))
                ->first();

            $pdf = PDF::loadView('formatospdf.checklistarrendatario', compact('ChkInmueble', 'foto','persona','descripcion','comentarios'));
            return $pdf->download($ChkInmueble->direccion . ' Nro.' . $ChkInmueble->numero . ' Comuna.' . $ChkInmueble->comuna . ' - ' . $month_now . '-' . $year_now . ' - CheckList Propietario.pdf');
        }
        else
        {
            $persona = DB::table('chkinmuebles as c')
                ->leftjoin('cap_publicaciones as a', 'c.id_cap_pro', '=', 'a.id')
                ->leftjoin('personas as p', 'a.id_propietario', '=', 'p.id')
                ->where('c.id', '=', $id)
                ->select(DB::raw('p.nombre, p.apellido_paterno, p.telefono, p.email'))
                ->first();

            $pdf = PDF::loadView('formatospdf.checklistpropietario', compact('ChkInmueble', 'foto','persona','descripcion','comentarios'));
            return $pdf->download($ChkInmueble->direccion . ' Nro.' . $ChkInmueble->numero . ' Comuna.' . $ChkInmueble->comuna . ' - ' . $month_now . '-' . $year_now . ' - CheckList Propietario.pdf');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Checklist  $checklist
     * @return \Illuminate\Http\Response
     */
    public function edit($id_contrato,$id_chk,$tipo,$edr)
    {

        if($tipo == "Propietario")
        {
            $Checklist = DB::table('adm_contratofinal as cf')
                        ->leftjoin('cap_publicaciones as p', 'cf.id_publicacion' , '=', 'p.id' )
                        ->leftjoin('inmuebles as i', 'p.id_inmueble', '=', 'i.id')
                        ->leftjoin('comunas as co', 'i.id_comuna', '=', 'co.comuna_id')
                        ->where('cf.id', '=', $id_contrato)
                        ->select(DB::raw('i.direccion,i.numero,i.departamento,i.id as id_inmueble,co.comuna_nombre as comuna'))
                        ->first();             
        }
        else
        {
            $Checklist = DB::table('adm_contratofinalarr as cf')
                        ->leftjoin('arrendatarios as p', 'cf.id_publicacion' , '=', 'p.id' )
                        ->leftjoin('inmuebles as i', 'p.id_inmueble', '=', 'i.id')
                        ->leftjoin('comunas as co', 'i.id_comuna', '=', 'co.comuna_id')
                        ->where('cf.id', '=', $id_contrato)
                        ->select(DB::raw('i.direccion,i.numero,i.departamento,i.id as id_inmueble,co.comuna_nombre as comuna'))
                        ->first();                         
        }

        $detalle = DB::table('chkinmuebles')
                    ->where('id', '=', $id_chk)->first(); 

        $vacio = $detalle->descripcion;
        $comentarios = $detalle->comentarios;

        $imgReserva = ChkInmuebleFoto::where('id_chk','=',$id_chk)->get();
        
        $listadoCheckList = DB::table('checklist')
                    ->where('estado', '=', 1)->get(); 


        return view('checklist.create',compact('listadoCheckList','imgReserva','comentarios','Checklist','vacio','tipo','id_contrato','id_chk','edr'));  
    }

    public function savefotos(Request $request, $id_inmueble){

        //dd($request);
        if($request->id_tipo == 'Propietario')
        {
                $adm_contratofinal = DB::table('adm_contratofinal')
                                ->Where('id','=',$request->id_contrato)
                                ->first();

                if($request->id_chk == 0)
                {
                    $checklist  = Checklist::create([                      
                                'id_inmueble'       => $id_inmueble,
                                'id_creador'        => $request->id_creadorfinal,
                                'id_modificador'    => $request->id_creadorfinal,
                                'id_contrato'       => $request->id_contrato,
                                'tipo'              => $request->id_tipo,
                                'e_s_r'             => $request->edr,
                                'comentarios'       => $request->comentarios,
                                'descripcion'       => $request->descripcion,
                                'id_cap_pro'        => $adm_contratofinal->id_publicacion,
                                'id_estado'         => '1',
                                'tipo_chk'          => $request->tipo_chk,
                    ]);
                    
                    $id_chk      = $checklist->id;            
                }
                else
                {   $id_chk      = $request->id_chk;   }                            
        }
        else
        {
            $adm_contratofinal = DB::table('adm_contratofinalarr')
                            ->Where('id','=',$request->id_contrato)
                            ->first();      

                if($request->id_chk == 0)
                {
                    $checklist  = Checklist::create([                      
                                'id_inmueble'       => $id_inmueble,
                                'id_creador'        => $request->id_creadorfinal,
                                'id_modificador'    => $request->id_creadorfinal,
                                'id_contrato'       => $request->id_contrato,
                                'tipo'              => $request->id_tipo,
                                'e_s_r'             => $request->edr,
                                'comentarios'       => $request->comentarios,
                                'descripcion'       => $request->descripcion,
                                'id_bor_arr'        => $adm_contratofinal->id_publicacion,
                                'id_estado'         => '1',
                                'tipo_chk'          => $request->tipo_chk,
                    ]);
                    
                    $id_chk      = $checklist->id;            
                }
                else
                {   $id_chk      = $request->id_chk;   }                                     
        }
        
        $tipo        = $request->id_tipo;
        $edr         = $request->edr;
        $id_contrato = $request->id_contrato;


        // $checklist = DB::table('chkinmuebles')
        // ->Where('chkinmuebles.id_inmueble','=',$id)
        // ->first();

        if(isset($request->foto))
        {

            $input  = array('image' => Input::file('foto'));
            $reglas = array('image' => 'mimes:jpeg,png');
            $validacion = Validator::make($input,  $reglas);
            if ($validacion->fails())
            {
                    $path='uploads/checklist';
                    $archivo=rand().$request->foto->getClientOriginalName();
                    $file = $request->file('foto');
                    $file->move($path, $archivo);
                    $imagen = ChkInmuebleFoto::create([
                                'id_chk'               => $id_chk,
                                'id_inmueble'          => $id_inmueble,
                                'nombre'               => $archivo,
                                'ruta'                 => $path,
                                'tipo'                 => $request->id_tipo,
                                'id_creador'           => $request->id_creador,
                                'tipo_chk'             => $request->tipo_chk,
                                'comentarios'          => $request->comentarios,
                    ]);                
            }
            else
            {
                $path='uploads/checklist';
                $archivo=rand().$request->foto->getClientOriginalName();
                $img = Image::make($_FILES['foto']['tmp_name'])->resize(600,400, function ($constraint){ 
                    $constraint->aspectRatio();
                });
                $img->save($path.'/'.$archivo,72);
                $imagen=ChkInmuebleFoto::create([
                       'id_chk'               => $id_chk,
                       'id_inmueble'          => $id_inmueble,
                       'nombre'               => $archivo,
                       'ruta'                 => $path,
                       'tipo'                 => $request->id_tipo,
                       'id_creador'           => $request->id_creador,
                       'tipo_chk'             => $request->tipo_chk,
                       'comentarios'          => $request->comentarios,
                ]);                
            }

            // Checklist::where('id', '=', $id_chk)->update([
            //             'descripcion'     => $request->descripcion,
            //             'comentarios'     => $request->comentarios,

            //         ]);

        }
        else
        { 
                $imagen=ChkInmuebleFoto::create([
                       'id_chk'               => $id_chk,
                       'id_inmueble'          => $id_inmueble,
                       'comentarios'          => $request->comentarios,
                       'tipo_chk'             => $request->tipo_chk,
                ]);             
            // Checklist::where('id', '=', $id_chk)->update([
            //         'descripcion'     => $request->descripcion,
            //         'comentarios'     => $request->comentarios,
            // ]);

            return redirect()->route('checklist.create_detalle', [$id_contrato,$id_chk,$tipo,$edr,$request->tipo_chk])->with('status', 'No se ha actualizado ninguna imágen'); 
        }
        
        return redirect()->route('checklist.create_detalle',   [$id_contrato,$id_chk,$tipo,$edr,$request->tipo_chk])->with('status', 'Foto guardada con éxito');
    }

public function eliminararchivo($idf,$id_contrato,$id_chk,$tipo,$edr){

        $imagen=ChkInmuebleFoto::find($idf);

        File::delete($imagen->ruta.'/'.$imagen->nombre);
        $foto = ChkInmuebleFoto::find($idf)->delete();

        return redirect()->route('checklist.edit', [$id_contrato,$id_chk,$tipo,$edr])->with('status', 'Foto eliminada con éxito');
    }

    
static function cantDias($fecha1,$fecha2){

        $fecha1 = Carbon::parse($fecha1);
        $fecha2 = Carbon::parse($fecha2);
        $res = $fecha2->diffInDays($fecha1);
        return $res;
    }



    public function index()
    {
        $publica = DB::table('chkinmuebles as chk')
         ->leftjoin('inmuebles as i', 'chk.id_inmueble', '=', 'i.id')
         ->leftjoin('comunas as co', 'i.id_comuna', '=', 'co.comuna_id')
         ->select(DB::raw('chk.id, i.direccion, i.numero, co.comuna_nombre as comuna, 
                           chk.id_estado, chk.tipo, chk.id_bor_arr, chk.id_cap_pro, chk.created_at, chk.fecha_limite , chk.id_contrato, chk.e_s_r'))
         ->orderBy('chk.id_contrato')
         ->orderBy('chk.tipo')
         ->get();

        return view('checklist.index',compact('publica'));

    }






    public function checkindex($id_contrato,$id_chk,$tipo)
    {
        if($id_chk == 0)
        {
            $publica = DB::table('chkinmuebles as chk')
             ->leftjoin('inmuebles as i', 'chk.id_inmueble', '=', 'i.id')
             ->leftjoin('comunas as co', 'i.id_comuna', '=', 'co.comuna_id')
             ->where('chk.id_contrato','=',$id_contrato)
             ->where('chk.tipo','=',$tipo)
             ->select(DB::raw('chk.id, i.direccion, i.numero, co.comuna_nombre as comuna, 
                               chk.id_estado, chk.tipo, chk.id_bor_arr, chk.id_cap_pro, chk.created_at, chk.id_contrato,chk.e_s_r '))
             ->get();
        }
        else
        {
            $publica = DB::table('chkinmuebles as chk')
             ->leftjoin('inmuebles as i', 'chk.id_inmueble', '=', 'i.id')
             ->leftjoin('comunas as co', 'i.id_comuna', '=', 'co.comuna_id')
             ->where('chk.id','=',$id_chk)
             ->where('chk.id_contrato','=',$id_contrato)
             ->where('chk.tipo','=',$tipo)
             ->select(DB::raw('chk.id, i.direccion, i.numero, co.comuna_nombre as comuna, 
                               chk.id_estado, chk.tipo, chk.id_bor_arr, chk.id_cap_pro, chk.created_at, chk.id_contrato,chk.e_s_r '))
             ->get();            
        }


         return view('contratoFinal.checklist',compact('publica','id_contrato','id_chk','tipo')); 
    }

    public function checkindexarr($id_contrato,$id_chk,$tipo)
    {
        if($id_chk == 0)
        {
            $publica = DB::table('chkinmuebles as chk')
             ->leftjoin('inmuebles as i', 'chk.id_inmueble', '=', 'i.id')
             ->leftjoin('comunas as co', 'i.id_comuna', '=', 'co.comuna_id')
             ->where('chk.id_contrato','=',$id_contrato)
             ->where('chk.tipo','=',$tipo)
             ->select(DB::raw('chk.id, i.direccion, i.numero, co.comuna_nombre as comuna, 
                               chk.id_estado, chk.tipo, chk.id_bor_arr, chk.id_cap_pro, chk.created_at, chk.id_contrato,chk.e_s_r '))
             ->get();
        }
        else
        {
            $publica = DB::table('chkinmuebles as chk')
             ->leftjoin('inmuebles as i', 'chk.id_inmueble', '=', 'i.id')
             ->leftjoin('comunas as co', 'i.id_comuna', '=', 'co.comuna_id')
             ->where('chk.id','=',$id_chk)
             ->where('chk.id_contrato','=',$id_contrato)
             ->where('chk.tipo','=',$tipo)
             ->select(DB::raw('chk.id, i.direccion, i.numero, co.comuna_nombre as comuna, 
                               chk.id_estado, chk.tipo, chk.id_bor_arr, chk.id_cap_pro, chk.created_at, chk.id_contrato,chk.e_s_r '))
             ->get();            
        }


         return view('finalContratoArr.checklist',compact('publica','id_contrato','id_chk','tipo')); 

     }

public function creachkportipo($tipoACrear)
{
    if($tipoACrear == 'Propietario')
    {
        $publica = DB::table('chkinmuebles as chk')
         ->leftjoin('inmuebles as i', 'chk.id_inmueble', '=', 'i.id')
         ->leftjoin('comunas as co', 'i.id_comuna', '=', 'co.comuna_id')
         ->where('chk.tipo','=',$tipoACrear)
         ->select(DB::raw('chk.id, i.direccion, i.numero, co.comuna_nombre as comuna, 
                           chk.id_estado, chk.tipo, chk.id_bor_arr, chk.id_cap_pro, chk.created_at, chk.fecha_limite , chk.id_contrato, chk.e_s_r'))
         ->orderBy('chk.id_contrato')
         ->get();
    }
    elseif ($tipoACrear == 'Arrendatario') 
    {
        $publica = DB::table('chkinmuebles as chk')
        ->select(DB::raw('chk.id_contrato, chk.id, i.direccion, i.numero, co.comuna_nombre as comuna, 
                           chk.id_estado, chk.tipo, chk.id_bor_arr, chk.id_cap_pro, chk.created_at, chk.fecha_limite , chk.e_s_r'))
         ->leftjoin('inmuebles as i', 'chk.id_inmueble', '=', 'i.id')
         ->leftjoin('comunas as co', 'i.id_comuna', '=', 'co.comuna_id')
         ->where('chk.tipo','=',$tipoACrear)
         ->orderBy('chk.id_contrato')
          ->get(); 

    }

    return view('checklist.indexTipo',compact('publica','tipoACrear')); 

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

    static  function Valida_boton($id_chk,$tipo_chk){

        $imgReserva = DB::table('chkinmueblefoto')
            ->where('id_chk',   '=', $id_chk)
            ->where('tipo_chk', '=', $tipo_chk)
            ->whereNotNull('comentarios')
            ->count();

        if($imgReserva == 0)
        { return false; }
        else
        { return true; }
        
    }   


}

