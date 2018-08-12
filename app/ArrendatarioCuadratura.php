<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ArrendatarioCuadratura extends Model
{
    protected $table='arrendatario_cuadratura';

    protected $fillable = ['id_contrato','id_publicacion','id_creador','descripcion','valor','id_estado'];
}
