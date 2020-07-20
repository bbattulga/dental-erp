<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;


class Staff extends Model
{
    //
	protected $table = 'users';	

    protected static function booted(){
        static::addGlobalScope('is_staff', function(Builder $builder){
            $builder->where('role_id', '!=', null);
        });
    }
}
