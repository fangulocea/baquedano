<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GestionPostVenta extends Model
{
    protected $table='post_gestion';
    protected $fillable = ['id_postventa', 'tipo_contacto','contacto_con','detalle_contacto','detalle_gestion','id_creador','id_modificador','id_gestionador','fecha_gestion','hora_gestion'];
}
