<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use App\Roles;
use App\User;
use App\Shift;


class Accountant extends User
{
    //
    protected $table = 'users';	

    protected static function booted(){
        static::addGlobalScope('is_accountant', function(Builder $builder){
            $builder->where('role_id', '=', Roles::accountant()->id);
        });
    }
}
