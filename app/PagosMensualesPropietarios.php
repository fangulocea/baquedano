<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PagosMensualesPropietarios extends Model
{
    protected $table='adm_pagosmensualespropietarios';
    protected $fillable = ['id_contratofinal','id_publicacion','E_S','fecha_iniciocontrato','mes','anio','valor_a_pagar','id_creador','id_modificador','id_estado','id_inmueble','subtotal_entrada','subtotal_salida','pago_propietario','pago_rentas'];
}
