<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PersonaInmueble extends Model
{
	use SoftDeletes;
    protected $table='personainmuebles';
    protected $fillable = ['id', 'id_persona','id_inmueble'];
    protected $dates = ['deleted_at'];
}
