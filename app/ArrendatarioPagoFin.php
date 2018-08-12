<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ArrendatarioPagoFin extends Model
{
    protected $table='arrendatariopagofin';
    protected $fillable=['id_contrato','id_publicacion','fecha','monto','saldo','created_at','updated_at','deleted_at'];
}