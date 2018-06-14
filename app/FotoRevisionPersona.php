<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FotoRevisionPersona extends Model
{
    protected $table='adm_fotorevpersona';
    protected $fillable = ['id_persona','descripcion','nombre','ruta','id_creador'];
}
