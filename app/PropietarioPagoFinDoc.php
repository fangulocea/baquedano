<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PropietarioPagoFinDoc extends Model
{
    protected $table='propietariopagofindoc';
    protected $fillable=['id_pago','id_contrato','id_publicacion','tipo','nombre','ruta','id_creador'];
}