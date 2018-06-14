<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FotoRevisionInmueble extends Model
{
        protected $table='adm_fotorevinmueble';
    protected $fillable = ['id_inmueble','descripcion','nombre','ruta','id_creador'];
}
