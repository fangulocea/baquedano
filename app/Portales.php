<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Portales extends Model
{
    use SoftDeletes;
    protected $table='portales';
    protected $fillable = ['nombre','estado'];
    protected $dates = ['deleted_at'];
}
