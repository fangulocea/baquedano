<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SimulaPagoPropietario extends Model
{
       protected $table='cap_simulapagopropietarios';
    protected $fillable=['id_simulacion','id_publicacion','id_inmueble','id_propietario','tipopago','idtipopago','meses_contrato','fecha_iniciocontrato','dia','mes','anio','cant_diasmes','cant_diasproporcional','moneda','valormoneda','valordia','precio_en_moneda','precio_en_pesos','id_creador','id_modificador','id_estado','canondearriendo','tipo'];
}
