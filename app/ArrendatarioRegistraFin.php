<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ArrendatarioRegistraFin extends Model
{
    protected $table='arrendatario_registrafin';
    protected $fillable=['id_contrato', 'id_cap_arrendatario', 'id_arrendatario', 'fecha', 'garantia', 'reserva'];
}


