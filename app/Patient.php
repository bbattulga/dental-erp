<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;
use App\Roles;
use App\CheckIn;
use App\User;

class Patient extends User
{
    // if uncomment this, uncomment delete method too and vice versa
    // use SoftDeletes;

    
    protected $table = 'users';
    //Make it available in the json response
    protected $appends = ['last_treatment_date', 'check_in_today'];
  
    
    protected static function booted(){
    	static::addGlobalScope('is_patient', function(Builder $builder){
    		$builder->where('role_id', null);
    	});
    }	

   public function getLastTreatmentDateAttribute(){
   	$checkin = CheckIn::orderBy('id', 'desc')->where('user_id', $this->id)
   											->where('state', '!=', 0)
   											->first();
   	if ($checkin)
   		return $checkin->shift->date;
   	return null;
   }

   public function getCheckinTodayAttribute(){
   		$checkin = CheckIn::where('user_id', $this->id)
   							->where('state', '<=', 2)
   							->first();
      return $checkin;
   }

   public function tooths(){
    return $this->hasMany('App\UserTooth', 'user_id', 'code')
                  ->withColumn('tooth_type_id');
   }

   public function delete(){
      $this->appointments->delete();
      $this->checkins->delete();
      parent::delete();
   }
}
