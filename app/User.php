<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Auth;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'last_name', 'name', 'email', 'password','sex','location','register','birth_date','description','phone_number'
    ];

    

    // basically, each account does one thing,
    // which means no need to have multiple roles,
    // just having 1 role is enough
    
    public function role(){
        return $this->hasOne('App\UserRole', 'user_id');
    }

    public function photos(){
        return $this->morphMany('App\Photo', 'imageable');
    }
    public function checkins(){
        return $this->hasMany('App\CheckIn','user_id','id');
    }

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
}
