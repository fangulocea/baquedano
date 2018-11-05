<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class PagosPropietarios extends Model
{
        protected $table='adm_pagospropietarios';
    protected $fillable=['id_contratofinal','id_publicacion','tipopago','fecha_iniciocontrato','dia','mes','anio','cant_diasmes','cant_diasproporcional','moneda','valormoneda','precio_en_moneda','precio_en_pesos','id_creador','id_modificador','id_estado','gastocomun','canondearriendo','valordia','idtipopago','meses_contrato','E_S','id_inmueble','tipopropuesta'];


    public static function pagomensual($id, $mes, $anio) {

    	      $contrato = DB::table('adm_pagospropietarios as pp')
                ->whereIn('pp.id_contratofinal', $id)
                ->where('pp.mes', '=', $mes)
                ->where('pp.anio', '=', $anio)
                ->select(DB::raw('pp.id, pp.id_contratofinal, pp.id_publicacion, pp.id_inmueble, pp.tipopago, pp.E_S, pp.idtipopago, pp.tipopropuesta, pp.meses_contrato, pp.fecha_iniciocontrato, pp.dia, pp.mes, pp.anio, pp.cant_diasmes, pp.cant_diasproporcional, pp.moneda, pp.valormoneda, pp.valordia, pp.precio_en_moneda, pp.precio_en_pesos, pp.id_creador, pp.id_modificador, pp.id_estado, pp.gastocomun, pp.canondearriendo, pp.created_at, pp.updated_at, pp.deleted_at, (Select 
                	id from adm_pagosmensualespropietarios as pm where pm.id_contratofinal=pp.id_contratofinal and pm.mes=pp.mes and pm.anio=pp.anio ) as id_pm '))
                ->get();

                return $contrato;

    }



}
