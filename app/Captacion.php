<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Captacion extends Model
{
	use SoftDeletes;
    protected $table='cap_publicaciones';
    protected $fillable = ['portal','url','codigo_publicacion','informacion_publicacion','fecha_publicacion','fecha_expiracion','observaciones','id_propietario', 'id_inmueble','id_creador','id_modificador','id_estado','condicion','id_corredor'];
    protected $dates = ['deleted_at'];
}

