<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PropietarioRegistraFin extends Model
{
    protected $table='propietario_registrafin';
    protected $fillable=['id_contrato', 'id_publicacion', 'id_cap_arrendatario', 'id_arrendatario', 'fecha', 'garantia', 'reserva'];
}



            