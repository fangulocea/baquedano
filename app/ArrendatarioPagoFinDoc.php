<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ArrendatarioPagoFinDoc extends Model
{
    protected $table='arrendatariopagofindoc';
    protected $fillable=['id_pago','id_contrato','id_publicacion','tipo','nombre','ruta','id_creador'];
}
