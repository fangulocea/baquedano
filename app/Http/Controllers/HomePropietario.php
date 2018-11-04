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
use DB;

class HomePropietario extends Controller
{
   
	public function getPagos($id,$mes,$anio) {

        $contrato = DB::table('adm_pagospropietarios as pp')
                ->where('pp.id_contratofinal', '=', $id)
                ->where('pp.mes', '=', $mes)
                ->where('pp.anio', '=', $anio)
                ->select(DB::raw('pp.id, pp.id_contratofinal, pp.id_publicacion, pp.id_inmueble, pp.tipopago, pp.E_S, pp.idtipopago, pp.tipopropuesta, pp.meses_contrato, pp.fecha_iniciocontrato, pp.dia, pp.mes, pp.anio, pp.cant_diasmes, pp.cant_diasproporcional, pp.moneda, pp.valormoneda, pp.valordia, pp.precio_en_moneda, pp.precio_en_pesos, pp.id_creador, pp.id_modificador, pp.id_estado, pp.gastocomun, pp.canondearriendo, pp.created_at, pp.updated_at, pp.deleted_at, (Select 
                	id from adm_pagosmensualespropietarios as pm where pm.id_contratofinal=pp.id_contratofinal and pm.mes=pp.mes and pm.anio=pp.anio ) as id_pm '))
                ->get();
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
