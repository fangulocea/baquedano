<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AsignaRevision extends Model
{
     protected $table='post_asignarevision';
    protected $fillable = ['id_asignado','id_contrato','id_estado'];
}
