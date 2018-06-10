<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CaptacionFoto extends Model
{
    protected $table='cap_imagenes';
    protected $fillable = ['id_captacion','descripcion','nombre','ruta'];
}
