<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Lease extends Model
{
    //
    protected $fillable=['checkin_id','price','created_by','total'];

    public function checkin(){
    	return $this->hasOne('App\CheckIn', 'id', 'checkin_id');
    }
}
