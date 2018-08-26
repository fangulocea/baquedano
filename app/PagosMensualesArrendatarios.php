<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PagosMensualesArrendatarios extends Model
{
    protected $table='adm_pagosmensualesarrendatarios';
    protected $fillable = ['id_contratofinal','id_publicacion','fecha_iniciocontrato','mes','anio','valor_a_pagar','id_creador','id_modificador','id_estado','subtotal_entrada','subtotal_salida','pago_a_arrendatario','pago_a_rentas','id_inmueble',
    'moneda','valor_moneda','fecha_moneda','subtotal_entrada_moneda','subtotal_salida_moneda','pago_a_arrendatario_moneda','pago_a_rentas_moneda'];
}
