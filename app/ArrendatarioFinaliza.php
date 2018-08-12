<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ArrendatarioFinaliza extends Model
{
    protected $table='arrendatario_finaliza';

    protected $fillable = ['id_contrato','id_publicacion','descripcion','nombre','ruta','id_creador'];
}
