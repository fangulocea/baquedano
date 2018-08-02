<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ContratoFinalArr extends Model
{
protected $table='adm_contratofinalarr';
    protected $fillable = ['id','id_notaria','id_publicacion','fecha_firma','observaciones','id_estado','id_creador','id_modificador','id_borrador','id_borradorpdf','meses_contrato','id_simulacion', 'tipo_contrato','tipo'];
}
