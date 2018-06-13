<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CaptacionCorredor extends Model
{
    	use SoftDeletes;
    protected $table='cap_corredores';
    protected $fillable = ['informacion_publicacion','fecha_publicacion','fecha_expiracion','observaciones','id_propietario','id_corredor', 'id_inmueble','id_creador','id_modificador','id_estado'];
    protected $dates = ['deleted_at'];
}
