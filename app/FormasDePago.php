<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FormasDePago extends Model
{
	use SoftDeletes;
    protected $table='formasDePagos';
    protected $fillable = ['id', 'nombre','descripcion','pie','cuotas','estado'];
    protected $dates = ['deleted_at'];
}
