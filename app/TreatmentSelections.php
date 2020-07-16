<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TreatmentSelections extends Model
{
    //
    protected $fillable = ['treatment_id', 'name', 'price', 'limit'];

    public function treatment(){
    	return $this->belongsTo('App\Treatment', 'treatment_id', 'id');
    }
}
