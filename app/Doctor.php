<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Roles;


class Doctor extends Model
{
    //
    protected $table = 'users';	

    public static function all($columns = Array()){
    	return User::where('role_id', Roles::doctor()->id)
    			->get();
    }

    // legacy receptino.shifts needs this
    protected $appends = 'staff';
    public function getStaffAttribute(){
        return $this;
    }
}
