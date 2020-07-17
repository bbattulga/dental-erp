<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserTreatments extends Model
{
    //
    protected $fillable = ['user_id','treatment_id','tooth_id','value','checkin_id','treatment_selection_id','price'];


 	public function user(){
    	return $this->belongsTo('App\User', 'user_id', 'id');
    }

    public function treatment() {
        return $this->belongsTo('App\Treatment', 'treatment_id', 'id');
    }

    public function checkIn(){
        return $this->belongsTo('App\CheckIn', 'checkin_id', 'id');
    }

    public function treatmentSelection(){
    	return $this->belongsTo('App\TreatmentSelections', 'treatment_selection_id', 'id');
    }
}
