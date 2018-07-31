<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Checklist extends Model
{
    protected $table='chkinmuebles';
    protected $fillable = ['id_inmueble','id_creador','id_modificador','id_estado','tipo','descripcion'];
}
