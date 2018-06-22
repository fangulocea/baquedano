<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Provincia extends Model
{
	use SoftDeletes;
    protected $table='provincias';
    protected $fillable=['provincia_nombre','region_id'];
    protected $dates = ['deleted_at'];

    public static function provincias($id){
    	return Provincia::where('region_id','=',$id)->get();
    }

}
