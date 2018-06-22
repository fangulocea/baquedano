<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Flexibilidad extends Model
{
	use SoftDeletes;
    protected $table='flexibilidads';
    protected $fillable = ['id', 'nombre','descripcion','estado'];
    protected $dates = ['deleted_at'];
}
