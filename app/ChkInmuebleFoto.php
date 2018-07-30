<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ChkInmuebleFoto extends Model
{
    protected $table='chkinmueblefoto';
    protected $fillable = ['id', 'id_chk','descripcion','nombre','ruta','id_creador','id_inmueble','id_item'];
}

