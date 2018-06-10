<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Notaria extends Model
{
	use SoftDeletes;
    protected $table='notarias';
    protected $fillable=['razonsocial','id_comuna','id_region','id_provincia','direccion','telefono','nombreNotario','email','estado'];
	protected $dates = ['deleted_at'];
}
