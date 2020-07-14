<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    //
    protected $fillable = ['shift_id', 'user_id','name', 'phone', 'start', 'end', 'created_by'];

    public function shift() {
        return $this->belongsTo('App\Shift', 'shift_id', 'id');
    }

    public function user(){
    	return $this->hasOne('App\User', 'id', 'user_id');
    }

}
