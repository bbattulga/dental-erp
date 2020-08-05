<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TreatmentNote extends Model
{
    //
    protected $table = 'treatment_notes';
    protected $fillable = ['checkin_id', 'user_treatment_id', 'symptom', 'diagnosis'];

    public function checkin(){
    	return $this->hasOne('App\CheckIn', 'id', 'checkin_id');
    }

    public function treatment(){
    	return $this->hasOne('App\UserTreatments', 'id', 'user_treatment_id');
    }
}
