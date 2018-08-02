<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ChkInmuebleFoto extends Model
{
    protected $table='chkinmueblefoto';
    protected $fillable = ['id', 'id_chk','nombre','ruta','id_creador','id_inmueble','tipo'];
}

