<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;
use App\Roles;
use App\CheckIn;


class Patient extends Model
{
    //
    use SoftDeletes;

    
    protected $table = 'users';
    
    protected static function booted(){
    	static::addGlobalScope('is_patient', function(Builder $builder){
    		$builder->where('role_id', null);
    	});
    }	
//Make it available in the json response
protected $appends = ['last_treatment_date', 'check_in_today'];

   public function getLastTreatmentDateAttribute(){
   	$checkin = CheckIn::orderBy('id', 'desc')->where('user_id', $this->id)
   											->where('state', '!=', 0)
   											->first();
   	if ($checkin)
   		return $checkin->shift->date;
   	return null;
   }

   public function getCheckInTodayAttribute(){
   		$checkin = CheckIn::where('user_id', $this->id)
   							->where('date', Date('Y-m-d'))
   							->first();
   }
}
