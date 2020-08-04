<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ToothType extends Model
{
    //

    protected $table='tooth_types';

    private static $MILK;
    private static $PERMA;

    public function getShortNameAttribute(){
    	$name = $this->name;
    	$words = explode(' ', $name);
    	return mb_strtolower($words[0]);
    }

    public static function milk(){

    	if (!isset(self::$MILK)){
    		self::$MILK = self::where('name', 'like', '%Сү%')
    				->orWhere('name', 'like', '%Milk%')
    				->first();
    	}
    	return self::$MILK;
    }

    public static function permanent(){
    	if (!isset(self::$PERMA)){
    		self::$PERMA = self::where('name', 'like', '%Яс%')
    				->orWhere('name', 'like', '%Perm%')
    				->first();
    	}
    	return self::$PERMA;
    }
}
