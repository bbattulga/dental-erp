<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class UserTooth extends Model
{
    //
    protected $table = 'user_tooth';

    protected $fillable = ['user_id', 'tooth_id', 'tooth_type_id'];

    public function tooth_type(){
    	return $this->hasOne('App\ToothType', 'id', 'tooth_type_id');
    }

    public function user(){
        return $this->hasOne('App\User', 'id', 'user_id');
    }
    
    public function tooth(){
		return $this->hasOne('App\Tooth', 'id', 'tooth_id');
	}
	
}
