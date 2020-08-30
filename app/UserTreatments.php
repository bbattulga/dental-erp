<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserTreatments extends Model
{
    //
    protected $fillable = ['user_id','treatment_id','tooth_id','value','checkin_id','treatment_selection_id','price', 'decay_level', 'tooth_type_id', 'note_id'];

    protected $table = 'user_treatments';
    
    protected $appends = ['symptom', 'diagnosis'];
    
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
    public function tooth_type(){
        return $this->hasOne('App\ToothType', 'id', 'tooth_type_id');
    }
    public function treatment_note(){
        return $this->hasOne('App\TreatmentNote','user_treatment_id', 'id');
    }

    public function getSymptomAttribute(){
        if ($this->treatment_note)
            return $this->treatment_note->symptom;
        return '';
    }
    public function getDiagnosisAttribute(){
        if ($this->treatment_note)
            return $this->treatment_note->diagnosis;
        return '';
    }
}
