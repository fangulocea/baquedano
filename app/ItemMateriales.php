<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ItemMateriales extends Model
{
    protected $table='post_itemmateriales';
    protected $fillable = ['id_familia','item','id_estado'];
}
