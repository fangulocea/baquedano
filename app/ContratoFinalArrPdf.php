<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ContratoFinalArrPdf extends Model
{
    protected $table='adm_contratofinalarrpdf';
    protected $fillable = ['id_final','nombre','ruta','id_creador'];
}
