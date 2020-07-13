<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
<<<<<<< HEAD

class Doctor extends User
{
    //
    protected $table = 'users';
=======
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
>>>>>>> temp
}
