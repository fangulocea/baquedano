<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ContratoBorradorArrendatario extends Model
{
    use SoftDeletes;
    protected $table='contratoborradorarrendatarios';
    protected $fillable = ['id','id_cap_arr','id_inmueble','id_arrendatario','id_servicios','id_formadepago','id_comisiones','id_flexibilidad','id_multa','fecha_pago','fecha_contrato','detalle','id_estado','dia_pago','valorarriendo','id_creador','id_modificador','id_contrato','id_simulacion', 'tipo_contrato','id_aval'];
    protected $dates = ['deleted_at'];
}