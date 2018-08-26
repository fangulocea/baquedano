<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetalleCuentas extends Model
{
       protected $table='post_detallecuentas';
    protected $fillable = ['id_cuenta','id_idcliente','idcliente','valor_medicion','diasproporcionales','id_contrato', 'id_inmueble','id_arrendatario','id_propietario','id_creador','id_serviciobasico','mes','anio','fecha_vencimiento','fecha_iniciolectura','fecha_finlectura','fecha_contrato','nombre','ruta','monto_boleta','monto_responsable','responsable','solicitudpago','id_estado','procesado'];
         
}
