<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetallePagosDocArrendatarios extends Model
{
    protected $table='adm_pagosdocarrendatarios';
    protected $fillable = ['id_detallepago','id_publicacion','tipo','nombre','ruta','id_creador','id_inmueble'];
}
