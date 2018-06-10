<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CaptacionImport extends Model
{
    protected $table='cap_import';
    protected $fillable = ['CAPTADOR', 'Fecha_publicacion', 'Direccion', 'Nro', 'Dpto', 'Comuna', 'Dorm', 'Bano', 'Esta' , 'Bode' , 'Pisc', 'Precio', 'GASTOS_COMUNES', 'CONDICION', 'nombre_propietario', 'TELEFONO'	,'correo' , 'portal', 'FECHA_ENVIO_CLIENTE', 'OBSERVACIONES', 'LINK', 'Codigo_Publicacion', 'id_creador'];
    protected $dates = ['deleted_at'];
}
