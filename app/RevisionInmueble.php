<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RevisionInmueble extends Model
{
    	use SoftDeletes;
    protected $table='adm_revisioninmueble';
    protected $fillable=['id_inmueble','tipo_revision','detalle_revision','id_creador','id_modificador','fecha_gestion','hora_gestion'];
    protected $dates = ['deleted_at'];
}
