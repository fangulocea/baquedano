<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PostVenta extends Model
{
       protected $table='post_venta';
    protected $fillable = ['id', 'id_contrato','id_inmueble','id_propietario','id_arrendatario','id_administradoredificio','id_aval','id_creador','id_modificador','id_asignacion','id_estado','meses_contrato','fecha_contrato','fecha_solicitud','fecha_revision','fecha_seguimiento','fecha_cierre','nombre_caso','descripcion_del_caso','id_cobro','id_modulo'];
}
