<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Condicion extends Model
{
	use SoftDeletes;
    protected $table='condicions';
    protected $fillable = ['id', 'descripcion','nombre','estado'];
    protected $dates = ['deleted_at'];

}
