<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetallePagosPropietarios extends Model
{
    protected $table='adm_detallepagospropietarios';
    protected $fillable = ['id_pagomensual','id_publicacion','E_S','valor_original','valor_pagado','saldo','id_creador','id_modificador','id_estado','fecha_pago','id_inmueble';
}
