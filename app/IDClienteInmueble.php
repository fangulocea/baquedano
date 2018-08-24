<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class IDClienteInmueble extends Model
{
     protected $table='post_idcliente';
    protected $fillable = ['id_inmueble', 'id_empresaservicio','id_creador','id_modificador','idcliente'];
}
