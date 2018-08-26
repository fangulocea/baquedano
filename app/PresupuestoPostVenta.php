<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PresupuestoPostVenta extends Model
{
    protected $table='post_presupuesto';
    protected $fillable = ['id','id_inmueble','id_propietario','id_arrendatario','id_creador','id_modificador','responsable_pago','id_responsable_pago','total','id_postventa','id_estado','id_solicitud'];
}
