<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class ContratoFinal extends Model
{

    protected $table='adm_contratofinal';
    protected $fillable = ['id','id_notaria','id_publicacion','fecha_firma','observaciones','id_estado','id_creador','id_modificador'
    ,'id_borrador','id_borradorpdf','meses_contrato','id_inmueble','id_propuesta','tipo_contrato','tipo'];

}
