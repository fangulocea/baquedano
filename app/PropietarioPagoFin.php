<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PropietarioPagoFin extends Model
{
    protected $table='propietariopagofin';
    protected $fillable=['id_contrato','id_publicacion','fecha','monto','saldo','created_at','updated_at','deleted_at'];
}