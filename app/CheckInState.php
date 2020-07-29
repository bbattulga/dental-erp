<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CheckInState extends Model
{
    //
    protected $table = 'checkin_states';

    // for legacy code
    public static function pending(){
        return 0;
    }
    public static function treatment_done(){
        return 2;
    }
    public static function payment_done(){
        return 3;
    }
    public static function lease_done(){
        return 4;
    }
}
