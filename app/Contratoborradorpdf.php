<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contratoborradorpdf extends Model
{
    protected $table='borradorespdf';
    protected $fillable = ['id_borrador','nombre','ruta','id_creador'];
}
