<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comuna extends Model
{
	use SoftDeletes;
    protected $table='comunas';
    protected $fillable=['comuna_nombre','provincia_id'];
    protected $dates = ['deleted_at'];

        public static function comunas($id){
    	return Comuna::where('provincia_id','=',$id)->get();
    }
}
