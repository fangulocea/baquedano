<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ArrReservaGesDocs extends Model
{
    protected $table='arr_reservas_ges_docs';
    protected $fillable = ['id_arrendatario','descripcion','nombre','ruta','id_creador','id_estado'];
}
