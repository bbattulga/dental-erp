<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserRole extends Model
{
    //

    protected $table = 'user_role';

    protected $fillable = [
        'user_id', 'role_id','state'
    ];
    public function staff() {
        return $this->hasOne('App\User', 'id', 'user_id');
    }
    public function shifts() {
        return $this->hasMany('App\Time', 'doctor_id', 'user_id');
    }
}
