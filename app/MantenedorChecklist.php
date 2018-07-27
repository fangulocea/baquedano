<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MantenedorChecklist extends Model
{
    protected $table='checklist';
    protected $fillable = ['id', 'nombre','estado'];
}
