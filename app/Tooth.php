<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tooth extends Model
{
    //
    protected $table = 'tooths';

    private static $toothsCache = null;

    public static function fromCache(){
    	if (self::$toothsCache == null){
    		self::$toothsCache = self::all();
    	}
    	return self::$toothsCache;
    }
}
