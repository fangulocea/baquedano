<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\User;
use App\ContratoFinal;
use App\Persona;
use App\ContratoFinalDocs;
use App\Region;
use App\Inmueble;
use App\PagosPropietarios;
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
}
