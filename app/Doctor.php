<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use App\Roles;


class Doctor extends Model
{
    //
    protected $table = 'users';	

    protected static function booted(){
        static::addGlobalScope('is_doctor', function(Builder $builder){
            $builder->where('role_id', '=', Roles::doctor()->id);
        });
    }

}
