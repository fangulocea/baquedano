<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Region extends Model
{
	use SoftDeletes;
    protected $table='regions';
    protected $fillable=['region_nombre','region_ordinal'];
    protected $dates = ['deleted_at'];

}
