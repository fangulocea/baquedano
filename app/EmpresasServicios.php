<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmpresasServicios extends Model
{
        protected $table='post_empresasservicios';
    protected $fillable = ['id', 'nombre','descripcion','id_estado'];
}
