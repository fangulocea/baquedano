<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetallePresupuestoPostVenta extends Model
{
       protected $table='post_detallepresupuesto';
    protected $fillable = ['id','id_presupuesto','id_proveedor','id_familia','id_item','id_creador','id_modificador','valor_proveedor','valor_unitario_baquedano','recargo','cantidad','monto_baquedano','monto_proveedor','subtotal'];
}
