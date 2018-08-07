<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PropietarioFinaliza extends Model
{
    protected $table='propietario_finaliza';

    protected $fillable = ['id_contrato','id_publicacion','descripcion','nombre','ruta','id_creador'];
}

