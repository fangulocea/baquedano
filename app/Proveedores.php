<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Proveedores extends Model
{
    protected $table='post_proveedores';
    protected $fillable = ['nombre','id_estado'];
}
