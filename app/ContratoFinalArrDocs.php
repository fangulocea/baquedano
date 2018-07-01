<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ContratoFinalArrDocs extends Model
{
    protected $table='adm_contratofinalarrdocs';
    protected $fillable = ['id','id_final','id_publicacion','tipo','ruta','nombre','id_creador'];
}
