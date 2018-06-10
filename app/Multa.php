<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Multa extends Model
{
	use SoftDeletes;
    protected $table='multas';
    protected $fillable = ['id', 'nombre','descripcion','tipo_multa','valor','estado'];
    protected $dates = ['deleted_at'];
}
