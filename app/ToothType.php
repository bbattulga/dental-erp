<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ToothType extends Model
{
    //

    protected $table='tooth_types';

    public function getShortNameAttribute(){
    	$name = $this->name;
    	$words = explode(' ', $name);
    	return mb_strtolower($words[0]);
    }
}
