<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ContratoMantenedor extends Model
{
	use SoftDeletes;
    protected $table='contratos';
    protected $fillable = ['id', 'nombre','descripcion','estado'];
    protected $dates = ['deleted_at'];
}
