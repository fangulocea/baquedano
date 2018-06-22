<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Arrendatario extends Model
{
    use SoftDeletes;
    protected $table='arrendatarios';
<<<<<<< HEAD
    protected $fillable = ['id','id_arrendatario','id_creador','id_modificador','id_estado', 'preferencias'];
=======
    protected $fillable = ['id','id_arrendatario','id_creador','id_modificador','id_estado'];
>>>>>>> 4679f853b0fcb2262a0e335c0f5b7340c138e65c
    protected $dates = ['deleted_at'];
}
	