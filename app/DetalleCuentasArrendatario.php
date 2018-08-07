<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetalleCuentasArrendatario extends Model
{
       protected $table='post_detallecuentasARR';
    protected $fillable = ['id_contrato', 'id_inmueble','id_arrendatario','id_creador','id_serviciobasico','mes','anio','fecha_vencimiento','nombre','ruta','valor_en_pesos','id_estado'];
}
