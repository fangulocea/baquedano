<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CatalogoServicios extends Model
{
   protected $table='post_catalogoservicios';
   protected $fillable = ['id_creador','id_modificador','moneda','fecha_moneda','valor_moneda','valor_pesos','nombre_servicio','id_estado'];
}
