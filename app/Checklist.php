<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Checklist extends Model
{
    protected $table='chkinmuebles';
<<<<<<< HEAD
    protected $fillable = ['id_inmueble','id_creador','id_modificador','id_estado','tipo','descripcion','id_bor_arr','id_cap_pro','id_contrato','e_s_r','comentarios'];
=======
    protected $fillable = ['id_inmueble','id_creador','id_modificador','id_estado','tipo','descripcion','id_bor_arr','id_cap_pro','fecha_limite'];
>>>>>>> 7402318a3fc360c205b6263f9d7fbc9fe5282f51
}
