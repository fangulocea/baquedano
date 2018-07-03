<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ContratoInmueblesPropietarios extends Model
{
        protected $table='adm_contratodirpropietarios';
    protected $fillable = ['id_publicacion','id_contratofinal','id_inmueble','id_creador'];
}
