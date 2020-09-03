<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class TransactionCategory extends Model
{
    //
    protected $table = 'transaction_categories';
    protected $fillable = ['name'];

    private static $TREATMENT = null;
    private static $SALARY = null;
    private static $MATERIAL = null;
    private static $PRODUCT = null;
    private static $OTHER = null;

    public static function treatment(){
    	if (!self::$TREATMENT){
    		self::$TREATMENT = self::where('name', 'like', 'Эмчил%')
    								->orWhere('name', 'like', 'Trea%')->first();
    	}
    	return self::$TREATMENT;
    }
    public static function salary(){
    	if (!self::$SALARY){
    		self::$SALARY = self::where('name', 'like', 'Цал%')
    								->orWhere('name', 'like', 'Sal%')->first();
    	}
    	return self::$SALARY;
    }
    public static function material(){
    	if (!self::$MATERIAL){
    		self::$MATERIAL = self::where('name', 'like', 'Мат%')
    								->orWhere('name', 'like', 'Mat%')->first();
    	}
    	return self::$MATERIAL;
    }
    public static function product(){
    	if (!self::$PRODUCT){
    		self::$PRODUCT = self::where('name', 'like', 'Бар%')
    								->orWhere('name', 'like', 'Pro%')->first();
    	}
    	return self::$PRODUCT;
    }
    public static function other(){
    	if (!self::$OTHER){
    		self::$OTHER = self::where('name', 'like', 'Бус%')
    								->orWhere('name', 'like', 'Oth%')->first();
    	}
    	return self::$OTHER;
    }
}
