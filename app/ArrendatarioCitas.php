<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ArrendatarioCitas extends Model
{
    use SoftDeletes;
    protected $table='arrendatariocitas';
    protected $fillable = ['id','nombre','telefono','email','direccion','numero','departamento','nombre_c','telefono_c','email_c','fecha','id_estado','id_creador','id_arrendatario'];
    protected $dates = ['deleted_at'];


            
            


}
