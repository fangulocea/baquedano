<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Servicio extends Model
{
	use SoftDeletes;
    protected $table='servicios';
    protected $fillable = ['id', 'nombre','descripcion','valor','estado'];
    protected $dates = ['deleted_at'];
}
