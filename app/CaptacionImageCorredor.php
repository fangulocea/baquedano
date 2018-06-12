<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CaptacionImageCorredor extends Model
{
        protected $table='cap_imagecorredor';
    protected $fillable = ['id_capcorredor','descripcion','nombre','ruta'];
}
