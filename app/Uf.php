<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Uf extends Model
{
   protected $table='adm_uf';
    protected $fillable = ['fecha','dia','mes','anio','valor','id_creador','id_modificador'];
}
