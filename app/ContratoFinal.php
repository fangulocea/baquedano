<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ContratoFinal extends Model
{
    use SoftDeletes;
    protected $table='adm_contratofinal';
    protected $fillable = ['id','id_notaria','id_publicacion','fecha_firma','observaciones','id_estado','id_creador','id_modificador'
    ,'id_borrador','id_borradorpdf'];
    protected $dates = ['deleted_at'];
}
