<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mensajes extends Model
{
     protected $table='mensajes';
    protected $fillable = ['id', 'id_modulo','nombre_modulo','id_estado','nombre'];
}
