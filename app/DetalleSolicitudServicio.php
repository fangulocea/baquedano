<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetalleSolicitudServicio extends Model
{
     protected $table='post_detallesolservicios';
    protected $fillable = ['id_solicitud', 'id_contrato','id_inmueble','id_propietario','id_creador','id_servicio','fecha_uf','valor_uf','valor_en_uf','valor_en_pesos','cantidad','subtotal_uf','subtotal_pesos','id_estado'];
}
