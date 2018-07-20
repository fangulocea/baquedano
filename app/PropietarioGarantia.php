<?php

namespace App;

use Illuminate\Database\Eloquent\Model;	

class PropietarioGarantia extends Model
{
    protected $table='propietario_garantia';
    protected $fillable=['id_publicacion','mes','ano','banco','numero','valor','fecha_cobro','id_creador','id_estado'];
}