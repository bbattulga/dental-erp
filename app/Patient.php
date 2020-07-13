<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    //

    protected $table = 'users';

    public static function all($columns=Array()){
    	return Users::where('role_id', null)->get();
    }
}
