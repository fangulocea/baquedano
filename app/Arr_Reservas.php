<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Arr_Reservas extends Model
{
    protected $table='arr_reservas';
    protected $fillable = ['id_condicion','monto_reserva','descripcion','id_arr_ges','id_creador','id_modificador','id_estado'];
}
