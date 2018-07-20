<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PagosArrendatarios extends Model
{
        protected $table='adm_pagosarrendatarios';
    protected $fillable=['id_contratofinal','id_publicacion','tipopago','fecha_iniciocontrato','dia','mes','anio','cant_diasmes','cant_diasproporcional','moneda','valormoneda','precio_en_moneda','precio_en_pesos','id_creador','id_modificador','id_estado','canondearriendo','valordia','idtipopago','meses_contrato','E_S','id_inmueble','tipopropuesta'];
}
