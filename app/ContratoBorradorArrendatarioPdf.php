<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ContratoBorradorArrendatarioPdf extends Model
{
    protected $table='contratoborradorarrendatariospdf';
    protected $fillable = ['id_b_arrendatario','nombre','ruta','id_creador'];
}
