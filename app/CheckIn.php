<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\CheckInState;
use App\TransactionCategory;


class CheckIn extends Model
{
    //
    protected $fillable = ['shift_id', 'user_id', 'state', 'created_by', 'nurse_id'];
    public function user() {
        return $this->hasOne('App\User', 'id', 'user_id');
    }
    public function appointments(){
        return $this->hasMany('App\Appointment', 'checkin_id', 'id');
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
        return Transaction::where('type_id', TransactionCategory::treatment()->id);
    }
    public function user_promotion() {
        return $this->hasOne('App\UserPromotions', 'checkin_id', 'id');
    }
    public function leases(){
        return $this->hasMany('App\Lease', 'checkin_id', 'id');
    }
    // for legacy code
    public function getPendingAttribute(){
        return $this->state==CheckInState::pending();
    }
    public function getTreatmentDoneAttribute(){
        return $this->state==CheckInState::treatment_done();
    }
    public function getPaymentDoneAttribute(){
        return $this->state==CheckInState::payment_done();
    }
    public function getLeaseDoneAttribute(){
        return $this->state==CheckInState::lease_done();
    }

    public function delete(){
        $this->transactions->delete();
        $this->user_promotion->delete();
        $this->appointments->delete();
        $this->treatments->delete();
        $this->leases->delete();
        parent::delete();
    }
}
