<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CaptacionGestionCorredor extends Model
{
   use SoftDeletes;
    protected $table='cap_gestioncorredor';
    protected $fillable = ['id_capcorredor_gestion','tipo_contacto','dir','detalle_contacto','id_creador_gestion','id_modificador_gestion','id_creador_gestion','fecha_gestion','hora_gestion'];
    protected $dates = ['deleted_at'];
}
