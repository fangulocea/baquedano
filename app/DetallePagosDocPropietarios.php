<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetallePagosDocPropietarios extends Model
{
    protected $table='adm_pagosdocpropietarios';
    protected $fillable = ['id_detallepago','id_publicacion','tipo','nombre','ruta','id_creador'];}
