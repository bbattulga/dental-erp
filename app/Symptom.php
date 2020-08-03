<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Symptom extends Model
{

	public $fillable = ['user_id', 'description', 'date'];

    public function user(){
    	return $this->belongsTo('App\User', 'user_id', 'id');
    }
}
