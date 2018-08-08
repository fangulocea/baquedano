<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PropietarioCuadratura extends Model
{
    protected $table='propietario_cuadratura';

    protected $fillable = ['id_contrato','id_publicacion','id_creador','descripcion','valor','id_estado'];
}

