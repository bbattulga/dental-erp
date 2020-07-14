<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\User;
use App\Roles;


class Reception extends Model
{
    //

	protected $table = 'users';

    public static function all($columns = Array()){
    	return User::where('role_id', Roles::reception()->id);
    }
}
