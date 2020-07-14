<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Shift extends Model
{
    protected $fillable = ['user_id','shift_type_id','date','created_by'];

    public function doctor() {
        return $this->hasOne('App\User', 'id', 'user_id');
    }

    public function appointments() {
        return $this->hasMany('App\Appointment', 'shift_id', 'id');
    }
    public function checkins(){
        return $this->hasMany('App\CheckIn','shift_id','id');
    }
    public function createdby() {
        return $this->hasOne('App\User', 'id', 'created_by');
    }

    public function delete(){

    }
}
