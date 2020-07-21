<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;
use App\Roles;
use App\CheckIn;
use App\User;

class Nurse extends User
{
    //
    use SoftDeletes;

    
    protected $table = 'users';
    
    protected static function booted(){
    	static::addGlobalScope('is_nurse', function(Builder $builder){
    		$builder->where('role_id', Roles::nurse()->id);
    	});
    }	
}
