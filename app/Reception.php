<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use App\User;
use App\Roles;


class Reception extends User
{
    //

	protected $table = 'users';

	protected static function booted(){
		static::addGlobalScope('is_reception', function(Builder $builder){
			$builder->where('role_id', Roles::reception()->id);
		});
	}
}
