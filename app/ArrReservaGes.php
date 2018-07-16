<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ArrReservaGes extends Model
{
    protected $table='arr_reservas_ges';
    protected $fillable = ['monto_reserva','descripcion','E_S','id_estado', 'id_creador','id_arr_ges'];
}
