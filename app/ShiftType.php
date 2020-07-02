<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ShiftType extends Model
{
    //
	
	public static function morning(){
		return 1;
	}

	public static function evening(){
		return 2;
	}

    public static function full(){
    	return 3;
    }
}
