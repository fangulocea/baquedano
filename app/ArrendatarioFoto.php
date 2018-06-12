<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ArrendatarioFoto extends Model
{
    protected $table='arrendatarioimgs';
    protected $fillable = ['id_arrendatario','descripcion','nombre','ruta'];
}
