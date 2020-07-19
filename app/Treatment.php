<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Treatment extends Model
{

	use SoftDeletes;
	
    //
    protected $fillable = ['name','category','price','selection_type', 'category','limit'];

    public function treatment_selections() {
        return $this->hasMany('App\TreatmentSelections', 'treatment_id', 'id');
    }

    public function category(){
    	return $this->belongsTo('App\TreatmentCategory', 'category', 'id');
    }
}
