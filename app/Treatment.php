<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Treatment extends Model
{
    //
    protected $fillable = ['name','category','price','selection_type', 'category','limit'];

    public function treatmentSelections() {
        return $this->hasMany('App\TreatmentSelections', 'treatment_id', 'id');
    }

    public function category(){
    	return $this->belongsTo('App\TreatmentCategory', 'category', 'id');
    }
}
