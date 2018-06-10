<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comision extends Model
{
	use SoftDeletes;
    protected $table='comisiones';
    protected $fillable = ['id', 'nombre','descripcion','comision','estado'];
    protected $dates = ['deleted_at'];
}
