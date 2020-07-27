<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CheckIn extends Model
{
    //
    protected $fillable = ['shift_id', 'user_id', 'state', 'created_by', 'nurse_id'];
    public function user() {
        return $this->hasOne('App\User', 'id', 'user_id');
    }
    public function doctor() {
        return $this->hasOne('App\Roles', 'id', 'doctor_id');
    }
    public function shift() {
        return $this->hasOne('App\Shift', 'id', 'shift_id');
    }
    public function treatments() {
        return $this->hasMany('App\UserTreatments', 'checkin_id', 'id');
    }
    public function transactions() {
        return Transaction::where('type', 4);
    }
    public function user_promotion() {
        return $this->hasOne('App\UserPromotions', 'checkin_id', 'id');
    }
    public function delete(){
        $this->treatments->delete();
        return parent::delete();
    }

    // for legacy code
    public function getPendingAttribute(){
        return $this->state==0;
    }
    public function getTreatmentDoneAttribute(){
        return $this->state==2;
    }
    public function getPaymentDoneAttribute(){
        return $this->state==3;
    }
    public function getLeaseDoneAttribute(){
        return $this->state==4;
    }
}
