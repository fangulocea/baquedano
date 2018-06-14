<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RevisionPersona extends Model
{
      	use SoftDeletes;
    protected $table='adm_revisionpersona';
    protected $fillable=['id_persona','tipo_revision','detalle_revision','id_creador','id_modificador','fecha_gestion','hora_gestion'];
    protected $dates = ['deleted_at'];
}
