<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SimulaPropietario extends Model
{
    protected $table='cap_simulapropietario';
    protected $fillable = ['id_publicacion', 'id_inmueble','id_propietario','meses_contrato','fecha_iniciocontrato','dia','mes','anio','moneda','valormoneda','id_creador','id_modificador','id_estado','canondearriendo','iva','descuento','pie','cobromensual','tipopropuesta','nrocuotas','ipc','gastocomun'];
   
}
