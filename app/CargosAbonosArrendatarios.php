<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CargosAbonosArrendatarios extends Model
{
      protected $table='adm_cargosabonosarrendatarios';
    protected $fillable = ['id_pagomensual','id_publicacion','tipooperacion','nombreoperacion','moneda','fecha_moneda','valor_moneda','monto_moneda','monto_pesos','tipo','nombre','ruta','id_creador','id_modificador','id_estado'];
}
