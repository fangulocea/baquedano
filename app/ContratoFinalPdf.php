<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ContratoFinalPdf extends Model
{
    use SoftDeletes;
    protected $table='adm_contratofinalpdf';
    protected $fillable = ['id_final','nombre','ruta','id_creador'];
    protected $dates = ['deleted_at'];
}
