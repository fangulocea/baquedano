<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PagosPropietarios extends Model
{
        protected $table='adm_pagospropietarios';
    protected $fillable=['id_contratofinal','id_publicacion','tipopago','fecha_iniciocontrato','dia','mes','anio','cant_diasmes','cant_diasproporcional','moneda','valormoneda','precio_en_moneda','precio_en_pesos','id_creador','id_modificador','id_estado','gastocomun','canondearriendo','valordia','idtipopago','meses_contrato','E_S','id_inmueble'];

}
