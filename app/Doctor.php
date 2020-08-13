<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use App\Roles;
use App\User;
use App\Shift;


class Doctor extends User
{
    //
    protected $table = 'users';	

    protected static function booted(){
        static::addGlobalScope('is_doctor', function(Builder $builder){
            $builder->where('role_id', '=', Roles::doctor()->id);
        });
    }

    public function getShiftTodayAttribute(){
    	return Shift::where('date', Date('Y-m-d'))
    				->where('user_id', $this->id)
    				->first();
    }

    public function shifts(){
        return $this->hasMany('App\Shift', 'user_id', 'id');
    }
}
