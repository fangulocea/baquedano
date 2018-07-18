<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ArrendatarioCheques extends Model
{
    protected $table='arrendatario_cheques';

    protected $fillable = ['id','id_contrato','monto','numero','id_estado','correlativo'];
}
