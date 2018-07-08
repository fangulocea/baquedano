<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ContratoFinalDocs extends Model
{
   protected $table='adm_contratofinaldocs';
    protected $fillable = ['id','id_final','id_publicacion','tipo','ruta','nombre','id_creador','id_inmueble'];
}
