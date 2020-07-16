<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use App\Roles;


class Doctor extends Model
{
    //
    protected $table = 'users';	

    protected static function boot(){
        parent::boot();

        static::addGlobalScope('doctor', function(Builder $builder){
            $builder->where('role_id', Roles::doctor()->id);
        });
    }

    // legacy reception.shifts needs this
    protected $appends = 'staff';
    public function getStaffAttribute(){
        return $this;
    }
}
