<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SolicitudServicioARR extends Model
{
        protected $table='post_solicitudserviciosarr';
    protected $fillable = ['id_contrato','id_inmueble','id_arrendatario','id_creador','id_modificador','id_autorizador','id_asignacion','fecha_autorizacion','fecha_uf','valor_uf','valor_en_uf','valor_en_pesos','id_estado'];
}
