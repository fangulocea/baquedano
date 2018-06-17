<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ContratoBorrador extends Model
{
    use SoftDeletes;
    protected $table='borradores';
    protected $fillable = ['id','id_notaria','id_servicios','id_comisiones','id_flexibilidad','id_publicacion','fecha_gestion','detalle_revision','id_estado','id_creador','id_modificador'];
    protected $dates = ['deleted_at'];
}