<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CheckInState extends Model
{
    //
    protected $table = 'checkin_states';

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
