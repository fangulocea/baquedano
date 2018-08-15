<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DocPostVenta extends Model
{
    protected $table='post_documentos';
    protected $fillable = ['id_postventa','descripcion','ruta','nombre','id_creador'];
}
