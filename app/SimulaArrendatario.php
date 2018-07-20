<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SimulaArrendatario extends Model
{
   protected $table='cap_simulaarrendatario';
    protected $fillable = ['id_publicacion', 'id_inmueble','id_arrendatario','meses_contrato','fecha_iniciocontrato','dia','mes','anio','moneda','valormoneda','id_creador','id_modificador','id_estado','canondearriendo','iva','descuento','pie','cobromensual','tipopropuesta','nrocuotas','gastocomun'];
}
