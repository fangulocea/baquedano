<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Correo extends Model
{
	use SoftDeletes;
    protected $table='correos';
    protected $fillable = ['id', 'nombre','descripcion','estado'];
    protected $dates = ['deleted_at'];
}
