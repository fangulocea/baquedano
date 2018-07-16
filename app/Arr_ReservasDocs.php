<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Arr_ReservasDocs extends Model
{
    protected $table='arr_reservasdocs';
    protected $fillable = ['id_arrendatario','descripcion','nombre','ruta','id_creador','id_estado'];
}
