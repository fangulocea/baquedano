<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SimulaMensualArrendatario extends Model
{
    protected $table='cap_simulamensualarrendatarios';
   protected $fillable=['id_simulacion','id_publicacion','id_inmueble','id_arrendatario','fecha_iniciocontrato','mes','anio','subtotal_entrada','subtotal_salida','pago_propietario','pago_rentas','valor_a_pagar','id_creador','id_modificador','id_estado'];
}
