<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FamiliaMateriales extends Model
{
        protected $table='post_familiamateriales';
    protected $fillable = ['familia','id_estado'];
}
