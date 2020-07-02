<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Roles extends Model
{
    // these will be cached as a Eloquent models
    // and accessible through Roles::[rolename]
    // and accessed via lowercased methods like Roles::admin()
	private static $ADMIN;
	private static $ACCOUNTANT;
	private static $DOCTOR;
	private static $RECEPTION;
	private static $NURSE;

    public static function admin(){
    	if (self::$ADMIN== null){
    		self::$ADMIN = self::where('name', 'like', 'Ad%')
    		->orWhere('name', 'like', 'Ад%')->firstOrFail();
    	}
    	return self::$ADMIN;
    }

    public static function accountant(){
    	if (self::$ACCOUNTANT == null){
    		self::$ACCOUNTANT = self::where('name', 'like', 'Acc%')
    		->orWhere('name', 'like', 'Няг%')->firstOrFail();
    	}
    	return self::$ACCOUNTANT;
    }

    public static function doctor(){
    	if (self::$DOCTOR == null){
    		self::$DOCTOR = self::where('name', 'like', 'Doc%')
    		->orWhere('name', 'like', 'Эм%')->firstOrFail();
    	}
    	return self::$DOCTOR;
    }

    public static function reception(){
    	if (self::$RECEPTION == null){
    		self::$RECEPTION = self::where('name', 'like', 'Rec%')
    		->orWhere('name', 'like', 'Рес%')->firstOrFail();
    	}
    	return self::$RECEPTION;
    }

    public static function nurse(){
    	if (self::$NURSE == null){
    		self::$NURSE = self::where('name', 'like', 'Nur%')
    		->orWhere('name', 'like', 'Сув%')->firstOrFail();
    	}
    	return self::$NURSE;
    }
}
