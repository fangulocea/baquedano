<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PropietarioCheques extends Model
{
    protected $table='propietario_cheques';

    protected $fillable = ['id','id_contrato','monto','numero','id_estado','correlativo','mes_arriendo','banco','fecha_pago'];
}
