<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role_User extends Model
{
	use SoftDeletes;
    protected $table='role_user';
    protected $fillable=['role_id','user_id'];
     protected $dates = ['deleted_at'];
}
