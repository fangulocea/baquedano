<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\User;
use App\ContratoFinal;
use App\Checklist;
use App\Persona;
use App\ContratoFinalDocs;
use App\Region;
use App\Inmueble;
use App\PagosPropietarios;
use App\ChkInmuebleFoto;
use DB;

class HomePropietario extends Controller
{
   
	public function getPagos($id,$mes,$anio) {
		$ids=array();
		array_push($ids, $id);
		$contrato = PagosPropietarios::pagomensual($ids,$mes,$anio);
    
        return response()->json($contrato);
    }


    public function getmeses($id) {

        $contrato = DB::table('adm_pagospropietarios')
                ->where('id_contratofinal', '=', $id)
                ->where('idtipopago',"=",1)
                ->get();



        return response()->json($contrato);
    }

     public function mostrar_documentos(){

		$user = User::find(Auth::id());
		$id_persona=$user->id_persona;
		$persona=Persona::find($id_persona);
		$contratos=ContratoFinal::contratos_activos_propietarios($id_persona);

		$docs = array();
		foreach ($contratos as $c ) {
			$documentos=ContratoFinalDocs::documentos($c->id_contrato);
	        array_push($docs, $documentos);
		}
	
		
		

		return view('interfaz_propietario.documentos_digitalizados',compact('docs','contratos'));
		
     }


     public function datos_propiedad(){

		$regiones=Region::pluck('region_nombre','region_id');
		$user = User::find(Auth::id());
		$id_persona=$user->id_persona;
		$_persona=Persona::find($id_persona);
		$contratos=ContratoFinal::contratos_activos_propietarios($id_persona);

		$docs = array();
		foreach ($contratos as $c ) {
			$inmuebles=Inmueble::find($c->id_inmueble);
	        array_push($docs, $inmuebles);
		}
		
		

		return view('interfaz_propietario.datospropiedad',compact('docs','regiones','_persona'));
		
     }


    public function pagos_pendientes(){

		$user = User::find(Auth::id());
		$id_persona=$user->id_persona;
		$_persona=Persona::find($id_persona);
		$contratos=ContratoFinal::contratos_activos_propietarios($id_persona);		
		

		return view('interfaz_propietario.pagospendientes',compact('contratos'));
		
     }




  public function finalizar( $id) {
  	$chk = Checklist::where("id","=",$id)->first();
	$checklist =  DB::table('chkinmuebles')
                    ->where('id_contrato', '=', $chk->id_contrato)
                    ->where('tipo', '=', "Propietario")
                    ->orderBy("id","desc")
                    ->first(); 

      $imagen = ChkInmuebleFoto::where("id_chk","=",$checklist->id)->get();

      if(count($imagen)==0){
      	return redirect()->back()->with('error', 'No es posible finalizar el checkin, ya que aún no lo realiza');
      }


       $save = Checklist::where("id","=",$id)->update([
        "id_estado"=>2,
        "id_modificador" => Auth::user()->id
    ]);
        
        
        return redirect()->route('home')->with('status', 'Finalizado con éxito');
    }


 public function checkin($id_contrato)
    {

        $contratos=ContratoFinal::datos_contrato($id_contrato);


        $checklist =  DB::table('chkinmuebles')
                    ->where('id_contrato', '=', $id_contrato)
                    ->where('tipo', '=', "Propietario")
                    ->orderBy("id","desc")
                    ->first();    

        $imagenes = DB::table('chkinmueblefoto')
                    ->where('id_chk','=', $checklist->id)
                    ->get();


        return view('interfaz_propietario.checkin',compact('contratos','checklist','imagenes'));  
    }


 public function savefotos(Request $request, $id) {
        if (!isset($request->foto)) {
            return redirect()->route('interfaz_propietario.checkin', $id)->with('error', 'Debe seleccionar archivo');
        }

                    $path='uploads/checklist';
                    $archivo=rand().$request->foto->getClientOriginalName();
                    $file = $request->file('foto');
                    $file->move($path, $archivo);
                    $imagen = ChkInmuebleFoto::create([
                                'id_chk'               => $request->id_chk,
                                'id_inmueble'          => $request->id_inmueble,
                                'nombre'               => $archivo,
                                'ruta'                 => $path,
                                'tipo_chk'             => $request->tipo,
                                'id_creador'           => $request->id_creador,
                                'tipo'                 => 'Propietario',
                                'habitacion'           => $request->habitacion,
                                'comentarios'          => $request->comentarios
                            ]);
        $save = Checklist::where("id","=",$request->id_chk)->update([
        "id_estado"=>3,
        "id_modificador" => Auth::user()->id
    ]);
        
        return redirect()->route('propietario.checkin', $id)->with('status', 'Documento guardada con éxito');
    }
}
