<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class ContratoFinalPdf extends Model
{

    protected $table='adm_contratofinalpdf';
    protected $fillable = ['id_final','nombre','ruta','id_creador'];

}
