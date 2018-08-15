<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Arrendatario extends Model
{
    use SoftDeletes;
    protected $table='arrendatarios';

    protected $fillable = ['id','id_arrendatario','id_creador','id_modificador','id_estado', 'preferencias','id_inmueble','id_aval'];

    protected $dates = ['deleted_at'];
}
	